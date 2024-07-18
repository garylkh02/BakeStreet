<?php

namespace App\Http\Controllers\Bakery;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FlavourController;
use App\Mail\OrderStatusUpdated;
use App\Mail\CustomisationStatusUpdate;
use App\Models\Cake;
use App\Models\Order;
use App\Models\User;
use App\Models\Category;
use App\Models\Flavour;
use App\Models\Bakery;
use App\Models\CakeCustomisation;


class BakeryController extends Controller
{
    public function bakeryList()
    {
        $bakeries = Bakery::with('reviews')->get();

        // Calculate the average rating for each bakery
        $bakeries = $bakeries->map(function ($bakery) {
            $bakery->averageRating = $bakery->reviews->avg('rating');
            return $bakery;
        });

        return view('bakerylist', compact('bakeries'));
    }

    public function showBakery($id)
    {
        $bakery = Bakery::with(['cakes', 'reviews'])->findOrFail($id);
        $averageRating = $bakery->reviews->avg('rating');
        // Calculate average rating and review count for each cake
        foreach ($bakery->cakes as $cake) {
            $cake->averageRating = $cake->reviews->avg('rating');
            $cake->reviewCount = $cake->reviews->count();
        }

        // Collect all reviews from the cakes
        $allReviews = $bakery->cakes->flatMap->reviews;

        // Pick random reviews
        $randomReviews = $allReviews->random(min(5, $allReviews->count()));
    
        return view('bakerydetails', compact('bakery', 'averageRating', 'randomReviews'));
    }
    

    public function index(){
        $user = Auth::user();

        $bakery = $user->bakery;

        if (!$bakery) {
            return redirect('/')->with('error', 'No bakery associated with this user.');
        }

        // Count the pending and completed orders
        $pendingOrdersCount = $bakery->cakes()
            ->join('order_items', 'cakes.id', '=', 'order_items.cake_id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.status', 'pending')
            ->count();

        $completedOrdersCount = $bakery->cakes()
            ->join('order_items', 'cakes.id', '=', 'order_items.cake_id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.status', 'completed')
            ->count();

        // Count the pending and completed orders from the cake_customisations table
        $pendingCustomisationsCount = $bakery->cakeCustomisations()
            ->where('status', 'pending')
            ->count();

        $completedCustomisationsCount = $bakery->cakeCustomisations()
            ->where('status', 'completed')
            ->count();

        // Combine counts from both tables
        $totalPendingOrdersCount = $pendingOrdersCount + $pendingCustomisationsCount;
        $totalCompletedOrdersCount = $completedOrdersCount + $completedCustomisationsCount;

        $currentMonth = Carbon::now()->month;
        
        $totalAmountEarnedFromOrders = $bakery->cakes()
            ->join('order_items', 'cakes.id', '=', 'order_items.cake_id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.status', 'completed')
            ->whereMonth('orders.created_at', $currentMonth)
            ->sum(DB::raw('order_items.price * order_items.quantity'));
        
        // Calculate total amount earned for the current month from the cake_customisations table
        $totalAmountEarnedFromCustomisations = $bakery->cakeCustomisations()
            ->where('status', 'completed')
            ->whereMonth('created_at', $currentMonth)
            ->sum(DB::raw('price * quantity'));
        
        $totalAmountEarned = $totalAmountEarnedFromOrders + $totalAmountEarnedFromCustomisations;
        $availablePending = $totalPendingOrdersCount > 0;

        return view('bakery.dashboard', [
            'pendingOrdersCount' => $totalPendingOrdersCount,
            'completedOrdersCount' => $totalCompletedOrdersCount,
            'totalAmountEarned' => $totalAmountEarned,
            'bakery' => $bakery,
            'availablePending' => $availablePending,
        ]);
    }


    public function list(Request $request)
    {
        $loggedInUserId = Auth::user()->id;
    
        $user = User::with('bakery')->find($loggedInUserId);
    
        if (!isset($user->bakery)) {
            return view('bakery.listproduct', [
                'cakesByCategory' => [],
            ]);
        }
    
        $bakeryId = $user->bakery->id;
    
        $search = $request->input('search');
    
        $cakes = Cake::where('bakery_id', $bakeryId)
                     ->when($search, function ($query, $search) {
                         return $query->where('name', 'like', '%' . $search . '%');
                     })
                     ->with('category')
                     ->get();
    
        $cakesByCategory = $cakes->groupBy('category.name');
        
        session(['previous_page' => 'bakeryproducts']);
    
        return view('bakery.listproduct', [
            'cakesByCategory' => $cakesByCategory,
            'search' => $search, 
        ]);
    }
    
    public function updateVisibility(Request $request, $id)
    {
        $cake = Cake::findOrFail($id);
        $cake->visible = $request->input('visible');
        $cake->save();

        return response()->json(['success' => true]);
    }

    public function view($id)
    {
        $cake = Cake::with(['bakery', 'flavour', 'category'])->findOrFail($id);
        $sizes = json_decode($cake->size, true);
        $addons = json_decode($cake->addons, true);
        return view('bakery.viewproduct', compact('cake', 'sizes', 'addons'));
    }

    
    public function editproduct($id, CategoryController $categoryController, FlavourController $flavourController)
    {
        $cake = Cake::with(['bakery', 'flavour', 'category'])->findOrFail($id);
        $categories = $categoryController->index();
        $flavours = $flavourController->index();
        return view('bakery.editproduct', ['cake' => $cake, 'categories' => $categories, 'flavours' => $flavours]);
    }

    public function updateproduct(Request $request, $id)
    {
        $cake = Cake::findOrFail($id);
    
        $loggedInUserId = Auth::user()->id;
    
        $user = User::with('bakery')->find($loggedInUserId);
    
        $bakeryId = $user->bakery->id;
    
        // Ensure original price is set
        $originalPrice = $cake->original_price ?: $cake->price;
    
        $request->validate([
            'discount' => ['nullable', 'numeric', 'min:0', 'lt:' . ($originalPrice)],
            'flavour_id' => 'required',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);
    
        if ($request->input('flavour_id') == 'other') {
            $newFlavour = new Flavour();
            $newFlavour->name = $request->input('other_flavour');
            $newFlavour->save();
            $cake->flavour_id = $newFlavour->id;
        } else {
            $cake->flavour_id = $request->input('flavour_id');
        }
    
        $addons = $request->input('addons', []);
        $sizes = $request->input('sizes', []);
    
        $addons = array_filter($addons, fn($addon) => isset($addon['enabled']) && $addon['enabled']);
        $sizes = array_filter($sizes, fn($size) => isset($size['enabled']) && $size['enabled']);
    
        // Decode the sizes JSON to handle price adjustments
        $decodedSizes = json_decode($cake->size, true);
    
        // Update sizes with the new prices based on the discount
        $newDiscount = $request->input('discount', 0);
        $oldDiscount = $cake->discount;
    
        foreach ($sizes as &$size) {
            // Ensure the 'size' key exists
            if (isset($size['size']) && isset($decodedSizes[$size['size']])) {
                $originalSizePrice = $decodedSizes[$size['size']]['price'];
                $size['price'] = max($originalSizePrice - $newDiscount, 0); // Ensure the new price is not negative
            }
        }
    
        // Convert sizes to JSON
        $cake->size = json_encode($sizes);
    
        // Update cake details
        $cake->name = $request->input('name');
        $cake->description = $request->input('description');
        $cake->cakecare = $request->input('cakecare');
        $cake->ingredients = $request->input('ingredients');
        $cake->allergens = $request->input('allergens');
        $cake->items = $request->input('items');
        $cake->occasions = $request->input('occasions');
        $cake->original_price = $originalPrice;
        $cake->bakery_id = $bakeryId;
        $cake->category_id = $request->input('category_id');
        $cake->preptime = $request->input('preptime');
        $cake->selfcollect = $request->input('selfcollect');
    
        // Update the discount and calculate the lowest price based on sizes
        $cake->discount = $newDiscount;
        $cake->price = $this->calculateLowestPrice($sizes, $newDiscount);
    
        if ($request->hasFile('photo')) {
            $fileName = time().'.'.$request->file('photo')->getClientOriginalExtension();
            $path = $request->file('photo')->storeAs('images', $fileName, 'public'); // Store in storage/app/public/images
            $cake->photo = 'storage/'.$path; // Using the public disk
        }
    
        $cake->save();
    
        return redirect()->route('bakery.viewproduct', $id)->with('success', 'Cake details updated successfully.');
    }
    
    private function calculateLowestPrice($sizes, $discount)
    {
        $lowestPrice = PHP_INT_MAX;
        foreach ($sizes as $size) {
            if (isset($size['price'])) {
                $lowestPrice = min($lowestPrice, $size['price']);
            }
        }
        return max($lowestPrice, 0);
    }
    
    public function create(CategoryController $categoryController, FlavourController $flavourController) {
        $categories = $categoryController->index();
        $flavours = $flavourController->index();
        return view('bakery.createproduct', ['categories' => $categories, 'flavours' => $flavours]);
    }    

    public function store(Request $request) {
        
        $cake = new Cake();
    
        $cake->name = $request->input('name');
        $cake->description = $request->input('description');
        $cake->cakecare = $request->input('cakecare');
        $cake->ingredients = $request->input('ingredients');
        $cake->allergens = $request->input('allergens');
        $cake->items = $request->input('items');
        $cake->occasions = $request->input('occasions');
        $cake->price = $request->input('price');
        $cake->original_price = $request->input('price');
        $cake->bakery_id = $request->input('bakery_id');
        $cake->category_id = $request->input('category_id');
        // Check if the selected flavour is "Other"
        if ($request->input('flavour_id') == 'other') {
            // Create a new flavour
            $newFlavour = new Flavour();
            $newFlavour->name = $request->input('other_flavour');
            $newFlavour->save();
            // Set the newly created flavour ID
            $cake->flavour_id = $newFlavour->id;
        } else {
            // Use the selected flavour ID directly
            $cake->flavour_id = $request->input('flavour_id');
        }
        $cake->preptime = $request->input('preptime');
        $cake->selfcollect = $request->input('selfcollect');

        $addons = $request->input('addons', []);
        $sizes = $request->input('sizes', []);
        
        // Filter out only enabled addons and sizes
        $addons = array_filter($addons, fn($addon) => isset($addon['enabled']) && $addon['enabled']);
        $sizes = array_filter($sizes, fn($size) => isset($size['enabled']) && $size['enabled']);
        
        // Convert to JSON
        $cake->addons = json_encode($addons);
        $cake->size = json_encode($sizes);


        $fileName = time().'.'.$request->file('photo')->getClientOriginalExtension();
        $path = $request->file('photo')->storeAs('images', $fileName, 'public'); // Store in storage/app/public/images
        $cake->photo = 'storage/'.$path; // using the public disk
    
        $cake->save();

        return redirect('/bakery/listproduct')->with('mssg', 'Cake Added Successfully!');       
    }

    public function destroy($id) {
        $cake = Cake::findOrFail($id);
        $cake->delete();

        return redirect('/bakery/listproduct')->with('mssg', 'Cake Deleted Successfully!');
    }

    public function orderlist()
    {
        $user = Auth::user();

        $bakery = $user->bakery;

        if (!$bakery) {
            return redirect('/')->with('error', 'No bakery associated with this user.');
        }

        $pendingOrdersCount = $bakery->cakes()
            ->join('order_items', 'cakes.id', '=', 'order_items.cake_id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.status', 'pending')
            ->count();

        $readyOrdersCount = $bakery->cakes()
            ->join('order_items', 'cakes.id', '=', 'order_items.cake_id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.status', 'ready')
            ->count();

        $currentDate = now(); // Get the current date
        $upcomingOrdersCount = $bakery->cakes()
            ->join('order_items', 'cakes.id', '=', 'order_items.cake_id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.status', '!=', 'completed')
            ->where('orders.status', '!=', 'ready')
            ->where('orders.status', '!=', 'unpaid')
            ->where('order_items.deldate', '>', $currentDate->addWeek()) // Only show orders with more than a week until the deldate
            ->count();

        $customOrdersCount = CakeCustomisation::where('bakery_id', $bakery->id)
            ->where('status', '!=', 'completed')
            ->count();

        $availableReady = $readyOrdersCount > 0;
        $availablePending = $pendingOrdersCount > 0;
        $availableUpcoming = $upcomingOrdersCount > 0;
        $availableCustom = $customOrdersCount > 0;

        session(['previous_page' => 'orderlist']);
        return view('bakery.orderlist', compact('availableReady', 'availablePending', 'availableUpcoming', 'availableCustom'));
    }

    public function pendingOrders()
    {
        $userId = Auth::id(); 
    
        $pendingOrders = Cake::join('bakeries', 'cakes.bakery_id', '=', 'bakeries.id')
            ->join('order_items', 'cakes.id', '=', 'order_items.cake_id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.status', '!=', 'completed')
            ->where('orders.status', '!=', 'ready')
            ->where('orders.status', '!=', 'cancelled')
            ->where('orders.status', '!=', 'unpaid')
            ->where('bakeries.user_id', $userId)
            ->select('orders.*', 'order_items.deldate', 'order_items.price', 'order_items.quantity', 'cakes.photo', 'cakes.name')
            ->get();

            session(['previous_page' => 'pending']);
    
        return view('bakery.partials.pending-orders', compact('pendingOrders'));
    }

    public function readyOrders()
    {
        $userId = Auth::id(); 
    
        $readyOrders = Cake::join('bakeries', 'cakes.bakery_id', '=', 'bakeries.id')
            ->join('order_items', 'cakes.id', '=', 'order_items.cake_id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.status', 'ready')
            ->where('bakeries.user_id', $userId)
            ->select('orders.*', 'order_items.deldate', 'order_items.price', 'order_items.quantity', 'cakes.photo', 'cakes.name')
            ->get();

            session(['previous_page' => 'ready']);
    
        return view('bakery.partials.ready-orders', compact('readyOrders'));
    }

    public function upcomingOrders()
    {
        $userId = Auth::id(); 
        $currentDate = now(); 

        $upcomingOrders = Cake::join('bakeries', 'cakes.bakery_id', '=', 'bakeries.id')
            ->join('order_items', 'cakes.id', '=', 'order_items.cake_id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.status', '!=', 'completed')
            ->where('orders.status', '!=', 'ready')
            ->where('orders.status', '!=', 'unpaid')
            ->where('bakeries.user_id', $userId)
            ->where('order_items.deldate', '>', $currentDate->addWeek()) // Only show orders with more than a week until the deldate
            ->select('orders.*', 'order_items.deldate', 'order_items.price', 'order_items.quantity', 'cakes.photo', 'cakes.name')
            ->get();

            session(['previous_page' => 'upcoming']);

        return view('bakery.partials.upcoming-orders', compact('upcomingOrders'));
    }

    public function completedOrders()
    {
        $userId = Auth::id(); 
    
        $completedOrders = Cake::join('bakeries', 'cakes.bakery_id', '=', 'bakeries.id')
            ->join('order_items', 'cakes.id', '=', 'order_items.cake_id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.status', 'completed')
            ->where('bakeries.user_id', $userId)
            ->select('orders.*', 'order_items.deldate', 'order_items.price', 'order_items.quantity', 'cakes.photo', 'cakes.name')
            ->get();

            session(['previous_page' => 'completed']);
    
        return view('bakery.partials.completed-orders', compact('completedOrders'));
    }


    public function search(Request $request)
    {
        $userId = Auth::id();
        $searchTerm = $request->input('search', ''); 

        $query = Cake::join('bakeries', 'cakes.bakery_id', '=', 'bakeries.id')
            ->join('order_items', 'cakes.id', '=', 'order_items.cake_id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('bakeries.user_id', $userId)
            ->select('orders.*', 'order_items.deldate', 'order_items.price', 'order_items.quantity', 'cakes.photo', 'cakes.name');

        if (!empty($searchTerm)) {
            $query->where(function($q) use ($searchTerm) {
                $q->where('orders.id', 'like', '%' . $searchTerm . '%');
            });
        }

        $products = $query->get();

        return view('bakery.partials.results', compact('products'));
    }

    public function show($orderId)
    {
        $order = Order::with('cakes')->findOrFail($orderId);

        $subtotal = $order->cakes->sum(function($cake) {
            return $cake->pivot->price * $cake->pivot->quantity;
        });

        $serviceTax = $subtotal * 0.06;
        $totalPrice = $subtotal + $serviceTax;

        return view('bakery.bakeryorderdetails', compact('order', 'subtotal', 'serviceTax', 'totalPrice'));
    }

    public function updateStatus(Request $request, $orderId)
    {
        $request->validate([
            'status' => 'required|in:pending,ready,upcoming,completed',
        ]);

        $order = Order::findOrFail($orderId);

        $order->status = $request->input('status');
        $order->save();

        // Send an email notification
        if (in_array($order->status, ['ready', 'completed'])) {
            Mail::to($order->user->email)->send(new OrderStatusUpdated($order));
        }

        return redirect()->route('bakery.orders.show', $orderId)->with('success', 'Order status updated successfully.');
    }

    public function showManageCategories()
    {
        $categories = Category::all();

        return view('bakery.managecategories', [
            'categories' => $categories,
        ]);
    }

    public function addCategory(Request $request)
    {
        $request->validate([
            'category_name' => 'required|string|max:255',
        ]);

        $category = new Category();
        $category->name = $request->category_name;
        $category->save();

        return redirect()->route('bakery.manageCategories')->with('success', 'Category added successfully!');
    }

    public function showBakeryReviews()
    {
        $loggedInUserId = Auth::user()->id; 
    
        $user = User::with('bakery')->find($loggedInUserId);
    
        $bakeryId = $user->bakery->id;

        $bakery = Bakery::findOrFail($bakeryId);

        $cakes = Cake::where('bakery_id', $bakeryId)
                 ->orderBy('name', 'asc')
                 ->get();

        $reviews = [];
        foreach ($cakes as $cake) {
            $cakeReviews = $cake->reviews()->with('user')->get();
            $reviews[$cake->id] = $cakeReviews;
        }

        return view('bakery.cakereviews', compact('bakery', 'cakes', 'reviews'));
    }

    public function showCustomOrders()
    {
        $loggedInUserId = Auth::user()->id;
        $user = User::with('bakery')->find($loggedInUserId);
    
        $bakeryId = $user->bakery->id;
    
        $customOrders = CakeCustomisation::where('bakery_id', $bakeryId)
                            ->with(['category', 'toppings', 'flavours'])
                            ->orderBy('created_at', 'desc') 
                            ->get();
    
        return view('bakery.partials.customiselist', compact('customOrders'));
    }
    

    public function showCustomOrderDetails($id)
    {
        $loggedInUserId = Auth::user()->id;
        $user = User::with('bakery')->find($loggedInUserId);
    
        $bakeryId = $user->bakery->id;
    
        $customOrder = CakeCustomisation::where('id', $id)
                        ->where('bakery_id', $bakeryId)
                        ->with(['category', 'toppings', 'flavours'])
                        ->firstOrFail();

        $totalPrice = $customOrder->quantity * $customOrder->price;
    
        return view('bakery.customisedetails', compact('customOrder', 'totalPrice'));
    }

    public function updateCustomOrderStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string|max:255',
        ]);

        $loggedInUserId = Auth::user()->id;
        $user = User::with('bakery')->find($loggedInUserId);

        $bakeryId = $user->bakery->id;

        $customOrder = CakeCustomisation::where('id', $id)
                        ->where('bakery_id', $bakeryId)
                        ->firstOrFail();

        $customOrder->status = $request->input('status');
        $customOrder->save();

         // Send an email notification
         if (in_array($customOrder->status, ['ready', 'completed'])) {
            Mail::to($customOrder->email)->send(new CustomisationStatusUpdate($customOrder));
        }

        return redirect()->route('bakery.custom.show', $id)->with('success', 'Order status updated successfully!');
    }

    




}

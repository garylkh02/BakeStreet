<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Cart;
use App\Models\Cake;
use App\Models\User;
use App\Models\Order;
use App\Models\Coupon;
use App\Models\LoyaltyPoint;
use App\Mail\OrderReceipt;


class CartController extends Controller
{
    public function store(Request $request, $id)
    {
       
        if (Auth::check()) {
            if (Auth::user()->usertype == 'user') {
                $user = auth()->user();
                $cake = cake::find($id);

                if (!$cake) {
                    return redirect()->back()->withErrors(['error' => 'Product not found']);
                }

                $cart = new cart;
                $cart->user_id=$user->id;
                $cart->phone=$user->phone;
                $cart->address=$user->address;
                $cart->product_title=$cake->name;

                // Retrieve the selected size and its price
                $sizes = json_decode($cake->size, true);
                $selectedSize = $request->input('size');
                $cart->size = $selectedSize;
                $cart->price = $sizes[$selectedSize]['price'];

                // Calculate total price with addons
                $addons = json_decode($cake->addons, true);
                $selectedAddons = $request->input('addons', []);
                $addonsTotalPrice = 0;
                $storedAddons = [];

                foreach ($selectedAddons as $addon) {
                    if (isset($addons[$addon])) {
                        $addonsTotalPrice += $addons[$addon]['price'];
                        $storedAddons[$addon] = $addons[$addon]; // Store the add-on name and details
                    }
                }

                $cart->addons = json_encode($storedAddons); // Store as JSON with names and details
                $cart->total_price = $cart->price + $addonsTotalPrice;

                $cart->quantity=$request->quantity;
                $cart->bcandle=$request->bigcandlesqty;
                $cart->scandle=$request->smallcandlesqty;
                $cart->message=$request->cardmsg;
                $cart->deldate=$request->selected_date;
                $cart->deltime=$request->selected_time;
                $cart->cake_id=$cake->id;
                
                $cart->save();

                return redirect()->back()->with('success', 'Product added to cart successfully');
            } 
        }
        return redirect('login')->withErrors(['error' => 'You need to log in first']);
    }

    public function showCart()
    {
        if (Auth::check()) {
            if (Auth::user()->usertype == 'user') {
                $user = auth()->user();
                $cart = cart::where('user_id', $user->id)->with('cake')->get();

                $orders = Order::where('user_id', auth()->id())
                ->where('created_at', '<', Carbon::now()->subSecond(3))
                ->where('status', 'checking')
                ->orderBy('created_at', 'desc')
                ->get();
                // Delete the fetched orders
                foreach ($orders as $order) {
                    $order->delete();
                }

                $subtotal = $cart->sum(function($cart) {
                    return $cart->total_price * $cart->quantity;
                });

                $serviceTax = $subtotal * 0.06;
                $totalPrice = $subtotal + $serviceTax;

                // Get the list of cake IDs with the highest counts from the wishlists table
                $recommendedCakeIds = DB::table('wishlists')
                ->select('cake_id', DB::raw('count(cake_id) as wishlist_count'))
                ->groupBy('cake_id')
                ->orderBy('wishlist_count', 'desc')
                ->take(3)
                ->pluck('cake_id');

                // Fetch the cake details using the IDs from the first query
                $recommendedCakes = Cake::whereIn('id', $recommendedCakeIds)->get();

                return view('showcart', [
                    'cart' => $cart,
                    'subtotal' => $subtotal,
                    'serviceTax' => $serviceTax,
                    'totalPrice' => $totalPrice,
                    'recommendedCakes' => $recommendedCakes]);
            }
        }
        return redirect('login')->withErrors(['error' => 'You need to log in first']);
    }

    public function delete($id)
    {
        $data = cart::find($id);

            // Check if the cart item exists
        if ($data) {
            // Delete the cart item
            $data->delete();
            return redirect()->back()->with('success', 'Item removed from cart successfully.');
        } else {
            return redirect()->back()->with('error', 'Item not found.');
        }

    }

    public function updateQuantity(Request $request)
    {
        $cartId = $request->input('cart_id');
        $quantity = $request->input('quantity');

        $cart = Cart::find($cartId);

        if ($cart) {
            $cart->quantity = $quantity;
            $cart->save();

            // Return a JSON response with a script to reload the page
            return response()->json([
                'success' => true,
                'message' => 'Ho Ho Quantity Updated!',
                'reload' => true
            ]);
        } else {
            return response()->json(['success' => false, 'message' => 'Cart item not found']);
        }
    }

    public function updateOrderItems(Request $request, $id)
    {
        $cart = Cart::find($id);

        if (!$cart) {
            return redirect()->route('cart.show')->with('error', 'Cart item not found');
        }

        $cart->quantity = $request->quantity;
        $cart->bcandle = $request->bcandle;
        $cart->scandle = $request->scandle;
        $cart->message = $request->message;
        $cart->deldate = $request->deldate;
        $cart->deltime = $request->deltime;
        $cart->save();

        return redirect()->route('cart.show')->with('success', 'Cart updated successfully');
    }


    public function checkout()
    {
        if (Auth::check()) {
            if (Auth::user()->usertype == 'user') {
                $user = auth()->user();
                $cart = cart::where('user_id', $user->id)->with('cake')->get();

                $subtotal = $cart->sum(function($cart) {
                    return $cart->total_price * $cart->quantity;
                });

                $serviceTax = $subtotal * 0.06;
                $totalPrice = $subtotal + $serviceTax;

                $userId = $user->id;
                $phone = $user->phone;
                $billaddress = $user->address;

                // Save the order details
                $order = new Order;
                $order->user_id = $userId;
                $order->phone = $phone;
                $order->billaddress = $billaddress;
                $order->status = 'checking';

                $order->save();

                foreach ($cart as $item) {
                    // Save each item associated with the order
                    $order->cakes()->attach($item->cake_id, [
                        'product_title' => $item->product_title,
                        'price' => $item->total_price,
                        'quantity' => $item->quantity,
                        'deldate' => $item->deldate,
                        'deltime' => $item->deltime,
                        'message' => $item->message,
                        'bcandle' => $item->bcandle,
                        'scandle' => $item->scandle,
                        'size' => $item->size, 
                        'addons' => $item->addons, 
                    ]);
                }
        
                // Check if all products in the cart are self-collectable
                $allSelfCollectable = $cart->every(function($item) {
                    return $item->cake->selfcollect == 1;
                });

                // Store subtotal, serviceTax, and totalPrice in session
                session([
                'subtotal' => $subtotal,
                'serviceTax' => $serviceTax,
                'totalPrice' => $totalPrice
                ]);

                return view('checkout', ['totalPrice' => $totalPrice, 'allSelfCollectable' => $allSelfCollectable, 'orderId' => $order->id]);
            }
        }
        return redirect('login')->withErrors(['error' => 'You need to log in first']);
    }

    public function checkCoupon(Request $request)
    {
        $couponCode = $request->input('coupon_code');
        $deliveryMethod = $request->input('delivery_method'); 
        $coupon = Coupon::where('code', $couponCode)->first();

        if (!$coupon) {
            return response()->json(['error' => 'Invalid coupon code.']);
        }

        // Check coupon ownwer
        if ($coupon->user_id != Auth::id()) {
            return response()->json(['error' => 'This coupon only available for certain users.']);
        }

        // Check if the coupon has expired
        if ($coupon->expiry_date < now()) {
            return response()->json(['error' => 'This coupon has expired.']);
        }

        // Check if the coupon has already been used
        if ($coupon->is_used) {
            return response()->json(['error' => 'This coupon has already been used.']);
        }

        // Check delivery fee waiver
        // Fetch the cart items from the database
        $cart = Cart::where('user_id', Auth::id())->with('cake')->get();

        // Calculate the subtotal
        $subtotal = $cart->sum(function($cart) {
            return $cart->total_price * $cart->quantity;
        });

        // Calculate the service tax
        $serviceTax = $subtotal * 0.06;
        $totalPrice = $subtotal + $serviceTax;
        
        if ($totalPrice > 100 && $coupon->type == 'free_delivery') {
            return response()->json(['error' => 'This coupon cannot be applied as your purchase already qualifies for free delivery.']);
        }
        
        // Initialize discount variables
        $discountAmount = 0;
        $discountedPrice = $totalPrice;
        $deliveryFee = 8.00; 

        // Check if the coupon type is free_delivery
        if ($coupon->type == 'free_delivery') {
            if ($deliveryMethod === 'self_pickup') {
                return response()->json(['error' => 'Free delivery vouchers cannot be used with self-pickup.']);
            }
            $discountAmount = 8.00; // Fixed discount amount for free delivery
            $deliveryFee = 0.00; 
        } else {
            // Calculate the discounted price for percentage-based discount
            $discount = $coupon->discount;
            $discountAmount = $totalPrice * ($discount / 100);
            $discountedPrice = max(0, $totalPrice - $discountAmount);
        }

        // Store the coupon and discounted price in the session
        session(['coupon' => $coupon, 'totalPrice' => $discountedPrice, 'offAmount' => $discountAmount, 'priceBefore' => $totalPrice]);

        return response()->json([
            'success' => 'Promo code is applied.',
            'totalPrice' => $totalPrice,
            'discountAmount' => $discountAmount,
            'discountedPrice' => $discountedPrice,
            'couponType' => $coupon->type,
            'deliveryFee' => $deliveryFee
        ]);
    }


    public function removeCoupon(Request $request)
    {
        // Clear the coupon from the session
        session()->forget('coupon');
        session()->forget('offAmount');
        session()->forget('totalPrice');

        // Fetch the cart items from the database
        $cart = Cart::where('user_id', Auth::id())->with('cake')->get();

        // Calculate the subtotal
        $subtotal = $cart->sum(function($cart) {
            return $cart->total_price * $cart->quantity;
        });

        // Calculate the service tax
        $serviceTax = $subtotal * 0.06;
        $totalPrice = $subtotal + $serviceTax;

        // Calculate the discounted price
        $discountedPrice = max(0, $totalPrice - 0);

        // Store the coupon and discounted price in the session
        session(['totalPrice' => $discountedPrice, 'offAmount' => 0, 'priceBefore' => $totalPrice]);

        return response()->json([
            'success' => 'Promo code is removed.',
            'totalPrice' => $totalPrice,
            'discountAmount' => 0,
            'discountedPrice' => $discountedPrice
        ]);
    }


    public function processCheckout(Request $request)
    {
        $request->validate([
            'delivery-method' => 'required|in:delivery,pickup',
            'recname' => 'required|string|max:255',
            'street' => 'required|string|max:255',
            'postcode' => 'required|string|max:10',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'coupon_code' => 'nullable|string|max:50',
        ]);
    
        $orders = Order::where('user_id', Auth::id())->where('status', 'checking')->get();
        $deliveryMethod = $request->input('delivery_method');

        if ($orders->isEmpty()) {
            return redirect()->route('cart.show')->with('error', 'No pending order found.');
        }
    
        // Get totalPrice, discountAmount, coupon, and deliveryFee from session
        $subtotal = session('subtotal');
        $serviceTax = session('serviceTax');
        $totalPrice = session('totalPrice');
        $discountAmount = session('offAmount');
        $coupon = session('coupon');
        $priceBefore = session('priceBefore');
        $deliveryFee = 8.00;

        $deliveryMethod = $request->input('delivery-method');

        // Check if the delivery method is 'pickup'
        if ($deliveryMethod === 'pickup') {
            $deliveryFee = 0.00;
        } else {
            // Check if the total price is more than 100
            if ($totalPrice > 100) {
                $deliveryFee = 0.00;
            } else {
                // Check if the coupon type is free_delivery
                if ($coupon && $coupon->type == 'free_delivery') {
                    $deliveryFee = 0.00;
                } else {
                    $deliveryFee = 8.00;
                }
            }
        }
                
        $totalPrice += $deliveryFee;
    
        foreach ($orders as $order) {
            $order->delmethod = $deliveryMethod;
            $order->recipient_name = $request->input('recname');
            $order->recphone = $request->input('recphone');
            $order->street = $request->input('street');
            $order->postcode = $request->input('postcode');
            $order->city = $request->input('city');
            $order->state = $request->input('state');
            $order->status = 'unpaid';
            $order->discount = $discountAmount;
            $order->newprice = $totalPrice;
            $order->promocode = $coupon ? $coupon->code : null;
            $order->deliveryfee = $deliveryFee;
            $order->pricebefdis = $priceBefore;
            $order->subtotal = $subtotal; 
            $order->service_tax = $serviceTax; 
            $order->delivery_instructions = $request->input('delivery_instructions');
    
            $order->save();
 
        }
    
        // Mark the coupon as used if it's valid
        if ($coupon) {
            $coupon->is_used = true;
            $coupon->save();
        }
    
        // Assign loyalty points for each order
        $this->addLoyaltyPoints(Auth::id(), $totalPrice, $orders->first()->id);
    
        // Clear the cart after checkout
        Cart::where('user_id', Auth::id())->delete();

        $user = auth()->user();
        // Send an email receipt
        Mail::to($user->email)->send(new OrderReceipt($order));
    
        // Clear session data
        session()->forget('subtotal');
        session()->forget('serviceTax');
        session()->forget('totalPrice');
        session()->forget('coupon');
        session()->forget('offAmount');
        session()->forget('priceBefore');

        session(['previous_page' => 'checkoutprocess']);
        // Redirect to the success page with the first order ID
        return redirect()->route('paymentPage', ['orderId' => $orders->first()->id]);
    }
    

    protected function addLoyaltyPoints($userId, $totalPrice, $orderId)
    {
        $points = floor($totalPrice); // 1 point per RM

        // Retrieve the user
        $user = User::find($userId);

        // Add the new points to the existing points
        $user->loyalty_points += $points;

        // Save the updated points
        $user->save();

        // Create a new loyalty points record
        LoyaltyPoint::create([
            'user_id' => $userId,
            'order_id' => $orderId,
            'points' => $points,
            'description' => 'Purchases from Order ' . $orderId,
        ]);
    }

    public function cancelOrder(Request $request)
    {
        $orderId = $request->orderId;
        $order = Order::find($orderId);

        if ($order) {
            $order->status = 'cancelled';
            $order->save();

            session()->forget('coupon');
            session()->forget('offAmount');
            session()->forget('totalPrice');

            // Return the URL of the cancelled order page
            return response()->json([
                'success' => true,
                'cancelledOrderUrl' => route('orders.cancelled', ['order' => $order->id])
            ]);
        }
        return response()->json(['success' => false]);
    }

    public function showCancelledOrder(Order $order)
    {
        return view('cancel', compact('order'));
    }


}

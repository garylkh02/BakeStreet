<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ApplicationStatusUpdate;
use App\Mail\EnquiryStatusUpdate;
use App\Models\User;
use App\Models\ContactUs;
use App\Models\BContactUs;
use App\Models\Application;
use App\Models\Bakery;
use App\Models\CorporateOrder;
use App\Models\BlogPost;

class AdminController extends Controller
{
    public function index()
    {
        // Count pending enquiries in ContactUs table
        $contactUsPendingCount = ContactUs::where('status', 'to be reviewed')->count();

        // Count pending enquiries in BContactUs table
        $bContactUsPendingCount = BContactUs::where('status', 'to be reviewed')->count();

        // Sum the counts
        $pendingEnquiryCount = $contactUsPendingCount + $bContactUsPendingCount;

        $applicationCount = Application::where('status', 'to be reviewed')->count();

        $availableApplication = $applicationCount > 0;
    
        $availableEnquiry = $pendingEnquiryCount > 0;

        $toBeReviewedCount = CorporateOrder::where('status', 'to be reviewed')->count();
        $reviewedCount = CorporateOrder::where('status', 'reviewed')->count();
        $readyCount = CorporateOrder::where('status', 'ready')->count();
    
        // Sum of counts
        $totalCount = $toBeReviewedCount + $reviewedCount + $readyCount;

        $availableCorpOrder = $totalCount > 0;

        return view('admin.dashboard', [
            'pendingEnquiryCount' => $pendingEnquiryCount,
            'applicationCount' => $applicationCount,
            'availableApplication' => $availableApplication,
            'availableEnquiry' => $availableEnquiry,
            'availableCorpOrder' => $availableCorpOrder,
        ]);
    }

    public function userlist() {
        // Retrieve users where usertype is 'user' and sort by user ID in ascending order
        $users = User::where('usertype', 'user')->orderBy('id', 'asc')->get();
        session(['previous_page' => 'userlist']);
        return view('admin.userlist', [
            'users' => $users,
        ]);
    }

    public function usersearch(Request $request)
    {
        $searchTerm = $request->input('search', ''); // Get the search term, default to empty string if not present

        // Initialize the query to search in the users table and filter by usertype 'user'
        $query = User::where('usertype', 'user');

        if (!empty($searchTerm)) {
            // Search by email or any other field you need, here it searches by email
            $query->where('email', 'like', '%' . $searchTerm . '%');
        }

        // Get the search results
        $results = $query->get();
        session(['previous_page' => 'searchuser']);
        return view('admin.userresult', compact('results'));
    }
    
    public function bakerylist() {
        // Retrieve users where usertype is 'user'
        $users = User::where('usertype', 'bakery')->orderBy('id', 'asc')->get();
        session(['previous_page' => 'bakerylist']);
        return view('admin.bakerylist', [
            'users' => $users,
        ]);
    }

    public function bakerysearch(Request $request)
    {
        $searchTerm = $request->input('search', ''); // Get the search term, default to empty string if not present

        // Initialize the query to search in the users table and filter by usertype 'user'
        $query = User::where('usertype', 'bakery');

        if (!empty($searchTerm)) {
            // Search by email or any other field you need, here it searches by email
            $query->where('email', 'like', '%' . $searchTerm . '%');
        }

        // Get the search results
        $results = $query->get();
        session(['previous_page' => 'searchbakery']);
        return view('admin.userresult', compact('results'));
    }

    public function enquirylist()
    {
        $contactUsPendingCount = ContactUs::where('status', 'to be reviewed')->count();
        $bContactUsPendingCount = BContactUs::where('status', 'to be reviewed')->count();

        session(['previous_page' => 'enquiry']);
        return view('admin.enquirylist', [
            'contactUsPendingCount' => $contactUsPendingCount,
            'bContactUsPendingCount' => $bContactUsPendingCount,
        ]);
    }

    public function userenquiry() {
        // Retrieve users where usertype is 'user' and sort by user ID in ascending order
        $enquiry = ContactUs::orderBy('id', 'asc')->get();

        session(['previous_page' => 'user']);
    
        return view('admin.userenquiry', [
            'enquiry' => $enquiry,
        ]);
    }

    public function bakeryenquiry() {
        // Retrieve users where usertype is 'user' and sort by user ID in ascending order
        $enquiry = BContactUs::orderBy('id', 'asc')->get();

        session(['previous_page' => 'bakery']);
    
        return view('admin.bakeryenquiry', [
            'enquiry' => $enquiry,
        ]);
    }

    public function enquirysearch(Request $request)
    {
        $userId = Auth::id(); // Get the logged-in user's ID
        $searchTerm = $request->input('search', ''); // Get the search term, default to empty string if not present

        // Initialize the query to search in ContactUs table
        $contactUsQuery = ContactUs::query();
        if (!empty($searchTerm)) {
            $contactUsQuery->where('email', 'like', '%' . $searchTerm . '%');
        }
        $contactUsResults = $contactUsQuery->get();

        // Initialize the query to search in BContactUs table
        $bContactUsQuery = BContactUs::query();
        if (!empty($searchTerm)) {
            $bContactUsQuery->where('email', 'like', '%' . $searchTerm . '%');
        }
        $bContactUsResults = $bContactUsQuery->get();

        // Combine the results
        $results = $contactUsResults->merge($bContactUsResults);
        session(['previous_page' => 'search']);

        return view('admin.result', compact('results'));
    }

    public function uenquirysearch(Request $request)
    {
        $userId = Auth::id(); // Get the logged-in user's ID
        $searchTerm = $request->input('search', ''); // Get the search term, default to empty string if not present

        // Initialize the query to search in ContactUs table
        $query = ContactUs::query();

        if (!empty($searchTerm)) {
            $query->where('email', 'like', '%' . $searchTerm . '%');
        }

        $results = $query->get();
        session(['previous_page' => 'usersearch']);

        return view('admin.result', compact('results'));
    }

    public function benquirysearch(Request $request)
    {
        $userId = Auth::id(); // Get the logged-in user's ID
        $searchTerm = $request->input('search', ''); // Get the search term, default to empty string if not present

        // Initialize the query to search in ContactUs table
        $query = BContactUs::query();

        if (!empty($searchTerm)) {
            $query->where('email', 'like', '%' . $searchTerm . '%');
        }

        $results = $query->get();
        session(['previous_page' => 'bakerysearch']);
        return view('admin.result', compact('results'));
    }

    public function showuseren($id)
    {
        // Retrieve the enquiry from the ContactUs table by its ID
        $enquiry = ContactUs::findOrFail($id);

        return view('admin.showenquiry', compact('enquiry'));
    }

    public function showbakeryen($id)
    {
        // Retrieve the enquiry from the ContactUs table by its ID
        $enquiry = BContactUs::findOrFail($id);

        return view('admin.showenquiry', compact('enquiry'));
    }

    public function showenquiry($id, $type)
    {
        // Determine the model to use based on the type parameter
        $model = $type === 'bakery' ? BContactUs::class : ContactUs::class;

        // Retrieve the enquiry from the appropriate table by its ID
        $enquiry = $model::findOrFail($id);

        return view('admin.showenquiry', compact('enquiry'));
    }

    public function updateEnquiryStatus(Request $request, $id, $type)
    {
        // Determine the model to use based on the type parameter
        $model = $type === 'bakery' ? BContactUs::class : ContactUs::class;

        // Retrieve the enquiry from the appropriate table by its ID
        $enquiry = $model::findOrFail($id);

        // Update the status
        $enquiry->status = $request->input('status');
        $enquiry->save();

        // Send email notification
        Mail::to($enquiry->email)->send(new EnquiryStatusUpdate($enquiry, $type));

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Enquiry status updated successfully.');
    }


    public function showUser($id)
    {
        // Fetch the user by ID
        $user = User::findOrFail($id);

        // Pass the user object to the view
        return view('admin.userdetails', [
            'user' => $user,
        ]);
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.useredit', compact('user'));
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $user->update($request->only(['name', 'email', 'phone', 'address', 'usertype']));

        return redirect()->route('admin.showUser', $id)->with('success', 'User details updated successfully');
    }

    public function destroyUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.userlist')->with('success', 'User deleted successfully');
    }

    public function showBakery($id)
    {
        // Fetch the user by ID, along with the related bakery
        $user = User::with('bakery')->findOrFail($id);

        // Pass the user object to the view
        return view('admin.bakerydetails', [
            'user' => $user,
        ]);
    }

    public function bakeryedit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.bakeryedit', compact('user'));
    }

    public function updateBakery(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Update user details
        $user->update($request->only(['name', 'email', 'phone', 'address', 'usertype']));

        // Check if the user has a related bakery
        if ($user->bakery) {
            // Update bakery details
            $user->bakery->update($request->only(['location']));
        }

        return redirect()->route('admin.showBakery', $id)->with('success', 'User and bakery details updated successfully');
    }

    public function destroyBakery($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.bakerylist')->with('success', 'Bakery deleted successfully');
    }

    public function bakeryApplicationList() 
    {
        // Retrieve applications and order by status and ID
        $applications = Application::orderByRaw("FIELD(status, 'to be reviewed') DESC")->orderBy('id', 'asc')->get();

        session(['previous_page' => 'bakeryApplicationList']);

        return view('admin.applicationlist', [
            'applications' => $applications,
        ]);
    }

    public function applicationSearch(Request $request)
    {
        $searchTerm = $request->input('search', ''); // Get the search term, default to empty string if not present
    
        // Initialize the query to search in the applications table
        $query = Application::orderByRaw("FIELD(status, 'to be reviewed') DESC")
            ->orderBy('id', 'asc');
    
        if (!empty($searchTerm)) {
            // Search by email or any other field you need, here it searches by email
            $query->where('email', 'like', '%' . $searchTerm . '%');
        }
    
        // Get the search results
        $results = $query->get();
        session(['previous_page' => 'searchbakery']);
        return view('admin.applicationresult', compact('results'));
    }
    

    public function showApplication($id)
    {
        // Retrieve the enquiry from the ContactUs table by its ID
        $application = Application::findOrFail($id);

        return view('admin.applicationdetails', compact('application'));
    }

    public function updateApplicationStatus(Request $request, $id)
    {
        $application = Application::findOrFail($id);

        // Update the application status
        $application->update($request->only(['status']));

        if ($request->input('status') == 'approved') {
            // Check if the user already exists
            $user = User::where('email', $application->email)->first();
            
            if (!$user) {
                // Create a new user
                $user = User::create([
                    'name' => $application->bakery_name,
                    'email' => $application->email,
                    'phone' => $application->phone,
                    'password' => bcrypt('abcd1234!'), // Set a default password or generate one
                    'usertype' => 'bakery',
                    'address' => $application->address,
                ]);

            }

            // Check if the bakery already exists
            $bakery = Bakery::where('user_id', $user->id)->first();

            if (!$bakery) {
                // Create a new bakery associated with the user
                Bakery::create([
                    'name' => $application->bakery_name,
                    'location' => $application->bakery_location,
                    'user_id' => $user->id,
                ]);
            }

        }
        Mail::to($application->email)->send(new ApplicationStatusUpdate($application));

        return redirect()->route('admin.showApplication', $id)->with('success', 'Application status updated successfully');
    }

    public function bloglist()
    {
        $posts = BlogPost::latest()->paginate(10);
        return view('admin.bloglist', compact('posts'));
    }

    public function viewblog($slug)
    {
        $post = BlogPost::where('slug', $slug)->firstOrFail();
        return view('admin.viewblog', compact('post'));
    }

    public function destroyBlog($id)
    {
        $post = BlogPost::findOrFail($id);
        $post->delete();

        return redirect()->route('admin.bloglist')->with('success', 'Blog deleted successfully');
    }


}

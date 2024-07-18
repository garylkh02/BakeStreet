<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Mail\CorporateOrderStatus;
use App\Mail\CorporateOrderReceipt;
use App\Models\CorporateOrder;

class CorporateOrderController extends Controller
{
    public function showCorporateOrderForm()
    {
        $states = [
            'Johor', 'Kedah', 'Kelantan', 'Kuala Lumpur', 'Labuan', 'Melaka', 'Negeri Sembilan', 'Pahang', 
            'Perak', 'Perlis', 'Penang', 'Putrajaya', 'Sabah', 'Sarawak', 'Selangor', 'Terengganu'
        ];
        return view('corporateOrder', compact('states'));
    }

    public function storeCorporateOrderForm(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'message' => 'required|string|max:1000',
            'location' => 'required|string',
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $file = $request->file('photo');
        $fileName = time().'.'.$file->getClientOriginalExtension();
        $path = $file->storeAs('images', $fileName, 'public');

        $corporateOrder = CorporateOrder::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'phone' => $validatedData['phone'],
            'message' => $validatedData['message'],
            'location' => $validatedData['location'],
            'status' => 'to be reviewed',
            'photo' => 'storage/'.$path,
        ]);

        // Sending email to the user who submitted the order
        Mail::to($validatedData['email'])->send(new CorporateOrderReceipt($corporateOrder));

        return redirect()->route('corporateOrder.store')->with('success', 'Corporate order submitted successfully.');
    }

    public function corporateOrderList()
    {
        $corporateOrders = CorporateOrder::all();

        return view('admin.corporateOrderList', compact('corporateOrders'));
    }

    public function corporateOrderDetails($id)
    {
        $corporateOrders = CorporateOrder::findOrFail($id);

        return view('admin.corporateOrderDetails', [
            'corporateOrder' => $corporateOrders,
        ]);
    }

    public function updateCorporateOrderStatus(Request $request, $id)
    {
        $validatedData = $request->validate([
            'status' => 'required|string|max:255',
        ]);

        // Find the corporate order by ID
        $corporateOrder = CorporateOrder::findOrFail($id);

        // Update the status
        $corporateOrder->status = $validatedData['status'];
        $corporateOrder->save();

        // Send email notification
        Mail::to($corporateOrder->email)->send(new CorporateOrderStatus($corporateOrder));

        return redirect()->route('corporateOrders.show', $id)->with('success', 'Status updated successfully.');
    }

    public function corporateOrderSearch(Request $request)
    {
        $searchTerm = $request->input('search', ''); 

        $query = CorporateOrder::query();

        if (!empty($searchTerm)) {
            $query->where('email', 'like', '%' . $searchTerm . '%');
        }

        $results = $query->get();
        session(['previous_page' => 'cordersearch']);

        return view('admin.corporateOrderResult', compact('results'));
    }

}


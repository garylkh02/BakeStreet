<?php

namespace App\Http\Controllers\Bakery;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\BakeryContactUsNotification;
use App\Models\BContactUs;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BContactUsController extends Controller
{
    public function showForm()
    {
        return view('bakery.bakerycontactus');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|string|email|max:255',
            'message' => 'required|string|max:500'
        ]);

        $user = Auth::user();

        $bakery = $user->bakery;

        if (!$bakery) {
            return redirect('/')->with('error', 'No bakery associated with this user.');
        }

        $bakerycontactus = new BContactUs();

        $bakerycontactus->name = $request->input('name');
        $bakerycontactus->phone = $request->input('phone');
        $bakerycontactus->email = $request->input('email');
        $bakerycontactus->message = $request->input('message');
        $bakerycontactus->bakery_id = $bakery->id; 
        $bakerycontactus->status = 'to be reviewed';

        $bakerycontactus->save();

        Mail::to($bakerycontactus->email)->send(new BakeryContactUsNotification($bakerycontactus));
        
        return redirect('/bakery/dashboard')->with('success', 'Enquiry submitted successfully!');
    }
}





    


<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use App\Mail\ContactUsNotification;
use App\Models\ContactUs;
use Illuminate\Http\Request;

class ContactUsController extends Controller
{
    public function showForm()
    {
        return view('contactus');
    }

    public function store(Request $request)
    {
        $contactus = new ContactUs();

        $contactus->name = $request->input('name');
        $contactus->phone = $request->input('phone');
        $contactus->email = $request->input('email');
        $contactus->message = $request->input('message');
        $contactus->status = 'to be reviewed'; // Assign the default status

        $contactus->save();

        Mail::to($contactus->email)->send(new ContactUsNotification($contactus));

        return redirect('/')->with('success', 'Enquiry submitted successfully!');
    }
}





    


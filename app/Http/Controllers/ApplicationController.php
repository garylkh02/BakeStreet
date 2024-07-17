<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Mail\BakeryApplication;
use App\Models\Application;
use App\Models\User;

class ApplicationController extends Controller
{
    public function showForm()
    {
        return view('bakeryapplication');
    }

    public function store(Request $request)
    {
        // Check if the email exists in the users table
        if (User::where('email', $request->input('email'))->exists()) {
            return redirect()->back()->with('error', 'This email is already in use. Please enter another email.');
        }

        // Create a new application
        $application = new Application();

        $application->name = $request->input('name');
        $application->email = $request->input('email');
        $application->phone = $request->input('phone');
        $application->bakery_name = $request->input('bakery_name');
        $application->bakery_location = $request->input('bakery_location');
        $application->address = $request->input('address');
        $application->social_media_link = $request->input('social_media_link');
        $application->message = $request->input('message');
        $application->status = 'to be reviewed';

        $application->save();

        // Send confirmation email
        Mail::to($application->email)->send(new BakeryApplication($application));

        return redirect('/')->with('success', 'Application submitted successfully!');
    }

}

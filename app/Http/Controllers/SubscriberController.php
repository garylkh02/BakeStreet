<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subscriber;

class SubscriberController extends Controller
{
    public function showSubscribeForm()
    {
        return view('subscribe');
    }

    public function subscribe(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);
    
        // Check if the email already exists in the subscribers table
        if (Subscriber::where('email', $request->email)->exists()) {
            return redirect()->back()->with('error', 'You are already subscribed!');
        }

        Subscriber::create(['email' => $request->email]);
    
        return redirect()->back()->with('success', 'Subscribed successfully!');
    }
    
    public function unsubscribe(Request $request)
    {
        $subscriber = Subscriber::where('email', $request->email)->first();
        if ($subscriber) {
            $subscriber->delete();
            return redirect()->back()->with('success', 'Unsubscribed successfully!');
        }
    
        return redirect()->back()->with('error', 'Email not found!');
    }
    
}

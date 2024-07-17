<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subscriber;
use Illuminate\Support\Facades\Mail;

class NewsletterController extends Controller
{
    public function showNewsletterForm()
    {
        return view('admin.newsletter');
    }

    public function sendNewsletter(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|max:2048'
        ]);

        $subscribers = Subscriber::where('is_subscribed', true)->get();

        foreach ($subscribers as $subscriber) {
            Mail::send('emails.newsletter', ['title' => $request->title, 'content' => $request->content, 'image' => $request->image], function ($message) use ($subscriber, $request) {
                $message->to($subscriber->email)
                        ->subject($request->title);
            });
        }

        return redirect()->back()->with('success', 'Newsletter sent successfully!');
    }
}


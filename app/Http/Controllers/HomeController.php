<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;

class HomeController extends Controller
{

    public function index()
    {
        $latestBlogPosts = BlogPost::latest()->take(3)->get(); // Fetch the latest 3 blog posts

        return view('welcome', compact('latestBlogPosts'));
    }

    public function faq()
    {
        return view('faq');
    }

    public function about()
    {
        return view('aboutus');
    }
        
}

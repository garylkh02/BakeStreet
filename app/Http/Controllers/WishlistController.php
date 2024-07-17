<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Cake;

class WishlistController extends Controller
{
    public function add(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['status' => 'not_logged_in']);
        }

        $user = Auth::user();
        $cakeId = $request->input('cake_id');

        if (!$user->wishlist->contains($cakeId)) {
            $user->wishlist()->attach($cakeId);
            return response()->json(['status' => 'added']);
        }

        return response()->json(['status' => 'already_added']);
    }

    public function remove(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['status' => 'not_logged_in']);
        }

        $user = Auth::user();
        $cakeId = $request->input('cake_id');

        if ($user->wishlist->contains($cakeId)) {
            $user->wishlist()->detach($cakeId);
            return response()->json(['status' => 'removed']);
        }

        return response()->json(['status' => 'not_in_wishlist']);
    }

    public function list()
    {
        $user = Auth::user();
        $wishlistItems = $user->wishlist()->where('visible', true)->get();
        return view('favlist', compact('wishlistItems'));
    }

    
    
    

    
}

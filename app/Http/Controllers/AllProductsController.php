<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Cake;

class AllProductsController extends Controller
{
    public function index()
    {
        $cakes = Cake::where('visible', true)->with('reviews.user')->latest()->get();

        return view('cakes.index', [
            'cakes' => $cakes,
        ]);
    }
    

    public function show($id) {
        $cake = Cake::with('reviews.user')->findOrFail($id);
        $averageRating = $cake->reviews()->avg('rating');
        $reviews = $cake->reviews;
        $reviewCount = $cake->reviews()->count();
        $displayReviews = $reviews->shuffle()->take(5);
        $addons = json_decode($cake->addons, true);
        $sizes = json_decode($cake->size, true);
    
        // Get the list of cake IDs with the highest counts from the wishlists table
        $recommendedCakeIds = DB::table('wishlists')
            ->select('cake_id', DB::raw('count(cake_id) as wishlist_count'))
            ->groupBy('cake_id')
            ->orderBy('wishlist_count', 'desc')
            ->take(3)
            ->pluck('cake_id');
    
        // Fetch the cake details using the IDs from the first query
        $recommendedCakes = Cake::whereIn('id', $recommendedCakeIds)
            ->where('category_id', $cake->category_id)
            ->get();
    
        return view('cakes.show', compact('cake', 'averageRating', 'reviews', 'reviewCount', 'displayReviews', 'recommendedCakes', 'addons', 'sizes'));
    }

    public function christmas() {
        $cakes = Cake::where('occasions', 'Christmas')->latest()->get();     
        return view('cakes.christmas', [
            'cakes' => $cakes,
        ]);
    }

    public function klselangor() {
        $cakes = Cake::whereHas('bakery', function ($query) {
            $query->where('location', 'Selangor');
        })->latest()->get();

        return view('cakes.klselangor', ['cakes' => $cakes]);
    }

    public function penang() {
        $cakes = Cake::whereHas('bakery', function ($query) {
            $query->where('location', 'Penang');
        })->latest()->get();

        return view('cakes.penang', ['cakes' => $cakes]);
    }

    public function jb() {
        $cakes = Cake::whereHas('bakery', function ($query) {
            $query->where('location', 'Johor');
        })->latest()->get();

        return view('cakes.johor', ['cakes' => $cakes]);
    }

    public function fivehours() {
        $cakes = Cake::where('preptime', '5hours')->latest()->get();     
        return view('cakes.5hours', [
            'cakes' => $cakes,
        ]);
    }

    public function oneday() {
        $cakes = Cake::where('preptime', '1day')->latest()->get();     
        return view('cakes.1day', [
            'cakes' => $cakes, 
        ]);
    }

    public function twodays() {
        $cakes = Cake::where('preptime', '2day')->latest()->get();     
        return view('cakes.2days', [
            'cakes' => $cakes,
        ]);
    }

    public function threedays() {
        $cakes = Cake::where('preptime', '3day')->latest()->get();     
        return view('cakes.3days', [
            'cakes' => $cakes,
        ]);
    }

    public function selfcollect() {
        $cakes = Cake::where('selfcollect', '1')->latest()->get();     
        return view('cakes.selfcollect', [
            'cakes' => $cakes,
        ]);
    }

    // search function
    public function search() {
        $cakes = Cake::latest()->get(); 
    
        if(request()->has('search')){
            $searchTerm = request()->get('search');
            $cakes = $cakes->filter(function ($cake) use ($searchTerm) {
                return strpos(strtolower($cake->name), strtolower($searchTerm)) !== false ||
                       strpos(strtolower($cake->flavour->name), strtolower($searchTerm)) !== false ||
                       strpos(strtolower($cake->category->name), strtolower($searchTerm)) !== false;
            });
        }
    
        return view('cakes.result', [
            'cakes' => $cakes
        ]);
    }
    
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\User;
use App\Models\LoyaltyPoint;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'cake_id' => 'required|exists:cakes,id',
            'order_id' => 'required|exists:orders,id',
            'review' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $existingReview = Review::where('user_id', Auth::id())
            ->where('cake_id', $request->cake_id)
            ->where('order_id', $request->order_id)
            ->first();

        if ($existingReview) {
            // Update the existing review
            $existingReview->update([
                'review' => $request->review,
                'rating' => $request->rating,
            ]);

            return redirect()->back()->with('success', 'Review updated successfully.');
        } else {
            // Create a new review
            Review::create([
                'user_id' => Auth::id(),
                'cake_id' => $request->cake_id,
                'order_id' => $request->order_id,
                'review' => $request->review,
                'rating' => $request->rating,
            ]);

            // Add loyalty points for the new review
            $this->addLoyaltyPoints($request);

            return redirect()->back()->with('success', 'Review submitted successfully.');
        }
    }

    protected function addLoyaltyPoints(Request $request)
    {
        $points = 10; // Example: 10 point per review

        // Retrieve the user
        $user = User::find(Auth::id());

        // Add the new points to the existing points
        $user->loyalty_points += $points;

        // Save the updated points
        $user->save();

        // Create a new loyalty points record
        LoyaltyPoint::create([
            'user_id' => Auth::id(),
            'order_id' => $request->order_id,
            'points' => $points,
            'description' => 'Review Reward for Order ' . $request->order_id,
        ]);
    }

    public function showUserReviews()
    {
        $user = Auth::user();

        $reviews = Review::where('user_id', $user->id)
            ->with(['cake', 'cake.bakery', 'order'])
            ->get();

        return view('reviews', [
            'reviews' => $reviews,
        ]);
    }
}

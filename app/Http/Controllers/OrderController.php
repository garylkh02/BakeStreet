<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Review;
use Carbon\Carbon;


class OrderController extends Controller
{
    public function showPaymentPage(Request $request)
    {
        $orderId = $request->orderId; // Pass the orderId from the request
        return view('payment', compact('orderId'));
    }
    
    public function showSuccessPage(Request $request, $orderId)
    {
        $order = Order::with('cakes')->findOrFail($orderId);

        $order->status = 'pending';
        $order->save();
        // Compute the subtotal
        $subtotal = $order->cakes->sum(function($cake) {
            return $cake->pivot->price * $cake->pivot->quantity;
        });

        // Calculate the service tax and total price
        $serviceTax = $subtotal * 0.06;
        $totalPrice = $subtotal + $serviceTax;

        return view('success', compact('order', 'subtotal', 'serviceTax', 'totalPrice'));
    }

    public function list()
    {
        $orders = Order::where('user_id', auth()->id())
                        ->where('created_at', '<', Carbon::now()->subMinutes(10))
                        ->where('status', 'checking')
                        ->orderBy('created_at', 'desc')
                        ->get();

        // Delete the fetched orders
        foreach ($orders as $order) {
            $order->delete();
        }

        // Fetch and return the remaining orders
        $remainingOrders = Order::where('user_id', auth()->id())
                                ->orderBy('created_at', 'desc')
                                ->get();
        
        session(['previous_page' => 'orderhis']);

        return view('orderlist', compact('remainingOrders'));
    }

    
    public function show($orderId)
    {
        $order = Order::with('cakes')->findOrFail($orderId);

        // Check if the order status is cancelled
        if ($order->status == 'cancelled') {
            return view('cancel', compact('order'));
        }

        // Compute the subtotal
        $subtotal = $order->cakes->sum(function($cake) {
            return $cake->pivot->price * $cake->pivot->quantity;
        });

        // Calculate the service tax and total price
        $serviceTax = $subtotal * 0.06;
        $totalPrice = $subtotal + $serviceTax;

        // Determine the delivery fee based on the delivery method
        $deliveryFee = 0.00;
        if ($totalPrice <= 100) {
            $deliveryFee = 8.00; 
        }

        $reviews = Review::where('order_id', $orderId)
                        ->where('user_id', $order->user_id)
                        ->get()
                        ->keyBy('cake_id');

        return view('orderdetails', compact('order', 'subtotal', 'serviceTax', 'totalPrice', 'reviews', 'deliveryFee'));
    }

    public function deleteOrder(Request $request)
    {
        $orderId = $request->orderId;
        $order = Order::findOrFail($orderId);

        if ($order->user_id != auth()->id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized']);
        }

        $order->delete();

        return response()->json(['success' => true, 'message' => 'Order deleted successfully']);
    }

   
}


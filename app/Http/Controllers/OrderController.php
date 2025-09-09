<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'food_id' => 'required|exists:foods,id',
            'customer_name' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'phone_number' => 'required|string|max:20',
        ]);

        $order = Order::create([
            'food_id' => $request->food_id,
            'customer_name' => $request->customer_name,
            'quantity' => $request->quantity,
            'phone_number' => $request->phone_number,
        ]);

        return response()->json(['message' => 'Order placed successfully!', 'order' => $order], 201);
    }
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Models\Food;
use App\Models\Order;

class FoodController extends Controller
{
    public function index()
    {
        $foods = Food::all();
        $orders = Order::with('food')->latest()->get();
        return view('welcome', compact('foods', 'orders'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'image_url' => 'nullable|url',
            'image' => 'nullable|image|max:2048',
        ]);

        // Prefer uploaded image over URL if provided
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('foods', 'public');
            $validated['image_url'] = Storage::url($path);
        }

        Food::create($validated);

        return redirect()->back()->with('success', 'Food item created successfully.');
    }

    public function edit(Food $food)
    {
        return view('edit-food', compact('food'));
    }

    public function update(Request $request, Food $food)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'image_url' => 'nullable|url',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('foods', 'public');
            $validated['image_url'] = Storage::url($path);
        }

        $food->update($validated);

        return redirect('/')->with('success', 'Food item updated successfully.');
    }

    public function destroy(Food $food)
    {
        $food->delete();

        return redirect()->back()->with('success', 'Food item deleted successfully.');
    }
}

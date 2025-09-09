<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

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

        // Prefer uploaded image over URL if provided and valid
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $uploadDirectory = public_path('uploads/foods');
            if (! File::exists($uploadDirectory)) {
                File::makeDirectory($uploadDirectory, 0755, true);
            }

            $uploadedFile = $request->file('image');
            $extension = $uploadedFile->getClientOriginalExtension() ?: 'jpg';
            $filename = uniqid('food_', true).'.'.$extension;
            $uploadedFile->move($uploadDirectory, $filename);

            $validated['image_url'] = '/uploads/foods/'.$filename;
        } else {
            // Normalize empty string to null to avoid saving empty paths
            if (isset($validated['image_url']) && $validated['image_url'] === '') {
                $validated['image_url'] = null;
            }
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

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $uploadDirectory = public_path('uploads/foods');
            if (! File::exists($uploadDirectory)) {
                File::makeDirectory($uploadDirectory, 0755, true);
            }

            $uploadedFile = $request->file('image');
            $extension = $uploadedFile->getClientOriginalExtension() ?: 'jpg';
            $filename = uniqid('food_', true).'.'.$extension;
            $uploadedFile->move($uploadDirectory, $filename);

            $validated['image_url'] = '/uploads/foods/'.$filename;
        } else {
            if (isset($validated['image_url']) && $validated['image_url'] === '') {
                $validated['image_url'] = null;
            }
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

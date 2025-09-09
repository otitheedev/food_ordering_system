<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FoodController;
use App\Http\Controllers\OrderController; // Add this line

use App\Models\Food;

Route::get('/', [FoodController::class, 'index']);

Route::get('/dashboard', function () {
    $foods = Food::all();
    return view('dashboard', compact('foods'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Food Routes
Route::resource('foods', FoodController::class)->only([
    'index'
]);

Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('foods', FoodController::class)->only([
        'store', 'edit', 'update', 'destroy'
    ]);
});

// Order Routes
Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');

require __DIR__.'/auth.php';

<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\AuctionController;

Route::get('/', function () {
  return redirect()->route('login');
});

Route::get('/dashboard', function () {
  return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
  // Redirect based on user role
  Route::get('/dashboard', function () {
    if (auth()->user()->role === 'admin') {
      return redirect()->route('admin.dashboard');
    }

    return redirect()->route('customer.dashboard');
  })->name('dashboard');

  Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
  Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
  Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin routes
Route::middleware(['auth', 'admin'])->group(function () {
  Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
  })->name('admin.dashboard');
});

Route::middleware(['auth', 'admin'])
  ->prefix('admin')
  ->name('admin.')
  ->group(function () {
    Route::resource('products', ProductController::class);
    Route::resource('auctions', AuctionController::class);
});

// Customer routes
Route::middleware(['auth'])->group(function () {
  Route::get('/customer/dashboard', function () {
    return view('customer.dashboard');
  })->name('customer.dashboard');
});

require __DIR__.'/auth.php';
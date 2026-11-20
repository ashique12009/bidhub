<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
  return view('welcome');
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

// Customer routes
Route::middleware(['auth'])->group(function () {
  Route::get('/customer/dashboard', function () {
    return view('customer.dashboard');
  })->name('customer.dashboard');
});

require __DIR__.'/auth.php';
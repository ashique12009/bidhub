<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\ProductController;
use App\Http\Controllers\Api\V1\AuctionController;

Route::get('/user', function (Request $request) {
  return $request->user();
})->middleware('auth:sanctum');

Route::prefix('v1')->group(function () {
  Route::get('/products', [ProductController::class, 'index']);
  Route::get('/products/{product}', [ProductController::class, 'show']);

  Route::get('/auctions', [AuctionController::class, 'index']);
  Route::get('/auctions/{auction}', [AuctionController::class, 'show']);
});
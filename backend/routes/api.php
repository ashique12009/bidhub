<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\ProductController;
use App\Http\Controllers\Api\V1\AuctionController;
use App\Http\Controllers\Api\V1\BidController;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\UserController;

// Route::get('/user', function (Request $request) {
//   return $request->user();
// })->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
  Route::get('/user', [UserController::class, 'profile']);
  Route::get('/user/bids', [UserController::class, 'bids']);
});

Route::prefix('v1')->group(function () {
  Route::get('/products', [ProductController::class, 'index']);
  Route::get('/products/{product}', [ProductController::class, 'show']);

  Route::get('/auctions', [AuctionController::class, 'index']);
  Route::get('/auctions/{auction}', [AuctionController::class, 'show']);

  Route::get('/auctions/{auction}/bids', [BidController::class, 'index']);
  Route::post('/auctions/{auction}/bids', [BidController::class, 'store'])
      ->middleware('auth:sanctum');

  Route::post('/login', [AuthController::class, 'login']);
});
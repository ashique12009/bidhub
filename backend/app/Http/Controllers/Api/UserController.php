<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use App\Http\Resources\V1\BidResource;

class UserController extends Controller {
  public function profile(Request $request) {
    return new UserResource($request->user());
  }

  public function bids(Request $request) {
    $bids = $request->user()
        ->bids()
        ->with('auction.product')
        ->latest()
        ->paginate(10);

    return BidResource::collection($bids);
  }
}
<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\AuctionResource;
use App\Models\Auction;

class AuctionController extends Controller {
  public function index() {
    $auctions = Auction::with('product')->latest()->paginate(6);

    return AuctionResource::collection($auctions);
  }

  public function show(Auction $auction) {
    $auction->load('product');

    return new AuctionResource($auction);
  }
}
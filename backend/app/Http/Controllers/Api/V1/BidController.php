<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\BidResource;
use App\Models\Auction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BidController extends Controller {
  public function index(Auction $auction) {
    $bids = $auction->bids()
        ->with('user')
        ->latest()
        ->paginate(10);

    return BidResource::collection($bids);
  }

  public function store(Request $request, Auction $auction) {
    return DB::transaction(function () use ($request, $auction) {
      // Lock auction row to prevent concurrent bids
      $lockedAuction = Auction::query()
          ->whereKey($auction->id)
          ->lockForUpdate()
          ->firstOrFail();

      $now = now();

      // Check auction time
      if (
        $now->lt($lockedAuction->start_time) ||
        $now->gte($lockedAuction->end_time)
      ) {
        return response()->json([
          'message' => 'Auction is not active.',
        ], 422);
      }

      // Find the current highest bid
      $highestBid = $lockedAuction->bids()->max('bid_amount');

      $minimumAmount = $highestBid ?? $lockedAuction->starting_price;

      // Validate bid amount
      $validated = $request->validate([
        'bid_amount' => [
          'required',
          'numeric',
          'gt:' . $minimumAmount,
        ],
      ]);

      // Save bid
      $bid = $lockedAuction->bids()->create([
        'user_id'    => $request->user()->id,
        'bid_amount' => $validated['bid_amount'],
      ]);

      return new BidResource($bid->load('user'));
    });
  }
}
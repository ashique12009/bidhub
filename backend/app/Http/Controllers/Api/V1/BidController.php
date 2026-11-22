<?php
namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\BidResource;
use App\Models\Auction;
use Illuminate\Http\Request;

class BidController extends Controller {
  public function index(Auction $auction) {
    $bids = $auction->bids()
        ->with('user')
        ->latest()
        ->paginate(10);

    return BidResource::collection($bids);
  }

  public function store(Request $request, Auction $auction) {
    $now = now();

    if ($now->lt($auction->start_time) || $now->gte($auction->end_time)) {
      return response()->json([
        'message' => 'Auction is not active.',
      ], 422);
    }

    $highestBid = $auction->bids()->max('bid_amount');

    $minimumAmount = $highestBid ?? $auction->starting_price;

    $validated = $request->validate([
      'bid_amount' => ['required', 'numeric', 'gt:' . $minimumAmount],
    ]);

    $bid = $auction->bids()->create([
      'user_id'     => $request->user()->id,
      'bid_amount'  => $validated['bid_amount'],
    ]);

    return new BidResource($bid->load('user'));
  }
}
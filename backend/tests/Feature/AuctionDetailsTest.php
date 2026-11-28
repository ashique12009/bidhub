<?php

use App\Models\Auction;
use App\Models\Bid;
use App\Models\Product;
use App\Models\User;

it('returns the highest bid as the current price in auction details', function () {
  $product = Product::create([
    'name' => 'Auction item',
  ]);
  $auction = Auction::create([
    'product_id'     => $product->id,
    'starting_price' => 700,
    'start_time'     => now()->subHour(),
    'end_time'       => now()->addHour(),
  ]);
  $user = User::factory()->create();

  Bid::create([
    'auction_id' => $auction->id,
    'user_id'    => $user->id,
    'bid_amount' => 710,
  ]);

  $this->getJson("/api/v1/auctions/{$auction->id}")
      ->assertOk()
      ->assertJsonPath('data.current_price', '710.00');
});

<?php

namespace App\Http\Resources\V1;

use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BidResource extends JsonResource {
  public function toArray(Request $request): array {
    return [
      'id'         => $this->id,
      'bid_amount' => $this->bid_amount,
      'auction'    => [
        'id'      => $this->auction->id,
        'product' => $this->auction->product->name,
      ],
      'created_at' => $this->created_at,
    ];
  }
}
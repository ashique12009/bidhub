<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BidResource extends JsonResource {
  public function toArray(Request $request): array {
    return [
      'id'         => $this->id,
      'amount'     => $this->bid_amount,
      'user'       => $this->user->name,
      'created_at' => $this->created_at,
    ];
  }
}
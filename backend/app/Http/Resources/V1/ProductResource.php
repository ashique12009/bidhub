<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource {
  public function toArray(Request $request): array {
    return [
      'id'          => $this->id,
      'name'        => $this->name,
      'description' => $this->description,
      'status'      => $this->status,
      'image'       => $this->image
          ? asset('storage/' . $this->image)
          : null,
      'created_at'  => $this->created_at,
      'auction'     => $this->whenLoaded('auction', function () {
        if (!$this->auction) {
          return null;
        }

        return [
          'id'             => $this->auction->id,
          'starting_price' => $this->auction->starting_price,
          'current_price'  => number_format(
            $this->auction->bids_max_bid_amount ?? $this->auction->starting_price,
            2,
            '.',
            ''
          ),
        ];
      }),
    ];
  }
}
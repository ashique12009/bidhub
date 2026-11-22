<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AuctionResource extends JsonResource {
  public function toArray(Request $request): array {
    $now = now();

    if ($now->lt($this->start_time)) {
      $status = 'scheduled';
    } elseif ($now->gte($this->end_time)) {
      $status = 'ended';
    } else {
      $status = 'active';
    }

    return [
      'id'             => $this->id,
      'starting_price' => $this->starting_price,
      'start_time'     => $this->start_time,
      'end_time'       => $this->end_time,
      'status'         => $status,

      'product' => [
        'id'          => $this->product->id,
        'name'        => $this->product->name,
        'description' => $this->product->description,
        'image'       => $this->product->image
            ? asset('storage/' . $this->product->image)
            : null,
      ],
    ];
  }
}
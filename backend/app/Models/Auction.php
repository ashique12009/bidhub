<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Auction extends Model
{
  protected $fillable = [
    'product_id',
    'starting_price',
    'start_time',
    'end_time',
    'status',
  ];

  protected function casts(): array
  {
    return [
      'starting_price'  => 'decimal:2',
      'start_time'      => 'datetime',
      'end_time'        => 'datetime',
    ];
  }

  public function product(): BelongsTo
  {
    return $this->belongsTo(Product::class);
  }
}

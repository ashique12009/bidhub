<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Product extends Model
{
  protected $fillable = [
    'name',
    'description',
    'image',
    'status',
    'is_featured',
  ];

  public function auction(): HasOne
  {
    return $this->hasOne(Auction::class);
  }
}
<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAuctionRequest extends FormRequest
{
  public function authorize(): bool
  {
    return true;
  }

  public function rules(): array
  {
    return [
      'product_id' => [
        'required',
        'integer',
        'exists:products,id',
        'unique:auctions,product_id',
      ],

      'starting_price' => [
        'required',
        'numeric',
        'min:0',
        'decimal:0,2',
      ],

      'start_time' => [
        'required',
        'date',
        'after:now',
      ],

      'end_time' => [
        'required',
        'date',
        'after:start_time',
      ],
    ];
  }

  public function messages(): array
  {
    return [
      'product_id.required'     => 'Please select a product.',
      'product_id.exists'       => 'The selected product does not exist.',
      'product_id.unique'       => 'This product already has an auction.',

      'starting_price.required' => 'Starting price is required.',
      'starting_price.numeric'  => 'Starting price must be a number.',
      'starting_price.min'      => 'Starting price cannot be negative.',
      'starting_price.decimal'  => 'Starting price can have maximum 2 decimal places.',

      'start_time.required'     => 'Auction start time is required.',
      'start_time.after'        => 'Auction start time must be in the future.',

      'end_time.required'  => 'Auction end time is required.',
      'end_time.after'     => 'Auction end time must be after the start time.',
    ];
  }
}
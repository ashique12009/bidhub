<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Auction;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Requests\StoreAuctionRequest;
use App\Http\Requests\UpdateAuctionRequest;

class AuctionController extends Controller
{
  public function index()
  {
    $auctions = Auction::with('product')->latest()->paginate(10);

    return view('admin.auctions.index', compact('auctions'));
  }

  public function create()
  {
    $products = Product::where('status', 'active')->whereDoesntHave('auction')->get();

    return view('admin.auctions.create', compact('products'));
  }

  public function store(StoreAuctionRequest $request)
  {
    Auction::create($request->validated());

    return redirect()
        ->route('admin.auctions.index')
        ->with('success', 'Auction created successfully.');
  }

  public function edit(Auction $auction)
  {
    $products = Product::where('status', 'active')
      ->where(function ($query) use ($auction) {
          $query->whereDoesntHave('auction')->orWhere('id', $auction->product_id);
      })
      ->get();

    return view('admin.auctions.edit', compact('auction', 'products'));
  }

  public function update(UpdateAuctionRequest $request, Auction $auction)
  {
    $auction->update($request->validated());

    return redirect()
      ->route('admin.auctions.index')
      ->with('success', 'Auction updated successfully.');
  }

  public function show(Auction $auction)
  {
    $auction->load('product');

    return view('admin.auctions.show', compact('auction'));
  }

  public function destroy(Auction $auction)
  {
    $auction->delete();

    return redirect()
      ->route('admin.auctions.index')
      ->with('success', 'Auction deleted successfully.');
  }
}
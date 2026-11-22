<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;

class ProductSeeder extends Seeder {
  /**
   * Run the database seeds.
   */
  public function run(): void {
    $statuses = ['active', 'pending', 'inactive'];

    // Folder na thakle create korbe
    Storage::disk('public')->makeDirectory('products');

    for ($i = 1; $i <= 40; $i++) {
      $imageName = "products/product-{$i}.jpg";

      // Online theke random dummy image download (640x480)
      $response = Http::get("https://picsum.photos/seed/product{$i}/640/480");

      if ($response->successful()) {
        Storage::disk('public')->put($imageName, $response->body());
      } else {
        $imageName = null; // Internet issue hole null rakhbe
      }

      Product::create([
        'name'        => "Auction Product #{$i}",
        'description' => "Detailed description for auction product #{$i}. Available for bidding with verified condition.",
        'image'       => $imageName,
        'status'      => $statuses[array_rand($statuses)],
      ]);
    }
  }
}

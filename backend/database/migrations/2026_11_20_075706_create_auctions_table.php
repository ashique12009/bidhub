<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    Schema::create('auctions', function (Blueprint $table) {
      $table->id();

      $table->foreignId('product_id')
        ->unique()
        ->constrained()
        ->cascadeOnDelete();

      $table->decimal('starting_price', 12, 2);

      $table->timestamp('start_time');
      $table->timestamp('end_time');

      $table->string('status')->default('scheduled');

      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('auctions');
  }
};

<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800">
      Auction Details
    </h2>
  </x-slot>

  <div class="max-w-3xl mx-auto py-6">
    <div class="bg-white p-6 rounded shadow max-w-2xl">

      <h3 class="text-lg font-bold mb-4">
        {{ $auction->product->name }}
      </h3>

      <p class="mb-2">
        <strong>Starting Price:</strong>
        {{ number_format($auction->starting_price, 2) }}
      </p>

      <p class="mb-2">
        <strong>Start Time:</strong>
        {{ $auction->start_time->format('d M Y H:i') }}
      </p>

      <p class="mb-2">
        <strong>End Time:</strong>
        {{ $auction->end_time->format('d M Y H:i') }}
      </p>

      <p class="mb-4">
        <strong>Status:</strong>
        {{ ucfirst($auction->status) }}
      </p>

      <a href="{{ route('admin.auctions.edit', $auction) }}"
        class="text-indigo-600">
        Edit Auction
      </a>

      <a href="{{ route('admin.auctions.index') }}"
        class="ml-4 text-gray-600">
        Back
      </a>
    </div>
  </div>

</x-app-layout>
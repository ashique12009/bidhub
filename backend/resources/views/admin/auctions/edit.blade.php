<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800">
      Edit Auction
    </h2>
  </x-slot>

  <div class="max-w-3xl mx-auto py-6">
    <form
      action="{{ route('admin.auctions.update', $auction) }}"
      method="POST"
      class="bg-white p-6 shadow rounded"
    >
      @method('PUT')

      @include('admin.auctions.form')
    </form>
  </div>
</x-app-layout>

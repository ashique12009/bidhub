<x-app-layout>

  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800">
      Auctions
    </h2>
  </x-slot>

  <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
    <div class="mb-4">
      <a href="{{ route('admin.auctions.create') }}"
        class="px-4 py-2 bg-indigo-600 text-white rounded">
        Create Auction
      </a>
    </div>

    @if (session('success'))
      <div class="bg-green-100 text-green-700 p-3 mb-4 rounded">
        {{ session('success') }}
      </div>
    @endif

    @if ($errors->any())
      <div class="mb-4 text-red-600">
        <ul>
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <div class="bg-white shadow rounded mt-5 p-5">
      <table class="w-full border-collapse border">
        <thead>
          <tr class="bg-gray-100">
            <th class="border p-3">#</th>
            <th class="border p-3">Product</th>
            <th class="border p-3">Starting Price</th>
            <th class="border p-3">Start Time</th>
            <th class="border p-3">End Time</th>
            <th class="border p-3">Actions</th>
          </tr>
        </thead>

        <tbody>
          @forelse ($auctions as $auction)
            <tr>
              <td class="border p-3">
                {{ $auction->id }}
              </td>

              <td class="border p-3">
                {{ $auction->product->name }}
              </td>

              <td class="border p-3">
                {{ number_format($auction->starting_price, 2) }}
              </td>

              <td class="border p-3">
                {{ $auction->start_time->format('d M Y H:i') }}
              </td>

              <td class="border p-3">
                {{ $auction->end_time->format('d M Y H:i') }}
              </td>

              <td class="border p-3 space-x-2">
                <a href="{{ route('admin.auctions.show', $auction) }}"
                  class="text-blue-600">
                  View
                </a>

                <a href="{{ route('admin.auctions.edit', $auction) }}"
                  class="text-indigo-600">
                  Edit
                </a>

                <form
                  action="{{ route('admin.auctions.destroy', $auction) }}"
                  method="POST"
                  class="inline"
                  onsubmit="return confirm('Are you sure?')"
                >
                  @csrf
                  @method('DELETE')

                  <button type="submit" class="text-red-600">
                    Delete
                  </button>
                </form>

              </td>
            </tr>
          @empty
            <tr>
              <td colspan="6" class="text-center p-4">
                No auctions found.
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>

      <div class="mt-4">
        {{ $auctions->links() }}
      </div>
    </div>
  </div>

</x-app-layout>
<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800">
      Products
    </h2>
  </x-slot>

  <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">

    @if(session('success'))
      <div class="bg-green-100 text-green-700 p-3 mb-4 rounded">
        {{ session('success') }}
      </div>
    @endif

    <a href="{{ route('admin.products.create') }}"
      class="bg-blue-600 text-white px-4 py-2 rounded">
      Add Product
    </a>

    <div class="bg-white shadow rounded mt-5 p-5">
      <table class="w-full text-left">
        <thead>
          <tr class="border-b">
            <th class="p-3">Image</th>
            <th class="p-3">Name</th>
            <th class="p-3">Status</th>
            <th class="p-3">Actions</th>
          </tr>
        </thead>

        <tbody>
          @forelse($products as $product)
            <tr class="border-b">
              <td class="p-3">
                @if($product->image)
                  <img src="{{ asset('storage/' . $product->image) }}"
                    class="w-16 h-16 object-cover rounded"
                    alt="{{ $product->name }}">
                @else
                  No image
                @endif
              </td>
              <td class="p-3">{{ $product->name }}</td>
              <td class="p-3">{{ $product->status }}</td>
              <td class="p-3">
                <a href="{{ route('admin.products.edit', $product) }}"
                  class="text-blue-600">Edit</a>

                <form action="{{ route('admin.products.destroy', $product) }}"
                    method="POST" class="inline">
                  @csrf
                  @method('DELETE')

                  <button class="text-red-600 ml-3"
                    onclick="return confirm('Delete this product?')">
                    Delete
                  </button>
                </form>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="5" class="p-3">
                No products found.
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>

      <div class="mt-5">
        {{ $products->links() }}
      </div>
    </div>
  </div>
</x-app-layout>
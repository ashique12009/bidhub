<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl">Edit Product</h2>
  </x-slot>

  <div class="max-w-3xl mx-auto py-6">

    <form action="{{ route('admin.products.update', $product) }}"
      method="POST" enctype="multipart/form-data" class="bg-white p-6 shadow rounded">
      @csrf
      @method('PUT')

      @include('admin.products.form')

      <button class="bg-blue-600 text-white px-4 py-2 rounded mt-4">
        Update Product
      </button>
    </form>

  </div>
</x-app-layout>
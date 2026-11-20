@csrf

<div class="space-y-4">

  {{-- Product --}}
  <div>
    <label for="product_id" class="block font-medium text-sm">
      Select Product
    </label>

    <select
      name="product_id"
      id="product_id"
      class="w-full border-gray-300 rounded-md shadow-sm"
      required
    >
      <option value="">Choose a product</option>

      @foreach ($products as $product)
        <option
          value="{{ $product->id }}"
          @selected(old('product_id', $auction->product_id ?? '') == $product->id)
        >
          {{ $product->name }}
        </option>
      @endforeach
    </select>

    @error('product_id')
      <p class="text-red-500 text-sm">{{ $message }}</p>
    @enderror
  </div>

  {{-- Starting Price --}}
  <div>
    <label for="starting_price" class="block font-medium text-sm">
      Starting Price
    </label>

    <input
      type="number"
      name="starting_price"
      id="starting_price"
      step="0.01"
      min="0"
      value="{{ old('starting_price', $auction->starting_price ?? '') }}"
      class="w-full border-gray-300 rounded-md shadow-sm"
      required
    >

    @error('starting_price')
      <p class="text-red-500 text-sm">{{ $message }}</p>
    @enderror
  </div>

  {{-- Start Time --}}
  <div>
    <label for="start_time" class="block font-medium text-sm">
      Auction Start Time
    </label>

    <input
      type="datetime-local"
      name="start_time"
      id="start_time"
      value="{{ old('start_time', isset($auction) ? $auction->start_time->format('Y-m-d\TH:i') : '') }}"
      class="w-full border-gray-300 rounded-md shadow-sm"
      required
    >

    @error('start_time')
      <p class="text-red-500 text-sm">{{ $message }}</p>
    @enderror
  </div>

  {{-- End Time --}}
  <div>
    <label for="end_time" class="block font-medium text-sm">
      Auction End Time
    </label>

    <input
      type="datetime-local"
      name="end_time"
      id="end_time"
      value="{{ old('end_time', isset($auction) ? $auction->end_time->format('Y-m-d\TH:i') : '') }}"
      class="w-full border-gray-300 rounded-md shadow-sm"
      required
    >

    @error('end_time')
      <p class="text-red-500 text-sm">{{ $message }}</p>
    @enderror
  </div>

  <button
    type="submit"
    class="px-4 py-2 bg-indigo-600 text-white rounded-md"
  >
    {{ isset($auction) ? 'Update Auction' : 'Create Auction' }}
  </button>

</div>
<div class="mb-4">
  <label>Product Name</label>
  <input type="text" name="name"
    value="{{ old('name', $product->name ?? '') }}"
    class="w-full border-gray-300 rounded mt-1">

  @error('name')
    <p class="text-red-500">{{ $message }}</p>
  @enderror
</div>

<div class="mb-4">
  <label>Description</label>
  <textarea name="description"
    class="w-full border-gray-300 rounded mt-1">{{ old('description', $product->description ?? '') }}</textarea>

  @error('description')
    <p class="text-red-500">{{ $message }}</p>
  @enderror
</div>

<div class="mb-4">
  <label>Product Image</label>

  <input type="file" name="image" accept="image/*" class="w-full border-gray-300 rounded mt-1">

  @error('image')
    <p class="text-red-500">{{ $message }}</p>
  @enderror

  @if(isset($product) && $product->image)
    <div class="mt-3">
      <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
        class="w-32 h-32 object-cover rounded">

      <p class="text-sm text-gray-500 mt-1">Current image</p>
    </div>
  @endif
</div>

<div class="mb-4">
  <label>Status</label>
  <select name="status" class="w-full border-gray-300 rounded mt-1">
    <option value="active"
      {{ old('status', $product->status ?? 'active') === 'active' ? 'selected' : '' }}>
      Active
    </option>

    <option value="inactive"
      {{ old('status', $product->status ?? '') === 'inactive' ? 'selected' : '' }}>
      Inactive
    </option>
  </select>
</div>
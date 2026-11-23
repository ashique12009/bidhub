<script setup>
import { ref, onMounted } from 'vue';
import ItemCard from './ItemCard.vue';
import { getFeaturedProducts } from '../services/productService';

const items = ref([]);
const loading = ref(true);
const error = ref(null);

onMounted(async () => {
  try {
    const data = await getFeaturedProducts();

    items.value = data.data;
  } catch (err) {
    error.value = 'Failed to load featured products.';
    console.error(err);
  } finally {
    loading.value = false;
  }
});
</script>

<template>
  <section>
    <h2 class="mb-4">Featured Items</h2>

    <p v-if="loading">Loading products...</p>

    <p v-else-if="error">{{ error }}</p>

    <div v-else-if="items.length" class="row">
      <div class="row">
        <ItemCard v-for="item in items" :key="item.id" :item="item" />
      </div>
    </div>
    
    <p v-else>No featured products available.</p>

  </section>
</template>
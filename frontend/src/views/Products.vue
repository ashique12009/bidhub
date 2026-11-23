<script setup>
import { ref, onMounted } from 'vue';
import ItemCard from '../components/ItemCard.vue';
import { getProducts } from '../services/productService';

const products = ref([]);
const loading = ref(true);
const error = ref(null);

onMounted(async () => {
  try {
    const data = await getProducts();
    products.value = data.data;
  } catch (err) {
    error.value = 'Failed to load products.';
    console.error(err);
  } finally {
    loading.value = false;
  }
});
</script>

<template>
  <section class="products-page py-5">
    <div class="container">
      <h1 class="mb-4">All Products</h1>

      <p v-if="loading">Loading products...</p>

      <p v-else-if="error">{{ error }}</p>

      <div v-else-if="products.length" class="row">
        <ItemCard v-for="product in products" :item="product" :key="product.id" class="col-md-4 mb-4" />
      </div>

      <p v-else>No products found.</p>
    </div>
  </section>
</template>
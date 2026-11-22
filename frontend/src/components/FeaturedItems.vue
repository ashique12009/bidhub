<script setup>
import ItemCard from './ItemCard.vue'

const items = [
  {
    id: 1,
    name: 'Item #1',
    image: 'https://picsum.photos/seed/item1/400/250',
    currentBid: 150
  },
  {
    id: 2,
    name: 'Item #2',
    image: 'https://picsum.photos/seed/item2/400/250',
    currentBid: 250
  },
  {
    id: 3,
    name: 'Item #3',
    image: 'https://picsum.photos/seed/item3/400/250',
    currentBid: 350
  }
]
</script>

<template>
  <section>
    <h2 class="mb-4">Featured Items</h2>

    <div class="row">
      <ItemCard v-for="item in items" :key="item.id" :item="item" />
    </div>
  </section>
</template>
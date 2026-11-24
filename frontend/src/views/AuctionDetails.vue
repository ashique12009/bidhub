<script setup>
import { useRoute } from 'vue-router';

const route = useRoute();

const auctionId = route.params.id;
</script>

<template>
  <div class="container py-5">
    <h2>Auction Details</h2>

    <p>Auction ID: {{ auctionId }}</p>
  </div>
</template>
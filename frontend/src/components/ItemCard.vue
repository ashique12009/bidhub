<script setup>
defineProps({
  item: {
    type: Object,
    required: true
  }
})
</script>

<template>
  <div class="col-md-4 mb-4">
    <div class="card h-100">
      <img :src="item.image" class="card-img-top" :alt="item.name" />

      <div class="card-body">
        <h5 class="card-title">{{ item.name }}</h5>

        <p class="card-text">
          Current bid: <strong>${{ item.currentBid }}</strong>
        </p>

        <a href="/auctions" class="btn btn-primary btn-sm">
          Place Bid
        </a>
      </div>
    </div>
  </div>
</template>
<script setup>
import { ref, onMounted, onUnmounted } from 'vue';

const props = defineProps({
  auction: {
    type: Object,
    required: true,
  },
});

const timeLeft = ref('');
let timer = null;

// Format date according to Finland timezone
const formatDate = (date) => {
  if (!date) return 'N/A';

  return new Date(date).toLocaleString('en-FI', {
    day: '2-digit',
    month: 'short',
    year: 'numeric',
    hour: '2-digit',
    minute: '2-digit',
  });
};

// Get status color
const getStatusClass = (status) => {
  return {
    ended: 'text-danger',
    active: 'text-success',
    scheduled: 'text-warning',
  }[status] || 'text-secondary';
};

// Calculate countdown
const calculateTime = () => {
  const now = new Date();

  let targetDate;
  let label;

  if (props.auction.status === 'scheduled') {
    targetDate = new Date(props.auction.start_time);
    label = 'Starts in';
  } else if (props.auction.status === 'active') {
    targetDate = new Date(props.auction.end_time);
    label = 'Time Left';
  } else {
    timeLeft.value = 'Auction Ended';
    return;
  }

  const total = targetDate - now;

  if (total <= 0) {
    timeLeft.value = props.auction.status === 'scheduled'
      ? 'Starting soon'
      : 'Auction Ended';

    return;
  }

  const days = Math.floor(total / (1000 * 60 * 60 * 24));
  const hours = Math.floor((total / (1000 * 60 * 60)) % 24);
  const minutes = Math.floor((total / (1000 * 60)) % 60);
  const seconds = Math.floor((total / 1000) % 60);

  timeLeft.value = `${label}: ${days}d ${hours}h ${minutes}m ${seconds}s`;
};

onMounted(() => {
  calculateTime();
  timer = setInterval(calculateTime, 1000);
});

onUnmounted(() => {
  clearInterval(timer);
});
</script>

<template>
  <div class="card h-100">

    <!-- Product Image -->
    <img :src="auction.product?.image" :alt="auction.product?.name" class="card-img-top"
      style="height: 240px; object-fit: cover;" />

    <div class="card-body d-flex flex-column">

      <!-- Product Title -->
      <h5 class="card-title">
        {{ auction.product?.name }}
      </h5>

      <!-- Auction Status -->
      <p class="mb-2">
        Status:
        <strong class="text-uppercase" :class="getStatusClass(auction.status)">
          {{ auction.status }}
        </strong>
      </p>

      <!-- Prices -->
      <p class="mb-1">
        Starting Price:
        <strong>{{ auction.starting_price }}</strong>
      </p>

      <p class="mb-1">
        Current Price:
        <strong>{{ auction.current_price ?? auction.starting_price }}</strong>
      </p>

      <!-- Start Time -->
      <p class="mb-1">
        Start:
        <strong>{{ formatDate(auction.start_time) }}</strong>
      </p>

      <!-- End Time -->
      <p class="mb-2 text-danger">
        Ends:
        {{ formatDate(auction.end_time) }}
      </p>

      <!-- Countdown -->
      <p class="mb-3">
        <strong>{{ timeLeft }}</strong>
      </p>

      <!-- View Auction -->
      <router-link :to="`/auctions/${auction.id}`" class="btn btn-dark mt-auto">
        View Auction
      </router-link>

    </div>
  </div>
</template>
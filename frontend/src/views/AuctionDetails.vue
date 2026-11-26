<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import { getAuctionById } from '../services/auctionService';
import api from '../api/axios';
import { useAuthStore } from '../stores/auth';

const route = useRoute();
const router = useRouter();
const auth = useAuthStore();

const auction = ref(null);
const loading = ref(true);
const error = ref(null);

const bidAmount = ref('');
const bidError = ref('');
const bidSuccess = ref('');
const submittingBid = ref(false);

const now = ref(Date.now());
let timer = null;

// Fetch auction details
const fetchAuction = async () => {
  loading.value = true;
  error.value = null;

  try {
    const response = await getAuctionById(route.params.id);

    auction.value = response?.data?.data ?? response?.data ?? null;

    if (!auction.value) {
      throw new Error('Auction data not found.');
    }
  } catch (err) {
    error.value =
      err.response?.data?.message ||
      err.message ||
      'Failed to load auction.';
  } finally {
    loading.value = false;
  }
};

// Auction start and end timestamps
const startTime = computed(() => {
  return auction.value?.start_time
    ? new Date(auction.value.start_time).getTime()
    : null;
});

const endTime = computed(() => {
  return auction.value?.end_time
    ? new Date(auction.value.end_time).getTime()
    : null;
});

// Auction status
const auctionStatus = computed(() => {
  if (!auction.value || !startTime.value || !endTime.value) {
    return 'Unknown';
  }

  if (now.value < startTime.value) {
    return 'Upcoming';
  }

  if (now.value >= endTime.value) {
    return 'Ended';
  }

  return 'Live';
});

// Countdown
const countdown = computed(() => {
  const target =
    auctionStatus.value === 'Upcoming'
      ? startTime.value
      : endTime.value;

  if (!target || auctionStatus.value === 'Unknown') {
    return 'Unavailable';
  }

  if (auctionStatus.value === 'Ended') {
    return 'Auction ended';
  }

  const distance = target - now.value;

  if (distance <= 0) {
    return 'Updating...';
  }

  const days = Math.floor(distance / (1000 * 60 * 60 * 24));
  const hours = Math.floor(
    (distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)
  );
  const minutes = Math.floor(
    (distance % (1000 * 60 * 60)) / (1000 * 60)
  );
  const seconds = Math.floor(
    (distance % (1000 * 60)) / 1000
  );

  return `${days}d ${hours}h ${minutes}m ${seconds}s`;
});

// Current price
const currentPrice = computed(() => {
  return Number(
    auction.value?.current_price ??
    auction.value?.starting_price ??
    0
  );
});

// Minimum next bid
const minimumBid = computed(() => {
  return currentPrice.value + 1;
});

const formattedStatus = computed(() => auctionStatus.value);

// Price formatting
const formatPrice = (price) => {
  return new Intl.NumberFormat('en-US', {
    style: 'currency',
    currency: 'EUR',
  }).format(Number(price || 0));
};

// Date formatting
const formatDate = (date) => {
  if (!date) return 'Not available';

  return new Intl.DateTimeFormat('en-GB', {
    timeZone: 'Europe/Helsinki',
    day: '2-digit',
    month: '2-digit',
    year: 'numeric',
    hour: '2-digit',
    minute: '2-digit',
    second: '2-digit',
    hour12: false,
  }).format(new Date(date));
};

// Guest wants to place a bid
const goToLogin = () => {
  router.push({
    name: 'Login',
    query: {
      redirect: route.fullPath,
    },
  });
};

// Submit bid
const submitBid = async () => {
  bidError.value = '';
  bidSuccess.value = '';

  // Check authentication
  if (!auth.isAuthenticated) {
    goToLogin();
    return;
  }

  // Check auction status
  if (auctionStatus.value !== 'Live') {
    bidError.value = 'Bidding is not available right now.';
    return;
  }

  // Validate bid amount
  const amount = Number(bidAmount.value);

  if (!bidAmount.value || !Number.isFinite(amount) || amount < minimumBid.value) {
    bidError.value = `Your bid must be at least ${formatPrice(minimumBid.value)}.`;
    return;
  }

  submittingBid.value = true;

  try {
    await api.post(`/auctions/${route.params.id}/bids`, {
      bid_amount: amount,
    });

    bidSuccess.value = 'Your bid has been placed successfully!';
    bidAmount.value = '';

    // Refresh auction details to get the latest price
    await fetchAuction();

  } catch (err) {
    if (err.response?.status === 401) {
      auth.logout();
      goToLogin();
      return;
    }

    const validationErrors = err.response?.data?.errors;

    bidError.value =
      validationErrors?.bid_amount?.[0] ||
      err.response?.data?.message ||
      'Failed to place your bid. Please try again.';
  } finally {
    submittingBid.value = false;
  }
};

onMounted(() => {
  fetchAuction();

  timer = setInterval(() => {
    now.value = Date.now();
  }, 1000);
});

onUnmounted(() => {
  if (timer) {
    clearInterval(timer);
  }
});
</script>

<template>
  <div class="container py-5">

    <!-- Loading -->
    <div v-if="loading" class="text-center py-5">
      <div class="spinner-border text-primary"></div>
      <p class="mt-3">Loading auction...</p>
    </div>

    <!-- Error -->
    <div v-else-if="error" class="alert alert-danger">
      {{ error }}
    </div>

    <!-- Auction Details -->
    <div v-else-if="auction" class="row g-4">

      <!-- Product Image -->
      <div class="col-lg-6">
        <div class="auction-image-wrapper border rounded p-3">
          <img v-if="auction.product?.image" :src="auction.product.image" :alt="auction.product?.name || 'Auction item'"
            class="img-fluid auction-details-image" />

          <img v-else src="https://placehold.co/600x400?text=Auction+Item" alt="Auction item"
            class="img-fluid auction-details-image" />
        </div>
      </div>

      <!-- Auction Information -->
      <div class="col-lg-6">
        <div class="auction-details-content">

          <!-- Auction Status -->
          <span class="badge mb-3" :class="{
            'bg-success': formattedStatus === 'Live',
            'bg-warning text-dark': formattedStatus === 'Upcoming',
            'bg-secondary': formattedStatus === 'Ended',
            'bg-dark': formattedStatus === 'Unknown'
          }">
            {{ formattedStatus }}
          </span>

          <h1 class="h2 mb-3">
            {{ auction.product?.name || 'Auction Item' }}
          </h1>

          <p class="text-muted mb-4">
            {{ auction.product?.description || 'No description available.' }}
          </p>

          <!-- Price and Countdown -->
          <div class="border rounded p-4 mb-4">

            <div class="mb-3">
              <small class="text-muted">Current Bid</small>

              <h2 class="text-primary fw-bold mb-0">
                {{ formatPrice(currentPrice) }}
              </h2>
            </div>

            <div class="row g-3">

              <div class="col-6">
                <small class="text-muted">Starting Price</small>

                <h5>
                  {{ formatPrice(auction.starting_price) }}
                </h5>
              </div>

              <div class="col-6">
                <small class="text-muted">Minimum Next Bid</small>

                <h5>
                  {{ formatPrice(minimumBid) }}
                </h5>
              </div>

            </div>

            <hr />

            <div class="mb-3">
              <small class="text-muted">
                {{ auctionStatus === 'Upcoming'
                  ? 'Auction starts in'
                  : 'Time remaining'
                }}
              </small>

              <h4 class="fw-bold text-danger">
                {{ countdown }}
              </h4>
            </div>

            <div class="mb-2">
              <small class="text-muted">Start Time</small>
              <p class="mb-0">
                {{ formatDate(auction.start_time) }}
              </p>
            </div>

            <div>
              <small class="text-muted">End Time</small>
              <p class="mb-0">
                {{ formatDate(auction.end_time) }}
              </p>
            </div>

          </div>

          <!-- Bid Section -->
          <div class="card border-0 shadow-sm">
            <div class="card-body">

              <h5 class="mb-3">Place Your Bid</h5>

              <!-- Guest User -->
              <div v-if="!auth.isAuthenticated">

                <p class="text-muted">
                  You need to login before placing a bid.
                </p>

                <button v-if="auctionStatus === 'Live'" type="button" class="btn btn-primary w-100" @click="goToLogin">
                  <i class="bi bi-box-arrow-in-right me-2"></i>
                  Login to Place Bid
                </button>

                <button v-else type="button" class="btn btn-secondary w-100" disabled>
                  {{ auctionStatus === 'Upcoming'
                    ? 'Auction Not Started'
                    : auctionStatus === 'Ended'
                      ? 'Auction Ended'
                      : 'Bidding Unavailable'
                  }}
                </button>

              </div>

              <!-- Authenticated User -->
              <form v-else @submit.prevent="submitBid">

                <div class="mb-3">
                  <label for="bidAmount" class="form-label">
                    Bid Amount (€)
                  </label>

                  <input id="bidAmount" type="number" class="form-control" v-model="bidAmount" :min="minimumBid"
                    step="0.01" placeholder="Enter your bid" :disabled="auctionStatus !== 'Live' || submittingBid"
                    required />

                  <small class="text-muted">
                    Minimum bid: {{ formatPrice(minimumBid) }}
                  </small>
                </div>

                <div v-if="bidError" class="alert alert-danger py-2">
                  {{ bidError }}
                </div>

                <div v-if="bidSuccess" class="alert alert-success py-2">
                  {{ bidSuccess }}
                </div>

                <button type="submit" class="btn btn-primary w-100"
                  :disabled="auctionStatus !== 'Live' || submittingBid">
                  <span v-if="submittingBid" class="spinner-border spinner-border-sm me-2"></span>

                  {{ submittingBid
                    ? 'Placing Bid...'
                    : auctionStatus === 'Live'
                      ? 'Place Bid'
                      : auctionStatus === 'Upcoming'
                        ? 'Auction Not Started'
                        : auctionStatus === 'Ended'
                          ? 'Auction Ended'
                          : 'Bidding Unavailable'
                  }}
                </button>

              </form>

            </div>
          </div>

        </div>
      </div>

      <!-- Product Description -->
      <div class="col-12">
        <div class="card mt-3">
          <div class="card-body">

            <h4>Product Details</h4>

            <p class="text-muted">
              {{
                auction.product?.description ||
                'No additional product information available.'
              }}
            </p>

          </div>
        </div>
      </div>

    </div>

  </div>
</template>

<style scoped>
.auction-details-image {
  width: 100%;
  max-height: 500px;
  object-fit: contain;
}

.auction-image-wrapper {
  background: #f8f9fa;
}

.auction-details-content {
  height: 100%;
}
</style>
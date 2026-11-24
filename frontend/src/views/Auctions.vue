<script setup>
import { ref, onMounted } from 'vue';
import { getAuctions } from '../services/auctionService';
import AuctionCard from '../components/AuctionCard.vue';

const auctions = ref([]);
const loading = ref(true);
const error = ref(null);

const currentPage = ref(1);
const lastPage = ref(1);
const status = ref('');

// Fetch auctions from Laravel API
const fetchAuctions = async (page = 1) => {
  loading.value = true;
  error.value = null;

  try {
    const response = await getAuctions({
      page,
      status: status.value || undefined,
    });

    const data = response.data;

    auctions.value = data.data;
    currentPage.value = data.meta.current_page;
    lastPage.value = data.meta.last_page;

  } catch (err) {
    error.value = 'Failed to load auctions.';
    console.error(err);

  } finally {
    loading.value = false;
  }
};

// Filter auctions by status
const changeStatus = (newStatus) => {
  status.value = newStatus;
  fetchAuctions(1);
};

// Pagination
const changePage = (page) => {
  if (page < 1 || page > lastPage.value) return;

  fetchAuctions(page);
};

// Initial API request
onMounted(() => {
  fetchAuctions();
});
</script>

<template>
  <div class="container py-5">

    <h2 class="mb-4">Auctions</h2>

    <!-- Auction Filters -->
    <div class="d-flex gap-2 mb-4 flex-wrap">

      <button class="btn" :class="status === '' ? 'btn-dark' : 'btn-outline-dark'" @click="changeStatus('')">
        All
      </button>

      <button class="btn" :class="status === 'scheduled' ? 'btn-dark' : 'btn-outline-dark'"
        @click="changeStatus('scheduled')">
        Upcoming
      </button>

      <button class="btn" :class="status === 'active' ? 'btn-dark' : 'btn-outline-dark'"
        @click="changeStatus('active')">
        Live
      </button>

      <button class="btn" :class="status === 'ended' ? 'btn-dark' : 'btn-outline-dark'" @click="changeStatus('ended')">
        Ended
      </button>

    </div>

    <!-- Loading -->
    <div v-if="loading" class="text-center py-5">
      Loading auctions...
    </div>

    <!-- Error -->
    <div v-else-if="error" class="alert alert-danger">
      {{ error }}
    </div>

    <!-- Auction Cards -->
    <div v-else-if="auctions.length" class="row g-4">

      <div v-for="auction in auctions" :key="auction.id" class="col-md-6 col-lg-4">
        <AuctionCard :auction="auction" />
      </div>

    </div>

    <!-- Empty State -->
    <div v-else class="text-center py-5">
      No auctions found.
    </div>

    <!-- Pagination -->
    <div v-if="!loading && lastPage > 1" class="d-flex justify-content-center mt-5 gap-2 flex-wrap">

      <button class="btn btn-outline-dark" :disabled="currentPage === 1" @click="changePage(currentPage - 1)">
        Previous
      </button>

      <button v-for="page in lastPage" :key="page" class="btn" :class="currentPage === page
        ? 'btn-dark'
        : 'btn-outline-dark'" @click="changePage(page)">
        {{ page }}
      </button>

      <button class="btn btn-outline-dark" :disabled="currentPage === lastPage" @click="changePage(currentPage + 1)">
        Next
      </button>

    </div>

  </div>
</template>
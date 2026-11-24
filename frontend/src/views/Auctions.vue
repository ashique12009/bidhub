<script setup>
import { ref, onMounted } from 'vue';
import { getAuctions } from '../services/auctionService';

const auctions = ref([]);
const loading = ref(true);
const error = ref(null);

const currentPage = ref(1);
const lastPage = ref(1);
const status = ref('');

const fetchAuctions = async (page = 1) => {
  loading.value = true;
  error.value = null;

  try {
    const response = await getAuctions({
      page,
      status: status.value || undefined,
    });

    const data = response.data;

    console.log('Fetched auctions:', data);

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

const changeStatus = (newStatus) => {
  status.value = newStatus;
  fetchAuctions(1);
};

const changePage = (page) => {
  if (page < 1 || page > lastPage.value) return;
  fetchAuctions(page);
};

onMounted(() => {
  fetchAuctions();
});

const formatDate = (date) => {
  return new Date(date).toLocaleString('en-FI', {
    day: '2-digit',
    month: 'short',
    year: 'numeric',
    hour: '2-digit',
    minute: '2-digit',
  });
};
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

    <!-- Auctions -->
    <div v-else-if="auctions.length" class="row g-4">
      <div v-for="auction in auctions" :key="auction.id" class="col-md-6 col-lg-4">
        <div class="card h-100">
          <img :src="auction.product?.image" class="card-img-top" :alt="auction.product?.name"
            style="height: 240px; object-fit: cover;" />

          <div class="card-body d-flex flex-column">
            <h5 class="card-title">
              {{ auction.product?.name }}
            </h5>

            <p class="mb-1">
              Starting Price:
              <strong>
                {{ auction.starting_price }}
              </strong>
            </p>

            <p class="mb-1">
              Start Date and Time:
              <strong>
                {{ formatDate(auction.start_time) }}
              </strong>
            </p>

            <p class="mb-1">
              Ends:
              {{ formatDate(auction.end_time) }}
            </p>

            <p class="mb-3">
              Status:
              <strong class="text-uppercase">
                {{ auction.status }}
              </strong>
            </p>

            <router-link :to="`/auctions/${auction.id}`" class="btn btn-dark mt-auto">
              View Auction
            </router-link>
          </div>
        </div>
      </div>
    </div>

    <!-- Empty -->
    <div v-else class="text-center py-5">
      No auctions found.
    </div>

    <!-- Pagination -->
    <div v-if="!loading && lastPage > 1" class="d-flex justify-content-center mt-5 gap-2">
      <button class="btn btn-outline-dark" :disabled="currentPage === 1" @click="changePage(currentPage - 1)">
        Previous
      </button>

      <button v-for="page in lastPage" :key="page" class="btn"
        :class="currentPage === page ? 'btn-dark' : 'btn-outline-dark'" @click="changePage(page)">
        {{ page }}
      </button>

      <button class="btn btn-outline-dark" :disabled="currentPage === lastPage" @click="changePage(currentPage + 1)">
        Next
      </button>
    </div>
  </div>
</template>
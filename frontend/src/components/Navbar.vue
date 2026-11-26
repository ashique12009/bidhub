<script setup>
import { useAuthStore } from '../stores/auth';
import { useRouter } from 'vue-router';

const auth = useAuthStore();
const router = useRouter();

const logout = () => {
  auth.logout();
  router.push('/');
};
</script>

<template>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
      <RouterLink class="navbar-brand" to="/">
        BidHub
      </RouterLink>

      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav" aria-controls="nav"
        aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="nav">
        <ul class="navbar-nav ms-auto align-items-lg-center">

          <li class="nav-item">
            <RouterLink class="nav-link" to="/" exact-active-class="active">
              Home
            </RouterLink>
          </li>

          <li class="nav-item">
            <RouterLink class="nav-link" to="/about">
              About
            </RouterLink>
          </li>

          <li class="nav-item">
            <RouterLink class="nav-link" to="/products">
              Products
            </RouterLink>
          </li>

          <li class="nav-item">
            <RouterLink class="nav-link" to="/auctions">
              Auctions
            </RouterLink>
          </li>

          <li class="nav-item">
            <RouterLink class="nav-link" to="/contact">
              Contact
            </RouterLink>
          </li>

          <!-- Guest -->
          <li class="nav-item" v-if="!auth.isAuthenticated">
            <RouterLink class="nav-link" to="/login">
              Login
            </RouterLink>
          </li>

          <!-- Authenticated User -->
          <li class="nav-item dropdown" v-else>
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              {{ auth.user?.name || 'My Account' }}
            </a>

            <ul class="dropdown-menu dropdown-menu-end">
              <li>
                <span class="dropdown-item-text">
                  {{ auth.user?.email }}
                </span>
              </li>

              <li>
                <hr class="dropdown-divider" />
              </li>

              <li>
                <button class="dropdown-item" type="button" @click="logout">
                  Logout
                </button>
              </li>
            </ul>
          </li>

        </ul>
      </div>
    </div>
  </nav>
</template>
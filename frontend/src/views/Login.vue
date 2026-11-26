<script setup>
import { ref } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import api from '../api/axios';
import { useAuthStore } from '../stores/auth';

const router = useRouter();
const route = useRoute();
const auth = useAuthStore();

const email = ref('');
const password = ref('');
const loading = ref(false);
const error = ref('');

const login = async () => {
  loading.value = true;
  error.value = '';

  try {
    const response = await api.post('/login', {
      email: email.value,
      password: password.value,
    });

    // Update Pinia store and localStorage
    auth.setAuth(response.data);

    // Redirect after login
    const redirect = route.query.redirect || '/';

    router.push(redirect);
  } catch (err) {
    error.value =
      err.response?.data?.message || 'Login failed. Please try again.';
  } finally {
    loading.value = false;
  }
};
</script>

<template>
  <div class="container py-5">
    <div class="row justify-content-center">
      <div class="col-md-6 col-lg-5">
        <div class="card shadow-sm">
          <div class="card-body p-4">
            <h2 class="text-center mb-4">Login</h2>

            <div v-if="error" class="alert alert-danger">
              {{ error }}
            </div>

            <form @submit.prevent="login">
              <div class="mb-3">
                <label for="email" class="form-label">
                  Email
                </label>

                <input id="email" type="email" class="form-control" v-model="email" required autocomplete="email" />
              </div>

              <div class="mb-3">
                <label for="password" class="form-label">
                  Password
                </label>

                <input id="password" type="password" class="form-control" v-model="password" required
                  autocomplete="current-password" />
              </div>

              <button type="submit" class="btn btn-primary w-100" :disabled="loading">
                {{ loading ? 'Logging in...' : 'Login' }}
              </button>
            </form>

            <div class="text-center mt-3">
              <RouterLink to="/">
                Back to Home
              </RouterLink>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
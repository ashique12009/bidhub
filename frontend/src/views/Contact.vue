<template>
  <main class="py-5">
    <div class="container">
      <h1>Contact Us</h1>

      <div class="row mt-4">
        <!-- Contact Form -->
        <div class="col-md-6">
          <form @submit.prevent="handleSubmit">
            <div class="mb-3">
              <label for="name" class="form-label">Name</label>
              <input
                id="name"
                v-model="form.name"
                type="text"
                class="form-control"
                placeholder="Enter your name"
                required
              />
            </div>

            <div class="mb-3">
              <label for="email" class="form-label">Email</label>
              <input
                id="email"
                v-model="form.email"
                type="email"
                class="form-control"
                placeholder="Enter your email"
                required
              />
            </div>

            <div class="mb-3">
              <label for="message" class="form-label">Message</label>
              <textarea
                id="message"
                v-model="form.message"
                class="form-control"
                rows="4"
                placeholder="Write your message"
                required
              ></textarea>
            </div>

            <button
              class="btn btn-primary"
              type="submit"
              :disabled="loading"
            >
              {{ loading ? 'Sending...' : 'Send' }}
            </button>

            <p v-if="success" class="text-success mt-3">
              {{ success }}
            </p>

            <p v-if="error" class="text-danger mt-3">
              {{ error }}
            </p>
          </form>
        </div>

        <!-- Contact Information -->
        <div class="col-md-6">
          <p>
            <strong>Address:</strong> 123 Market Street
          </p>

          <p>
            <strong>Email:</strong> info@bidhub.com
          </p>

          <p>
            <strong>Phone:</strong> +1 234 567 890
          </p>
        </div>
      </div>
    </div>
  </main>
</template>

<script setup>
import { ref, reactive } from 'vue';

const form = reactive({
  name: '',
  email: '',
  message: '',
});

const loading = ref(false);
const success = ref('');
const error = ref('');

const handleSubmit = async () => {
  success.value = '';
  error.value = '';

  loading.value = true;

  try {
    // Contact API will be connected here later.

    console.log('Contact Form Data:', { ...form });

    success.value = 'Your message has been submitted successfully!';

    // Reset form
    form.name = '';
    form.email = '';
    form.message = '';

  } catch (err) {
    error.value = 'Something went wrong. Please try again.';
  } finally {
    loading.value = false;
  }
};
</script>
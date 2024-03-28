<template>
  <div class="d-block mt-5">
    <div class="col-md-4 mx-auto">
      <div>
        <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">Sign in to your account</h2>
      </div>
      <form class="mt-8 space-y-6" action="#" method="POST" @submit.prevent="authorize">
        <div class="alert alert-danger" v-if="error">{{ error }}</div>

        <div class="rounded-md shadow-sm -space-y-px">
          <div class="mb-4">
            <label for="email-address" class="sr-only">Email address</label>
            <input
              id="email-address"
              name="email"
              type="email"
              autocomplete="email"
              class="form-control"
              placeholder="Email address"
              required
              v-model="form.email"
            >
          </div>
          <div>
            <label for="password" class="sr-only">Password</label>
            <input
              id="password"
              name="password"
              type="password"
              autocomplete="current-password"
              class="form-control"
              placeholder="Password"
              required
              v-model="form.password"
            >
          </div>
        </div>

        <div class="form-check mb-2 mt-2">
          <input id="remember-me" name="remember-me" type="checkbox" class="form-check-input" v-model="form.remember">
          <label for="remember-me" class="form-check-label">Remember me</label>
        </div>

        <button type="submit" class="btn btn-primary w-full" :disabled="loading">
          Sign in
        </button>
      </form>
    </div>
  </div>
</template>

<script lang="ts">
import axios from "axios";
import {authStore} from "@/stores/authStore";

export default {
  name: "LoginPage",
  data() {
    return {
      form: {
        email: '',
        password: '',
        remember: true,
      },
      loading: false,
      error: null,
    }
  },
  methods: {
    authorize() {
      this.loading = true;
      axios.post('/api/login', this.form)
        .then(() => {
          // Check auth and redirect to homepage
          authStore()
            .checkAuth()
            .then(() => {
              this.$router.push({name: 'HomePage'});
            })
            .catch(() => {
              alert('An error has occurred');
            });
        })
        .catch((error) => {
          if (error.response.status === 401) {
            this.error = error.response.data.message;
          } else {
            alert('An error has occurred');
          }
        })
        .finally(() => {
          this.loading = false;
        })
    }
  }
}
</script>

<style scoped>
</style>

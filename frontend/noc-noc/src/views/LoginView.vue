<script>
import { login } from '@/config/api';

export default {
  data() {
    return {
      email: '',
      password: ''
    };
  },
  methods: {
    async handleLogin() {
      const response = await login(this.email, this.password);
      if (response.status === 'success') {
        localStorage.setItem('user', JSON.stringify(response.user));
        localStorage.setItem('token', response.authorization.token);
      }
      localStorage.getItem('user');
      localStorage.getItem('token');

      this.$router.push('/');
    }
  }
};

</script>

<template>
  <div class="flex items-center justify-center min-h-screen">
    <div class="w-full max-w-md p-8 rounded-md bg-white">
      <h2 class="text-2xl font-semibold mb-4 text-center">Login</h2>
      <form @submit.prevent="handleLogin">
        <div class="mb-4">
          <label for="email" class="block text-gray-700">Email</label>
          <input type="email" id="email" v-model="email"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 px-1">
        </div>
        <div class="mb-6">
          <label for="password" class="block text-gray-700">Password</label>
          <input type="password" id="password" v-model="password"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 px-1">
        </div>
        <button type="submit"
          class="w-full bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600">Login</button>
      </form>
      <div class="text-center mt-4">
        <a href="#" class="text-blue-500 hover:underline">I forgot my password</a>
      </div>
    </div>
  </div>
</template>
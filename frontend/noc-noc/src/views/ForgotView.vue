<script>
import { forgotPassword } from '@/config/api'
export default {
  data() {
    return {
      email: '',
      token: ''
    };
  },
  methods: {
    async handleForgotPassword() {
        console.log(this.email)
        const response = await forgotPassword(this.email)
        console.log(response)
        if(response.status === 'success'){
            this.$router.push('/password');
        }
    }
  },
  created() {
    const queryString = window.location.search;
    
    const params = new URLSearchParams(queryString);
    
    const token = params.get('token');
    
    this.token = token
  }
};

</script>

<template>
  <div class="flex items-center justify-center min-h-screen">
    <div class="w-full max-w-md p-8 rounded-md bg-white">
      <h2 class="text-2xl font-semibold mb-4 text-center">Set email</h2>
      <form @submit.prevent="handleForgotPassword">
        <div class="mb-6">
          <label for="email" class="block text-gray-700">Email</label>
          <input type="email" id="email" v-model="email"
            class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 px-1">
        </div>
        <button type="submit"
          class="w-full bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600">Send</button>
      </form>
    </div>
  </div>
</template>
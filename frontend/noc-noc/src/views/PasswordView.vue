<script>
import { setPassword } from '@/config/api'
export default {
  data() {
    return {
      password: '',
      token: ''
    };
  },
  methods: {
    async handlePassword() {
        console.log(this.password)
        const response = await setPassword(this.token, this.password)
        console.log(response)
        if(response.status === 'success'){
            this.$router.push('/login');
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
      <h2 class="text-2xl font-semibold mb-4 text-center">Set password</h2>
      <form @submit.prevent="handlePassword">
        <div class="mb-6">
          <label for="password" class="block text-gray-700">Password</label>
          <input type="password" id="password" v-model="password"
            class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 px-1">
        </div>
        <button type="submit"
          class="w-full bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600">Save</button>
      </form>
    </div>
  </div>
</template>
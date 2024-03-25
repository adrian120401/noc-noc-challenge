<script>
export default {
  created() {
    const user = localStorage.getItem('user');
    const token = localStorage.getItem('token');
    if (!user || !token) {
      this.$router.push({ name: 'login' });
    }
  }
};
</script>

<template>
  <div id="app">
    <router-view />
  </div>
</template>

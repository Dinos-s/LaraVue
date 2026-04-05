<script setup lang="ts">
  import { RouterLink, RouterView } from 'vue-router';
</script>

<template>
  <header class="p-6">
    <RouterLink to="/">Home</RouterLink><br>
    <RouterLink to="/users">Users</RouterLink><br>
    <RouterLink to="/veiculos">Veículos</RouterLink>
  </header>

  <RouterView />
</template>

<style scoped>

</style>

<template>
    <Navbar/>
  <div class="p-6">
    <h1 class="text-2xl font-bold mb-4">Liste des Utilisateurs</h1>

    <div v-if="Users.length > 0" class="grid gap-4">
      <div v-for="user in Users" :key="user.id" class="border p-4 rounded shadow-sm bg-white">
        <h2 class="text-xl font-semibold">{{ user.name }}</h2>
        <p class="text-gray-600">{{ user.email }}</p>
      </div>
    </div>

    <div v-else class="text-gray-500">
      Aucun utilisateur trouvé.
    </div>
  </div>
</template>

<script setup>
import Navbar from '@/Layouts/Navbar.vue';

defineProps({
  Users: Array
})
</script>
<template>
    <Navbar/>
  <div class="p-6">
    <h1 class="text-2xl font-bold mb-4">La vue d'affichage des Posts</h1>

    <div v-if="Posts.length > 0" class="grid gap-4">
      <div v-for="post in Posts" :key="post.id" class="border p-4 rounded shadow-sm bg-white">
        <h2 class="text-xl font-semibold">{{ post.title }}</h2>
        <p class="text-gray-600">{{ post.oembedUrl }}</p>
      </div>
    </div>

    <!-- Message si aucun post n'est trouvé (utile pour la recherche) --> 
    <div v-else class="text-gray-500">
      Aucun post trouvé pour cette recherche.
    </div>
  </div>
</template>

<script setup>
import Navbar from '@/Layouts/Navbar.vue';
// On récupère les données envoyées par le contrôleur
defineProps({
  Posts: Array
})
</script>

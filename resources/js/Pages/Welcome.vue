<template>
    <h1 class="text-2xl font-bold">Bienvenue sur l'Accueil !</h1>
    <p>Ceci est le contenu spécifique à l'accueil.</p>
</template>

<script setup>                        
import Navbar from '@/Layouts/Navbar.vue';

defineOptions({
  layout: Navbar,
});
</script>

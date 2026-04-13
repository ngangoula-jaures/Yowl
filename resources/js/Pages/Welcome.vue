<template>
    <h1 class="text-2xl font-bold">Bienvenue sur l'Accueil !</h1>
    <p>Ceci est le contenu spécifique à l'accueil.</p>
</template>

<script setup>
import HeaderLayout from '@/Layouts/HeaderLayout.vue';

// On définit le layout persistant
defineOptions({ layout: HeaderLayout })
</script>

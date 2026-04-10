<template>
    <h1 class="text-2xl font-bold text-blue-600">Vous êtes sur la Page Test</h1>
    <p>Le menu en haut n'a pas bougé, seul ce texte a changé !</p>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';

defineOptions({ layout: AppLayout })
</script>

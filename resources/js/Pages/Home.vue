<template>
    <section class="space-y-4">
        <div class="flex flex-col items-center justify-center">
            <h1 class="text-2xl font-bold">Bienvenue sur l'Accueil !</h1>
        </div>
    </section>
</template>

<script setup>
import Navbar from '@/Layouts/Navbar.vue';

defineOptions({
  layout: Navbar,
});
</script>
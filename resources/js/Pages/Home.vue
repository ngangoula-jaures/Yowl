<template>
    <section class="space-y-6">
        <div class="flex flex-col items-center justify-center mb-6 mt-4">
            <h1 class="text-3xl font-extrabold text-white pulse-neon">Bienvenue sur YOWL !</h1>
            <p class="text-sm text-[rgba(255,255,255,0.6)] mt-2">Découvre et commente des articles comme sur un réseau social moderne.</p>
        </div>

        <div class="yowl-card">
            <PostCards :posts="posts" />
        </div>
    </section>
</template>

<script setup>
import Navbar from '@/Layouts/Navbar.vue';
import PostCards from '@/Layouts/PostCards.vue';

defineOptions({
  layout: Navbar,
});

defineProps({
    posts: [Array, Object]
});
</script>

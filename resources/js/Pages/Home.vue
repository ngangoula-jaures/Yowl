<template>
    <section class="space-y-4">
        <div class="flex flex-col items-center justify-center mb-8 mt-4">
            <h1 class="text-3xl font-extrabold text-indigo-600">Bienvenue sur YOWL !</h1>
        </div>
        
        <PostCards :posts="posts" />
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
<template>
  <main>
    <Navbar />
    <CommentCards :comments="comments" />
  </main>
</template>

<script setup>
import Navbar from '@/Layouts/Navbar.vue';
import CommentCards from '@/Layouts/CommentCards.vue';

defineProps({
  comments: {
    type: [Array, Object],
    required: true,
  },
});
</script>

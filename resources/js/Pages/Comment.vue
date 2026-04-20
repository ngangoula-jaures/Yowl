<template>
  <Navbar>
  <main>
      <CommentCards :comments="comments" />
  </main>
  </Navbar>
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

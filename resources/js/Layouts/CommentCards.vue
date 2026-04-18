<template>
  <div class="p-6">
    <h1 class="text-2xl font-bold mb-4">Les Commentaires</h1>
    <p class="text-gray-600">{{ commentsList.length }} commentaires trouvés</p>

    <div v-if="commentsList.length > 0" class="grid gap-4">
      <div
        v-for="comment in commentsList"
        :key="comment.id"
        class="border p-4 rounded shadow-sm bg-white"
      >
        <p class="text-gray-800">{{ comment.content }}</p>
        <p class="text-gray-500 text-sm mt-2">{{ comment.created_at }}</p>
      </div>
    </div>

    <div v-else class="text-gray-500">
      Aucun commentaire trouvé pour cette recherche.
    </div>

    <div v-if="paginationInfo" class="mt-8 flex justify-center gap-2">
      <button
        @click="goToPage(paginationInfo.current_page - 1)"
        :disabled="paginationInfo.current_page === 1"
        class="px-4 py-2 bg-gray-200 rounded disabled:opacity-50"
      >
        ←
      </button>

      <span class="px-4 py-2">
        Page {{ paginationInfo.current_page }} / {{ paginationInfo.last_page }}
      </span>

      <button
        @click="goToPage(paginationInfo.current_page + 1)"
        :disabled="paginationInfo.current_page === paginationInfo.last_page"
        class="px-4 py-2 bg-gray-200 rounded disabled:opacity-50"
      >
        →
      </button>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue';
import { router } from '@inertiajs/vue3';

const props = defineProps({
  comments: {
    type: [Array, Object],
    required: true,
  },
});

const commentsList = computed(() => {
  if (Array.isArray(props.comments)) {
    return props.comments;
  }

  if (props.comments?.data && Array.isArray(props.comments.data)) {
    return props.comments.data;
  }

  return [];
});

const paginationInfo = computed(() => {
  if (props.comments?.current_page) {
    return {
      current_page: props.comments.current_page,
      last_page: props.comments.last_page,
    };
  }

  return null;
});

const goToPage = (targetPage) => {
  if (!paginationInfo.value || targetPage < 1 || targetPage > paginationInfo.value.last_page) {
    return;
  }

  const currentQuery = new URLSearchParams(window.location.search);
  const search = currentQuery.get('search');
  const query = { page: targetPage };

  if (search) {
    query.search = search;
  }

  router.get(route('Comment.index'), query, {
    preserveScroll: true,
    preserveState: true,
    replace: true,
    only: ['comments'],
  });
};
</script>

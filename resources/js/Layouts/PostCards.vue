<template>
    <div class="p-6">
      <h1 class="text-2xl font-bold mb-4">Les Posts</h1>
      <p class="text-gray-600">{{ postsList.length }} posts trouvés</p>

      <div v-if="postsList.length > 0" class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-5">
        <div v-for="post in postsList" :key="post.id" class="overflow-hidden rounded border bg-white shadow-sm">
          <a :href="route('post.comments', {id: post.id})"><img
            :src="post.image.startsWith('http') ? post.image : '/storage/' + post.image"
            :alt="post.url_title || post.content"
            class="h-40 w-full object-contain bg-white-100"
          />
          </a>
          <div class="space-y-2 p-4">
            <h2 class="line-clamp-2 text-lg font-semibold">{{ post.url_title || post.content }}</h2>
            <p class="line-clamp-2 text-sm text-gray-600">{{ post.content }}</p>
            <div class="flex items-center justify-between pt-2 text-sm text-gray-700">
              <span>👍 {{ post.post_likes_count ?? 0 }}</span>
              <span>💬 {{ post.comments_count ?? 0 }}</span>
              <span>❤️💬 {{ post.comment_likes_count ?? 0 }}</span>
            </div>
          </div>
        </div>
      </div>

      <div v-else class="text-gray-500">
        Aucun post trouvé pour cette recherche.
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
  posts: {
    type: [Array, Object],
    required: true,
  },
});

const postsList = computed(() => {
  if (Array.isArray(props.posts)) {
    return props.posts;
  }

  if (props.posts?.data && Array.isArray(props.posts.data)) {
    return props.posts.data;
  }

  return [];
});

const paginationInfo = computed(() => {
  if (props.posts?.current_page) {
    return {
      current_page: props.posts.current_page,
      last_page: props.posts.last_page
    };
  }
  return null;
});

const goToPage = (targetPage) => {
  if (!paginationInfo.value || targetPage < 1 || targetPage > paginationInfo.value.last_page) {
    return;
  }

  const currentQuery = new URLSearchParams(window.location.search);
  const pathParts = window.location.pathname.split('/').filter(Boolean);
  const searchFromPath = pathParts[1] ?? null;
  const searchFromQuery = currentQuery.get('search');
  const activeSearch = searchFromQuery || searchFromPath;
  const query = { page: targetPage };

  if (activeSearch) {
    query.search = activeSearch;
  }

  router.get(route('Post.index'), query, {
    preserveScroll: true,
    preserveState: true,
    replace: true,
    only: ['posts'],
  });
};
</script>

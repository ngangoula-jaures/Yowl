<template>
    <div class="p-4">
      <div class="flex items-center justify-between mb-4">
        <h1 class="text-2xl font-bold text-white">Les Posts</h1>
        <p class="text-sm text-[rgba(255,255,255,0.6)]">{{ postsList.length }} posts</p>
      </div>

      <div v-if="postsList.length > 0" class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-3">
        <div v-for="post in postsList" :key="post.id" class="overflow-hidden rounded yowl-card">
          <a :href="route('post.comments', {id: post.id})"><img
            :src="post.image.startsWith('http') ? post.image : '/storage/' + post.image"
            :alt="post.url_title || post.content"
            class="h-44 w-full object-cover rounded-t-md"
          />
          </a>
          <div class="space-y-2 p-4">
            <h2 class="line-clamp-2 text-lg font-semibold text-white">{{ post.url_title || post.content }}</h2>
            <p class="line-clamp-2 text-sm text-[rgba(255,255,255,0.75)]">{{ post.content }}</p>
            <div class="flex items-center justify-between pt-2 text-sm text-[rgba(255,255,255,0.6)]">
              <span>👍 {{ post.post_likes_count ?? 0 }}</span>
              <span>💬 {{ post.comments_count ?? 0 }}</span>
              <span>💙 {{ post.comment_likes_count ?? 0 }}</span>
            </div>
          </div>
        </div>
      </div>

      <div v-else class="text-[rgba(255,255,255,0.6)]">
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

<template>
  <div>
    <!-- Recherche avec bouton -->
    <div class="flex gap-2 mb-4">
      <input
        type="text"
        v-model="searchTerm"
        @keyup.enter="searchPosts"
        placeholder="Rechercher un post (contenu ou URL)..."
        class="flex-1 px-4 py-2 border rounded"
      />
      <button
        @click="searchPosts"
        class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700"
      >
        Rechercher
      </button>
    </div>

    <!-- Liste des posts -->
    <div class="yowl-card rounded">
      <div v-for="post in postsList" :key="post.id" class="flex justify-between items-start p-4 border-b border-[rgba(255,255,255,0.03)]">
        <div class="flex-1">
          <Link :href="route('post.comments', { id: post.id })" class="block p-2 -ml-2 rounded hover:bg-[rgba(255,255,255,0.02)] transition-colors">
            <span class="font-bold text-white">{{ post.url_title || 'Post sans titre' }}</span>
            <p class="text-sm text-[rgba(255,255,255,0.7)] mt-1 mb-2">
              <span v-if="post.url" class="text-[rgba(255,255,255,0.65)] break-all">{{ post.url }}</span>
            </p>
            <p class="text-sm text-[rgba(255,255,255,0.9)]">{{ truncate(post.content, 100) }}</p>
            <div class="flex gap-4 mt-2">
              <span class="text-xs text-[rgba(255,255,255,0.6)]">Par: {{ getUserName(post) }}</span>
              <span class="text-xs text-[rgba(255,255,255,0.6)]">Le: {{ formatDate(post.created_at) }}</span>
            </div>
          </Link>
        </div>
        <button @click="confirmDelete(post.id, post.title)" class="bg-red-600 text-white px-3 py-1 rounded text-sm ml-4">
          Supprimer
        </button>
      </div>
      <div v-if="postsList.length === 0" class="p-4 text-center text-[rgba(255,255,255,0.6)]">
        Aucun post trouvé
      </div>

      <!-- Pagination -->
      <div v-if="paginationInfo" class="p-4 flex justify-center gap-2">
        <button @click="goToPage(paginationInfo.current_page - 1)" :disabled="paginationInfo.current_page === 1" class="px-3 py-1 bg-gray-200 rounded disabled:opacity-50">←</button>
        <span class="px-3 py-1">Page {{ paginationInfo.current_page }} / {{ paginationInfo.last_page }}</span>
        <button @click="goToPage(paginationInfo.current_page + 1)" :disabled="paginationInfo.current_page === paginationInfo.last_page" class="px-3 py-1 bg-gray-200 rounded disabled:opacity-50">→</button>
      </div>
    </div>

    <!-- Modal -->
    <div v-if="showModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
      <div class="yowl-card rounded p-4 max-w-lg w-full">
        <p class="text-[rgba(255,255,255,0.95)]">Supprimer le post <strong class="text-white">"{{ postToDeleteName }}"</strong> ?</p>
        <p class="text-red-400 text-sm mt-2">⚠️ Tous les commentaires de ce post seront supprimés.</p>
        <div class="flex justify-end gap-2 mt-4">
          <button @click="showModal = false" class="px-3 py-1 bg-[rgba(255,255,255,0.04)] rounded">Non</button>
          <button @click="performDelete" class="px-3 py-1 bg-red-600 text-white rounded">Oui</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import { router, Link } from '@inertiajs/vue3';

const props = defineProps({
  posts: Object
});

const searchTerm = ref('');
const showModal = ref(false);
const postToDeleteId = ref(null);
const postToDeleteName = ref('');

const getUserName = (post) => {
  if (post.user?.pseudo) return post.user.pseudo;
  if (post.user?.name) return post.user.name;
  return 'Inconnu';
};

const truncate = (text, length) => {
  if (!text) return '';
  return text.length > length ? text.substring(0, length) + '...' : text;
};

const formatDate = (date) => {
  if (!date) return '';
  return new Date(date).toLocaleDateString('fr-FR');
};

const postsList = computed(() => props.posts?.data || []);
const paginationInfo = computed(() => props.posts?.current_page ? {
  current_page: props.posts.current_page,
  last_page: props.posts.last_page
} : null);

const searchPosts = () => {
  router.get(route('admin.showPosts'), { page: 1, search: searchTerm.value }, { preserveScroll: true });
};

const goToPage = (page) => {
  if (!paginationInfo.value) return;
  router.get(route('admin.showPosts'), { page, search: searchTerm.value }, { preserveScroll: true });
};

const confirmDelete = (id, title) => {
  postToDeleteId.value = id;
  postToDeleteName.value = title;
  showModal.value = true;
};

const performDelete = () => {
  router.delete(route('admin.deletePost', { id: postToDeleteId.value }), {
    onSuccess: () => {
      showModal.value = false;
      goToPage(paginationInfo.value?.current_page || 1);
    }
  });
};
</script>

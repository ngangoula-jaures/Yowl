<template>
  <div>
    <!-- Recherche avec bouton -->
    <div class="flex gap-2 mb-4">
      <input 
        type="text" 
        v-model="searchTerm"
        @keyup.enter="searchComments"
        placeholder="Rechercher un commentaire..."
        class="flex-1 px-4 py-2 border rounded"
      />
      <button 
        @click="searchComments"
        class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700"
      >
        Rechercher
      </button>
    </div>

    <!-- Liste des commentaires -->
    <div class="bg-white rounded shadow">
      <div v-for="comment in commentsList" :key="comment.id" class="flex justify-between items-start p-4 border-b">
        <div class="flex-1">
          <Link :href="route('post.comments', { id: comment.post_id })" class="block p-2 -ml-2 rounded hover:bg-gray-50 transition-colors">
            <p class="text-gray-800">{{ truncate(comment.content, 150) }}</p>
            <div class="flex gap-4 mt-2">
              <span class="text-xs text-gray-500">Par: {{ getUserName(comment) }}</span>
              <span class="text-xs text-gray-500">Post: {{ getPostTitle(comment) }}</span>
              <span class="text-xs text-gray-500">Le: {{ formatDate(comment.created_at) }}</span>
            </div>
          </Link>
        </div>
        <button @click="confirmDelete(comment.id, truncate(comment.content, 50))" class="bg-red-600 text-white px-3 py-1 rounded text-sm ml-4">
          Supprimer
        </button>
      </div>
      <div v-if="commentsList.length === 0" class="p-4 text-center text-gray-500">
        Aucun commentaire trouvé
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
      <div class="bg-white rounded p-4">
        <p>Supprimer le commentaire <strong>"{{ commentToDeleteName }}..."</strong> ?</p>
        <p class="text-red-600 text-sm mt-2">⚠️ Toutes les réponses seront supprimées.</p>
        <div class="flex justify-end gap-2 mt-4">
          <button @click="showModal = false" class="px-3 py-1 bg-gray-300 rounded">Non</button>
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
  comments: Object
});

const searchTerm = ref('');
const showModal = ref(false);
const commentToDeleteId = ref(null);
const commentToDeleteName = ref('');

const getUserName = (comment) => {
  if (comment.user?.pseudo) return comment.user.pseudo;
  if (comment.user?.name) return comment.user.name;
  return 'Inconnu';
};

const getPostTitle = (comment) => {
  // Gérer le cas où post est null ou non défini
  if (comment.post?.title) return comment.post.title;
  if (comment.post_title) return comment.post_title;
  return 'Post #' + comment.post_id;
};

const truncate = (text, length) => {
  if (!text) return '';
  return text.length > length ? text.substring(0, length) + '...' : text;
};

const formatDate = (date) => {
  if (!date) return '';
  return new Date(date).toLocaleDateString('fr-FR');
};

const commentsList = computed(() => props.comments?.data || []);
const paginationInfo = computed(() => props.comments?.current_page ? { 
  current_page: props.comments.current_page, 
  last_page: props.comments.last_page 
} : null);

const searchComments = () => {
  router.get(route('admin.showComments'), { page: 1, search: searchTerm.value }, { preserveScroll: true });
};

const goToPage = (page) => {
  if (!paginationInfo.value) return;
  router.get(route('admin.showComments'), { page, search: searchTerm.value }, { preserveScroll: true });
};

const confirmDelete = (id, content) => {
  commentToDeleteId.value = id;
  commentToDeleteName.value = content;
  showModal.value = true;
};

const performDelete = () => {
  router.delete(route('admin.deleteComment', { id: commentToDeleteId.value }), {
    onSuccess: () => {
      showModal.value = false;
      goToPage(paginationInfo.value?.current_page || 1);
    }
  });
};
</script>
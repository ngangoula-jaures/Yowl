<template>
  <div>
    <!-- Recherche avec bouton -->
    <div class="flex gap-2 mb-4">
      <input
        type="text"
        v-model="searchTerm"
        @keyup.enter="searchUsers"
        placeholder="Rechercher un utilisateur par pseudo ou email..."
        class="flex-1 px-4 py-2 border rounded"
      />
      <button
        @click="searchUsers"
        class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700"
      >
        Rechercher
      </button>
    </div>

    <!-- Liste utilisateurs -->
    <div class="yowl-card rounded">
      <div v-for="user in usersList" :key="user.id" class="flex justify-between items-center p-4 border-b border-[rgba(255,255,255,0.03)]">
        <div>
          <span class="font-bold text-white">{{ user.pseudo }}</span>
          <span class="text-[rgba(255,255,255,0.6)] ml-2">{{ user.email }}</span>
        </div>
        <button @click="confirmDelete(user.id, user.pseudo)" class="bg-red-600 text-white px-3 py-1 rounded text-sm">
          Supprimer
        </button>
      </div>
      <div v-if="usersList.length === 0" class="p-4 text-center text-[rgba(255,255,255,0.6)]">
        Aucun utilisateur trouvé
      </div>

      <!-- Pagination -->
      <div v-if="paginationInfo" class="p-4 flex justify-center gap-2">
        <button @click="goToPage(paginationInfo.current_page - 1)" :disabled="paginationInfo.current_page === 1" class="px-3 py-1 bg-[rgba(255,255,255,0.03)] rounded disabled:opacity-50">←</button>
        <span class="px-3 py-1 text-[rgba(255,255,255,0.8)]">Page {{ paginationInfo.current_page }} / {{ paginationInfo.last_page }}</span>
        <button @click="goToPage(paginationInfo.current_page + 1)" :disabled="paginationInfo.current_page === paginationInfo.last_page" class="px-3 py-1 bg-[rgba(255,255,255,0.03)] rounded disabled:opacity-50">→</button>
      </div>
    </div>

    <!-- Modal -->
    <div v-if="showModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
      <div class="yowl-card rounded p-4 max-w-lg w-full">
        <p class="text-[rgba(255,255,255,0.95)]">Supprimer "{{ userToDeleteName }}" ?</p>
        <p class="text-red-400 text-sm mt-2">⚠️ Tous ses posts et commentaires seront supprimés.</p>
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
import { router } from '@inertiajs/vue3';

const props = defineProps({
  users: Object
});

const searchTerm = ref('');
const showModal = ref(false);
const userToDeleteId = ref(null);
const userToDeleteName = ref('');

const usersList = computed(() => props.users?.data || []);
const paginationInfo = computed(() => props.users?.current_page ? {
  current_page: props.users.current_page,
  last_page: props.users.last_page
} : null);

const searchUsers = () => {
  router.get(route('admin.showUsers'), { page: 1, search: searchTerm.value }, { preserveScroll: true });
};

const goToPage = (page) => {
  if (!paginationInfo.value) return;
  router.get(route('admin.showUsers'), { page, search: searchTerm.value }, { preserveScroll: true });
};

const confirmDelete = (id, name) => {
  userToDeleteId.value = id;
  userToDeleteName.value = name;
  showModal.value = true;
};

const performDelete = () => {
  router.delete(route('admin.deleteUser', { id: userToDeleteId.value }), {
    onSuccess: () => {
      showModal.value = false;
      // Rafraîchir la page actuelle
      goToPage(paginationInfo.value?.current_page || 1);
    }
  });
};
</script>

<template>
  <MainAdmin>
    <div>
      <h1 class="text-2xl font-bold mb-6">Dashboard Admin</h1>

      <!-- Liens de navigation -->
      <div class="flex gap-4 mb-6">
        <Link :href="route('admin.showUsers')" class="bg-gray-200 px-4 py-2 rounded hover:bg-gray-300">
          Utilisateurs ({{ usersTotal }})
        </Link>
        <Link :href="route('admin.showPosts')" class="bg-gray-200 px-4 py-2 rounded hover:bg-gray-300">
          Posts ({{ postsTotal }})
        </Link>
        <Link :href="route('admin.showComments')" class="bg-gray-200 px-4 py-2 rounded hover:bg-gray-300">
          Commentaires Parents ({{ parentCommentsTotal }})
        </Link>
      </div>

      <!-- Affichage du composant selon la route -->
      <component :is="currentComponent" v-bind="componentProps" />
    </div>
  </MainAdmin>
</template>

<script setup>
import Navbar from '@/Layouts/Navbar.vue';
defineOptions({
  layout: Navbar,
});
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';
import MainAdmin from '@/Layouts/MainAdmin.vue';
import ShowUsers from '@/Layouts/ShowUsers.vue';
import ShowPosts from '@/Layouts/ShowPosts.vue';
import ShowComments from '@/Layouts/ShowComments.vue';

const props = defineProps({
  view: String,
  Users: Object,
  Posts: Object,
  Comments: Object,
  postsTotal: Number,
  parentCommentsTotal: Number
});

const usersTotal = computed(() => props.Users?.total || 0);

const currentComponent = computed(() => {
  switch (props.view) {
    case 'users': return ShowUsers;
    case 'posts': return ShowPosts;
    case 'comments': return ShowComments;
    default: return ShowUsers;
  }
});

const componentProps = computed(() => {
  switch (props.view) {
    case 'users': return { users: props.Users };
    case 'posts': return { posts: props.Posts };
    case 'comments': return { comments: props.Comments };
    default: return { users: props.Users };
  }
});
</script>
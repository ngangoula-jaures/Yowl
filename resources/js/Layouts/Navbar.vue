<script setup>
import { Link, useForm } from '@inertiajs/vue3' // Ajoute useForm ici

const form = useForm({
  search: '',
});

const handleSearch = () => {
  // On envoie la recherche vers la route d'accueil en méthode GET
  form.get(route('Post.index'));
};
</script>

<template>
  <main>
    <nav>
      <div class="flex justify-between items-center width-full bg-gray-100 p-4">
        <div class="flex items-center gap-4">
            <Link :href="route('Post.index')">Accueil</Link>
            <Link href="/admin">ADMIN</Link>
        </div>

        <!-- Remplacer 'action' par @submit.prevent -->
        <form @submit.prevent="handleSearch">
          <div class="flex justify-start items-center gap-2 ">
              <input 
                v-model="form.search" 
                class="border-2 border-gray-300 rounded-md p-2 w-full"
                type="text" 
                placeholder="Rechercher..." 
              />
              <button type="submit">Search</button>
          </div>
        </form>

        <div class="flex items-center gap-2">
          <button>Login</button>
          <button>Register</button>
        </div>
      </div>
    </nav>

    <article>
      <slot />
    </article>
  </main>
</template>

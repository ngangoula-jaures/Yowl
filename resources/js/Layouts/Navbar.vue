<script setup>
import { Link, useForm } from '@inertiajs/vue3' // Ajoute useForm ici
import { usePage } from '@inertiajs/vue3';
import { watch, onMounted } from "vue"
import { useToast } from "primevue/usetoast";
import Toast from 'primevue/toast';

const form = useForm({
  search: '',
});

const handleSearch = () => {
  const routeName = window.location.pathname.startsWith('/comments')
    ? 'Comment.index'
    : 'Post.index';

  form.get(route(routeName), {
    preserveState: true,
    preserveScroll: true,
    replace: true,
    data: {
      search: form.search,
    },
  });
};


const page = usePage();
const toast = useToast();

const showToast= ()=>{
  if(page.props.flash){
    if(page.props.flash?.success){
      toast.add({
        severity: 'success',
        summary: 'Succès',
        detail: page.props.flash.success,
        life: 3000
      })
      page.props.flash.success = null;
    }else if(page.props.flash?.echec){
      toast.add({
        severity: 'error',
        summary: "Echec",
        detail: page.props.flash.echec,
        life: 3000
      })
      page.props.flash.echec = null;
    }
  }

  const errors = page.props.errors;
  if (Object.keys(errors).length > 0) {
    Object.values(errors).forEach(msg => {
      toast.add({ severity: 'error', summary: 'Validation', detail: msg, life: 4000 });
    });
  }
}

  onMounted(()=>{
    showToast()
  })

  watch(
    ()=> [page.props.flash, page.props.errors], 
    ()=> showToast(), 
    {deep: true}
  )
</script>

<template>
  <Toast/>
  <div class="min-h-screen bg-gray-50 flex flex-col">
    <nav class="bg-white p-4 shadow-sm sticky top-0 z-50">
      <div class="container mx-auto flex justify-between items-center">
        <Link href="/home" class="text-xl font-extrabold text-indigo-600 flex items-center gap-2">
          YOWL
        </Link>

        <div class="flex items-center space-x-6">
          <form v-if="route().current('Post.index') || $page.url.startsWith('/comments')" @submit.prevent="handleSearch">
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
          <Link :href="route('Post.index')" class="text-gray-600 hover:text-indigo-600 font-medium transition">Accueil</Link>
          <Link v-if="!$page.props.auth.user" :href="route('login')" class="text-gray-600 hover:text-indigo-600 font-medium transition">Connexion</Link>
          <Link v-if="$page.props.auth.user" :href="route('post')" class="text-gray-600 hover:text-indigo-600 font-medium transition">Faire un post</Link>
          <Link v-if="$page.props.auth.user?.role === 'admin' " :href="route('dashboard.kpi')" class="text-gray-600 hover:text-indigo-600 font-medium transition">Dashboard</Link>
          <Link v-if="$page.props.auth.user " :href="route('profile', {me: $page.props.auth.user?.id})" class="text-gray-600 hover:text-indigo-600 font-medium transition">Profile</Link>

          <Link v-if="!$page.props.auth.user"
            :href="route('verify.email')" 
            class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg font-bold transition shadow-md"
          >
            S'inscrire
          </Link>
          <Link v-if="$page.props.auth.user && route().current('profile')"
            :href="route('logout')" method="post" as="button"
            class="bg-red-600 hover:bg-red-700 text-white px-5 py-2 rounded-lg font-bold transition shadow-md"
          >
            Se deconnecter
          </Link>
        </div>
      </div>
    </nav>

    <main class="flex-grow container mx-auto p-6">
      <slot />
    </main>

    <footer class="bg-white border-top py-6 text-center text-gray-400 text-sm">
      &copy; 2026 YOWL - Tous droits réservés.
    </footer>
  </div>
</template>
        
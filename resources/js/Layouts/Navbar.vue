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
  <div class="min-h-screen flex flex-col">
    <nav class="glass sticky top-0 z-50 py-3">
      <div class="container mx-auto flex justify-between items-center px-4">
        <Link href="/home" class="text-2xl font-extrabold flex items-center gap-3 neon-avatar">
          <span class="px-3 py-2 text-white text-lg">Y</span>
          <span class="text-white">YOWL</span>
        </Link>

        <div class="flex items-center space-x-4">
          <form v-if="route().current('Post.index') || $page.url.startsWith('/comments')" @submit.prevent="handleSearch" class="w-72">
            <div class="flex items-center gap-2">
              <input
                v-model="form.search"
                class="yowl-search"
                type="text"
                placeholder="Rechercher une URL, un profil..."
              />
            </div>
          </form>

          <div class="hidden md:flex items-center gap-4">
            <Link :href="route('Post.index')" class="text-sm text-[rgba(255,255,255,0.85)] hover:text-white font-medium transition">Accueil</Link>
            <Link v-if="!$page.props.auth.user" :href="route('login')" class="text-sm text-[rgba(255,255,255,0.85)] hover:text-white font-medium transition">Connexion</Link>
            <Link :href="route('post')" class="text-sm text-[rgba(255,255,255,0.85)] hover:text-white font-medium transition">Faire un post</Link>
            <Link v-if="$page.props.auth.user?.role === 'admin' " :href="route('dashboard.kpi')" class="text-sm text-[rgba(255,255,255,0.85)] hover:text-white font-medium transition">Dashboard</Link>
            <Link v-if="$page.props.auth.user " :href="route('profile', {me: $page.props.auth.user?.id})" class="text-sm text-[rgba(255,255,255,0.85)] hover:text-white font-medium transition">Profil</Link>
          </div>

          <div class="flex items-center gap-2">
            <Link v-if="!$page.props.auth.user" :href="route('verify.email')" class="yowl-btn">S'inscrire</Link>
            <Link v-if="$page.props.auth.user && route().current('profile')" :href="route('logout')" method="post" as="button" class="yowl-btn bg-red-500">Se déconnecter</Link>
          </div>
        </div>
      </div>
    </nav>

    <main class="flex-grow container mx-auto px-4 py-6">
      <slot />
    </main>

    <footer class="py-6 text-center text-[rgba(255,255,255,0.5)] text-sm">
      &copy; 2026 YOWL - Tous droits réservés.
    </footer>
  </div>
</template>

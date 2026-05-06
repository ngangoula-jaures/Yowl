<script setup>
import { Link, useForm } from '@inertiajs/vue3' // Ajoute useForm ici
import { usePage } from '@inertiajs/vue3';
import { watch, onMounted, ref } from "vue"
import { useToast } from "primevue/usetoast";
import Toast from 'primevue/toast';

const form = useForm({
  search: '',
});

const mobileMenuOpen = ref(false);

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
      <div class="container mx-auto flex flex-wrap justify-between items-center px-4">
        <!-- Logo -->
        <Link href="/home" class="text-2xl font-extrabold flex items-center gap-3 neon-avatar">
          <span class="px-3 py-2 text-white text-lg">Y</span>
          <span class="text-white hidden sm:block">YOWL</span>
        </Link>

        <!-- Barre de recherche (cachée sur tout petit écran, affichée en sm) -->
        <div class="flex-1 px-4 max-w-sm hidden sm:block">
          <form v-if="route().current('Post.index') || $page.url.startsWith('/comments')" @submit.prevent="handleSearch" class="w-full">
            <input
              v-model="form.search"
              class="yowl-search w-full"
              type="text"
              placeholder="Rechercher..."
            />
          </form>
        </div>

        <div class="flex items-center gap-3">
          <!-- Menu Desktop -->
          <div class="hidden md:flex items-center gap-4">
            <Link :href="route('Post.index')" class="text-sm text-[rgba(255,255,255,0.85)] hover:text-white font-medium transition">Accueil</Link>
            <Link v-if="!$page.props.auth.user" :href="route('login')" class="text-sm text-[rgba(255,255,255,0.85)] hover:text-white font-medium transition">Connexion</Link>
            <Link v-if="$page.props.auth.user" :href="route('post')" class="text-sm text-[rgba(255,255,255,0.85)] hover:text-white font-medium transition">Faire un post</Link>
            <Link v-if="$page.props.auth.user?.role === 'admin' " :href="route('dashboard.kpi')" class="text-sm text-[rgba(255,255,255,0.85)] hover:text-white font-medium transition">Dashboard</Link>
            <Link v-if="$page.props.auth.user " :href="route('profile', {me: $page.props.auth.user?.id})" class="text-sm text-[rgba(255,255,255,0.85)] hover:text-white font-medium transition">Profil</Link>
          </div>

          <!-- Boutons Desktop / Tablette -->
          <div class="hidden md:flex items-center gap-2">
            <Link v-if="!$page.props.auth.user" :href="route('verify.email')" class="yowl-btn text-sm px-3 py-1.5">S'inscrire</Link>
            <Link v-if="$page.props.auth.user && route().current('profile')" :href="route('logout')" method="post" as="button" class="yowl-btn bg-red-500 text-sm px-3 py-1.5">Déconnexion</Link>
          </div>

          <!-- Bouton Menu Mobile (Hamburger) -->
          <button @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden text-white focus:outline-none p-2 rounded-lg hover:bg-[rgba(255,255,255,0.1)] transition">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path v-if="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
              <path v-else stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
          </button>
        </div>
      </div>

      <!-- Menu Mobile -->
      <div v-if="mobileMenuOpen" class="md:hidden mt-3 px-4 pb-4 space-y-2 glass border-t border-[rgba(255,255,255,0.1)] pt-3 absolute w-full left-0 z-40 bg-[rgba(10,10,10,0.95)]">
          <form v-if="route().current('Post.index') || $page.url.startsWith('/comments')" @submit.prevent="handleSearch" class="w-full mb-4 sm:hidden">
            <input
              v-model="form.search"
              class="yowl-search w-full"
              type="text"
              placeholder="Rechercher une URL..."
            />
          </form>

          <Link @click="mobileMenuOpen = false" :href="route('Post.index')" class="block text-base font-medium text-white hover:bg-[rgba(255,255,255,0.1)] rounded-lg px-3 py-2 transition">Accueil</Link>
          <Link v-if="!$page.props.auth.user" @click="mobileMenuOpen = false" :href="route('login')" class="block text-base font-medium text-white hover:bg-[rgba(255,255,255,0.1)] rounded-lg px-3 py-2 transition">Connexion</Link>
          <Link v-if="!$page.props.auth.user" @click="mobileMenuOpen = false" :href="route('verify.email')" class="block text-base font-medium text-[rgba(255,122,24,1)] hover:bg-[rgba(255,255,255,0.1)] rounded-lg px-3 py-2 transition">S'inscrire</Link>
          <Link v-if="$page.props.auth.user" @click="mobileMenuOpen = false" :href="route('post')" class="block text-base font-medium text-white hover:bg-[rgba(255,255,255,0.1)] rounded-lg px-3 py-2 transition">Faire un post</Link>
          <Link v-if="$page.props.auth.user?.role === 'admin' " @click="mobileMenuOpen = false" :href="route('dashboard.kpi')" class="block text-base font-medium text-white hover:bg-[rgba(255,255,255,0.1)] rounded-lg px-3 py-2 transition">Dashboard</Link>
          <Link v-if="$page.props.auth.user " @click="mobileMenuOpen = false" :href="route('profile', {me: $page.props.auth.user?.id})" class="block text-base font-medium text-white hover:bg-[rgba(255,255,255,0.1)] rounded-lg px-3 py-2 transition">Profil</Link>
          <Link v-if="$page.props.auth.user && route().current('profile')" @click="mobileMenuOpen = false" :href="route('logout')" method="post" as="button" class="block w-full text-left text-base font-bold text-red-500 hover:bg-red-500/10 rounded-lg px-3 py-2 mt-2 transition">Se déconnecter</Link>
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

<template>
  <div class="min-h-screen bg-gray-100">
    <!-- Barre de navigation fixe -->
    <nav class="bg-white p-4 shadow">
      <Link href="/" class="mr-4">Accueil</Link>
      <Link href="/test">Page Test</Link>
    </nav>

    <!-- ZONE DYNAMIQUE (Le contenu de la page arrive ici) -->
    <main class="p-8">
      <slot />
    </main>
  </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
</script>

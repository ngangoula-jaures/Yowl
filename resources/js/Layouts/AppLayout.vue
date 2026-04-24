<template>
  <div class="min-h-screen" style="background: linear-gradient(180deg,#0b0b0d,#070708);">
    <!-- Barre de navigation fixe -->
    <nav class="glass p-4 shadow-sm">
      <div class="container mx-auto flex items-center gap-4">
        <Link href="/home" class="text-white font-semibold">Accueil</Link>
        <Link href="/test" class="text-[rgba(255,255,255,0.8)]">Page Test</Link>
      </div>
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

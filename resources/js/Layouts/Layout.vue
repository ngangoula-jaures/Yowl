<template>
  <div class="min-h-screen flex flex-col" style="background: linear-gradient(180deg,#0b0b0d,#070708);">
    <nav class="glass sticky top-0 z-50 py-3">
      <div class="container mx-auto flex justify-between items-center px-4">
        <Link href="/" class="text-2xl font-extrabold text-white">YOWL</Link>

        <div class="flex items-center space-x-4">
          <Link href="/" class="text-[rgba(255,255,255,0.85)] hover:text-white font-medium transition">Accueil</Link>
          <Link href="/login" class="text-[rgba(255,255,255,0.85)] hover:text-white font-medium transition">Connexion</Link>
          <Link href="/EmailVerify" class="yowl-btn">S'inscrire</Link>
        </div>
      </div>
    </nav>

    <main class="flex-grow container mx-auto p-6">
      <slot />
    </main>

    <footer class="py-6 text-center text-[rgba(255,255,255,0.5)] text-sm">
      &copy; 2026 YOWL - Tous droits réservés.
    </footer>
  </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
</script>

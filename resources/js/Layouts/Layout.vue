<template>
  <div class="min-h-screen bg-gray-50 flex flex-col">
    <nav class="bg-white p-4 shadow-sm sticky top-0 z-50">
      <div class="container mx-auto flex justify-between items-center">
        <Link href="/" class="text-xl font-extrabold text-indigo-600 flex items-center gap-2">
          YOWL
        </Link>

        <div class="flex items-center space-x-6">
          <Link href="/" class="text-gray-600 hover:text-indigo-600 font-medium transition">Accueil</Link>
          <Link href="/login" class="text-gray-600 hover:text-indigo-600 font-medium transition">Connexion</Link>
          
          <Link 
            href="/EmailVerify" 
            class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg font-bold transition shadow-md"
          >
            S'inscrire
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

<script setup>
import { Link } from '@inertiajs/vue3';
</script>
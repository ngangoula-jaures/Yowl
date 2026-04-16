<template>
  <section class="space-y-4">
    <h1 class="text-3xl font-bold text-gray-900">Accueil Admin</h1>
    <p class="text-gray-600">
      Bienvenue sur la page <strong>aristide</strong>. Cette vue est servie via Inertia depuis
      <code>routes/admin.php</code>.
    </p>
  </section>
</template>

<script setup>
import Navbar from '@/Layouts/Navbar.vue';

defineOptions({
  layout: Navbar,
});
</script>


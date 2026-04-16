<template>
    <h1 class="text-2xl font-bold">Bienvenue sur l'Accueil !</h1>
    <p>Ceci est le contenu spécifique à l'accueil.</p>
</template>

<script setup>
<<<<<<< HEAD
import Navbar from '@/Layouts/Navbar.vue';

defineOptions({
  layout: Navbar,
});
</script>
=======
import HeaderLayout from '@/Layouts/HeaderLayout.vue';

// On définit le layout persistant
defineOptions({ layout: HeaderLayout })
</script>
>>>>>>> a395fea376a3050bf48fd62b86a4872a041a8a67

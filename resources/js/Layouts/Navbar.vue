<template>
  <main>
    <nav>
    <div class="flex justify-between items-center width-full bg-gray-100 p-4">
      <div class="flex items-center gap-4">
          <Link href="/home">Accueil</Link>
          <Link href="/admin">ADMIN</Link>
      </div>
    
      <div class="flex justify-start items-center gap-2 ">
          <input class="  border-2 border-gray-300 rounded-md p-2 w-full" type="text" placeholder="Search" />
          <button>Search</button>
      </div>
      <div class="flex items-center gap-2">
        <button>Login</button>
        <button>Register</button>
      </div>
    </div>
    </nav>

    <article>
      <!-- Le <slot /> agit comme le <router-view> -->
      <slot />
    </article>
  </main>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
</script>

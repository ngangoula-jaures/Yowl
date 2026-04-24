<template>
  <div class="min-h-screen flex flex-col" style="background: linear-gradient(180deg,#0b0b0d,#070708);">
    <main class="flex-grow flex items-center justify-center px-4 py-12">
      <div class="w-full max-w-md yowl-card p-10">

        <div class="text-center mb-8">
          <h1 class="text-3xl font-bold text-white">YOWL</h1>
          <p class="text-[rgba(255,255,255,0.7)] text-sm">Veuillez vérifier votre email pour commencer l'inscription.</p>
        </div>

        <form @submit.prevent="submit" class="space-y-6">
          <div>
            <label class="block text-xs font-bold text-[rgba(255,255,255,0.85)] uppercase mb-1">Adresse Email</label>
            <input
              type="email"
              v-model="form.email"
              placeholder="Entrez votre adresse email"
              class="w-full bg-[rgba(255,255,255,0.02)] border border-[rgba(255,255,255,0.04)] rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[rgba(199,63,255,0.4)] text-white"
              required
            />
            <div v-if="form.errors.email" class="text-red-500 text-xs mt-1">{{ form.errors.email }}</div>
          </div>

          <button
            type="submit"
            :disabled="form.processing"
            class="w-full yowl-btn"
          >
            {{ form.processing ? 'Chargement...' : 'Valider mon Email' }}
          </button>

          <p class="text-center text-sm text-[rgba(255,255,255,0.6)] mt-6">
            Vous avez déjà un compte ?
            <Link href="/login" class="text-[rgba(199,63,255,0.95)] font-bold hover:underline">Connexion</Link>
          </p>
        </form>
      </div>
    </main>
  </div>
</template>

<script setup>
import AppLayout from '@/Layouts/Layout.vue'
import { useForm, Link } from '@inertiajs/vue3'

defineOptions({ layout: AppLayout })

const form = useForm({
  email: '',
})

const submit = () => {
  form.post('/EmailVerify')
}
</script>

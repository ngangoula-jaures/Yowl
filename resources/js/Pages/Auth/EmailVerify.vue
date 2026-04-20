<template>
  <div class="min-h-screen bg-gray-100 flex flex-col">
    <main class="flex-grow flex items-center justify-center px-4 py-12">
      <div class="w-full max-w-md bg-white rounded-2xl shadow-md p-10">
        
        <div class="text-center mb-8">
          <h1 class="text-3xl font-bold text-indigo-600">YOWL</h1>
          <p class="text-gray-500 text-sm">Veuillez vérifier votre email pour commencer l'inscription.</p>
        </div>

        <form @submit.prevent="submit" class="space-y-6">
          <div>
            <label class="block text-xs font-bold text-gray-400 uppercase mb-1">Adresse Email</label>
            <input
              type="email"
              v-model="form.email"
              placeholder="Entrez votre adresse email"
              class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500"
              required
            />
            <div v-if="form.errors.email" class="text-red-500 text-xs mt-1">{{ form.errors.email }}</div>
          </div>

          <button
            type="submit"
            :disabled="form.processing"
            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-lg transition disabled:opacity-50"
          >
            {{ form.processing ? 'Chargement...' : 'Valider mon Email' }}
          </button>

          <p class="text-center text-sm text-gray-500 mt-6">
            Vous avez déjà un compte ? 
            <Link href="/login" class="text-blue-600 font-bold hover:underline">Connexion</Link>
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
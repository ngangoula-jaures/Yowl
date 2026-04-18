<template>
  <div class="min-h-screen bg-gray-100 flex items-center justify-center px-4 py-12">
    <div class="w-full max-w-md bg-white rounded-2xl shadow-md p-8">

      <div class="text-center mb-6">
        <h1 class="text-3xl font-bold text-indigo-600">Finalisez votre inscription</h1>
        <p class="text-gray-500 text-sm mt-1">Complétez vos informations</p>
      </div>

      <div v-if="Object.keys(form.errors).length > 0"
        class="bg-red-50 border border-red-200 text-red-600 rounded-lg p-3 mb-4 text-sm">
        <p v-for="(error, key) in form.errors" :key="key">{{ error }}</p>
      </div>

      <div v-if="ageError"
        class="bg-red-50 border border-red-200 text-red-600 rounded-lg p-3 mb-4 text-sm">
        <p>{{ ageError }}</p>
      </div>

      <form @submit.prevent="submit" class="space-y-5">

        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Pseudo</label>
          <input
            type="text"
            v-model="form.pseudo"
            placeholder="Votre pseudo"
            class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400"
            required
          />
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">
            Âge <span class="text-gray-400 font-normal">(entre 13 et 35 ans)</span>
          </label>
          <input
            type="number"
            v-model="form.age"
            placeholder="Votre âge"
            class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400"
            required
          />
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
          <input
            type="email"
            v-model="form.email"
            placeholder="exemple@gmail.com"
            class="w-full border border-gray-300 bg-gray-50 rounded-lg px-4 py-2.5 text-sm focus:outline-none cursor-not-allowed"
            readonly 
          />
          <p class="text-[10px] text-gray-400 mt-1 italic">L'email a été vérifié à l'étape précédente.</p>
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Mot de passe</label>
          <input
            type="password"
            v-model="form.password"
            placeholder="••••••••"
            class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400"
            required
          />
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Confirmer le mot de passe</label>
          <input
            type="password"
            v-model="form.password_confirmation"
            placeholder="••••••••"
            class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400"
            required
          />
        </div>

        <button
          type="submit"
          :disabled="form.processing"
          class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2.5 rounded-lg text-sm transition disabled:opacity-50">
          {{ form.processing ? 'Création en cours...' : 'Créer mon compte' }}
        </button>

      </form>

      <div class="flex items-center my-5">
        <div class="flex-1 h-px bg-gray-200"></div>
        <span class="px-3 text-xs text-gray-400">ou</span>
        <div class="flex-1 h-px bg-gray-200"></div>
      </div>

      <p class="text-center text-sm text-gray-500">
        Vous avez déjà un compte ? 
        <Link href="/login" class="text-indigo-600 font-medium hover:underline">Login</Link>
      </p>

    </div>
  </div>
</template>

<script setup>
import AppLayout from '@/Layouts/Layout.vue'
import { ref } from 'vue'
import { useForm, Link } from '@inertiajs/vue3'

defineOptions({ layout: AppLayout })

// Réception de l'email depuis le contrôleur
const props = defineProps({
    email: String
})

const ageError = ref('')

const form = useForm({
  pseudo: '',
  age: '',
  email: props.email || '', 
  password: '',
  password_confirmation: '',
})

const submit = () => {
  ageError.value = ''
  
  // Validation locale de l'âge
  const age = parseInt(form.age)
  if (!form.age || isNaN(age) || age < 13 || age > 35) {
    ageError.value = "L'âge doit être compris entre 13 et 35 ans."
    return
  }

  // Envoi vers la route définie dans web.php
  form.post('/inscription')
}
</script>
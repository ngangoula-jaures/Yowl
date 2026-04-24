<template>
  <div class="min-h-screen flex items-center justify-center px-4 py-12" style="background: linear-gradient(180deg,#0b0b0d,#070708);">
    <div class="w-full max-w-md yowl-card p-8">

      <div class="text-center mb-6">
        <h1 class="text-3xl font-bold text-white">Finalisez votre inscription</h1>
        <p class="text-[rgba(255,255,255,0.7)] text-sm mt-1">Complétez vos informations</p>
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
          <label class="block text-sm font-medium text-[rgba(255,255,255,0.9)] mb-1">Pseudo</label>
          <input
            type="text"
            v-model="form.pseudo"
            placeholder="Votre pseudo"
            class="w-full border border-[rgba(255,255,255,0.04)] rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[rgba(199,63,255,0.4)] bg-[rgba(255,255,255,0.02)] text-white"
            required
          />
        </div>

        <div>
          <label class="block text-sm font-medium text-[rgba(255,255,255,0.9)] mb-1">
            Âge <span class="text-gray-400 font-normal">(entre 13 et 35 ans)</span>
          </label>
          <input
            type="number"
            v-model="form.age"
            placeholder="Votre âge"
            class="w-full border border-[rgba(255,255,255,0.04)] rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[rgba(199,63,255,0.4)] bg-[rgba(255,255,255,0.02)] text-white"
            required
          />
        </div>

        <div>
          <label class="block text-sm font-medium text-[rgba(255,255,255,0.9)] mb-1">Email</label>
          <input
            type="email"
            v-model="form.email"
            placeholder="exemple@gmail.com"
            class="w-full border border-[rgba(255,255,255,0.04)] bg-[rgba(255,255,255,0.02)] rounded-lg px-4 py-2.5 text-sm focus:outline-none cursor-not-allowed text-white"
            readonly
          />
          <p class="text-[10px] text-gray-400 mt-1 italic">L'email a été vérifié à l'étape précédente.</p>
        </div>

        <div>
          <label class="block text-sm font-medium text-[rgba(255,255,255,0.9)] mb-1">Mot de passe</label>
          <input
            type="password"
            v-model="form.password"
            placeholder="••••••••"
            class="w-full border border-[rgba(255,255,255,0.04)] rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[rgba(199,63,255,0.4)] bg-[rgba(255,255,255,0.02)] text-white"
            required
          />
        </div>

        <div>
          <label class="block text-sm font-medium text-[rgba(255,255,255,0.9)] mb-1">Confirmer le mot de passe</label>
          <input
            type="password"
            v-model="form.password_confirmation"
            placeholder="••••••••"
            class="w-full border border-[rgba(255,255,255,0.04)] rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[rgba(199,63,255,0.4)] bg-[rgba(255,255,255,0.02)] text-white"
            required
          />
        </div>

        <button
          type="submit"
          :disabled="form.processing"
          class="w-full yowl-btn">
          {{ form.processing ? 'Création en cours...' : 'Créer mon compte' }}
        </button>

      </form>

      <div class="flex items-center my-5">
        <div class="flex-1 h-px bg-[rgba(255,255,255,0.03)]"></div>
        <span class="px-3 text-xs text-[rgba(255,255,255,0.6)]">ou</span>
        <div class="flex-1 h-px bg-[rgba(255,255,255,0.03)]"></div>
      </div>

      <p class="text-center text-sm text-[rgba(255,255,255,0.6)]">
        Vous avez déjà un compte ?
        <Link href="/login" class="text-[rgba(199,63,255,0.95)] font-medium hover:underline">Login</Link>
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

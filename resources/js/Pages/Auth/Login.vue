<template>
  <div class="min-h-screen bg-gray-100 flex flex-col">
    <main class="flex-grow flex items-center justify-center px-4 py-12">
      <div class="w-full max-w-md bg-white rounded-2xl shadow-md p-10">
        
        <div class="text-center mb-10">
          <h2 class="text-3xl font-extrabold text-indigo-600 mb-2">YOWL</h2>
          <p class="text-gray-500 text-sm font-medium">Connectez-vous à votre compte</p>
        </div>

        <form @submit.prevent="submit" class="space-y-6">
          <div>
            <label class="block text-xs font-bold text-gray-400 uppercase mb-1 tracking-wider">Email</label>
            <input
              type="email"
              v-model="form.email"
              placeholder="exemple@gmail.com"
              class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition"
              required
            />
            <div v-if="form.errors.email" class="text-red-500 text-xs mt-1">{{ form.errors.email }}</div>
          </div>

          <div>
            <div class="flex justify-between items-center mb-1">
              <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider">Mot de passe</label>
              <a href="#" class="text-xs text-indigo-600 hover:underline">Mot de passe oublié ?</a>
            </div>
            <input
              type="password"
              v-model="form.password"
              placeholder="••••••••"
              class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition"
              required
            />
            <div v-if="form.errors.password" class="text-red-500 text-xs mt-1">{{ form.errors.password }}</div>
          </div>

          <button
            type="submit"
            :disabled="form.processing"
            class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 rounded-lg transition shadow-lg disabled:opacity-50"
          >
            {{ form.processing ? 'Connexion en cours...' : 'Login' }}
          </button>
        </form>

        <div class="flex items-center my-8">
          <div class="flex-1 h-px bg-gray-200"></div>
          <span class="px-3 text-xs text-gray-400 uppercase font-bold">ou</span>
          <div class="flex-1 h-px bg-gray-200"></div>
        </div>

        <p class="text-center text-sm text-gray-500">
          Pas encore de compte ? 
          <Link href="/EmailVerify" class="text-indigo-600 font-bold hover:underline ml-1">
            S'inscrire
          </Link>
        </p>

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
  password: '',
})

const submit = () => {
  form.post('/login', {
    onFinish: () => form.reset('password'),
  })
}
</script>
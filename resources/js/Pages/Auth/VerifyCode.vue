<template>
  <div class="min-h-screen bg-gray-100 flex items-center justify-center px-4">
    <div class="w-full max-w-md bg-white rounded-2xl shadow-md p-8">

      <div class="text-center mb-6">
        <h1 class="text-3xl font-bold text-indigo-600">YOWL</h1>
        <p class="text-gray-500 text-sm mt-1">Entrez le code reçu par email</p>
      </div>

      <div v-if="form.errors.code" class="bg-red-50 border border-red-200 text-red-600 rounded-lg p-3 mb-4 text-sm">
        <p>{{ form.errors.code }}</p>
      </div>

      <form @submit.prevent="submit" class="space-y-5">
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Code de vérification</label>
          <input
            type="text"
            v-model="form.code"
            placeholder="123456"
            maxlength="6"
            class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm text-center tracking-widest text-lg focus:outline-none focus:ring-2 focus:ring-indigo-400"
          />
        </div>
        <button type="submit" :disabled="form.processing"
          class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2.5 rounded-lg text-sm transition disabled:opacity-50">
          Vérifier le code
        </button>
      </form>

    </div>
  </div>
</template>

<script setup>
import AppLayout from '@/Layouts/Layout.vue'
import { useForm } from '@inertiajs/vue3'

defineOptions({ layout: AppLayout })

const form = useForm({ code: '' })
const submit = () => form.post('/verify-code')
</script>
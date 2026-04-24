<template>
  <div class="min-h-screen flex items-center justify-center px-4" style="background: linear-gradient(180deg,#0b0b0d,#070708);">
    <div class="w-full max-w-md yowl-card p-8">

      <div class="text-center mb-6">
        <h1 class="text-3xl font-bold text-white">YOWL</h1>
        <p class="text-[rgba(255,255,255,0.7)] text-sm mt-1">Entrez le code reçu par email</p>
      </div>

      <div v-if="form.errors.code" class="bg-red-800 border border-red-700 text-red-200 rounded-lg p-3 mb-4 text-sm">
        <p>{{ form.errors.code }}</p>
      </div>

      <form @submit.prevent="submit" class="space-y-5">
        <div>
          <label class="block text-sm font-medium text-[rgba(255,255,255,0.9)] mb-1">Code de vérification</label>
          <input
            type="text"
            v-model="form.code"
            placeholder="123456"
            maxlength="6"
            class="w-full border border-[rgba(255,255,255,0.04)] rounded-lg px-4 py-2.5 text-sm text-center tracking-widest text-lg focus:outline-none focus:ring-2 focus:ring-[rgba(199,63,255,0.4)] bg-[rgba(255,255,255,0.02)] text-white"
          />
        </div>
        <button type="submit" :disabled="form.processing" class="w-full yowl-btn">Vérifier le code</button>
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

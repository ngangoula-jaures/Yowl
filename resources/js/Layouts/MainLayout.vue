<script setup>
import HeaderLayout from '@/Layouts/HeaderLayout.vue';
import { Link } from '@inertiajs/vue3';
import { usePage } from '@inertiajs/vue3';
import { watch, onMounted } from "vue"
import { useToast } from "primevue/usetoast";
import Toast from 'primevue/toast';

defineOptions({ layout: HeaderLayout })

const page = usePage();
const toast = useToast();

const showToast= ()=>{
  if(page.props.flash){
    if(page.props.flash.success){
      toast.add({
        severity: 'success',
        summary: 'Succès',
        detail: page.props.flash.success,
        life: 3000
      })
      page.props.flash.success = null;
    }else if(page.props.flash.echec){
      toast.add({
        severity: 'error',
        summary: "Echec",
        detail: page.props.flash.echec,
        life: 3000
      })
      page.props.flash.echec = null;
    }
  }
}

  onMounted(()=>{
    showToast()
  })

  watch(
    ()=> page.props.flash,
    ()=> showToast(),
    {deep: true}
  )

</script>

<template>
  <div class="min-h-screen" style="background: linear-gradient(180deg,#0b0b0d,#070708);">
    <Toast/>
    <nav class="glass p-4">
      <div class="container mx-auto flex items-center gap-4">
        <Link href="/" class="text-white">Accueil</Link>
        <Link href="/test" class="text-[rgba(255,255,255,0.8)]">Page Test</Link>
      </div>
    </nav>
    <!-- ZONE DYNAMIQUE (Le contenu de la page arrive ici) -->
    <main class="p-8 container mx-auto">
      <slot />
    </main>
  </div>
</template>

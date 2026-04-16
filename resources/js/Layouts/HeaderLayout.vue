<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import { watch, onMounted } from "vue"
import { useToast } from "primevue/usetoast";
import Toast from 'primevue/toast';


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
  <div class="bg-red-500">
    <h1>gvgvgwvwghcvwygcgywgywv</h1>
  </div>
  <slot />
</template>

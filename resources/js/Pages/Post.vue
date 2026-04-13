<script setup>
import HeaderLayout from '@/Layouts/HeaderLayout.vue';
import { useForm } from '@inertiajs/vue3';
import FileUpload from 'primevue/fileupload';

defineOptions({ layout: HeaderLayout })

const data = useForm({
    url: '',
    comment: ''
})

const submitForm = ()=>{
    data.post(route('post.create'),{
            onSuccess: ()=>{
                if(typeof props.image !== 'undefined' && 
                props.image === 'aucune image' && props.image === ''){
                    data.reset();
                }
            }
    });
};
const props = defineProps({
    type: String,
    title: String,
    image: String, 
    description: String
})
</script>

<template>
<form @submit.prevent="submitForm">
    <InputText class="w-[450px] !rounded-3xl !border-2" type="text" v-model="data.url" placeholder="Collez une url..."/>
    <FloatLabel class="mt-8">
    <Textarea v-model="data.comment" rows="5" cols="70" />
    <label>Commentaire</label>
    </FloatLabel>
    <FileUpload class="my-3"
    mode="basic" 
    name="img[]"
    accept=".jpg, .jpeg, .png," 
    :maxFileSize="1000000" 
    v-if="typeof props.image !== 'undefined' && (props.image === 'aucune image' || props.image === '')" />
    <Button type="submit" name='add' label="Submit" icon="pi pi-check" iconPos="right" />
</form>

<div>
        <h1>{{ props.title }}</h1>
        <h2>{{ props.type }}</h2>
        
        <!-- Pour une image, on utilise le binding ":" -->
        <img :src="props.image" :alt="props.title" v-if="typeof props.image !== 'undefined' && props.image !== 'aucune image' && props.image !== '' " />

        <p>{{ props.description }}</p>
    </div>

<pre>{{ $page.props }}</pre>

</template>
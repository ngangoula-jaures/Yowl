<script setup>
import HeaderLayout from '@/Layouts/HeaderLayout.vue';
import { useForm } from '@inertiajs/vue3';
import FileUpload from 'primevue/fileupload';
import { ref, watch } from 'vue';

defineOptions({ layout: HeaderLayout });

const data = useForm({
    url: '',
    comment: ''
});

const props = defineProps({
    type: String,
    title: String,
    image: String, 
    description: String
});

// Création d'une variable locale (modifiable) basée sur l'image qui vient du serveur (prop)
const currentImage = ref(props.image);

// Met à jour la variable si la prop "image" du serveur venait à changer après une navigation
watch(() => props.image, (newImage) => {
    currentImage.value = newImage;
});

const isImage = (url) => {
    if (!url) return false;
    return /\.(jpg|jpeg|png|webp|avif|gif|svg)$/.test(url.toLowerCase());
};

const submitForm = () => {
    if (isImage(data.url)) {
        // Comme c'est une image, on l'affiche directement sur la page !
        currentImage.value = data.url;
    } else {
        data.post(route('post.create'),{
            onSuccess: () => {
                if(typeof props.image !== 'undefined' && 
                props.image === 'aucune image' && props.image === ''){
                    data.reset();
                }
            }
        });
    }
};
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
    name="img"
    accept=".jpg, .jpeg, .png," 
    :maxFileSize="1000000" 
    v-if="typeof props.image !== 'undefined' && (props.image === 'aucune image' || props.image === '')" />
    <Button type="submit" name='add' label="Submit" icon="pi pi-check" iconPos="right" />
</form>

<div>
        <h1>{{ props.title }}</h1>
        <h2>{{ props.type }}</h2>
        
        <!-- On utilise la variable "currentImage" au lieu de "props.image" -->
        <img :src="currentImage" :alt="props.title" v-if="currentImage && currentImage !== 'aucune image'" />

        <p>{{ props.description }}</p>
    </div>

<!-- <pre>{{ $page.props }}</pre> -->

</template>
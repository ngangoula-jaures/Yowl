<script setup>
import Navbar from '@/Layouts/Navbar.vue';
defineOptions({
  layout: Navbar,
});

import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import FileUpload from 'primevue/fileupload';

const props = defineProps({
    type: String,
    title: String,
    image: String, 
    description: String
})

const url = ref(null)
const localTitle = ref(null)
const localType = ref(null)
const localImage = ref(null)
const localDescription = ref(null)


const data = useForm({
    url: '',
    comment: '',
    img: null,
    action: '', 
});

const isImage= (url)=>{
    return /\.(jpg|jpeg|png|webp|avif|gif|svg)$/.test(url.toLowerCase())
}

const resetLocal = () => {
    localTitle.value = null
    localType.value = null
    localImage.value = null
    localDescription.value = null
}

const submitForm = ()=>{
    if(data.img != null){
        return validateForm();
    }
    data.action = 'preview';
    if(isImage(data.url)){
        url.value= data.url;
        resetLocal()
    }else{
        data.post(route('post.create'),{
            onSuccess: ()=>{
                localTitle.value = props.title ?? null;
                localType.value = props.type ?? null;
                localImage.value = props.image ?? 'aucune image';
                localDescription.value = props.description ?? null
                url.value= null;
            }
    });
    } 
};

const validateForm = ()=>{
    data.action = 'save';
    data.post(route('post.create'))
    resetLocal();
    data.reset();
}

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
    :maxFileSize="2000000" 
    @select="data.img = $event.files[0]" 
    v-if="localImage && (localImage === 'aucune image' || localImage === '' )" />
    <Button type="submit" label="Envoyer" />
</form>

<div>
    <img :src="url" /> 
    <!-- v-if="typeof url !== null " -->
</div>

<div>
        <h1>{{ localTitle }}</h1>
        <h2>{{ localType }}</h2>
        
        <!-- Pour une image, on utilise le binding ":" -->
        <img :src="localImage" :alt="localTitle" v-if="localImage && localImage !== 'aucune image' && localImage !== '' " />

        <p>{{ localDescription }}</p>
    </div>
    <Button v-if="(localImage && localImage !== 'aucune image' && localImage !== '' ) || url" @click="validateForm" label="Enregistrer le Post" />

    <!-- <pre>{{ $page.props }}</pre> -->


</template>
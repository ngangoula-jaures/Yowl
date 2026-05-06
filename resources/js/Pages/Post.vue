<script setup>
import Navbar from '@/Layouts/Navbar.vue';
defineOptions({
  layout: Navbar,
});

import { ref } from 'vue';
import { useForm, usePage } from '@inertiajs/vue3';
import FileUpload from 'primevue/fileupload';

const page = usePage();

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
const fileUploadRef = ref(null)


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
            onSuccess: (pageObj)=>{
                localTitle.value = pageObj.props.title ?? null;
                localType.value = pageObj.props.type ?? null;
                localImage.value = pageObj.props.image ?? 'aucune image';
                localDescription.value = pageObj.props.description ?? null;
                url.value= null;
            }
        });
    }
};

const validateForm = ()=>{
    data.action = 'save';
    data.post(route('post.create'), {
        onSuccess: () => {
            resetLocal();
            data.reset();
            if (fileUploadRef.value) {
                fileUploadRef.value.clear();
            }
        }
    });
}

</script>

<template>
<div class="max-w-3xl mx-auto space-y-4">
    <div v-if="$page.props.auth.user" class="yowl-card space-y-4">
        <form @submit.prevent="submitForm" class="space-y-3">
        <div>
            <InputText class="w-full rounded-3xl px-4 py-3" type="text" v-model="data.url" placeholder="Collez une url..."/>
        </div>

        <div>
            <FloatLabel>
                <Textarea v-model="data.comment" rows="5" cols="70" class="w-full rounded-lg px-3 py-2" />
                <label>Commentaire</label>
            </FloatLabel>
        </div>

        <div>
            <FileUpload ref="fileUploadRef" class="my-3" mode="basic" name="img" accept=".jpg, .jpeg, .png," :maxFileSize="2000000" @select="data.img = $event.files[0]" v-if="localImage && (localImage === 'aucune image' || localImage === '' )" />
        </div>

        <div class="flex gap-3">
            <Button type="submit" label="Envoyer" class="yowl-btn" />
            <Button v-if="localImage || url || data.img" @click="validateForm" label="Enregistrer le Post" class="yowl-btn bg-[rgba(255,122,24,0.9)]" />
        </div>
    </form>

    <div v-if="url || localImage" class="mt-4 bg-[rgba(0,0,0,0.2)] rounded-xl overflow-hidden border border-[rgba(255,255,255,0.1)]">
        <div v-if="url"><img :src="url" class="w-full object-contain"/></div>
        <div v-if="localImage && localImage !== 'aucune image' && localImage !== '' ">
            <img :src="localImage" :alt="localTitle" class="w-full object-contain" />
        </div>
        <div class="p-4">
            <h3 class="text-lg font-bold text-white">{{ localTitle || data.url }}</h3>
            <p v-if="localType" class="text-sm text-[rgba(255,255,255,0.7)]">{{ localType }}</p>
            <p v-if="localDescription" class="mt-2 text-[rgba(255,255,255,0.8)]">{{ localDescription }}</p>
            <p v-if="!localTitle && !localDescription" class="mt-2 text-[rgba(255,255,255,0.6)] italic">Aucune métadonnée trouvée. Vous pouvez quand même enregistrer.</p>
        </div>
    </div>
    </div>

    <div v-else class="yowl-card text-center py-12">
        <h2 class="text-xl font-bold text-white">Connectez-vous pour créer un post</h2>
        <p class="text-[rgba(255,255,255,0.7)] mt-2">La création de posts nécessite une authentification.</p>
        <div class="mt-4">
            <Link :href="route('login')" class="yowl-btn">Se connecter</Link>
        </div>
    </div>
</div>
</template>

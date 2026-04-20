<script setup>
import { ref } from 'vue';
import '../../../css/profile.css'; 
import { Link } from '@inertiajs/vue3';
import { useForm } from '@inertiajs/vue3';
import Navbar from '@/Layouts/Navbar.vue';

defineOptions({
  layout: Navbar,
});

const form = useForm({
    photo: null,
});

const changerPhoto = (event) => {
    form.photo = event.target.files[0];
    
    // On envoie le formulaire immédiatement après la sélection
    form.post(route('profile.photo'), {
        forceFormData: true,
    });
};
//recevoir les informations de user ses post et ses likes depuis le controller
const props = defineProps({
    
    user: Object,       
    userPosts: Array,   
    likedPosts: Array   
});
// c'est pour que le post s'affiche quand on va sur la page pour la première fois où on actualise la page
const activeTab = ref('posts');
</script>

<template>
    <div class="profile-container">
        
        <header>
            <div class="cover-image"style="background-image: url('/storage/images/couverture.jpg')"></div>
            
            <div class="profile-header">
                <div class="image-wrapper" style="position: relative; display: inline-block;">
                   <img :src="user.photo ? '/storage/' + user.photo : '/storage/images/icone.png'" 
     class="profile" alt="Photo"> 
                    
                    <label for="choisir-photo" class="bouton-icone">
                        <img src="/storage/images/icone.png" alt="Ajouter" />
                    </label>
                    <input id="choisir-photo" type="file" style="display: none;" @change="changerPhoto" />
                </div>
                
                <div class="user-info">
                    <h1>{{ user.pseudo }}</h1>
                    <p>{{ user.bio }}</p>

                    <Link :href="route('profile.edit')" class="btn-modifier">
                        Modifier mon profil
                    </Link>
                </div>
            </div>
        </header>

        <nav class="tabs-nav">
        
            <button 
                @click="activeTab = 'posts'" 
                :class="{ active: activeTab === 'posts' }" 
                class="tab-btn"
            >
                Mes Posts
            </button>
            
            <button 
                @click="activeTab = 'likes'" 
                :class="{ active: activeTab === 'likes' }" 
                class="tab-btn"
            >
                Mes Likes
            </button>
        </nav>

        <main class="posts-grid">

            
            <div v-if="activeTab === 'posts'" class="grid-container">
                <div v-for="post in userPosts" :key="post.id" class="post-it">
                    <p>{{ post.content }}</p>
                </div>
                <p v-if="userPosts.length === 0">Tu n'as pas encore écrit de post-it.</p>
            </div>

            <div v-else class="grid-container">
                <div v-for="post in likedPosts" :key="post.id" class="post-it liked">
                    <p>{{ post.content }}</p>
                </div>
                <p v-if="likedPosts.length === 0">Tu n'as pas encore de coups de cœur.</p>
            </div>
            
        </main>
    </div>
</template>

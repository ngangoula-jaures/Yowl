<script setup>
import { ref } from 'vue';
import '../../../css/profile.css'; 

const props = defineProps({
    
    user: Object,       
    userPosts: Array,   
    likedPosts: Array   
});

const activeTab = ref('posts');
</script>

<template>
    <div class="profile-container">
        
        <header>
            <div class="cover-image"style="background-image: url('/storage/images/codegirl.jpg');"></div>
            
            <div class="profile-header">
                <img :src="props.user.photo || '/storage/images/codegirl.jpg'" class="profile" alt="Photo de profil">
                
                <div class="user-info">
                    <h1>{{ props.user.pseudo }}</h1>
                    <p>{{ props.user.bio }}</p>
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

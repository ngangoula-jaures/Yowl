<script setup>
import Navbar from '@/Layouts/Navbar.vue';
defineOptions({
  layout: Navbar,
});

import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';

import Avatar from 'primevue/avatar';

const props = defineProps({
    user: Object,
    post: Object, 
    postLikes: String,
    numberComments: String,
    currentUser: Object,
    comments: Array,
})

const postData= useForm({
    postId: props.post['id'],
    userId: props.post['user_id'],
    comment: '',
    response: '',
    forResponseId: '',
    commentId: '',
})

// dédié aux likes de commentaires
const likeForm = useForm({
    commentId: '',
})

const openComment = ref(null)

const liker= ()=>{
    postData.post(route('like.post', {id:props.post['id']}))
}

const likerComment = (commentId)=>{
    likeForm.commentId = commentId
    likeForm.post(route('like.comment', {id:props.post['id']}))
}

const showDetails = (commentId)=>{
    if(openComment.value === commentId){
        openComment.value = null
    }else{
        openComment.value = commentId
    }
}

const submitComment= ()=>{
    if(postData.comment.trim() !== '')
    postData.post(route('post.comments', {id:props.post['id']}))
}

const submitResponse= (id)=>{
    if(postData.response.trim() !== ''){
    postData.forResponseId= id
    postData.post(route('post.comments', {id:props.post['id']}))
    }
    postData.response= '';
}

const deleteComment= (id)=>{
    postData.commentId= id
    postData.post(route('delete.comment', {id:props.post['id']}))
}

</script>

<template>

    <div class="max-w-2xl mx-auto px-4 py-8 pb-36 space-y-6">
        <!-- CARTE DU POST                                                     -->
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="flex items-center gap-3 px-4 pt-4 pb-3">
                <div class="w-9 h-9 rounded-full bg-blue-600 flex items-center justify-center text-white text-sm font-bold shrink-0">
                    {{props.user['pseudo'].toUpperCase().substr(0, 2)}}
                </div>
                <div>
                    <p class="text-sm font-semibold text-gray-800">{{props.user['pseudo']}}</p>
                    <p class="text-xs text-gray-400">posté le {{ props.post['created_at'].substr(0, 10)}}</p>
                </div>
            </div>
            <!-- Image du post -->
            <img v-if="props.post['image'].includes('images/')"
                :src="'/storage/' + props.post['image']"
                alt="Image du post"
                class="w-full object-cover"
            />
            <img v-else
                :src="props.post['image']"
                alt="Image du post"
                class="w-full object-cover"
            />
            <!-- Métadonnées de l'URL -->
            <div class="px-4 pt-3 pb-1 space-y-1">
                <span class="inline-block text-xs text-blue-600 font-medium uppercase tracking-wide">
                    <a :href="props.post['url']" target="_blank">{{ props.post['url'] }}</a>
                </span>
                <h1 v-if="props.post['url_title']" class="text-base font-bold text-gray-900 leading-snug">
                    {{ props.post['url_title'] }}
                </h1>
                <p v-if="props.post['url_description']" class="text-sm text-gray-500 leading-relaxed">
                    {{ props.post['url_description'] }}
                </p>
            </div>
            <!-- Commentaire principal du créateur -->
            <div class="mx-4 my-3 p-3 bg-gray-50 border border-gray-200 rounded-lg ">
                <p class="text-sm text-gray-700 break-words whitespace-pre-wrap">
                    💬 <span class="font-medium ">{{ props.user['pseudo'] }} : </span>
                    {{ props.post['content'] }}
                </p>
            </div>
            <div class="flex items-center justify-between px-4 pb-4 pt-2 border-t border-gray-100">
                <div class="flex items-center gap-3">
                    <button class="flex items-center gap-1.5 text-sm text-gray-500 hover:text-red-500 transition-colors group">
                        <i class="pi pi-heart group-hover:scale-110 transition-transform" />
                        <button @click="liker"> {{ props.postLikes }} ❤️</button>
                    </button>
                    <span class="flex items-center gap-1.5 text-sm text-gray-400">
                        <i class="pi pi-comment" />
                        <span>{{ props.numberComments }} commentaires</span>
                    </span>
                </div>
                <button class="flex items-center gap-1.5 text-sm text-gray-500 hover:text-blue-600 transition-colors">
                    <i class="pi pi-share-alt" />
                    <span>Partager</span>
                </button>
            </div>
        </div>

        <!-- LISTE DES COMMENTAIRES (comments où parent_id IS NULL)           -->
        <div class="space-y-3">
            <p class="text-sm font-semibold text-gray-500 uppercase tracking-wide">
                Commentaires . {{ props.numberComments }}
            </p>

            <!--ICICICICICICIC -->
            <!-- COMMENTAIRE #1                                                -->
            <div v-for="comment in props.comments " :key="comment['id']" class="bg-white rounded-xl border border-gray-200 shadow-sm">

                <div class="p-4 space-y-2">
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-full bg-purple-600 flex items-center justify-center text-white text-xs font-bold shrink-0">
                            {{ comment['user']['pseudo'].toUpperCase().substr(0, 2) }}
                        </div>
                        <div class="flex-1">
                            <div class="flex items-baseline gap-2">
                                <span class="text-sm font-semibold text-gray-800">{{ comment['user']['pseudo'] }}</span>
                                <span class="text-xs text-gray-400">{{ comment['created_at'].substr(0, 10) }}</span>
                            </div>
                            <p class="text-sm text-gray-700 mt-1">
                                {{ comment['content'] }}
                            </p>
                        </div>
                    </div>

                    <!-- Actions du commentaire -->
                    <div class="flex items-center gap-4 pl-11">
                        <!-- Bouton like commentaire — toggle rouge si déjà liké -->
                        <button
                            @click="likerComment(comment['id'])"
                            :class="[
                                'flex items-center gap-1.5 text-xs transition-colors group',
                                comment['liked_by_user']
                                    ? 'text-red-500 font-semibold'
                                    : 'text-gray-400 hover:text-red-500'
                            ]"
                        >
                            <i
                                :class="[
                                    'pi text-xs group-hover:scale-110 transition-transform',
                                    comment['liked_by_user'] ? 'pi-heart-fill' : 'pi-heart'
                                ]"
                            />
                            <span>{{ comment['likes_count'] }} ❤️</span>
                        </button>
                        <button @click="deleteComment(comment['id'])" v-if="comment['user']['id'] === props.currentUser['id']" class="text-xs text-gray-500 hover:text-gray-700 font-medium px-3 py-1.5 rounded-lg border border-gray-200 hover:bg-red-400 transition-colors">
                                    Supprimer
                        </button>
                        <button @click="showDetails(comment['id'])" class="flex items-center gap-1 text-xs text-blue-500 hover:text-blue-700 font-medium transition-colors">
                            <!-- Icone à changer selon l'état : pi-chevron-down (déplié) / pi-chevron-right (replié) -->
                            <i :class="openComment === comment['id'] ? 'pi pi-chevron-down text-xs' : 'pi pi-chevron-right text-xs'" />
                            {{ openComment === comment['id'] ? 'Masquer les réponses' : 'Voir les réponses' }}
                        </button>
                    </div>
                </div>

                <!-- Changer   FORMULAIRE RÉPONSE — visible quand openReplyId === comment.id -->
                <div v-if="openComment === comment['id']" class="pl-8 pt-2 border-t border-gray-100 px-4 py-3 pl-12 bg-gray-50"><!--A mettre en hidden-->
                    <div class="flex gap-2 items-start">
                        <!-- Avatar utilisateur connecté -->
                        <Avatar image="https://object.pixocial.com/pixocial/dmxffni837f1xrj8pki9xgrl.jpg" class="mr-2" size="large" shape="circle" />
                        <div class="flex-1 space-y-2">
                            <textarea
                                rows="2"
                                v-model="postData.response"
                                placeholder="Répondre à ce commentaire…"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm text-gray-800 placeholder-gray-400 resize-none focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition"
                            ></textarea>
                            <div class="flex justify-end gap-2">
                                <button @click="submitResponse(comment['id'])" class="bg-blue-600 hover:bg-blue-700 text-white text-xs font-medium px-4 py-1.5 rounded-lg transition-colors">
                                    Répondre
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- RÉPONSES AU COMMENTAIRE (comments où parent_id = id) -->
                <div v-for="response in comment['responses']" v-if="openComment === comment['id']" class="border-t border-gray-100 bg-gray-50 rounded-b-xl divide-y divide-gray-100"> <!-- hidden -->

                    <!-- Réponse #1 -->
                    <div class="flex items-start gap-3 px-4 py-3 pl-14">
                        <div class="w-7 h-7 rounded-full bg-yellow-500 flex items-center justify-center text-white text-xs font-bold shrink-0">
                            {{ response['user']['pseudo'].toUpperCase().substr(0, 2) }}
                        </div>
                        <div class="flex-1">
                            <div class="flex items-baseline gap-2">
                                <span class="text-sm font-semibold text-gray-800">{{ response['user']['pseudo'] }}</span>
                                <span class="text-xs text-gray-400">{{ response['created_at'].substr(0, 10) }}</span>
                            </div>
                            <p class="text-sm text-gray-700 mt-1">
                                {{ response['content'] }}
                            </p>
                            <div class="flex items-center gap-3 mt-2">
                                <!-- Bouton like réponse — toggle rouge si déjà liké -->
                                <button
                                    @click="likerComment(response['id'])"
                                    :class="[
                                        'flex items-center gap-1 text-xs transition-colors group',
                                        response['liked_by_user']
                                            ? 'text-red-500 font-semibold'
                                            : 'text-gray-400 hover:text-red-500'
                                    ]"
                                >
                                    <span>{{ response['likes_count'] }} ❤️</span>
                                </button>
                                <button @click="deleteComment(response['id'])" v-if="response['user']['id'] === props.currentUser['id']" class="flex items-center gap-1 text-xs text-white-400 hover:text-white-600 font-medium bg-red-200 hover:bg-red-400 border border-gray-200 transition-colors">
                                    <i class="pi pi-reply text-xs" />
                                    Supprimer
                                </button>
                                <button class="flex items-center gap-1 text-xs text-gray-400 hover:text-blue-600 font-medium transition-colors">
                                    <i class="pi pi-reply text-xs" />
                                    Répondre
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--FINFINFINFINFINFINFINF-->


        </div>
    </div>
    <!-- INPUT COMMENTAIRE PRINCIPAL — FIXÉ EN BAS DE PAGE                  -->
    <div class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 shadow-md z-50">
        <div class="max-w-2xl mx-auto px-4 py-3">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-full bg-green-600 flex items-center justify-center text-white text-xs font-bold shrink-0">
                    MO
                </div>
                <input
                    type="text"
                    v-model="postData.comment"
                    placeholder="Ajoute un commentaire sur ce post…"
                    class="flex-1 border border-gray-300 rounded-full px-4 py-2 text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition"
                />
                <button @click="submitComment" class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-4 py-2 rounded-full transition-colors shrink-0">
                    <i class="pi pi-send" /> Envoyer
                </button>
            </div>
        </div>
    </div>
</template>
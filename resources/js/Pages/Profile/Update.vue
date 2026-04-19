<script setup>
import { useForm } from '@inertiajs/vue3';
import '../../../css/update.css'; 

const props = defineProps({ auth: Object });

const form = useForm({
    pseudo: props.auth.user.pseudo,
    email: props.auth.user.email,
    bio: props.auth.user.bio || '',
    photo: null,
});

const submit = () => {
    // Si une nouvelle photo est sélectionnée, on envoie la photo
    if (form.photo) {
        form.post('/profile/update-photo', {
            forceFormData: true,
        });
    }

    // On envoie toujours les infos texte (pseudo, email, bio)
    // On utilise patch pour appeler ta méthode update()
    form.patch('/profile/update', {
    
    });
};
</script>

<template>
    <div class="edit-container">
        <h1>Modifier mon profil</h1>
        
        <form @submit.prevent="submit" class="profile-form">
            <div class="form-group">
                <label>Pseudo</label>
                <input v-model="form.pseudo" type="text" />
            </div>

            <div class="form-group">
                <label>Email</label>
                <input v-model="form.email" type="email" />
            </div>

            <div class="form-group">
                <label>Bio</label>
                <textarea v-model="form.bio"></textarea>
            </div>

            <div class="form-group">
                <label>Photo de profil</label>
                <input type="file" @change="form.photo = $event.target.files[0]" />
            </div>

            <button type="submit" :disabled="form.processing" class="submit-btn">
                {{ form.processing ? 'Enregistrement...' : 'Enregistrer' }}
            </button>
            
        </form>
    </div>
</template>
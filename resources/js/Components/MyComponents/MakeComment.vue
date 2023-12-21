<template>
    <div class="flex items-center">
        <figure class="flex text-sm border-2 rounded-full mr-6">
            <img class="h-8 w-8 rounded-full object-cover" :src="$page.props.auth.user.profile_photo_url"
                :alt="$page.props.auth.user.name">
        </figure>
        <div class="relative w-full">
            <input v-model="comment" type="text" class="input pr-8 mr-3" placeholder="Escribe un comentario">
            <button @click="sendComment" :disabled="!comment || loading"
                class="absolute right-3 top-[10px] disabled:cursor-not-allowed disabled:text-gray-400 text-primary">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                    class="bi bi-send rotate-45" viewBox="0 0 16 16">
                    <path
                        d="M15.854.146a.5.5 0 0 1 .11.54l-5.819 14.547a.75.75 0 0 1-1.329.124l-3.178-4.995L.643 7.184a.75.75 0 0 1 .124-1.33L15.314.037a.5.5 0 0 1 .54.11ZM6.636 10.07l2.761 4.338L14.13 2.576zm6.787-8.201L1.591 6.602l4.339 2.76 7.494-7.493Z" />
                </svg>
            </button>
        </div>
    </div>
</template>
<script>
import axios from 'axios';

export default {
    data() {
        return {
            comment: null,
            loading: false,
        }
    },
    emits: ['commentSent'],
    props: {
        storeEndpoint: String,
    },
    methods: {
        async sendComment() {
            this.loading = true;
            try {
                const response = await axios.post(this.storeEndpoint, { comment: this.comment });

                if (response.status === 200) {
                    this.$emit('commentSent', response.data.item);
                    // this.$notify({
                    //     title: "Correcto",
                    //     message: "Se ha guardado el comentario",
                    //     type: "success",
                    // });
                    this.comment = null;
                }
            } catch (error) {
                console.log('log', error);
                this.$notify({
                    title: "Algo inesperado sucedió",
                    message: "El servior no pudo completar el envío del comentario. Favo de intentar más tarde.",
                    type: "error",
                });
            } finally {
                this.loading = false;
            }
        }
    }
}
</script>
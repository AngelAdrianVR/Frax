<template>
    <LoadingState :loading="loading" />
    <div v-if="!loading" class="min-h-[calc(100vh-9rem)]">
        <div class="flex justify-between items-center lg:mx-12 mb-10 mt-2">
            <h2 class="font-bold">Tus visitas frecuentes</h2>
            <PrimaryButton class="hidden md:block" @click="$inertia.get(route('favorite-guests.create'))">Agregar visita
                frecuente</PrimaryButton>
            <PrimaryButton class="lg:hidden" @click="$inertia.get(route('favorite-guests.create'))"><i
                    class="fa-solid fa-plus"></i></PrimaryButton>
        </div>
        <div class="mt-4 lg:mx-12">
            <div v-if="favoriteGuests?.length > 0" class="md:grid lg:grid-cols-3 md:grid-cols-2 gap-5">
                <FavoriteGuestCard class="mt-4 lg:mt-0" @favoriteGuestDeleted="handleFavoriteGuestDeleted"
                    v-for="favoriteGuest in favoriteGuests" :key="favoriteGuest" :favoriteGuest="favoriteGuest" />
            </div>
            <p class="text-xs text-gray-400 text-center" v-else>No tienes visitantes frecuentes registrados</p>
        </div>
    </div>
</template>
<script>
import PrimaryButton from "@/Components/PrimaryButton.vue";
import FavoriteGuestCard from "@/Components/MyComponents/Guest/FavoriteGuestCard.vue";
import LoadingState from "@/Components/MyComponents/LoadingState.vue";
import axios from 'axios';

export default {
    data() {
        return {
            favoriteGuests: [],
            loading: true,
        }
    },
    components: {
        PrimaryButton,
        FavoriteGuestCard,
        LoadingState,
    },
    methods: {
        async fetchFavoriteGuests() {
            try {
                this.loading = true;
                const response = await axios.get(route('favorite-guests.get-all'));
                if (response.status === 200) {
                    this.favoriteGuests = response.data.items;
                }
            } catch (error) {
                console.log(error);
            } finally {
                this.loading = false;
            }
        },
        handleFavoriteGuestDeleted(deletedItemId) {
            // Encuentra el índice del objeto eliminado en la lista
            const deletedItemIndex = this.favoriteGuests.findIndex(item => item.id === deletedItemId);

            // Elimina el objeto localmente
            if (deletedItemIndex !== -1) {
                this.favoriteGuests.splice(deletedItemIndex, 1);
            }
        },
    },
    mounted() {
        this.fetchFavoriteGuests();
    }
}
</script>
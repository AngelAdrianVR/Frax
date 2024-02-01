<template>
    <div class="flex justify-between items-center lg:mx-12 mb-10 mt-2">
        <h2 class="font-bold">Tus visitas programadas</h2>
        <HideableLabel class="absolute right-0 top-28 z-50" iconClass="fa-solid fa-info">
            <p>
                La tarjeta de visitante desaparecerá el día siguiente de su ingreso o al expirar la fecha de entrada
                registrada.
            </p>
        </HideableLabel>

        <PrimaryButton class="hidden md:block" @click="$inertia.get(route('guests.create'))">Programar visita
        </PrimaryButton>
        <PrimaryButton class="lg:hidden" @click="$inertia.get(route('guests.create'))"><i class="fa-solid fa-plus"></i>
        </PrimaryButton>
    </div>
    <div class="mt-4 lg:mx-12">
        <div v-if="guests.length" class="md:grid lg:grid-cols-3 md:grid-cols-2 gap-5">
            <GuestCard class="mt-4 lg:mt-0" @guestDeleted="handleGuestDeleted" v-for="guest in guests" :key="guest"
                :guest="guest" />
        </div>
        <p class="text-xs text-gray-400 text-center" v-else>No hay visitas registradas</p>
    </div>
</template>
<script>
import PrimaryButton from "@/Components/PrimaryButton.vue";
import GuestCard from "@/Components/MyComponents/Guest/GuestCard.vue";
import HideableLabel from "@/Components/MyComponents/HideableLabel.vue";

export default {
    components: {
        PrimaryButton,
        GuestCard,
        HideableLabel,
    },
    props: {
        guests: {
            type: Object,
            defult: [],
        }
    },
    methods: {
        handleGuestDeleted(deletedItemId) {
            // Encuentra el índice del objeto eliminado en la lista
            const deletedItemIndex = this.guests.findIndex(item => item.id === deletedItemId);

            // Elimina el objeto localmente
            if (deletedItemIndex !== -1) {
                this.guests.splice(deletedItemIndex, 1);
            }
        },
    }
}
</script>
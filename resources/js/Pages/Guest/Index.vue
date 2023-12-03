<template>
  <AppLayout title="Visitantes">
    <!-- ------------- tabs section starts ------------- -->
    <div class="border-y-2 border-[#D9D9D9] items-center py-2">
      <div class="flex lg:ml-20">
        <Tab
          @click="currentTab = index + 1"
          :label="tab"
          :active="currentTab == index + 1"
          v-for="(tab, index) in tabs"
          :key="index"
        />
      </div>
    </div>
    <!-- ------------- tabs section ends ------------- -->

    <!-- ------------- tab 1 section visitas programadas starts ------------- -->
    <div class="p-4" v-if="currentTab == 1">
      <div class="flex justify-between lg:mx-12">
        <h2 class="font-bold">Visitas agendadas</h2>
        <PrimaryButton @click="$inertia.get(route('guests.create'))">Programar visita</PrimaryButton>
      </div>
      <div class="mt-4 lg:mx-12">
        <div v-if="guests.data" class="grid grid-cols-3 gap-5">
          <GuestCard @guestDeleted="handleGuestDeleted" v-for="guest in guests.data" :key="guest" :guest="guest" />
        </div>
        <p class="text-xs text-gray-400 text-center" v-else>No hay visitas registradas</p>
      </div>
    </div>
    <!-- ------------- tab 1 section visitas programadas ends ------------- -->


    <!-- ------------- tab 2 section visitas frecuentes starts ------------- -->
    <div class="p-4" v-if="currentTab == 2">
      <div class="flex justify-between lg:mx-12">
        <h2 class="font-bold">Visitas frecuentes</h2>
        <PrimaryButton @click="$inertia.get(route('favorite-guests.create'))">Agregar visita frecuente</PrimaryButton>
      </div>
      <div class="mt-4 lg:mx-12">
        <div class="grid grid-cols-3 gap-5">
          <GuestCard @guestDeleted="handleGuestDeleted" v-for="guest in guests.data" :key="guest" :guest="guest" />
        </div>
      </div>
    </div>
    <!-- ------------- tab 2 section visitas frecuentes ends ------------- -->
  </AppLayout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { Link } from "@inertiajs/vue3";
import Tab from "@/Components/MyComponents/Tab.vue";
import GuestCard from "@/Components/MyComponents/Guest/GuestCard.vue";
import axios from 'axios';

export default {
  data() {
    return {
      currentTab: 1,
      tabs: ["Visitas programadas", "Visitas frecuentes", "Historial"],
    };
  },
  components: {
    AppLayout,
    PrimaryButton,
    GuestCard,
    Link,
    Tab,
  },
  props: {
    guests: Object,
    favorite_guests: Object,
    guest_history: Object,
  },
  methods: {
    handleGuestDeleted(deletedItemId) {
      // Encuentra el índice del objeto eliminado en la lista
      const deletedItemIndex = this.guests.data.findIndex(item => item.id === deletedItemId);

      // Elimina el objeto localmente
      if (deletedItemIndex !== -1) {
        this.guests.data.splice(deletedItemIndex, 1);
      }
    },
  },
  watch:{
    async currentTab(){
      try {
        if (this.currentTab == 2) { //recupera la información de visitas frecuentes
          const response = await axios.get(route('favorite-guests.fetch'));
          if (response.status === 200) {
            this.favorite_guests = response.data.favorite_guests;
          }
        } 
      } catch (error) {
        console.log(error);
      }
    }
  }
};
</script>

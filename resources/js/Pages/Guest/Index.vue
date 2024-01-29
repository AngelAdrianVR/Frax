<template>
  <!-- Envoltorio de AppLaout para estado de carga en toda la pantalla -->
  <div class="relative h-full">
    <LoadingState :loading="loading" />

    <AppLayout title="Visitantes">
      <!-- ------------- tabs section starts ------------- -->
      <div class="border-y-2 border-[#D9D9D9] items-center py-2">
        <div class="flex lg:ml-20 w-full overflow-x-auto">
          <Tab @click="currentTab = index + 1" :label="tab" :active="currentTab == index + 1" v-for="(tab, index) in tabs"
            :key="index" />
        </div>
      </div>
      <!-- ------------- tabs section ends ------------- -->

      <!-- ------------- tab 1 section visitas programadas starts ------------- -->
      <div class="p-4" v-if="currentTab == 1">
        <div class="flex justify-between items-center lg:mx-12 mb-10 mt-4">
          <h2 class="font-bold">Tus visitas programadas</h2>
          <HideableLabel class="absolute right-0 top-28 z-50" iconClass="fa-solid fa-info">
          <p>
            La tarjeta de visitante desaparecerá el día siguiente de su ingreso o al expirar la fecha de entrada registrada.
          </p>
        </HideableLabel>

          <PrimaryButton class="hidden md:block" @click="$inertia.get(route('guests.create'))">Programar visita
          </PrimaryButton>
          <PrimaryButton class="lg:hidden" @click="$inertia.get(route('guests.create'))"><i class="fa-solid fa-plus"></i>
          </PrimaryButton>
        </div>
        <div class="mt-4 lg:mx-12">
          <div v-if="guests.data?.length > 0" class="md:grid lg:grid-cols-3 md:grid-cols-2 gap-5">
            <GuestCard class="mt-4 lg:mt-0" @guestDeleted="handleGuestDeleted" v-for="guest in guests.data" :key="guest"
              :guest="guest" />
          </div>
          <p class="text-xs text-gray-400 text-center" v-else>No hay visitas registradas</p>
        </div>
      </div>
      <!-- ------------- tab 1 section visitas programadas ends ------------- -->


      <!-- ------------- tab 2 section visitas frecuentes starts ------------- -->
      <div class="p-4" v-if="currentTab == 2">
        <div class="flex justify-between items-center lg:mx-12 mb-10">
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
      <!-- ------------- tab 2 section visitas frecuentes ends ------------- -->

      <!-- ------------- tab 3 section hidtorial de visitas starts ------------- -->
      <div class="p-4" v-if="currentTab == 3">
        <div class="flex justify-between items-center lg:mx-12 mb-10">
          <h2 class="font-bold">Historial de visitas</h2>
        </div>

        <div class="overflow-auto">
          <GuestHistoryTable v-if="guestHistories?.length > 0" :guestHistories="guestHistories" />
          <p class="text-xs text-gray-400 text-center" v-else>No tienes historial de visitas</p>
        </div>

        <!-- --- pagination --- -->
        <div class="mt-4">
          <Pagination :pagination="guestHistories" />
        </div>
      </div>
      <!-- ------------- tab 3 section hidtorial de visitas ends ------------- -->
    </AppLayout>
  </div>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { Link } from "@inertiajs/vue3";
import Tab from "@/Components/MyComponents/Tab.vue";
import GuestCard from "@/Components/MyComponents/Guest/GuestCard.vue";
import FavoriteGuestCard from "@/Components/MyComponents/Guest/FavoriteGuestCard.vue";
import GuestHistoryTable from "@/Components/MyComponents/Guest/GuestHistoryTable.vue";
import LoadingState from "@/Components/MyComponents/LoadingState.vue";
import HideableLabel from "@/Components/MyComponents/HideableLabel.vue";
import axios from 'axios';

export default {
  data() {
    return {
      currentTab: 1,
      loading: false,
      favoriteGuests: null,
      guestHistories: null,
      tabs: ["Visitas programadas", "Visitas frecuentes", "Historial"],
    };
  },
  components: {
    AppLayout,
    PrimaryButton,
    LoadingState,
    FavoriteGuestCard,
    GuestCard,
    GuestHistoryTable,
    HideableLabel,
    Link,
    Tab,
  },
  props: {
    guests: Object,
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
    handleFavoriteGuestDeleted(deletedItemId) {
      // Encuentra el índice del objeto eliminado en la lista
      const deletedItemIndex = this.favoriteGuests.findIndex(item => item.id === deletedItemId);

      // Elimina el objeto localmente
      if (deletedItemIndex !== -1) {
        this.favoriteGuests.splice(deletedItemIndex, 1);
      }
    },
    async fetchFavoriteGuests() {
      try {
        this.loading = true;
        const response = await axios.get(route('favorite-guests.get-all'));
        if (response.status === 200) {
          this.favoriteGuests = response.data.items;
          this.loading = false;
        }
      } catch (error) {
        console.log(error);
      }
    },
    async fetchGuestHistories() {
      try {
        this.loading = true;
        const response = await axios.get(route('guest-histories.get-all'));
        if (response.status === 200) {
          this.guestHistories = response.data.items;
          this.loading = false;
        }
      } catch (error) {
        console.log(error);
      }
    }
  },
  watch: {
    currentTab(newVal) {
      if (newVal == 2 && this.favoriteGuests === null) {
        //recupera la información de visitas frecuentes
        this.fetchFavoriteGuests();

      }
      if (newVal == 3 && this.guestHistories === null) {
        //recupera la información de visitas frecuentes
        this.fetchGuestHistories();
      }

      // Agrega la variable currentTab=newVal a la URL para mejorar la navegacion al actalizar o cambiar de pagina
      const currentURL = new URL(window.location.href);
      currentURL.searchParams.set('currentTab', newVal);

      // Actualiza la URL
      window.history.replaceState({}, document.title, currentURL.href);
    }
  },
  mounted() {
    // Agrega la variable currentTab al url para mejorar navegación al retroceder
    // Obtén la URL actual
    const currentURL = new URL(window.location.href);

    // Extrae el valor de 'currentTab' de los parámetros de búsqueda
    const currentTabFromURL = currentURL.searchParams.get('currentTab');

    // Convierte el valor a un número, ya que los parámetros de búsqueda son cadenas
    this.currentTab = parseInt(currentTabFromURL) || 1;
  },
};
</script>

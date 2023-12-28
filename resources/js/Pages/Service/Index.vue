<template>
  <!-- Envoltorio de AppLaout para estado de carga en toda la pantalla -->
  <div class="relative h-full">
    <LoadingState :loading="loading" />

    <AppLayout title="Servicios">
        <!-- ------------- tabs section starts ------------- -->
      <div class="border-y-2 border-[#D9D9D9] items-center py-2">
        <div class="flex lg:ml-20 w-full overflow-x-auto lg:overflow-x-hidden">
          <Tab @click="currentTab = index + 1" :label="tab" :active="currentTab == index + 1" v-for="(tab, index) in tabs"
            :key="index" />
        </div>
      </div>
      <!-- ------------- tabs section ends ------------- -->


        <!-- ------------- tab 1 section Servicios Internos starts ------------- -->
        <div class="p-4" v-if="currentTab == 1">
            <div class="flex justify-between items-center lg:mx-12 mb-10">
            <h2 class="font-bold">Servicios Internos</h2>
            <PrimaryButton class="hidden md:block" @click="$inertia.get(route('services.create'))">Agregar servicio
            </PrimaryButton>
            <PrimaryButton class="lg:hidden" @click="$inertia.get(route('services.create'))"><i class="fa-solid fa-plus"></i>
            </PrimaryButton>
            </div>
            <div class="mt-20 lg:mx-12">
            <div v-if="internal_services.data?.length > 0" class="md:grid lg:grid-cols-3 md:grid-cols-2 gap-5 mb-4">
                <ServiceCard v-for="internal_service in internal_services.data" :key="internal_service" :service="internal_service" />
            </div>
            <p class="text-xs text-gray-400 text-center" v-else-if="!loading">No hay servicios registrados</p>
            </div>
        </div>
        <!-- ------------- tab 1 section Servicios Internos ends ------------- -->


        <!-- ------------- tab 2 section Servicios externos starts ------------- -->
        <div class="p-4" v-if="currentTab == 2">
            <div class="flex justify-between items-center lg:mx-12 mb-10">
            <h2 class="font-bold">Servicios Externos</h2>
            <PrimaryButton class="hidden md:block" @click="$inertia.get(route('services.create'))">Agregar servicio
            </PrimaryButton>
            <PrimaryButton class="lg:hidden" @click="$inertia.get(route('services.create'))"><i class="fa-solid fa-plus"></i>
            </PrimaryButton>
            </div>
            <div class="mt-20 lg:mx-12">
            <div v-if="external_services?.length > 0" class="md:grid lg:grid-cols-3 md:grid-cols-2 gap-5 mb-4">
                <ServiceCard v-for="external_service in external_services" :key="external_service" :service="external_service" />
            </div>
            <p class="text-xs text-gray-400 text-center" v-else-if="!loading">No hay servicios registrados</p>
            </div>
        </div>
        <!-- ------------- tab 2 section Servicios externos ends ------------- -->



        <!-- ------------- tab 3 section historial de servicios starts ------------- -->
        <div class="p-4" v-if="currentTab == 3">
        <div class="flex justify-between items-center lg:mx-12 mb-10">
            <h2 class="font-bold">Historial de servicios</h2>
        </div>

        <div class="overflow-auto">
            <ServiceHistoryTable @delete-service="deleteService" v-if="services_history?.length > 0" :services_history="services_history" />
            <p class="text-xs text-gray-400 text-center" v-else>No tienes historial de servicios</p>
        </div>

        <!-- --- pagination --- -->
        <div class="mt-4">
            <Pagination :pagination="guestHistories" />
        </div>
        </div>
        <!-- ------------- tab 3 section historial de servicios ends ------------- -->
    </AppLayout>
  </div>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import ServiceCard from "@/Components/MyComponents/Service/ServiceCard.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import LoadingState from "@/Components/MyComponents/LoadingState.vue";
import ServiceHistoryTable from "@/Components/MyComponents/Service/ServiceHistoryTable.vue";
import Tab from "@/Components/MyComponents/Tab.vue";

export default {
  data() {
    return {
        currentTab: 1,
        loading: false,
        external_services: null,
        services_history: null,
        tabs: ["Internos", "Externos", "Historial"],
    };
  },
  components: {
    AppLayout,
    PrimaryButton,
    LoadingState,
    ServiceCard,
    ServiceHistoryTable,
    Tab
  },
  props: {
    internal_services: Object,
  },
  methods: {
    async fetchExternalServices() {
      try {
        this.loading = true;
        const response = await axios.get(route('services.get-external-services'));
        if (response.status === 200) {
          this.external_services = response.data.items;
          this.loading = false;
        }
      } catch (error) {
        console.log(error);
      }
    },
    async fetchServicesHistories() {
      try {
        this.loading = true;
        const response = await axios.get(route('services.get-services-history'));
        if (response.status === 200) {
          this.services_history = response.data.items;
          this.loading = false;
        }
      } catch (error) {
        console.log(error);
      }
    },
    async deleteService(history) {
      try {
        const response = await axios.delete(route('services.destroy', history.id));
        if (response.status === 200) {
            
            //encontrar index de elemento eliminado
            if (history.is_internal) { //en caso de ser servicio interno
                const deletedItemIndex = this.internal_services.data.findIndex(item => item.id === history.id);
                // Elimina el objeto localmente
            if (deletedItemIndex !== -1) {
                this.internal_services.data.splice(deletedItemIndex, 1);
                this.services_history.splice(deletedItemIndex, 1);
            }
            } else { // en el caso de ser servicio externo
                const deletedItemIndex = this.external_services.findIndex(item => item.id === history.id);
                // Elimina el objeto localmente
            if (deletedItemIndex !== -1) {
                this.external_services.splice(deletedItemIndex, 1);
                this.services_history.splice(deletedItemIndex, 1);
            }
            }

            this.$notify({
                title: "Correcto",
                message: "Se ha eliminado el servicio",
                type: "success",
                });

        }
      } catch (error) {
        console.log(error);
        this.$notify({
          title: "Error de servidor",
          message: "No se pudo eliminar el servicio. Intenta más tarde",
          type: "error",
        });
      }
    },
  },
  watch: {
    currentTab(newVal) {
      if (newVal == 2 && this.external_services === null) {
        //recupera la información de servicios externos
        this.fetchExternalServices();

      }
      if (newVal == 3 && this.services_history === null) {
        //recupera la información de historial de servicios
        this.fetchServicesHistories();
      }

      // Agrega la variable currentTab=newVal a la URL para mejorar la navegacion al actalizar o cambiar de pagina
      const currentURL = new URL(window.location.href);
      currentURL.searchParams.set('currentTab', newVal);

      // Actualiza la URL
      window.history.replaceState({}, document.title, currentURL.href);
    }
  },
mounted() {
    // Obtén la URL actual
    const currentURL = new URL(window.location.href);

    // Extrae el valor de 'currentTab' de los parámetros de búsqueda
    const currentTabFromURL = currentURL.searchParams.get('currentTab');

    // Convierte el valor a un número, ya que los parámetros de búsqueda son cadenas
    this.currentTab = parseInt(currentTabFromURL) || 1;
  },
};
</script>

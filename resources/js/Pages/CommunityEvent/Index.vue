<template>
    <AppLayout title="Eventos comunitarios">
        <div class="py-8 px-1 lg:px-10">
          <div class="flex justify-end items-center mx-5 mb-8">
            <PrimaryButton class="hidden md:block" @click="$inertia.get(route('community-events.create'))">Crear evento</PrimaryButton>
            <PrimaryButton class="lg:hidden" @click="$inertia.get(route('community-events.create'))"><i class="fa-solid fa-plus"></i></PrimaryButton>
          </div>
            <div class="lg:w-3/4 w-full flex items-center space-x-7 text-sm border-b border-gray4 lg:mx-5 mx-2 mb-8">
              <div @click="currentTab = 1" :class="currentTab == 1 ? 'text-primary border-b-2 border-primary pb-1 px-3' : 'px-3 pb-1' " class="flex items-center space-x-2 cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"  class="size-4">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V15Zm0 2.25h.008v.008h-.008v-.008Zm2.25-4.5h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5V15Z" />
                </svg>
                <p>Eventos proximos</p> 
              </div>
              <div @click="currentTab = 2" :class="currentTab == 2 ? 'text-primary border-b-2 border-primary pb-1 px-3' : 'px-3 pb-1'" class="flex items-center space-x-2 cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                  <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                </svg>
                <p>Mis eventos registrados</p> 
              </div>
            </div>
          
            <!-- Tab 1 all events ------------------------ -->
            <div class="lg:grid grid-cols-2 gap-5 lg:mx-7" v-if="currentTab == 1">
              <div class="space-y-5" v-if="community_events.data.length > 0">
                <CommunityEventCard 
                @delete-community-event="deleteCommunityEvent" 
                v-for="communityEvent in community_events.data" :key="communityEvent" :communityEvent="communityEvent"
                :registered_events="my_community_events" />
              </div>
              <p class="text-xs text-gray-400 text-center" v-else>No hay eventos próximos</p>
            </div>
            <!-- ----------------------------------------- -->


            <!-- Tab 2 my events ------------------------ -->
            <div class="lg:grid grid-cols-2 gap-5 lg:mx-7" v-if="currentTab == 2 && !loading">
              <div class="space-y-5" v-if="myEvents?.length > 0">
                <CommunityEventCard 
                :is_my_event="true"
                v-for="myEvent in myEvents" :key="myEvent" :communityEvent="myEvent"
                :registered_events="my_community_events" />
              </div>
              <p class="text-xs text-gray-400 text-center" v-else>No tienes ningún evento registrado</p>
            </div>
            <!--  estado de carga -->
            <div v-if="loading" class="flex justify-center items-center py-10">
              <i class="fa-solid fa-spinner fa-spin text-4xl text-primary"></i>
            </div>
            <!-- ----------------------------------------- -->
            
        </div>
    </AppLayout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import CancelButton from "@/Components/MyComponents/CancelButton.vue";
import CommunityEventCard from "@/Components/MyComponents//CommunityEvent/CommunityEventCard.vue";
import axios from 'axios';

export default {
data(){
    return {
        currentTab: 1,
        myEvents: null,
        loading: false,
    }
},
components:{
AppLayout,
PrimaryButton,
CancelButton,
CommunityEventCard,
},
props:{
community_events: Object,
my_community_events: Array
},
methods:{
async deleteCommunityEvent(communityEventId) {
  try {
    const response = await axios.delete(route('community-events.destroy', communityEventId));

    if (response.status === 200) {
      //encontrar index de elemento eliminado
      const deletedItemIndex = this.community_events.data.findIndex(item => item.id === communityEventId);

      // Elimina el objeto localmente
      if (deletedItemIndex !== -1) {
        this.community_events.data.splice(deletedItemIndex, 1);
      }

      this.$notify({
          title: "Correcto",
          message: "Se ha eliminado el evento",
          type: "success",
        });
    }

  } catch (error) {
    console.log(error);
    this.$notify({
          title: "Error de servidor",
          message: "No se pudo eliminar el evento. Intenta más tarde",
          type: "error",
        });
  }
},
 async fetchMyEvents() {
      try {
        this.loading = true;
        const response = await axios.get(route('community-event-user.get-all', { registeredEvents: this.my_community_events }));
        if (response.status === 200) {
          this.myEvents = response.data.items;
          
        }
      } catch (error) {
        console.log(error);
      } finally {
        this.loading = false;
      }
    },
},
watch: {
    currentTab(newVal) {
      if (newVal == 2 && this.myEvents === null) {
        //recupera la información de visitas frecuentes
        this.fetchMyEvents();

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
}
</script>
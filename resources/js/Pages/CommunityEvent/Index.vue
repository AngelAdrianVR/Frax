<template>
    <AppLayout title="Eventos comunitarios">
        <div class="py-8 px-3 lg:px-7">
          <div class="flex justify-between items-center mx-5 mb-8">
            <h1>Eventos proximos</h1>
            <PrimaryButton class="hidden md:block" @click="$inertia.get(route('community-events.create'))">Crear evento</PrimaryButton>
            <PrimaryButton class="lg:hidden" @click="$inertia.get(route('community-events.create'))"><i class="fa-solid fa-plus"></i></PrimaryButton>
          </div>
          
            <div class="md:grid lg:grid-cols-3 md:grid-cols-2 gap-5" v-if="community_events.data.length > 0">
              <CommunityEventCard v-for="communityEvent in community_events.data" :key="communityEvent" :communityEvent="communityEvent" />
            </div>
            <p class="text-xs text-gray-400 text-center" v-else>No hay eventos próximos</p>
            
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
        
    }
},
components:{
AppLayout,
PrimaryButton,
CancelButton,
CommunityEventCard,
},
props:{
community_events: Object
},
methods:{

}
}
</script>
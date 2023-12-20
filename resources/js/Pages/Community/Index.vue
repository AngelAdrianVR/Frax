<template>
    <AppLayout title="Comunidad virtual">
        <div class="py-8 px-3 lg:px-7 border">
            <div class="lg:w-1/2 mx-auto">
                <h1 class="font-bold">Muro de noticias</h1>

                <PublicationBar />
                
                <div class="border-b border-gray4 w-full my-9 flex items-center">
                    <p @click="currentTab = 1" :class="currentTab == 1 ? 'border-b-2 border-primary border-offset-2' : '' " class="px-2 font-bold cursor-pointer py-1">Publicaciones</p>
                    <!-- <p @click="currentTab = 2" :class="currentTab == 2 ? 'border-b-2 border-primary border-offset-2' : '' " class="px-2 font-bold cursor-pointer py-1 ml-5">@menciones</p> -->
                </div>

                <!-- Tab 1 publicaciones stars ------------------------------->
                <div v-if="currentTab == 1">
                    
                    <PublicationCard v-for="post in posts.data" :key="post" :post="post" :users="users" />
                </div>
                <!-- Tab 1 publicaciones ends ------------------------------->

            </div>
        </div>

        
    </AppLayout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import CancelButton from "@/Components/MyComponents/CancelButton.vue";
import PublicationBar from "@/Components/MyComponents/Community/PublicationBar.vue";
import PublicationCard from "@/Components/MyComponents/Community/PublicationCard.vue";

export default {
data(){
    return {
        currentTab: 1,
        
    }
},
components:{
AppLayout,
PrimaryButton,
CancelButton,
PublicationBar,
PublicationCard,
},
props:{
posts: Object,
users: Array,
},
methods:{

}
}
</script>
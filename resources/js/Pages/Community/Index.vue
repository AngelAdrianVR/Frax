<template>
    <AppLayout title="Comunidad virtual">
        <div ref="scrollContainer" class="px-1" style="height: 91vh; overflow-y: scroll;" @scroll="handleScroll">
            <div class="lg:w-1/2 mx-auto">
                <h1 class="font-bold">Muro de noticias</h1>

                <PublicationBar @new-post="visiblePosts = posts" />
                
                <div class="border-b border-gray4 w-full my-9 flex items-center">
                    <p @click="currentTab = 1" :class="currentTab == 1 ? 'border-b-2 border-primary border-offset-2' : '' " class="px-2 font-bold cursor-pointer py-1">Publicaciones</p>
                    <!-- <p @click="currentTab = 2" :class="currentTab == 2 ? 'border-b-2 border-primary border-offset-2' : '' " class="px-2 font-bold cursor-pointer py-1 ml-5">@menciones</p> -->
                </div>

                <!-- Tab 1 publicaciones stars ------------------------------->
                <div v-if="currentTab == 1">
                    
                    <PublicationCard @delete-post="deletePost" v-for="post in visiblePosts" :key="post" :post="post" />
                </div>
                <!-- Tab 1 publicaciones ends ------------------------------->

            </div>
            <div v-if="loading" class="flex justify-center items-center py-10">
                <i class="fa-solid fa-spinner fa-spin text-4xl text-primary"></i>
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
import axios from 'axios';

export default {
data(){
    return {
        currentTab: 1,
        loading: false,
        visiblePosts: null,
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
total_posts: Number
},
methods:{
async deletePost(postId) {
        try {
            const response = await axios.delete(route('posts.destroy', postId));
            if (response.status === 200) {
            // Eliminar el post del arreglo local
            const index = this.posts.findIndex(post => post.id === postId);
            if (index !== -1) {
                this.posts.splice(index, 1);
            }
            this.$notify({
                title: "Correcto",
                message: "Se ha eliminado tu publicación",
                type: "success",
            });
        }
        } catch (error) {
            console.log(error);
            this.$notify({
                title: "Error",
                message: "No se pudo eliminar tu publicación. Refresca la página e intenta de nuevo.",
                type: "error",
            });
        }
    },
    handleScroll() {
      const container = this.$refs.scrollContainer;
      const scrollHeight = container.scrollHeight;
      const scrollTop = container.scrollTop;
      const clientHeight = container.clientHeight;

      // Determinar si has llegado al final de la vista
      if (scrollHeight - scrollTop === clientHeight) {

        // Ejecutar tu método cuando llegues al final. No se ejecuta si se estan cargando ya posts
        if (!this.loading) {
            this.loadMorePosts();
        }
      }
    },
    async loadMorePosts() {

        const offset = this.visiblePosts.length; //de donde empieza a contar la carga de posts
        let limit = 5; // numero de post que carga por petición

        // regula el numero de posts para cargar segun los que queden por cargar y cuando es 0 no se hace la peticion
        if ( ( this.total_posts - this.visiblePosts.length) < limit ) {
            limit = this.total_posts - this.visiblePosts.length;
            }

            if ( ( this.total_posts - this.visiblePosts.length ) !== 0 ) {
                this.loading = true;
                try {
                    const response = await axios.get(route('posts.load-more-posts', [offset, limit]));
                    if (response.status === 200 ) {
                        this.visiblePosts = [...this.visiblePosts, ...response.data.posts]; //agrega los posts obtenidos al array de posts que se muestran 
                    }
                } catch (error) {
                    console.log(error);
                } finally {
                    this.loading = false;
                }
            } else {
                console.log('No hay mas posts por cargar');
                return ;
            }
          },
},
mounted() {
    this.visiblePosts = this.posts;
}
}
</script>
<template>
  <!-- post component ------ -->
    <div @click="optionsDropdown = false" class="border border-gray4 rounded-md lg:p-8 p-5 my-3">
        <div class="flex justify-between items-center">
            <div v-if="$page.props.jetstream.managesProfilePhotos">
                <div class="flex text-sm items-center rounded-full w-5/6 lg:w-full">
                    <img class="h-10 w-10 rounded-full object-cover" :src="user?.profile_photo_url"
                    :alt="user?.name" />
                    <p class="ml-4"><strong class="text-primary mr-2">{{ user?.name }}</strong> ha compartido una publicación</p>
                </div>
                    <p class="text-gray-600 text-xs ml-[52px] lg:-mt-2">{{ post.created_at }}</p>
            </div>
            <div v-else>
                <div class="flex items-center w-full" figurestyle="float: left">
                    <i class="fa-solid fa-circle-user text-blue-200 text-4xl"></i>
                    <p class="ml-4"><strong class="text-primary mr-2">{{ user?.name }}</strong> ha compartido una publicación</p>
                </div>
                    <p class="text-gray-600 text-xs ml-[52px] lg:-mt-2 -mt-1">{{ post.created_at }}</p>
            </div>
            <div class="relative">
                <i @click.stop="optionsDropdown = !optionsDropdown" class="fa-solid fa-ellipsis text-primary cursor-pointer p-1 hover:bg-gray5 rounded-full"></i>
                <div v-if="optionsDropdown" class="border border-gray5 flex flex-col space-y-1 rounded-md p-1 absolute w-28 h-auto top-7 -right-1 text-sm z-50 bg-white">
                    <p class="hover:bg-gray5 cursor-pointer text-center px-2">Reportar</p>
                    <p v-if="user.id == $page.props.auth.user.id" class="hover:bg-gray5 cursor-pointer text-center px-2">Eliminar</p>
                    <p v-if="user.id == $page.props.auth.user.id" class="hover:bg-gray5 cursor-pointer text-center px-2">Otro</p>
                </div>
            </div>
        </div>

        <!-- body --------- -->
        <div class="my-7">
            <p v-if="post.title" class="font-bold">{{ post.title }}</p>
            <p :class="{ 'text-sm': truncated, 'whitespace-normal text-sm': !truncated }" class="my-3 truncate" ref="postBody">
            {{ post.body }}
            </p>
            <button class="text-sm cursor-pointer text-blue-600" v-if="truncated" @click="showMore">Ver más</button>
            <figure v-if="post.media?.length > 0" class="bg-gray5 m-4 rounded-md cursor-pointer">
                <img class="w-full rounded-xl object-contain h-96" :src="post.media[0]?.original_url" alt="Sin imagen" >
            </figure>
        </div>

        <!-- Reacciones -------------->
        <div class="border-b border-gray5"></div>
        <div class="flex justify-between items-center my-2 mx-7">
            <div class="flex items-center">
                <i class="fa-solid fa-heart text-red-500 mr-2 cursor-pointer P-1 hover:animate-bounce"></i>
                <span class="text-xs">{{ post.likes  }}</span>
            </div>
            <div class="flex items-center">
                <i class="fa-regular fa-eye text-gray3 mr-2"></i>
                <span class="text-xs">{{ post.views }}</span>
            </div>
        </div>
        <div class="border-b border-gray5"></div>

        <!-- Comentarios ----------->
        <div class="my-5">
            <MakeComment />
        </div>
    </div>
</template>

<script>
import MakeComment from "@/Components/MyComponents/MakeComment.vue";
import axios from 'axios';

export default {
data(){
    return {
        optionsDropdown: false,
        truncated: true, // Inicialmente asumimos que el texto está truncado
        user: this.users.find(item => item.id === this.post.user.id),
    }
},
components:{
MakeComment,
},
props:{
post: Object,
users: Array,
},
methods:{
    showMore() {
      this.truncated = false; // Mostrar el texto completo
      this.$refs.postBody.classList.remove('truncate'); // Eliminar la truncación

      // Hacer la solicitud al servidor para incrementar las vistas
      this.incrementViews(this.post.id);
    },
    incrementViews(postId) {
      // Realizar una solicitud al servidor para incrementar las vistas
      try {
        const response = axios.post(route('posts.view', postId));
      } catch (error) {
        console.log(error);
      }
    },
    checkIfTruncated() {
      // Verifica si el texto se está truncando
      if (this.$refs.postBody.scrollWidth > this.$refs.postBody.clientWidth) {
        this.truncated = true;
      }
    }
},
watch: {
    'post.body': 'checkIfTruncated' // Observa cambios en el texto y ejecuta checkIfTruncated
  }
}
</script>

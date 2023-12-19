<template>
  <!-- post component ------ -->
    <div class="border border-gray4 rounded-md lg:p-8 p-5 my-3">
        <div class="flex justify-between items-center">
            <div v-if="$page.props.jetstream.managesProfilePhotos">
                <div class="flex text-sm items-center rounded-full w-5/6 lg:w-full">
                    <img class="h-10 w-10 rounded-full object-cover" :src="$page.props.auth.user.profile_photo_url"
                    :alt="$page.props.auth.user.name" />
                    <p class="ml-4"><strong class="text-primary mr-2">{{ $page.props.auth.user.name }}</strong> ha compartido una publicación</p>
                </div>
                    <p class="text-gray-600 text-xs ml-[52px] lg:-mt-2">{{ post.created_at }}</p>
            </div>
            <div v-else>
                <div class="flex items-center w-full" figurestyle="float: left">
                    <i class="fa-solid fa-circle-user text-blue-200 text-4xl"></i>
                    <p class="ml-4"><strong class="text-primary mr-2">{{ $page.props.auth.user.name }}</strong> ha compartido una publicación</p>
                </div>
                    <p class="text-gray-600 text-xs ml-[52px] lg:-mt-2 -mt-1">{{ post.created_at }}</p>
            </div>
            <i class="fa-solid fa-ellipsis text-primary cursor-pointer p-2 hover:bg-gray5  rounded-full"></i>
        </div>

        <!-- Imagen --------- -->
        <div class="my-7">
            <p v-if="post.title" class="font-bold">{{ post.title }}</p>
            <p class="text-sm my-3">{{ post.body }}</p>
            <figure v-if="post.media?.length > 0" class="bg-gray5 m-4 rounded-md">
                <img class="w-full rounded-xl object-contain h-96" :src="post.media[0]?.original_url" alt="Sin imagen" >
            </figure>
        </div>

        <!-- Reacciones -------------->
        <div class="border-b border-gray5"></div>
        <div class="flex justify-between items-center my-2 mx-7">
            <div class="flex items-center">
                <i class="fa-solid fa-heart text-red-500 mr-2"></i>
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
            <!-- coments component --------->
            
        </div>
    </div>
</template>

<script>

export default {
data(){
    return {

    }
},
components:{

},
props:{
post: Object
},
methods:{

}
}
</script>

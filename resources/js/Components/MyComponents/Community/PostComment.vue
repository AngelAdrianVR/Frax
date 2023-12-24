<template>
  <div @click="commentDropdown = false" class="relative my-1 p-2 rounded-md border border-transparent hover:border-primary transition ease-in-out duration-300 group">
        <i @click.stop="commentDropdown = !commentDropdown" class="fa-solid fa-ellipsis-vertical px-[10px] py-1 rounded-full cursor-pointer hover:bg-gray5 text-xs text-primary absolute right-1 top-2 hidden group-hover:block transition ease-in-out duration-300"></i>
        <div class="flex items-center">
            <figure class="flex text-sm mr-6">
                <img class="h-8 w-8 rounded-full object-cover" :src="comment?.user.profile_photo_url"
                    :alt="comment?.user.profile_photo_url">
            </figure>
            <p class="text-primary font-semibold text-sm">{{ comment?.user.name }}</p>
        </div>
        <p class="text-sm ml-14">{{ comment?.content }}</p>
        <p class="text-xs text-gray3 ml-14">{{ comment?.created_at + '  .' }}<i class="fa-regular fa-heart text-red-500 ml-3 cursor-pointer"></i> {{ 2 + '  .  ' }} <span class="cursor-pointer">Responder</span> </p>

        <!-- Dropdown de comentario -->
        <div v-if="commentDropdown" 
        class="border border-gray5 flex flex-col space-y-1 rounded-md p-1 absolute w-28 h-auto top-9 -right-4 text-sm z-50 bg-white">
            <p
            v-if="comment.user.id !== $page.props.auth.user.id"
            class="hover:bg-gray5 cursor-pointer text-center px-2"
          >
            Reportar
          </p>
          <p
            v-if="comment.user.id == $page.props.auth.user.id"
            class="hover:bg-gray5 cursor-pointer text-center px-2"
          >
            Editar
          </p>
          <el-popconfirm v-if="comment.user.id == $page.props.auth.user.id" confirm-button-text="Si" cancel-button-text="No" icon-color="#D90537" title="¿Eliminar?"
          @confirm="deleteComment">
          <template #reference>
          <p
            class="hover:bg-gray5 cursor-pointer text-center px-2"
             @click.stop=""
          >
            Eliminar
          </p>
          </template>
        </el-popconfirm>
        </div>
    </div>
</template>

<script>

export default {
data() {
    return {
        commentDropdown: false,
    }
},
components:{

},
props:{
comment: Object
},
emits:['delete-comment'],
methods:{
    deleteComment() {
        this.$emit('delete-comment', this.comment.id);
    }
}
}
</script>

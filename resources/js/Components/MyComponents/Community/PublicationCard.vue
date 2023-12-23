<template>
  <!-- post component ------ -->
  <div
    @click="optionsDropdown = false"
    class="border border-gray4 rounded-md lg:p-8 p-5 my-3"
  >
    <div class="flex justify-between items-center">
      <div v-if="$page.props.jetstream.managesProfilePhotos">
        <div class="flex text-sm items-center rounded-full w-5/6 lg:w-full">
          <img
            class="h-10 w-10 rounded-full object-cover"
            :src="post.user?.profile_photo_url"
            :alt="post.user?.name"
          />
          <p class="ml-4">
            <strong class="text-primary mr-2">{{ post.user?.name }}</strong> ha compartido una
            publicación
          </p>
        </div>
        <p class="text-gray-600 text-xs ml-[52px] lg:-mt-2">{{ post.created_at }}</p>
      </div>
      <div v-else>
        <div class="flex items-center w-full" figurestyle="float: left">
          <i class="fa-solid fa-circle-user text-blue-200 text-4xl"></i>
          <p class="ml-4">
            <strong class="text-primary mr-2">{{ post.user?.name }}</strong> ha compartido una
            publicación
          </p>
        </div>
        <p class="text-gray-600 text-xs ml-[52px] lg:-mt-2 -mt-1">
          {{ post.created_at }}
        </p>
      </div>
      <div class="relative">
        <i
          @click.stop="optionsDropdown = !optionsDropdown"
          class="fa-solid fa-ellipsis text-primary cursor-pointer p-1 hover:bg-gray5 rounded-full"
        ></i>
        <div
          v-if="optionsDropdown"
          class="border border-gray5 flex flex-col space-y-1 rounded-md p-1 absolute w-28 h-auto top-7 -right-1 text-sm z-50 bg-white"
        >
          <p
            v-if="post.user.id !== $page.props.auth.user.id"
            class="hover:bg-gray5 cursor-pointer text-center px-2"
          >
            Reportar
          </p>
          <p
            @click="editPublication = true"
            v-if="post.user.id == $page.props.auth.user.id"
            class="hover:bg-gray5 cursor-pointer text-center px-2"
          >
            Editar
          </p>
          <p
            @click="confirmDelete = true"
            v-if="post.user.id == $page.props.auth.user.id"
            class="hover:bg-gray5 cursor-pointer text-center px-2"
          >
            Eliminar
          </p>
        </div>
      </div>
    </div>

    <!-- body --------- -->
    <div class="my-7">
      <p v-if="post.title" class="font-bold">{{ post.title }}</p>
      <p
        :class="{ 'text-sm': truncated, 'whitespace-normal text-sm': !truncated }"
        class="my-3 truncate"
        ref="postBody"
      >
        {{ post.body }}
      </p>
      <button
        class="text-sm cursor-pointer text-blue-600"
        v-if="truncated"
        @click="showMore"
      >
        Ver más
      </button>
      <figure
        v-if="post.media?.length > 0"
        class="bg-gray5 m-4 rounded-md cursor-pointer"
        @click="openImage"
      >
        <img
          class="w-full rounded-xl object-contain h-96"
          :src="post.media[0]?.original_url"
          alt="Sin imagen"
        />
      </figure>
    </div>

    <!-- Reacciones -------------->
    <div class="border-b border-gray5"></div>
    <div class="flex justify-between items-center my-2 mx-7">
      <div class="flex items-center">
        <i
          class="fa-solid fa-heart text-red-500 mr-2 cursor-pointer P-1 hover:animate-bounce"
        ></i>
        <span class="text-xs">{{ post.likes }}</span>
      </div>
      <div class="flex items-center">
        <i class="fa-regular fa-eye text-gray3 mr-2"></i>
        <span class="text-xs">{{ post.views }}</span>
      </div>
    </div>
    <div class="border-b border-gray5"></div>

    <!-- Comentar ----------->
    <div class="my-5">
      <MakeComment :storeEndpoint="route('posts.store-comment', { postId: this.post.id })"
      @comment-sent="addNewComment($event)" />
    </div>

    <!-- Comentarios de post ------->
    <PostComment v-for="comment in post.comments" :key="comment" :comment="comment" />
  </div>

  <!-- Confirmation modal --------->
  <ConfirmationModal :show="confirmDelete" @close="confirmDelete = false">
    <template #title> ¿Continuar con la eliminación? </template>
    <template #content> Si eliminas la publicación no podrás recuperarla. </template>
    <template #footer>
      <CancelButton @click="confirmDelete = false">Cancelar</CancelButton>
      <PrimaryButton @click="deletePost" class="!bg-red-500 ml-2">Eliminar</PrimaryButton>
    </template>
  </ConfirmationModal>

  <!-------------- Publication Modal -------------->
  <Modal :maxWidth="'xl'" :show="editPublication" @close="editPublication = false">
    <div class="mx-7 my-4 space-y-4 relative">
      <div
        @click="
          editPublication = false;
          form.reset();
        "
        class="cursor-pointer w-5 h-5 rounded-full border-2 border-black flex items-center justify-center absolute top-0 -right-2"
      >
        <i class="fa-solid fa-xmark"></i>
      </div>

      <h1 class="text-lg border-b pb-2 px-3">Editar publicación</h1>

      <input
        v-model="form.title"
        class="input"
        type="text"
        placeholder="Escribe un título a tu publicación (opcional)"
      />

      <textarea
        v-model="form.body"
        class="w-full textarea !border-transparent"
        rows="3"
        placeholder="Escribe el contenido de tu publicación"
      ></textarea>

      <div class="flex justify-center py-9">
        <InputFilePreview class="scale-150" @imagen="saveImage" />
      </div>

      <div class="flex justify-center space-x-1 pt-5 pb-1">
        <PrimaryButton class="px-16" :disabled="!form.body" @click="updatePublication"
          >Guardar cambios</PrimaryButton
        >
      </div>
    </div>
  </Modal>
</template>

<script>
import MakeComment from "@/Components/MyComponents/MakeComment.vue";
import PostComment from "@/Components/MyComponents/Community/PostComment.vue";
import ConfirmationModal from "@/Components/ConfirmationModal.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import CancelButton from "@/Components/MyComponents/CancelButton.vue";
import InputFilePreview from "@/Components/MyComponents/InputFilePreview.vue";
import Modal from "@/Components/Modal.vue";
import { useForm } from "@inertiajs/vue3";
import axios from "axios";

export default {
  data() {
    const form = useForm({
      title: this.post.title,
      body: this.post.body,
      media: [],
    });
    return {
      form,
      optionsDropdown: false,
      editPublication: false,
      confirmDelete: false,
      truncated: true, // Inicialmente asumimos que el texto está truncado
    };
  },
  components: {
    MakeComment,
    ConfirmationModal,
    PrimaryButton,
    CancelButton,
    InputFilePreview,
    PostComment,
    Modal,
  },
  props: {
    post: Object,
  },
  emits: ["delete-post"], // Declaración del evento delete-post
  methods: {
    showMore() {
      this.truncated = false; // Mostrar el texto completo
      this.$refs.postBody.classList.remove("truncate"); // Eliminar la truncación

      // Hacer la solicitud al servidor para incrementar las vistas
      this.incrementViews(this.post.id);
    },
    incrementViews(postId) {
      // Realizar una solicitud al servidor para incrementar las vistas
      try {
        const response = axios.post(route("posts.view", postId));
      } catch (error) {
        console.log(error);
      }
    },
    checkIfTruncated() {
      // Verifica si el texto se está truncando
      if (this.$refs.postBody.scrollWidth > this.$refs.postBody.clientWidth) {
        this.truncated = true;
      }
    },
    deletePost() {
      this.confirmDelete = false;
      this.$emit("delete-post", this.post.id);
    },
     openImage() {
        this.incrementViews(this.post.id); //incrementa la vista en uno
        const urlImagen = this.post.media[0]?.original_url;
        if (urlImagen) {
        window.open(urlImagen, '_blank');
    }
  },
    addNewComment(comment) {
        this.post.comments.push(comment);
    },
    updatePublication() {
      if (this.form.media.length > 0) {
        this.form.post(route("posts.update-with-media", this.post.id), {
          method: "_put",
          onSuccess: () => {
            this.$notify({
              title: "Correcto",
              message: "Se ha editado tu publicación",
              type: "success",
            });
            location.reload();
          },
        });
      } else {
        this.form.put(route("posts.update", this.post.id), {
          onSuccess: () => {
            this.$notify({
              title: "Correcto",
              message: "Se ha editado tu publicación",
              type: "success",
            });
            location.reload();
          },
        });
      }
    },
  },
  watch: {
    "post.body": "checkIfTruncated", // Observa cambios en el texto y ejecuta checkIfTruncated
  },
};
</script>

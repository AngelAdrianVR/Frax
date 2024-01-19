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
          @click.stop="optionsDropdown = !optionsDropdown; incrementViews(post.id)"
          class="fa-solid fa-ellipsis text-primary cursor-pointer p-1 hover:bg-gray5 rounded-full"
        ></i>
        <div
          v-if="optionsDropdown"
          class="border border-gray5 flex flex-col space-y-1 rounded-md p-1 absolute w-28 h-auto top-7 -right-1 text-sm z-50 bg-white"
        >
          <p
            @click="showReportModal = true"
            v-if="post.user.id !== $page.props.auth.user.id"
            class="hover:bg-gray5 cursor-pointer text-center px-2"
          >
            <i class="fa-regular fa-flag mr-1"></i>
            Reportar
          </p>
          <p
            @click="editPublication = true"
            v-if="post.user.id == $page.props.auth.user.id"
            class="hover:bg-gray5 cursor-pointer text-center px-2"
          >
          <i class="fa-solid fa-pencil mr-1 text-xs"></i>
            Editar
          </p>
          <p
            @click="confirmDelete = true"
            v-if="post.user.id == $page.props.auth.user.id"
            class="hover:bg-gray5 cursor-pointer text-center px-2"
          >
            <i class="fa-regular fa-trash-can text-xs mr-1"></i>
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
        class="text-xs cursor-pointer text-blue-600"
        v-if="post.body.length > 54 && truncated"
        @click="showMore"
      >
        Ver más
      </button>
      <figure
        v-if="post.media?.length > 0"
        class="bg-gray5 m-4 rounded-lg cursor-pointer"
        @click="openImage"
      >
        <img
          class="w-full rounded-lg object-contain h-96"
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
          class="fa-solid fa-heart text-red-500 mr-2 cursor-pointer P-1 animate-bounce"
        ></i>
        <span class="text-xs">{{ post.likes }}</span>
      </div>
      <div class="flex items-center">
        <i class="fa-regular fa-eye text-gray3 mr-2 p-1"></i>
        <span class="text-xs">{{ post.views }}</span>
      </div>
    </div>
    <div class="border-b border-gray5"></div>

    <!-- Comentarios de post ------->
    <div :class="{ 'overflow-hidden': !showComments }" class="mt-5 transition-all duration-300 ease-linear" :style="{ maxHeight: showComments ? '1000px' : '0' }">
      <PostComment @report-comment="reportComment" @delete-comment="deleteComment" v-for="comment in post.comments" :key="comment" :comment="comment" />
    </div>

    <!-- Comentar ----------->
    <div v-if="showComments" class="my-4">
      <MakeComment :storeEndpoint="route('posts.store-comment', { postId: this.post.id })"
      @comment-sent="addNewComment($event)" />
    </div>

    <div @click="showComments = false" class="hover-3dbuttom mt-5 border border-gray4 rounded-full px-3 py-1 flex items-center text-gray3 justify-center w-1/2 mx-auto cursor-pointer" v-if="showComments">
        <i class="fa-regular fa-comments"></i>
        <p class="text-sm ml-2">Ocultar comentarios</p>
    </div>

    <div @click="showComments = true" class="hover-3dbuttom mt-5 border border-gray4 rounded-full px-3 py-1 flex items-center text-gray3 justify-center w-1/2 mx-auto cursor-pointer" v-else>
        <i class="fa-regular fa-comments"></i>
        <p class="text-sm ml-2">Comentar</p>
    </div>

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
  <Modal :maxWidth="'xl'" :show="editPublication || showReportModal" @close="editPublication = false; showReportModal = false">
    <div class="mx-7 my-4 space-y-4 relative">
      <div
        @click="
          editPublication = false;
          showReportModal = false;
          form.reset();
        "
        class="cursor-pointer w-5 h-5 rounded-full border-2 border-black flex items-center justify-center absolute top-0 -right-2"
      >
        <i class="fa-solid fa-xmark"></i>
      </div>

      <!-- edit post section  -->
      <section v-if="editPublication">
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
      </section>
      <!-------------------------------->

      <!-- comment or post report section  -->
      <section v-if="showReportModal">
        <h1 class="text-lg border-b pb-2 px-3">Reportar</h1>

        <textarea
          v-model="reportForm.description"
          class="w-full textarea !border-transparent"
          rows="3"
          placeholder="Explica el motivo de tu reporte"
        ></textarea>

        <div class="flex justify-center space-x-1 pt-5 pb-1">
          <PrimaryButton class="px-16" :disabled="!reportForm.description" @click="storeReport"
            >Reportar</PrimaryButton
          >
        </div>
      </section>
      <!----------------------------------------->
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

    const reportForm = useForm({
      description: null,
      post_id: this.post.id,
      comment_id: null,
    });
    return {
      form,
      reportForm,
      postLiked: false, //bandera para saber si ya se dió like al post
      postSeen: false, //bandera para saber si ya se vió el post
      optionsDropdown: false, //dropdown de opciones de post
      editPublication: false, //modal para editar publicación
      showComments: false, //Mostras comentarios de post
      showReportModal: false, //Modal de reporte de post o comentario.
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
      if (!this.postSeen && this.post.user.id != this.$page.props.auth.user.id) { //Si no se ha visto el post y el usuario no es el creador del post, aumenta el contador.
            // Realizar una solicitud al servidor para incrementar las vistas
          try {
            const response = axios.post(route("posts.view", postId));
          } catch (error) {
            console.log(error);
          } finally {
            this.postSeen = true
          }
        } else {
          return;
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
    reportComment(commentId) {
      this.reportForm.comment_id = commentId;
      this.showReportModal = true;
    },
    openImage() {
        this.incrementViews(this.post.id); //incrementa la vista en uno
        const urlImagen = this.post.media[0]?.original_url;
        if (urlImagen) {
        window.open(urlImagen, '_blank');
    }
  },
    addNewComment(comment) {
        comment.created_at = 'Justo ahora'
        this.post.comments.push(comment);
    },
    async deleteComment(commentId) {
        try {
            const response = await axios.delete(route('comments.destroy', commentId));
            if (response.status === 200) {
            // Eliminar el post del arreglo local
            const index = this.post.comments?.findIndex(comment => comment.id === commentId);
            if (index !== -1) {
                this.post.comments?.splice(index, 1);
            }
            this.$notify({
                title: "Correcto",
                message: "Se ha eliminado tu comentario",
                type: "success",
            });
        }
        } catch (error) {
            console.log(error);
            this.$notify({
                title: "Error",
                message: "No se pudo eliminar tu comentario. Refresca la página e intenta de nuevo.",
                type: "error",
            });
        }
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
    storeReport() {
      this.reportForm.post(route("reports.store"), {
      onSuccess: () => {
        this.$notify({
          title: "Correcto",
          message: "Se ha enviado tu reporte. Se revisará y te daremos respuesta pronto",
          type: "success",
        });
        this.showReportModal = false;
      },
    });
    }
  },

};
</script>

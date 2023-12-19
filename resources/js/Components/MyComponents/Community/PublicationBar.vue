<template>
    <div @click="showPublication = true" class="mt-5 border border-gray4 rounded-sm shadow-sm flex items-center py-2 px-7 cursor-pointer hover:shadow-md transition ease-in-out duration-300 hover:-translate-y-2">
        <div class="w-2/3 flex space-x-2">
            <div v-if="$page.props.jetstream.managesProfilePhotos" class="flex text-sm rounded-full w-full items-center">
                <img class="h-10 w-10 rounded-full object-cover" :src="$page.props.auth.user.profile_photo_url"
                :alt="$page.props.auth.user.name" />
                <p class="text-gray3 ml-4">Publica un anuncio</p>
            </div>
            <div class="flex items-center w-full" v-else figurestyle="float: left">
                <i class="fa-solid fa-circle-user text-blue-200 text-4xl"></i>
                <p class="text-gray3 ml-4">Publica un anuncio</p>
            </div>
        </div>
    </div>

<!-------------- Publication Modal -------------->
    <Modal :maxWidth="'xl'" :show="showPublication"  @close="showPublication = false">
        <div class="mx-7 my-4 space-y-4 relative">
            
            <div @click="showPublication = false; form.reset()"
                class="cursor-pointer w-5 h-5 rounded-full border-2 border-black flex items-center justify-center absolute top-0 -right-2">
                <i class="fa-solid fa-xmark"></i>
            </div>

            <h1 class="text-lg border-b pb-2 px-3">Crear publicación</h1>

            <input v-model="form.title" class="input" type="text" placeholder="Escribe un título a tu publicación (opcional)">

            <textarea v-model="form.body" class="w-full textarea !border-transparent" rows="3" placeholder="Escribe el contenido de tu publicación"></textarea>

            <div class="flex justify-center py-9">
                <InputFilePreview class="scale-150" @imagen="saveImage" />
            </div>

            <div class="flex justify-center space-x-1 pt-5 pb-1">
                <PrimaryButton class="px-16" :disabled="!form.body" @click="storePublication">Publicar</PrimaryButton>
            </div>
        </div>
    </Modal>
</template>

<script>
import Modal from "@/Components/Modal.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import CancelButton from "@/Components/MyComponents/CancelButton.vue";
import InputFilePreview from '@/Components/MyComponents/InputFilePreview.vue';
import { useForm } from "@inertiajs/vue3";

export default {
data(){
    const form = useForm({
    title: null,
    body: null,
    media: []
  });
    return {
        form,
        showPublication: false,
    }
},
components:{
PrimaryButton,
CancelButton,
InputFilePreview,
Modal,
},
props:{

},
methods:{
    storePublication() {
    this.form.post(route("posts.store"), {
      onSuccess: () => {
        this.$notify({
          title: "Correcto",
          message: "Se ha creado tu publicación",
          type: "success",
        });
        location.reload();
      },
    });

  },
  saveImage(image) {
    this.form.media.push(image);
  }
}
}
</script>

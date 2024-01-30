<template>
    <AppLayout title="Normativas">
        <div class="lg:py-7 lg:px-10 py-2 px-1">
          <div class="flex justify-between items-center mx-5 mb-8">
            <Back />
            <PrimaryButton @click="addNormModal = true">Agregar normativa</PrimaryButton>
          </div>
          <div class="lg:flex">
            <section class="lg:w-1/5">
              <div class="mt-7">
                <p class="my-4 px-3 font-bold">{{ section.title }}</p>
                <p @click="normSelected(index, norm)" v-for="(norm, index) in normsMedia" :key="norm" 
                :class="{'bg-primarylight text-primary': selectedNorm == index}"
                class="text-sm mt-1 px-3 py-1 cursor-pointer truncate">{{ norm.name }}</p>
              </div>
            </section>
            <section class="lg:w-4/5 lg:p-5 p-3">
              <div class="rounded-t-sm border border-gray3 p-9">
                 <!-- Mostrar el PDF seleccionado -->
                <VuePDF :pdf="pdf" />
              </div>
                <div class="text-right p-3 rounded-b-sm border border-gray3">
                  <PrimaryButton>Marcar como leído</PrimaryButton>
                </div>
            </section>
          </div>
        </div>

        <!-- modal para agregar normativa a la sección  -------------------------------------------------->
        <Modal :show="addNormModal"
          @close="addNormModal = false">
          <div class="mx-7 my-4 space-y-4 relative">
            <div @click="addNormModal = false"
              class="cursor-pointer w-5 h-5 rounded-full border-2 border-black flex items-center justify-center absolute top-0 -right-2">
              <i class="fa-solid fa-xmark"></i>
            </div>

            <h1>Agregar normativa a sección {{ section.title }}</h1>

            <div class="col-span-full mt-2">
                <div class="flex items-center">
                    <span
                        class="font-bold text-[16px] inline-flex items-center text-gray-600 border border-r-8 border-transparent rounded-l-md h-9 darkk:bg-gray-600 darkk:text-gray-400 darkk:border-gray-600">
                        <el-tooltip content="Imagen del producto" placement="top">
                            <i class="fa-solid fa-images"></i>
                        </el-tooltip>
                    </span>
                    <input @input="form.media = $event.target.files[0]" class="input h-12 rounded-lg
                    file:mr-4 file:py-1 file:px-2
                    file:rounded-full file:border-0
                    file:text-sm file:font-semibold
                    file:bg-primary file:text-white
                    file:cursor-pointer" aria-describedby="file_input_help" id="file_input" type="file">
                </div>
                <p class="mt-1 text-xs text-right text-gray-500" id="file_input_help">PDF, DOC (MAX. 4 MB).</p>
            </div>

            <div class="flex justify-end space-x-1 pt-5 pb-1">
              <CancelButton @click="form.reset(); addNormModal = false">Cancelar</CancelButton>  
              <PrimaryButton :disabled="form.processing" @click="store">Agregar</PrimaryButton>
            </div>
          </div>
        </Modal>
    </AppLayout>
  
</template>

<script>  
import AppLayout from "@/Layouts/AppLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import CancelButton from "@/Components/MyComponents/CancelButton.vue";
import Modal from "@/Components/Modal.vue";
import Back from '@/Components/MyComponents/Back.vue';
import { VuePDF, usePDF } from '@tato30/vue-pdf'
import { useForm } from "@inertiajs/vue3";

export default {
data(){
  const form = useForm({
    section_id: this.section.id,
    media: null,
  });
  const { pdf } = usePDF('http://localhost:8000/storage/35/Residentfy_ManualResidente.pdf');
    return {
      form,
      pdf,
      selectedNorm: null,
      selectedNormUrl: null,
      addNormModal: false,
    }
},
components:{
AppLayout,
PrimaryButton,
CancelButton,
Modal,
VuePDF,
Back
},
props:{
section: Object
},
methods:{
  store() {
    this.form.post(route("norms.store-norm"), {
      onSuccess: () => {
        this.$notify({
          title: "Correcto",
          message: "Se ha agregado la normativa",
          type: "success",
        });
        location.reload();
      },
    });
  },
  normSelected(index, norm) {
    this.selectedNorm = index;
    this.selectedNormUrl = norm.original_url;
  }
},
computed: {
  normsMedia() {
    return this.section.media.filter(file => file.collection_name === 'norms');
  }
}
}
</script>

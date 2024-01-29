<template>
    <AppLayout title="Agregar Sección">
        <div class="lg:py-7 lg:px-10 py-2 px-1">
          <Back />
          <form @submit.prevent="store" class="mx-8 mt-9 md:grid grid-cols-2 md:gap-9 md:p-4">
            <!-- Primera parte del grid (izquierda) -->
            <section> 
                <h1 class="font-bold mb-5">Agregar sección</h1>
                <div class="mt-3">
                    <InputLabel value="Título*" class="ml-3 mb-1" />
                    <el-input v-model="form.title" placeholder="Escribe el título de la sección" :maxlength="100" clearable />
                    <InputError :message="form.errors.title" />
                </div>

                <div class="mt-3">
                    <InputLabel value="Imagen portada" class="ml-3 mb-1" />
                    <InputFilePreview @imagen="saveImage" />
                </div>

                <div class="mt-3">
                    <InputLabel value="Descripción" class="ml-3 mb-1" />
                    <el-input v-model="form.description" :autosize="{ minRows: 3, maxRows: 5 }" type="textarea"
                            placeholder="Escribe una descripción de la sección" :maxlength="200" show-word-limit clearable />
                    <InputError :message="form.errors.description" />
                </div>

                <div class="text-right mt-5 mb-3">
                    <PrimaryButton>Crear</PrimaryButton>
                </div>
            </section>
          </form>
        </div>
     </AppLayout>
  
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import Back from '@/Components/MyComponents/Back.vue';
import InputFilePreview from '@/Components/MyComponents/InputFilePreview.vue';
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import { useForm } from "@inertiajs/vue3";

export default {
data(){
    const form = useForm({
    title: null,
    imageCover: null,
    description: null,
  });
    return {
        form,
    }
},
components:{
AppLayout,
PrimaryButton,
Back,
InputLabel,
InputFilePreview,
InputError
},
props:{

},
methods:{
store() {
    this.form.post(route("norms.store"), {
      onSuccess: () => {
        this.$notify({
          title: "Correcto",
          message: "Se ha agregado una sección normativa",
          type: "success",
        });
      },
    });
  },
  saveImage(image) {
    this.form.imageCover = image;
  }
}
}
</script>

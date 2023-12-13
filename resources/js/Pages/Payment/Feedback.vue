<template>
  <AppLayout title="Aclaraciones de pago">
        <div class="py-8 px-3 lg:px-12">
            <div class="flex items-center">
                <i class="fa-regular fa-handshake mr-3"></i>
                <p>Estamos para ayudarte</p>
            </div>
            <form @submit.prevent="store" class="mx-8 mt-9 md:grid grid-cols-3 md:gap-9 md:p-4">
                <!-- Primera parte del grid (izquierda) 2 partes del grid -->
                <section class="col-span-2">
                    <div>
                        <InputLabel value="Tipo de comentario*" class="ml-3 mb-1" />
                        <el-select class="w-full" v-model="form.feedback_type" clearable
                            placeholder="Seleccione" no-data-text="No hay opciones registradas"
                            no-match-text="No se encontraron coincidencias">
                            <el-option v-for="item in feedbackTypes" :key="item" :label="item" :value="item" />
                        </el-select>
                        <InputError :message="form.errors.feedback_type" />
                    </div>

                    <div class="mt-3">
                        <InputLabel value="Descripción" class="ml-3 mb-1" />
                        <textarea v-model="form.description" class="textarea" rows="3" placeholder="Describe tu comentario"></textarea>
                        <InputError :message="form.errors.description" />
                    </div>

                    <div class="mt-3">
                        <FileUploader />
                    </div>
                    
                    <div class="mt-3">
                        <InputLabel value="Contacto de respuesta*" class="ml-3 mb-1" />
                        <input v-model="form.answer_contact" class="input" type="text" placeholder="Escribe tu correo electrónico" />
                        <InputError :message="form.errors.answer_contact" />
                    </div>

                    <div class="mt-3">
                        <InputLabel value="Ingresa la captura de pantalla si es posible" class="ml-3 mb-1" />
                        <InputFilePreview @imagen="saveImage" />
                    </div>

                    <div class="text-left mt-5 mb-3">
                        <PrimaryButton>Enviar</PrimaryButton>
                    </div>
                </section>
            </form>
        </div>
  </AppLayout>

</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import FileUploader from '@/Components/MyComponents/FileUploader.vue';
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import { useForm } from "@inertiajs/vue3";
export default {
data(){
     const form = useForm({
        feedback_type: null,
        description: null,
        answer_contact: null,
        media: null,
    });
        return {
        form,
        feedbackTypes: ["Duda", "Aclaración", "Sugerencia", "Problema"]
    }
},
components:{
AppLayout,
PrimaryButton,
FileUploader,
InputLabel,
InputError
},
props:{

},
methods:{
    store() {
    this.form.post(route("payments-feedback.store"), {
      onSuccess: () => {
        this.$notify({
          title: "Correcto",
          message: "Se ha enviado tu reporte. Te contestaremos a la brevedad",
          type: "success",
        });
      },
    });
  },
  saveImage(image) {
    this.form.image = image;
  }
}
}
</script>

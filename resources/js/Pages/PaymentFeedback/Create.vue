<template>
  <AppLayout title="Aclaraciones de pago">
        <div class="py-8 px-3 lg:px-12">
            <Back />
            <div class="flex items-center mt-10">
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

                    <div class="mt-3 relative">
                        <i :class="getColor()" class="fa-solid fa-circle text-[10px] absolute top-1 left-36"></i>
                        <InputLabel value="Nivel de urgencia" class="ml-3 mb-1" />
                        <el-select class="w-full" v-model="form.urgency_level" clearable
                            placeholder="Seleccione" no-data-text="No hay opciones registradas"
                            no-match-text="No se encontraron coincidencias">
                            <el-option v-for="item in urgencyLevels" :key="item" :label="item" :value="item" />
                        </el-select>
                        <InputError :message="form.errors.urgency_level" />
                    </div>

                    <p class="text-xs text-gray3 mt-1 ml-3">Tus comentarios (en caso de ser necesario) puede ser respondidos en un plazo de aproximadamente 2 días hábiles.</p>

                    <div class="text-center mt-8 mb-3">
                        <PrimaryButton class="px-20">Enviar</PrimaryButton>
                        <p class="text-xs mt-3">Consulta los <a :href="route('dashboard')" target="_blank" class="text-primary cursor-pointer hover:underline font-bold">términos y condiciones de los pagos</a></p>
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
import Back from '@/Components/MyComponents/Back.vue';
import { useForm } from "@inertiajs/vue3";
export default {
data(){
     const form = useForm({
        feedback_type: null,
        description: null,
        answer_contact: null,
        urgency_level: null,
        media: null,
    });
        return {
        form,
        feedbackTypes: ["Duda", "Aclaración", "Sugerencia", "Problema"],
        urgencyLevels: ["Baja", "Media", "Alta"],
    }
},
components:{
AppLayout,
PrimaryButton,
FileUploader,
InputLabel,
InputError,
Back
},
props:{

},
methods:{
    store() {
    this.form.post(route("payment-feedbacks.store"), {
      onSuccess: () => {
        this.$notify({
          title: "Correcto",
          message: "Se ha enviado tu comentario",
          type: "success",
        });
      },
    });
  },
  saveImage(image) {
    this.form.image = image;
  },
  getColor() {
    if (this.form.urgency_level === 'Baja'){
        return 'text-blue-500';
    } else if (this.form.urgency_level === 'Media') {
        return 'text-amber-500';
    } else if (this.form.urgency_level === 'Alta') {
        return 'text-red-500';
    } else {
        return 'text-transparent';
    }
  },

}
}
</script>

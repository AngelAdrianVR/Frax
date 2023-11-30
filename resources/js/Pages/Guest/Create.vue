<template>
    <AppLayout title="Registrar visita">
        <div class="lg:py-7 lg:px-10">
            <Back />

            <form @submit.prevent="store" class="mx-8 mt-9 grid grid-cols-2 border p-4">
                <div>
                    <div class="flex justify-center items-start space-x-12 text-sm mb-8">
                        <div class="flex items-center mr-5">
                        <input v-model="form.type" value="Visita"
                            class="checked:bg-primary focus:text-primary focus:ring-primary bg-transparent w-3 h-3 cursor-pointer"
                            type="radio" name="task_type" />
                        <p class="ml-3 flex items-center">
                            <i class="fa-regular fa-user mr-2"></i>
                            Programar visita
                        </p>
                        </div>
                        <div class="flex items-center">
                        <input v-model="form.type" value="Evento"
                            class="checked:bg-primary focus:text-primary focus:ring-primary bg-transparent w-3 h-3 cursor-pointer"
                            type="radio" name="task_type" />
                        <p class="ml-3 flex items-center">
                            <i class="fa-regular fa-calendar mr-2"></i>
                            Evento
                        </p>
                        </div>
                    </div>
                    <!-- --------------- Programar visita -------------- -->
                    <section v-if="form.type == 'Visita'">
                        <div class="relative">
                            <InputLabel value="Nombre del visitante *" class="ml-3 mb-1" />
                            <p class="text-primary text-xs underline cursor-pointer absolute right-2 top-[2px]">Seleccionar visita frecuente</p>
                            <input v-model="form.name" class="input" type="text" placeholder="Agregar título" />
                            <InputError :message="form.errors.name" />
                            <p class="text-xs ml-3">En caso de no saber el nombre de la visita, solo puede agregar  el nombre de la empresa o el tipo de servicio que le realizarán. (p ej. servicio de comida)</p>
                        </div>

                        <div class="mt-4">
                            <InputLabel value="Foto del visitante" class="ml-3 mb-1" />
                            <figure @click="triggerInput" class="flex items-center justify-center rounded-md border border-dashed border-[#373737] w-48 h-36 cursor-pointer relative">
                                <i v-if="image" @click.stop="image = null" class="fa-solid fa-xmark absolute p-1 top-1 right-1 z-10 text-sm"></i>
                                <i v-if="!image" class="fa-solid fa-camera text-gray-400 text-xl"></i>
                                 <img v-if="image" :src="image" alt="Vista previa" class="w-full h-full object-cover rounded-md opacity-50" />
                                <input ref="fileInput" type="file" @change="handleImageUpload" class="hidden" />
                            </figure>
                        </div>

                        <div class="mt-3">
                            <InputLabel value="Fecha de la visita *" class="ml-2" />
                            <el-date-picker v-model="form.visit_date" type="date" placeholder="Seleccione" :disabled-date="disabledDate" />
                            <InputError :message="form.errors.visit_date" />
                        </div>

                        <div class="mt-3">
                            <InputLabel value="Hora" class="ml-2" />
                            <el-time-picker v-model="time" placeholder="Seleccione (opcional)" />
                            <InputError :message="form.errors.time" />
                        </div>

                        <label class="flex items-center mt-1 lg:mt-5 lg:ml-4 text-xs">
                            <Checkbox v-model:checked="form.identification" class="bg-transparent disabled:border-gray-400" />
                            <span class="ml-2 text-xs">Solictar foto o identificación del visitante</span>
                        </label>
                        <!-- <div>
                            <InputLabel value="Participante(s) *" class="ml-2" />
                            <el-select class="w-full" v-model="form.participants" clearable filterable multiple
                                placeholder="Seleccionar participantes" no-data-text="No hay usuarios registrados"
                                no-match-text="No se encontraron coincidencias">
                                <el-option v-for="user in users" :key="user.id" :label="user.name" :value="user.id">
                                <div v-if="$page.props.jetstream.managesProfilePhotos"
                                    class="flex text-sm rounded-full items-center mt-[3px]">
                                    <img class="h-7 w-7 rounded-full object-cover mr-4" :src="user.profile_photo_url" :alt="user.name" />
                                    <p>{{ user.name }}</p>
                                </div>
                                </el-option>
                            </el-select>
                            <InputError :message="form.errors.participants" />
                        </div> -->
                    </section>
                </div>
            </form>
        </div>
    <!-- {{form}} -->
    </AppLayout>
  
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import Back from '@/Components/MyComponents/Back.vue';
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import Checkbox from "@/Components/Checkbox.vue";
import { useForm } from "@inertiajs/vue3";

export default {
  data() {
    const form = useForm({
      type: "Visita",
      name: null,
      visit_date: null,
      time: null,
      identification: false,
      media: [],
    });
    return {
      form,
      image: null,
    };
  },
  components: {
    AppLayout,
    PrimaryButton,
    InputLabel,
    InputError,
    Checkbox,
    Back
  },
  props: {
    guests: Object
  },
  methods: {
    store() {
      this.form.post(route("guests.store"), {
        onSuccess: () => {
          this.$notify({
            title: "Correcto",
            message: "Se ha registrado la visita",
            type: "success",
          });
        },
      });
    },
    triggerInput() {
      // Simular clic en el input file cuando se hace clic en el icono de la cámara
      this.$refs.fileInput.click();
    },
    handleImageUpload(event) {
      const file = event.target.files[0];
      this.form.media.push(file);

      if (file) {
        // Obtener la URL de la imagen cargada
        const imageURL = URL.createObjectURL(file);

        // Mostrar la vista previa de la imagen
        this.image = imageURL;
      }
    },
    disabledDate(time) {
      const today = new Date();
      today.setHours(0, 0, 0, 0);
      return time.getTime() < today.getTime();
    },
  },
};
</script>

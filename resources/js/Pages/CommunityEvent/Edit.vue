<template>
    <AppLayout title="Editar evento">
        <div class="lg:py-7 lg:px-10 py-2 px-1">
          <Back />
          <form @submit.prevent="update" class="mx-8 mt-9 md:grid grid-cols-2 md:gap-9 md:p-4">
            <!-- Primera parte del grid (izquierda) -->
            <section> 
                <h1 class="font-bold mb-5">Editar evento "{{ community_event.name }}"</h1>
                <div class="mt-3">
                    <InputLabel value="Nombre*" class="ml-3 mb-1" />
                    <input v-model="form.name" class="input" type="text" />
                    <InputError :message="form.errors.name" />
                </div>

                <div class="mt-3">
                    <InputLabel value="Fecha del evento*" class="ml-3 mb-1" />
                    <el-date-picker v-model="form.date" type="date" placeholder="Seleccione" :disabled-date="disabledDate" />
                    <InputError :message="form.errors.date" />
                </div>

                <div class="mt-3">
                    <InputLabel value="Hora" class="ml-3 mb-1" />
                    <el-time-picker v-model="form.time" placeholder="Seleccione (opcional)" />
                    <InputError :message="form.errors.time" />
                </div>

                <div class="mt-3">
                  <InputLabel value="Participantes*" class="ml-3 mb-1" />
                  <el-select class="w-full" v-model="localParticipants" clearable
                      placeholder="Seleccione" no-data-text="No hay opciones registradas"
                      no-match-text="No se encontraron coincidencias">
                      <el-option v-for="item in participants" :key="item" :label="item" :value="item" />
                  </el-select>
                  <InputError :message="form.errors.participants" />
                </div>

                <div v-if="localParticipants === 'Otro'" class="mt-3">
                    <InputLabel value="Describa a los participantes*" class="ml-3 mb-1" />
                    <input v-model="form.participants" class="input" type="text" />
                    <InputError :message="form.errors.participants" />
                </div>

                <div class="mt-3">
                    <InputLabel value="Descripción" class="ml-3 mb-1" />
                    <textarea v-model="form.description" class="textarea" rows="3"></textarea>
                    <InputError :message="form.errors.description" />
                </div>

                <div class="mt-3">
                    <InputLabel value="Imagen portada" class="ml-3 mb-1" />
                    <InputFilePreview @imagen="saveImage" />
                </div>


                <div class="text-right mt-5 mb-3">
                    <PrimaryButton>Guardar cambios</PrimaryButton>
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
    name: this.community_event.name,
    date: this.community_event.date,
    time: this.community_event.time,
    participants: null,
    description: this.community_event.description,
    imageCover: null,
  });
    return {
        form,
        localParticipants: this.community_event.participants,
        participants: ['Todos los residentes',
                     'Niñas y niños de entre 10 y 15 años',
                     'Un representante de cada casa',
                     'Un representante por casa',
                     'Sólo Mujeres',
                     'Sólo Hombres',
                     'Otro',
                      ]
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
community_event: Object
},
methods:{
update() {
    if (this.localParticipants !== 'Otro') {
        this.form.participants = this.localParticipants
    }
    
    if (this.form.imageCover !== null ) {
            this.form.post(route("community-events.update-with-media", this.community_event.id), {
                method: '_put',
                onSuccess: () => {
                  this.$notify({
                  title: "Correcto",
                  message: "Se ha editado el evento",
                  type: "success",
                      });
                  },
              });
              } else {

        this.form.put(route("community-events.update", this.community_event.id), {
            onSuccess: () => {
                this.$notify({
                    title: "Correcto",
                    message: "Se ha editado el evento",
                    type: "success",
                });
                },
            });
             }
  },
  saveImage(image) {
    this.form.imageCover = image;
  },
  disabledDate(time) {
    const today = new Date();
    today.setHours(0, 0, 0, 0);
    return time.getTime() < today.getTime();
  },
}
}
</script>

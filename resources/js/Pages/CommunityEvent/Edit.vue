<template>
    <AppLayout title="Editar evento">
        <div class="lg:py-7 lg:px-10 py-2 px-1">
          <Back />
          <form @submit.prevent="update" class="mx-8 mt-9 md:grid grid-cols-2 md:gap-9 md:p-4">
            <!-- Primera parte del grid (izquierda) -->
            <section> 
                <h1 class="font-bold mb-5">Crear un evento</h1>
                <div class="mt-3">
                    <InputLabel value="Nombre*" class="ml-3 mb-1" />
                    <el-input v-model="form.name" placeholder="Escribe el nombre del evento" :maxlength="100" clearable />
                    <InputError :message="form.errors.name" />
                </div>

                <div class="flex items-center space-x-2 mt-3">
                  <div class="w-1/2">
                      <InputLabel value="Fecha del evento*" class="ml-3 mb-1" />
                      <el-date-picker v-model="form.date" type="date" placeholder="Seleccione" :disabled-date="disabledDate" />
                      <InputError :message="form.errors.date" />
                  </div>

                  <div class="w-1/2">
                    <InputLabel value="Hora" class="ml-3 mb-1" />
                    <el-time-picker v-model="form.time" placeholder="Seleccione (opcional)" />
                    <InputError :message="form.errors.time" />
                  </div>
                </div>

                <div class="mt-3">
                    <InputLabel value="Lugar*" class="ml-3 mb-1" />
                    <el-input v-model="form.place" placeholder="Escribe el Lugar del evento" :maxlength="100" clearable />
                    <InputError :message="form.errors.place" />
                </div>

                <div class="flex items-center space-x-3 mt-3">
                  <div class="w-2/3">
                      <InputLabel value="Capacidad" class="ml-3 mb-1 text-sm" />
                      <el-input :disabled="unlimited_capacity" v-model="form.capacity_event" placeholder="Cantidad máxima de personas"
                      :formatter="(value) => `${value}`.replace(/\B(?=(\d{3})+(?!\d))/g, ',')"
                      :parser="(value) => value.replace(/\$\s?|(,*)/g, '')" />
                      <InputError :message="form.errors.capacity_event" />
                  </div>
                  <label class="flex items-center text-xs mt-5">
                    <Checkbox @change="form.capacity_event = null; form.capacity_per_resident = null" v-model:checked="unlimited_capacity" class="bg-transparent disabled:border-gray-400" />
                    <span class="ml-2 mr-2 text-xs">Capacidad ilimitada</span>
                    <el-tooltip
                    content="Marca la casilla si no hay límite de participantes para este evento"
                    placement="top">
                    <div class="rounded-full border border-primary w-3 h-3 flex items-center justify-center">
                      <i class="fa-solid fa-info text-primary text-[7px]"></i>
                    </div>
                    </el-tooltip>
                  </label>
                </div>

                <div class="mt-3 w-2/3">
                  <InputLabel value="Participantes por residencia" class="ml-3 mb-1 text-sm" />
                  <el-input :disabled="unlimited_capacity" v-model="form.capacity_per_resident" placeholder="Cantidad máxima de personas por residencia"
                      :formatter="(value) => `${value}`.replace(/\B(?=(\d{3})+(?!\d))/g, ',')"
                      :parser="(value) => value.replace(/\$\s?|(,*)/g, '')" />
                  <InputError :message="form.errors.capacity_per_resident" />
                </div>

                <div class="mt-3 w-1/2 relative">
                    <InputLabel value="Costo*" class="ml-3 mb-1 text-sm" />
                    <el-input v-model="form.cost" placeholder=""
                      :formatter="(value) => `$ ${value}`.replace(/\B(?=(\d{3})+(?!\d))/g, ',')"
                      :parser="(value) => value.replace(/\$\s?|(,*)/g, '')" />
                    <InputError :message="form.errors.cost" />
                </div>
            </section>

            <!-- Segunda parte del grid (derecha) -->
            <section class="mt-8">
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
                  <el-input v-model="form.participants" placeholder="Describe los participantes" :maxlength="100" clearable />
                  <InputError :message="form.errors.participants" />
                </div>

                <div class="mt-3">
                  <InputLabel value="Descripción*" class="ml-3 mb-1" />
                  <el-input v-model="form.description" :autosize="{ minRows: 3, maxRows: 5 }" type="textarea"
                            placeholder="Escribe una breve descripción del evento" :maxlength="200" show-word-limit clearable />
                  <InputError :message="form.errors.description" />
                </div>

                <div class="mt-3">
                    <InputLabel value="Reglas del evento" class="ml-3 mb-1" />
                  <div class="flex space-x-2 mb-1">
                    <el-input v-model="newRule" placeholder="Escriba una regla (Opcional)" :maxlength="100" clearable />
                    <SecondaryButton @click="addRule" type="button">
                        Agregar
                    </SecondaryButton>
                  </div>
                  <el-select class="w-full" v-model="form.rules" multiple clearable placeholder="Reglas"
                      no-data-text="Agregue primero una regla">
                      <el-option v-for="rule in rules" :key="rule" :label="rule"
                          :value="rule"></el-option>
                  </el-select>
              </div>

                <div class="mt-3">
                    <InputLabel value="Imagen portada" class="ml-3 mb-1" />
                    <InputFilePreview 
                    @imagen="saveImage($event); form.coverImageCleared = false"
                    @cleared="form.imageCover = null; form.coverImageCleared = true"
                    :imageUrl="community_event.media[0]?.original_url" />
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
import SecondaryButton from "@/Components/SecondaryButton.vue";
import InputFilePreview from '@/Components/MyComponents/InputFilePreview.vue';
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import Checkbox from "@/Components/Checkbox.vue";
import Back from '@/Components/MyComponents/Back.vue';
import { useForm } from "@inertiajs/vue3";

export default {
data(){
    const form = useForm({
    name: this.community_event.name,
    date: this.community_event.date,
    time: this.community_event.time,
    participants: null,
    description: this.community_event.description,
    place: this.community_event.place,
    cost: this.community_event.cost,
    rules: this.community_event.rules,
    capacity_event: this.community_event.capacity_event,
    capacity_per_resident: this.community_event.capacity_per_resident,
    imageCover: null,
    coverImageCleared: false,
  });
    return {
        form,
        localParticipants: this.community_event.participants,
        unlimited_capacity: false,
        participants: [
            'Todos los residentes',
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
InputFilePreview,
SecondaryButton,
PrimaryButton,
InputLabel,
InputError,
Checkbox,
Back
},
props:{
community_event: Object
},
methods:{
update() {
    if (this.localParticipants !== 'Otro') {
        this.form.participants = this.localParticipants
    }
    
    if (this.form.imageCover != null ) {
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
  addRule() {
      if (this.newRule?.trim() !== '') {
          this.form.rules.push(this.newRule);
          this.rules.push(this.newRule);
          this.newRule = '';
      }
  },
}
}
</script>

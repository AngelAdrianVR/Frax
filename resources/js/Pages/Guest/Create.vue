<template>
    <AppLayout title="Registrar visita">
        <div class="lg:py-7 lg:px-10">
            <Back />

            <form @submit.prevent="store" class="mx-8 mt-9 grid grid-cols-2 gap-9 p-4">
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
                            <InputLabel value="Nombre del visitante*" class="ml-3 mb-1" />
                            <p class="text-primary text-xs underline cursor-pointer absolute right-2 top-[2px]">Seleccionar visita frecuente</p>
                            <input v-model="form.name" class="input" type="text" />
                            <InputError :message="form.errors.name" />
                            <p class="text-xs ml-3">En caso de no saber el nombre de la visita, solo puede agregar  el nombre de la empresa o el tipo de servicio que le realizarán. (p ej. servicio de comida)</p>
                        </div>

                        <div class="mt-4">
                            <InputLabel value="Foto del visitante" class="ml-3 mb-1" />
                            <figure @click="triggerGuestImageInput" class="flex items-center justify-center rounded-md border border-dashed border-[#373737] w-48 h-36 cursor-pointer relative">
                                <i v-if="guestImage" @click.stop="guestImage = null" class="fa-solid fa-xmark absolute p-1 top-1 right-1 z-10 text-sm"></i>
                                <i v-if="!guestImage" class="fa-solid fa-camera text-gray-400 text-xl"></i>
                                 <img v-if="guestImage" :src="guestImage" alt="Vista previa" class="w-full h-full object-contain bg-no-repeat rounded-md opacity-50" />
                                <input ref="fileGuestInput" type="file" @change="handleGuestImageUpload" class="hidden" />
                            </figure>
                        </div>

                        <div class="mt-3">
                            <InputLabel value="Fecha de la visita*" class="ml-3 mb-1" />
                            <el-date-picker v-model="form.visit_date" type="date" placeholder="Seleccione" :disabled-date="disabledDate" />
                            <InputError :message="form.errors.visit_date" />
                        </div>

                        <div class="mt-3">
                            <InputLabel value="Hora" class="ml-3 mb-1" />
                            <el-time-picker v-model="form.time" placeholder="Seleccione (opcional)" />
                            <InputError :message="form.errors.time" />
                        </div>

                        <label class="flex items-center mt-4 text-xs">
                            <Checkbox v-model:checked="form.identification" class="bg-transparent disabled:border-gray-400" />
                            <span class="ml-2 mr-2 text-xs">Solictar foto o identificación del visitante</span>
                            <el-tooltip
                            content="Puedes requerirlo para mayor seguridad"
                            placement="top">
                            <div class="rounded-full border border-primary w-3 h-3 flex items-center justify-center">
                              <i class="fa-solid fa-info text-primary text-[7px]"></i>
                            </div>
                          </el-tooltip>
                        </label>
                    </section>
                </div>
            
                <section v-if="form.type == 'Visita'" class="mt-14">
                  <div>
                      <InputLabel value="Tipo de acceso*" class="ml-3 mb-1" />
                      <el-select class="w-full" v-model="form.guest_type" clearable
                          placeholder="Seleccione" no-data-text="No hay opciones registradas"
                          no-match-text="No se encontraron coincidencias">
                          <el-option v-for="item in guestTypes" :key="item" :label="item" :value="item" />
                      </el-select>
                      <InputError :message="form.errors.guest_type" />
                  </div>
                  <div class="rounded-md border border-[#D9D9D9] mt-3" v-if="guest_type == 'Vehicular'">
                    <div class="bg-[#F2F2F2] rounded-t-md p-2 flex items-center text-gray-500">
                      <i class="fa-solid fa-car mx-3"></i>
                      <p>Datos del vehículo</p>
                    </div>
                    <div class="pt-1 pb-5 px-7">
                      <div>
                            <InputLabel value="Foto del visitante (opcional)" class="ml-3 mb-1" />
                            <figure @click="triggerVehicleImageInput" class="flex items-center justify-center rounded-md border border-dashed border-[#373737] w-48 h-36 cursor-pointer relative">
                                <i v-if="vehicleImage" @click.stop="vehicleImage = null" class="fa-solid fa-xmark absolute p-1 top-1 right-1 z-10 text-sm"></i>
                                <i v-if="!vehicleImage" class="fa-solid fa-camera text-gray-400 text-xl"></i>
                                 <img v-if="vehicleImage" :src="vehicleImage" alt="Vista previa" class="w-full h-full  object-contain bg-no-repeat rounded-md opacity-50" />
                                <input ref="fileVehicleInput" type="file" @change="handleVehicleImageUpload" class="hidden" />
                            </figure>
                        </div>
                        <div class="mt-3">
                            <InputLabel value="Marca*" class="ml-3 mb-1" />
                            <input class="input" v-model="form.vehicle_details.brand" type="text" required />
                            <!-- <InputError :message="form.errors?.vehicle_details?.brand" /> -->
                        </div>
                        <div class="mt-3">
                            <InputLabel value="Modelo*" class="ml-3 mb-1" />
                            <input class="input" v-model="form.vehicle_details.model" type="text" required />
                            <!-- <InputError :message="form.errors.vehicle_details.model" /> -->
                        </div>
                        <div class="mt-3">
                            <InputLabel value="Color*" class="ml-3 mb-1" />
                            <input class="input" v-model="form.vehicle_details.color" type="text" required />
                            <!-- <InputError :message="form.errors.vehicle_details.color" /> -->
                        </div>
                        <div class="mt-3">
                            <InputLabel value="Placa*" class="ml-3 mb-1" />
                            <input class="input" v-model="form.vehicle_details.plate" type="text" required />
                            <!-- <InputError :message="form.errors.vehicle_details.plate" /> -->
                        </div>
                    </div>
                  </div>
                  <div class="mt-3">
                      <InputLabel value="Notas" class="ml-3 mb-1" />
                      <textarea v-model="form.notes" class="textarea" rows="3"></textarea>
                      <InputError :message="form.errors.notes" />
                  </div>
                  <label class="flex items-center mt-1 lg:mt-5 lg:ml-4 text-xs">
                      <Checkbox v-model:checked="form.is_favorite_guest" class="bg-transparent disabled:border-gray-400" />
                      <span class="ml-2 mr-2 text-xs">Agregar esta visita como frecuente</span>
                      <el-tooltip
                      content="Marca esta visita como frecuente para agilizar futuras programaciones de acceso"
                      placement="top">
                      <div class="rounded-full border border-primary w-3 h-3 flex items-center justify-center">
                        <i class="fa-solid fa-info text-primary text-[7px]"></i>
                      </div>
                    </el-tooltip>
                  </label>
                </section>
                <div class="text-right col-span-2">
                  <PrimaryButton>Guardar</PrimaryButton>
                </div>
        </form>
        </div>
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
      guest_type: null, //solo para hacer validación desde metodo store.
      name: null,
      visit_date: null,
      time: null,
      identification: false,
      notes: null,
      is_favorite_guest: false,
      vehicle_details: {
        brand: null,
        model: null,
        color: null,
        plate: null
      },
      guest_image: null,
      vehicle_image: null,
    });
    return {
      form,
      guestImage: null,
      vehicleImage: null,
      guestTypes: ["Peatonal", "Vehicular"],
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
    triggerGuestImageInput() {
      // Simular clic en el input file cuando se hace clic en el icono de la cámara
      this.$refs.fileGuestInput.click();
    },
    triggerVehicleImageInput() {
      // Simular clic en el input file cuando se hace clic en el icono de la cámara
      this.$refs.fileVehicleInput.click();
    },
    handleGuestImageUpload(event) {
      const file = event.target.files[0];
      this.form.guest_image = file;

      if (file) {
        // Obtener la URL de la imagen cargada
        const imageURL = URL.createObjectURL(file);

        // Mostrar la vista previa de la imagen
        this.guestImage = imageURL;
      }
    },
    handleVehicleImageUpload(event) {
      const file = event.target.files[0];
      this.form.vehicle_image = file;

      if (file) {
        // Obtener la URL de la imagen cargada
        const imageURL = URL.createObjectURL(file);

        // Mostrar la vista previa de la imagen
        this.vehicleImage = imageURL;
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

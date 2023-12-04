<template>
    <AppLayout title="Registrar visita frecuente">
        <div class="lg:py-7 lg:px-10">
            <Back />
            <form @submit.prevent="store" class="lg:mx-16 mt-5 p-4">
                <h1 class="font-bold text-lg"><i class="fa-regular fa-star mr-2"></i> Agregar visita frecuente</h1>
                <div class="grid grid-cols-2 gap-9">
                    <!-- Primera mitad del grid ---------------------- -->
                    <section>
                        <div class="mt-4">
                            <InputLabel value="Nombre del visitante*" class="ml-3 mb-1" />
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

                    <!-- Segunda mitad del grid ------------------------ -->
                    <section>
                        <div class="mt-[18px]">
                            <InputLabel value="Tipo de acceso*" class="ml-3 mb-1" />
                            <el-select class="w-full" v-model="form.guest_type" clearable
                                placeholder="Seleccione" no-data-text="No hay opciones registradas"
                                no-match-text="No se encontraron coincidencias">
                                <el-option v-for="item in guestTypes" :key="item" :label="item" :value="item" />
                            </el-select>
                            <InputError :message="form.errors.guest_type" />
                        </div>

                        <div class="rounded-md border border-[#D9D9D9] mt-3" v-if="form.guest_type == 'Vehicular'">
                            <div class="bg-[#F2F2F2] rounded-t-md p-2 flex items-center text-gray-500">
                                <i class="fa-solid fa-car mx-3"></i>
                                <p>Datos del vehículo</p>
                                <el-tooltip
                                    content="En este apartado, puedes agregar los vehículos que estén asociados a tu visita. Esto simplifica el proceso de programar tu visita."
                                    placement="top">
                                    <div class="rounded-full border border-primary w-3 h-3 flex items-center justify-center ml-7">
                                        <i class="fa-solid fa-info text-primary text-[7px]"></i>
                                    </div>
                                 </el-tooltip>
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
                                    <input class="input" v-model="localVehicleDetails.brand" type="text" required />
                                    <!-- <InputError :message="form.errors?.vehicle_details?.brand" /> -->
                                </div>
                                <div class="mt-3">
                                    <InputLabel value="Modelo*" class="ml-3 mb-1" />
                                    <input class="input" v-model="localVehicleDetails.model" type="text" required />
                                    <!-- <InputError :message="form.errors.vehicle_details.model" /> -->
                                </div>
                                <div class="mt-3">
                                    <InputLabel value="Color*" class="ml-3 mb-1" />
                                    <input class="input" v-model="localVehicleDetails.color" type="text" required />
                                    <!-- <InputError :message="form.errors.vehicle_details.color" /> -->
                                </div>
                                <div class="mt-3">
                                    <InputLabel value="Placa*" class="ml-3 mb-1" />
                                    <input class="input uppercase" v-model="localVehicleDetails.plate" type="text" required />
                                    <!-- <InputError :message="form.errors.vehicle_details.plate" /> -->
                                </div>

                                <div class="text-right mt-3">
                                    <ThirthButton @click="addVehicle" 
                                    :disabled="!localVehicleDetails.brand || !localVehicleDetails.model || !localVehicleDetails.color || !localVehicleDetails.plate"
                                     type="button">Agregar a la lista</ThirthButton>
                                </div>

                                <div v-if="form.vehicle_details?.length > 0" class="mt-3">
                                    <p class="font-bold">Lista de vehiculos</p>
                                    <ul>
                                        <li class="flex justify-between items-center"  v-for="(vehicle, index) in form.vehicle_details" :key="index">
                                            <p class="text-[#677677]">{{ (index + 1) + '. Auto: ' + vehicle?.brand + ' ' + vehicle?.model  }}</p>
                                            <div class="flex items-center space-x-2">
                                                <i class="fa-solid fa-pencil p-2 text-gray2 rounded-full bg-[#F2F2F2] cursor-pointer"></i>
                                                <i class="fa-regular fa-trash-can p-2 text-gray2 rounded-full bg-[#F2F2F2] cursor-pointer"></i>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="mt-3">
                            <InputLabel value="Notas" class="ml-3 mb-1" />
                            <textarea v-model="form.notes" class="textarea" rows="3"></textarea>
                            <InputError :message="form.errors.notes" />
                        </div>
                    </section>

                </div>
            </form>
{{localVehicleDetails}}
{{form.vehicle_details}}
        </div>
        
    </AppLayout>
  
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import ThirthButton from "@/Components/ThirthButton.vue";
import Back from '@/Components/MyComponents/Back.vue';
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import Checkbox from "@/Components/Checkbox.vue";
import { useForm } from "@inertiajs/vue3";

export default {
  data() {
    const form = useForm({
      guest_type: null, //solo para hacer validación desde metodo store.
      name: null,
      visit_date: null,
      time: null,
      identification: false,
      notes: null,
      is_favorite_guest: false,
      vehicle_details: [],
      guest_image: null,
      vehicle_image: null,
    });

    return {
      form,
      guestImage: null,
      vehicleImage: null,
      localVehicleDetails: {
        brand: null,
        model: null,
        color: null,
        plate: null
      },
      guestTypes: ["Peatonal", "Vehicular"],
    };
  },
  components: {
    AppLayout,
    PrimaryButton,
    ThirthButton,
    InputLabel,
    InputError,
    Checkbox,
    Back
  },
  props: {

  },
  methods: {
    store() {
       if (this.form.guest_type == 'Peatonal'){ //si no es vehicular el json de vehicle_details es null para no guardar el formato en la bd.
          this.form.vehicle_details = null;
       }
      this.form.post(route("favorite-guests.store"), {
        onSuccess: () => {
          this.$notify({
            title: "Correcto",
            message: "Se ha registrado la visita frecuente",
            type: "success",
          });
        },
      });
    },
    addVehicle() {
        this.form.vehicle_details.push(this.localVehicleDetails);
        this.localVehicleDetails.brand = null;
        this.localVehicleDetails.model = null;
        this.localVehicleDetails.color = null;
        this.localVehicleDetails.plate = null;
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
  },
  mounted() {
  }
};
</script>

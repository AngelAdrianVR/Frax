<template>
    <AppLayout title="Editar visita frecuente">
        <div class="lg:py-7 lg:px-10 py-2 px-1">
            <Back />
            <form @submit.prevent="update" class="lg:mx-16 mt-5 p-4">
                <h1 class="font-bold text-lg"><i class="fa-regular fa-star mr-2"></i> Editar visita frecuente</h1>
                <div class="lg:grid grid-cols-2 gap-9">
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
                                <i v-if="guestImage" @click.stop="guestImage = null; form.guest_image = null" class="fa-solid fa-xmark absolute p-1 top-1 right-1 z-10 text-sm"></i>
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
                            <el-select @change="form.vehicle_details = []" class="w-full" v-model="form.guest_type" clearable
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
                                    <input class="input" v-model="localVehicleDetails.brand" type="text" placeholder="Escribe el modelo del vehículo" />
                                    <!-- <InputError :message="form.errors?.vehicle_details?.brand" /> -->
                                </div>
                                <div class="mt-3">
                                    <InputLabel value="Modelo*" class="ml-3 mb-1" />
                                    <input class="input" v-model="localVehicleDetails.model" type="text" placeholder="Escribe la marca del vehículo" />
                                    <!-- <InputError :message="form.errors.vehicle_details.model" /> -->
                                </div>
                                <div class="mt-3">
                                    <InputLabel value="Color*" class="ml-3 mb-1" />
                                    <input class="input" v-model="localVehicleDetails.color" type="text" placeholder="Escribe el color del vehículo" />
                                    <!-- <InputError :message="form.errors.vehicle_details.color" /> -->
                                </div>
                                <div class="mt-3">
                                    <InputLabel value="Placa*" class="ml-3 mb-1" />
                                    <input class="input uppercase" v-model="localVehicleDetails.plate" type="text" placeholder="Escribe la placa del vehículo" />
                                    <!-- <InputError :message="form.errors.vehicle_details.plate" /> -->
                                </div>

                                <div class="text-right mt-3">
                                    <ThirthButton @click="addVehicle" 
                                    :disabled="!localVehicleDetails.brand || !localVehicleDetails.model || !localVehicleDetails.color || !localVehicleDetails.plate"
                                     type="button">{{editIndex !== null ? 'Actualzar' : 'Agregar a la lista'}}</ThirthButton>
                                </div>
                                <!-- Lista de vehiculos ------------------- -->
                                <div v-if="form.vehicle_details?.length > 0" class="mt-3">
                                    <p class="font-bold">Lista de vehiculos</p>
                                    <ul>
                                        <li class="flex justify-between items-center space-y-1"  v-for="(vehicle, index) in form.vehicle_details" :key="index">
                                          <p class="text-[#677677]">{{ (index + 1) + '. Auto: ' + vehicle?.brand + ' ' + vehicle?.model  }}</p>
                                            <div class="flex items-center space-x-2">
                                              <el-tag v-if="index == editIndex" class="ml-2">En edición</el-tag>
                                              <i @click="editVehicle(index)" class="fa-solid fa-pencil p-2 text-gray2 rounded-full bg-[#F2F2F2] cursor-pointer"></i>
                                              <el-popconfirm confirm-button-text="Si" cancel-button-text="No" icon-color="#D90537" title="¿Eliminar?"
                                                @confirm="deleteVehicle(index)">
                                                <template #reference>
                                                  <i class="fa-regular fa-trash-can p-2 text-gray2 rounded-full bg-[#F2F2F2] cursor-pointer"></i>
                                                </template>
                                              </el-popconfirm>
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

                    <div class="text-right col-span-2 my-3">
                    <PrimaryButton>Actualizar</PrimaryButton>
                  </div>
                </div>
            </form>
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
      guest_type: this.favorite_guest.vehicle_details?.length > 0 ? 'Vehicular' : 'Peatonal', //solo para hacer validación desde metodo update.
      name: this.favorite_guest.name,
      identification: !!this.favorite_guest.identification,
      notes: this.favorite_guest.notes,
      vehicle_details: this.favorite_guest.vehicle_details,
      guest_image: null, //se asigna en el mounted
    });

    return {
      form,
      guestImage: null, //se asigna en el mounted
      vehicleImage: null,
      editIndex: null,
      localVehicleDetails: {
        brand: null,
        model: null,
        color: null,
        plate: null,
        image: null
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
    favorite_guest: Object
  },
  methods: {
    update() {
        if (this.form.guest_image !== null ) {
            this.form.post(route("favorite-guests.update-with-media", this.favorite_guest.id), {
                method: '_put',
                onSuccess: () => {
                  this.$notify({
                  title: "Correcto",
                  message: "Se ha editado la visita",
                  type: "success",
                      });
                  },
              });
              } else {

        this.form.put(route("favorite-guests.update", this.favorite_guest.id), {
            onSuccess: () => {
                this.$notify({
                    title: "Correcto",
                    message: "Se ha editado tu visita frecuente",
                    type: "success",
                });
                },
            });
             }
    },
    addVehicle() {
      // Crear una nueva instancia del objeto localVehicleDetails
      const vehicle = { ...this.localVehicleDetails };

      //Actualiza el vehiculo si existe un index de edicion
      if (this.editIndex !== null) {
        this.form.vehicle_details[this.editIndex] = { ...this.localVehicleDetails };
        } else {

          // Agregar el nuevo objeto al array
        this.form.vehicle_details.push(vehicle);
        }

      // Restablecer localVehicleDetails
      this.localVehicleDetails.brand = null;
      this.localVehicleDetails.model = null;
      this.localVehicleDetails.color = null;
      this.localVehicleDetails.plate = null;
      this.localVehicleDetails.image = null;
      this.vehicleImage = null;
      this.editIndex = null;
    },
    editVehicle(index) {
      // Aquí puedes utilizar el índice para realizar la lógica de edición
      this.editIndex = index;
      this.localVehicleDetails = { ...this.form.vehicle_details[this.editIndex] };

    },
    deleteVehicle(index) {
      // Eliminar el vehículo del array
      this.form.vehicle_details.splice(index, 1);
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
      this.localVehicleDetails.image = file;

      if (file) {
        // Obtener la URL de la imagen cargada
        const imageURL = URL.createObjectURL(file);

        // Mostrar la vista previa de la imagen
        this.vehicleImage = imageURL;
      }
    },
  },
  mounted() {
    // Encuentra el primer elemento en favorite_guest.media con collection_name igual a "guest_image"
    const guestImageMedia = this.favorite_guest.media.find(item => item.collection_name === "guest_image");
    this.form.guest_image = guestImageMedia.original_url;
    this.guestImage = guestImageMedia.original_url;
  }
};
</script>

<template>
  <div
    class="rounded-md shadow-md shadow-gray-200 border border-[#D9D9D9] text-sm transition duration-300 ease-out self-start pb-3"
  >
    <div class="px-3 py-3">
      <div class="flex justify-between">
        <i class="fa-solid fa-star text-lg text-[#e1cb3b]"></i>
        <!-- -----------photo--------- -->
        <div class="ml-10">
          <figure v-if="favoriteGuest.media_guest?.length > 0" class="bg-[#F2F2F2] w-44 h-36 rounded-sm">
            <img class="object-contain bg-no-repeat w-44 h-36" :src="favoriteGuest.media_guest[0]?.original_url" alt="" />
          </figure>
          <div class="bg-[#F2F2F2] w-44 h-36 rounded-sm flex justify-center items-center" v-else><i class="fa-regular fa-user text-4xl text-gray3"></i></div>
        </div>
        <!-- ------- Acciones ------ -->
        <div class="flex items-center space-x-1 self-start">
          <el-popconfirm confirm-button-text="Si" cancel-button-text="No" icon-color="#D90537" title="¿Eliminar?"
            @confirm="deleteGuest">
            <template #reference>
            <i class="fa-regular fa-trash-can bg-[#F2F2F2] rounded-full p-2 cursor-pointer"></i>
            </template>
          </el-popconfirm>
          <i @click="$inertia.get(route('favorite-guests.edit', favoriteGuest.id))" class="fa-solid fa-pencil p-2 rounded-full bg-[#F2F2F2] cursor-pointer"></i>
        </div>
      </div>
      <!-- -------------- info ------- -->
      <div class="flex flex-col items-center justify-center mt-2">
        <p class="font-semibold">{{ favoriteGuest.name }}</p>
      </div>
      <div class="mt-4 grid grid-cols-2">
        <section>
          <div class="flex items-center mb-1">
            <i class="fa-solid fa-arrow-right-to-bracket mr-4"></i>
            <p>Tipo de acceso</p>
          </div>
          <div class="flex items-center mb-1">
            <i class="fa-regular fa-file-lines mr-4"></i>
            <p>Notas</p>
          </div>
          <div v-if="cardDetails && favoriteGuest.identification" class="flex items-center mb-1 col-span-2 text-primary">
            <i class="fa-regular fa-square-check mr-4"></i>
            <p>Solicitar foto o id</p>
          </div>
          <div
            v-if="favoriteGuest.vehicle_details?.length > 0"
            @click="showVehicles = !showVehicles"
            class="flex items-center mb-1 cursor-pointer"
          >
            <i class="fa-solid fa-car mr-4"></i>
            <p>Datos del vehículo(s) registrado(s)</p>
            <i
              class="fa-solid fa-angle-up transform origin-center transition duration-200 ease-out ml-5"
              :class="{ '!rotate-180': showVehicles }"
            ></i>
          </div>
        </section>
        <section>
          <p class="mb-1">{{ favoriteGuest.type }}</p>
          <p class="mb-1">{{ favoriteGuest.notes ?? '-' }}</p>
        </section>

        <!-- --------- info vehículos ----------- -->
        <div v-for="(vehicle, index) in favoriteGuest.vehicle_details" :key="index"
          v-if="showVehicles"
          class="rounded-md bg-[#F2F2F2] col-span-2 mx-auto w-4/5 px-2 py-2 space-y-2 text-xs mt-1"
        >
          <div @click="vehicleDetails[index] = !vehicleDetails[index]" class="flex justify-between items-center cursor-pointer">
            <p class="text-gray-800 text-center font-bold ml-3">Vehículo {{ index + 1 }}</p>
            <i
              class="fa-solid fa-angle-up transform origin-center transition duration-200 ease-out ml-5"
              :class="{ '!rotate-180': vehicleDetails[index] }"
            ></i>
          </div>
          <section v-if="vehicleDetails[index]">
            <div class="border border-[#CCCCCC] border-dashed w-full"></div>
            <p class="text-gray-400 text-center">Foto del vehículo</p>
            <figure v-if="favoriteGuest.media_vehicle?.length > 0" class="w-48 h-32 rounded-xl mx-auto">
              <img class="object-contain bg-no-repeat h-32 rounded-lg" :src="favoriteGuest.media_vehicle[index]?.original_url" alt="Sin imagen" />
            </figure>
            <div class="w-48 h-32 rounded-xl flex border border-dashed border-gray2 mx-auto" v-else></div>
            <div
              class="w-full border-b border-dashed border-[#CCCCCC] mt-2 flex justify-between"
            >
              <p class="pl-9 text-gray-500">Marca</p>
              <p class="pr-9">{{ vehicle.brand }}</p>
            </div>
            <div
              class="w-full border-b border-dashed border-[#CCCCCC] mt-2 flex justify-between"
            >
              <p class="pl-9 text-gray-500">Modelo</p>
              <p class="pr-9">{{ vehicle.model }}</p>
            </div>
            <div
              class="w-full border-b border-dashed border-[#CCCCCC] mt-2 flex justify-between"
            >
              <p class="pl-9 text-gray-500">Color</p>
              <p class="pr-9">{{ vehicle.color }}</p>
            </div>
            <div
              class="w-full border-b border-dashed border-[#CCCCCC] mt-2 flex justify-between"
            >
              <p class="pl-9 text-gray-500">Placas</p>
              <p class="pr-9">{{ vehicle.plate }}</p>
            </div>
          </section>
        </div>
      </div>
        <div class="text-center mt-3">
          <PrimaryButton @click="ShowGuestFormModal = true; form.name = favoriteGuest.name">Programar visita</PrimaryButton>
        </div>
    </div>
  </div>

  <!-- Programar visita desde tarjeta de visitante frecuente -------------------------------------------------->
  <Modal :show="ShowGuestFormModal"
        @close="ShowGuestFormModal = false">
        <div class="mx-7 my-4 space-y-4 relative">
          <div @click="ShowGuestFormModal = false"
            class="cursor-pointer w-5 h-5 rounded-full border-2 border-black flex items-center justify-center absolute top-0 -right-2">
            <i class="fa-solid fa-xmark"></i>
          </div>

          <h1>Programar visita frecuente</h1>

          <section class="lg:grid grid-cols-2">
            <!-- Primer mitad del grid del formulariovisita frecuente ------------------ -->
            <div>
              <figure v-if="favoriteGuest.media_guest?.length > 0" class="bg-[#F2F2F2] w-44 h-36 rounded-sm">
                <img class="object-contain bg-no-repeat w-44 h-36" :src="favoriteGuest?.media_guest[0]?.original_url" alt="" />
              </figure>
              <div class="bg-[#F2F2F2] w-44 h-36 rounded-sm flex justify-center items-center" v-else><i class="fa-regular fa-user text-4xl text-gray3"></i></div>
              <p class="font-bold text-center w-44 mt-1">{{ favoriteGuest?.name }}</p>

                <div class="mt-7">
                  <InputLabel value="Fecha de la visita*" class="ml-3 mb-1" />
                  <el-date-picker v-model="form.visit_date" type="date" placeholder="Seleccione" :disabled-date="disabledDate" />
                  <InputError :message="form.errors.visit_date" />
                </div>

                <div class="mt-2">
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
            </div>

            <!-- segunda mitad del grid del formulariovisita frecuente ------------------ -->
            <div>
              <div>
                <InputLabel value="Tipo de acceso*" class="ml-3 mb-1 mt-7 lg:mt-0" />
                <el-select class="w-full" v-model="form.guest_type" clearable
                    placeholder="Seleccione" no-data-text="No hay opciones registradas"
                    no-match-text="No se encontraron coincidencias">
                    <el-option v-for="item in guestTypes" :key="item" :label="item" :value="item" />
                </el-select>
                <InputError :message="form.errors.guest_type" />
              </div>

              <div v-if="form.guest_type == 'Vehicular'" class="border border-[#D9D9D9] rounded-sm mt-2 py-3 px-5">
                <div class="flex justify-between items-center text-sm mb-3">
                  <p class="font-bold">Selecciona el vehículo</p>
                  <el-tooltip
                    content="Selecciona el vehículo en el que vendrá tu visita"
                    placement="top">
                    <div class="rounded-full border border-primary w-3 h-3 flex items-center justify-center">
                      <i class="fa-solid fa-info text-primary text-[7px]"></i>
                    </div>
                  </el-tooltip>
                </div>
                <p v-if="!favoriteGuest?.vehicle_details" class="text-xs text-red-600">Tu visita frecuente no tiene vehículos registrados*</p>
                <!-- --------- info vehículos ----------- -->
                <div v-for="(vehicle, index) in favoriteGuest?.vehicle_details" :key="index"
                  class="rounded-md bg-[#F2F2F2] col-span-2 mx-auto w-full px-2 py-2 space-y-2 text-xs mt-1"
                >
                  <div @click="vehicleDetails[index] = !vehicleDetails[index]" class="flex justify-between items-center cursor-pointer relative">
                    <input v-model="selectedVehicleIndex" :value="index" @click.stop="" @change="saveVehicleDetails" class="absolute left-0 bg-transparent checked:text-primary active:text-primary focus:ring-primary transition duration-300 ease-out" type="radio" name="selectedVehicle">
                    <p class="text-gray-800 text-center font-bold ml-7">Vehículo {{ index + 1 }}</p>
                    <i
                      class="fa-solid fa-angle-up transform origin-center transition duration-200 ease-out ml-5"
                      :class="{ '!rotate-180': vehicleDetails[index] }"
                    ></i>
                  </div>
                  <section v-if="vehicleDetails[index]">
                    <div class="border border-[#CCCCCC] border-dashed w-full"></div>
                    <p class="text-gray-400 text-center">Foto del vehículo</p>
                    <figure v-if="favoriteGuest?.media_vehicle?.length > 0" class="w-48 h-32 rounded-xl mx-auto">
                      <img class="object-contain bg-no-repeat h-32 rounded-lg" :src="favoriteGuest?.media_vehicle[index]?.original_url" alt="Sin imagen" />
                    </figure>
                    <div class="w-48 h-32 rounded-xl flex border border-dashed border-gray2 mx-auto" v-else></div>
                    <div
                      class="w-full border-b border-dashed border-[#CCCCCC] mt-2 flex justify-between"
                    >
                      <p class="pl-9 text-gray-500">Marca</p>
                      <p class="pr-9">{{ vehicle.brand }}</p>
                    </div>
                    <div
                      class="w-full border-b border-dashed border-[#CCCCCC] mt-2 flex justify-between"
                    >
                      <p class="pl-9 text-gray-500">Modelo</p>
                      <p class="pr-9">{{ vehicle.model }}</p>
                    </div>
                    <div
                      class="w-full border-b border-dashed border-[#CCCCCC] mt-2 flex justify-between"
                    >
                      <p class="pl-9 text-gray-500">Color</p>
                      <p class="pr-9">{{ vehicle.color }}</p>
                    </div>
                    <div
                      class="w-full border-b border-dashed border-[#CCCCCC] mt-2 flex justify-between"
                    >
                      <p class="pl-9 text-gray-500">Placas</p>
                      <p class="pr-9">{{ vehicle.plate }}</p>
                    </div>
                  </section>
                </div>
              </div>
              <div class="mt-3">
                <InputLabel value="Notas" class="ml-3 mb-1" />
                <textarea v-model="form.notes" class="textarea" rows="3"></textarea>
                <InputError :message="form.errors.notes" />
              </div>
            </div>
          </section>

          <div class="flex justify-end space-x-1 pt-5 pb-1">
            <CancelButton @click="form.reset(); ShowGuestFormModal = false">Cancelar</CancelButton>  
            <PrimaryButton :disabled="form.guest_type == 'Vehicular' && !favoriteGuest?.vehicle_details" @click="store">Continuar</PrimaryButton>
          </div>
        </div>
      </Modal>
</template>

<script>
import PrimaryButton from "@/Components/PrimaryButton.vue";
import Modal from "@/Components/Modal.vue";
import CancelButton from "@/Components/MyComponents/CancelButton.vue";
import Checkbox from "@/Components/Checkbox.vue";
import { useForm } from "@inertiajs/vue3";
import axios from 'axios';

export default {
data(){
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
      plate: null,
    },
    guest_image: null,
    vehicle_image: null,
    qr_code: null,
  });
    return {
        form,
        showVehicles: false,
        ShowGuestFormModal: false,
        vehicleDetails: Array.from({ length: this.favoriteGuest.vehicle_details?.length }, () => false),
        guestTypes: ["Peatonal", "Vehicular"],
    }
},
components:{
PrimaryButton,
CancelButton,
Checkbox,
Modal
},
props:{
favoriteGuest: Object
},
methods:{
  store() {
     if (this.form.guest_type == 'Peatonal'){ //si no es vehicular el json de vehicle_details es null para no guardar el formato en la bd.
        this.form.vehicle_details = null;
     }
    this.form.post(route("guests.store"), {
      onSuccess: () => {
        this.$notify({
          title: "Correcto",
          message: "Se ha programado tu visita",
          type: "success",
        });
        this.ShowGuestFormModal = false;
        this.$inertia.get(route('guests.index'));
      },
    });
  },
  async deleteGuest() {
    try {
      const response = await axios.delete(route('favorite-guests.destroy', this.favoriteGuest.id));

      if (response.status === 200) {
        const deletedItemId = response.data.item.id;

         // Emitir un evento al componente padre
        this.$emit('favoriteGuestDeleted', deletedItemId);

        this.$notify({
          title: "Correcto",
          message: "Se ha eliminado el registro de visita",
          type: "success",
        });
      }
    } catch (error) {
      console.log(error);
    }
  },
  disabledDate(time) {
    const today = new Date();
    today.setHours(0, 0, 0, 0);
    return time.getTime() < today.getTime();
  }, 
}
};
</script>


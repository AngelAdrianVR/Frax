<template>
  <div
    class="rounded-md shadow-md shadow-gray-200 border border-[#D9D9D9] text-sm transition duration-300 ease-out self-start pb-3"
  >
    <div class="px-3 py-3">
      <div class="flex justify-between">
        <i class="fa-solid fa-star text-lg text-[#EEF317]"></i>
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
          <PrimaryButton>Programar visita</PrimaryButton>
        </div>
    </div>
  </div>
</template>

<script>
import PrimaryButton from "@/Components/PrimaryButton.vue";
import axios from 'axios';

export default {
data(){
    return {
        showVehicles: false,
        vehicleDetails: Array.from({ length: this.favoriteGuest.vehicle_details?.length }, () => false),
    }
},
components:{
PrimaryButton,
},
props:{
favoriteGuest: Object
},
methods:{
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
  }
}
};
</script>

<style></style>

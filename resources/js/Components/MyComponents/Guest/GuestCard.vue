<template>
  <div
    class="rounded-md shadow-md shadow-gray-200 border border-[#D9D9D9] text-sm transition duration-300 ease-out relative self-start"
  >
    <div class="px-5 py-3">
      <div class="flex items-center space-x-2 absolute top-2 right-2">
        <el-popconfirm confirm-button-text="Si" cancel-button-text="No" icon-color="#D90537" title="¿Eliminar?"
          @confirm="deleteGuest">
          <template #reference>
          <i class="fa-regular fa-trash-can bg-[#F2F2F2] rounded-md p-2 cursor-pointer"></i>
          </template>
        </el-popconfirm>
        <PrimaryButton @click="$inertia.get(route('guests.edit', guest.id))" v-if="!guest.arrived_at" class="rounded-md !py-1">Editar</PrimaryButton>
      </div>
      <!-- -----------photo--------- -->
      <div class="flex space-x-2">
        <figure v-if="guest.media_guest?.length > 0" class="bg-[#F2F2F2] w-44 h-36 rounded-sm">
          <img class="object-contain bg-no-repeat w-44 h-36" :src="guest.media_guest[0]?.original_url" alt="" />
        </figure>
        <div class="bg-[#F2F2F2] w-44 h-36 rounded-sm flex justify-center items-center" v-else><i class="fa-regular fa-user text-4xl text-gray3"></i></div>
        <div class="flex flex-col items-center justify-center pl-9">
          <p class="font-semibold">{{ guest.name }}</p>
        </div>
      </div>
      <!-- -------------- info ------- -->
      <div class="mt-4 grid grid-cols-2">
        <section>
          <div class="flex items-center mb-1">
            <i class="fa-solid fa-calendar-days mr-4"></i>
            <p>Fecha de la visita</p>
          </div>
          <div class="flex items-center mb-1">
            <i class="fa-regular fa-clock mr-4"></i>
            <p>Hora</p>
          </div>
          <div v-if="cardDetails" class="flex items-center mb-1">
            <i class="fa-solid fa-arrow-right-to-bracket mr-4"></i>
            <p>Tipo de acceso</p>
          </div>
          <div v-if="cardDetails" class="flex items-center mb-1">
            <i class="fa-regular fa-file-lines mr-4"></i>
            <p>Notas</p>
          </div>
          <div v-if="cardDetails && guest.identification" class="flex items-center mb-1 mt-4 col-span-2 text-primary">
            <i class="fa-regular fa-square-check mr-4"></i>
            <p>Solicitar foto o id</p>
          </div>
          <div
            v-if="cardDetails && guest.vehicle_details"
            @click="vehicleDetails = !vehicleDetails"
            class="flex items-center mb-1 cursor-pointer"
          >
            <i class="fa-solid fa-car mr-4"></i>
            <p>Datos del vehículo</p>
            <i
              class="fa-solid fa-angle-up transform origin-center transition duration-200 ease-out ml-5"
              :class="{ '!rotate-180': vehicleDetails }"
            ></i>
          </div>
        </section>
        <section>
          <p class="mb-1">{{ guest.visit_date }}</p>
          <p class="mb-1">{{ guest.time }}</p>
          <p v-if="cardDetails" class="mb-1">{{ guest.type }}</p>
          <p v-if="cardDetails" class="mb-1">{{ guest.notes }}</p>
        </section>
        <div
          v-if="vehicleDetails && cardDetails"
          class="rounded-md bg-[#F2F2F2] col-span-2 mx-auto w-4/5 px-2 py-4 space-y-2 text-xs"
        >
          <p class="text-gray-400 text-center">Foto del vehiculo</p>
          <figure v-if="guest.media_vehicle?.length > 0" class="w-48 h-32 rounded-xl mx-auto">
            <img class="object-contain bg-no-repeat h-32 rounded-lg" :src="guest.media_vehicle[0]?.original_url" alt="Sin imagen" />
          </figure>
          <div class="w-48 h-32 rounded-xl flex border border-dashed border-gray2 mx-auto" v-else></div>
          <div
            class="w-full border-b border-dashed border-[#CCCCCC] mt-2 flex justify-between"
          >
            <p class="pl-9 text-gray-500">Marca</p>
            <p class="pr-9">{{ guest.vehicle_details?.brand }}</p>
          </div>
          <div
            class="w-full border-b border-dashed border-[#CCCCCC] mt-2 flex justify-between"
          >
            <p class="pl-9 text-gray-500">Modelo</p>
            <p class="pr-9">{{ guest.vehicle_details?.model }}</p>
          </div>
          <div
            class="w-full border-b border-dashed border-[#CCCCCC] mt-2 flex justify-between"
          >
            <p class="pl-9 text-gray-500">Color</p>
            <p class="pr-9">{{ guest.vehicle_details?.color }}</p>
          </div>
          <div
            class="w-full border-b border-dashed border-[#CCCCCC] mt-2 flex justify-between"
          >
            <p class="pl-9 text-gray-500">Placas</p>
            <p class="pr-9">{{ guest.vehicle_details?.plate }}</p>
          </div>
        </div>
      </div>
    </div>
    <div
      @click="cardDetails = !cardDetails"
      class="flex items-center text-primary font-bold cursor-pointer mx-5"
    >
      <p>{{ cardDetails ? "Ocultar" : "Ver más" }}</p>
      <i
        class="fa-solid fa-angle-up transform origin-center transition duration-200 ease-out ml-5"
        :class="{ '!rotate-180': cardDetails }"
      ></i>
    </div>
    <div class="w-full border-b border-dashed border-[#CCCCCC]"></div>
    <div class="px-5 py-3">
      <div class="flex items-center mb-3">
        <i class="fa-solid fa-list-check mr-3"></i>
        <p class="font-bold">Registro de caseta</p>
      </div>
      <div v-if="guest.arrived_at">
        <div v-if="guest.arrived_at" class="flex items-center text-primary">
          <i class="fa-solid fa-check mr-3"></i>
          <p>Ingreso {{ guest.arrived_at }}</p>
        </div>
        <div v-if="guest.leaved_at" class="flex items-center text-primary">
          <i class="fa-solid fa-check mr-3"></i>
          <p>Salida {{ guest.leaved_at }}</p>
        </div>
      </div>
      <p class="text-xs text-gray-400" v-else>No hay registro en caseta</p>
    </div>
  </div>
  
</template>

<script>
import PrimaryButton from "@/Components/PrimaryButton.vue";
import axios from 'axios';

export default {
data(){
    return {
        cardDetails: false,
        vehicleDetails: false,
    }
},
components:{
PrimaryButton,
},
props:{
guest: Object
},
methods:{
  async deleteGuest() {
    try {
      const response = await axios.delete(route('guests.destroy', this.guest.id));

      if (response.status === 200) {
        const deletedItemId = response.data.item.id;

         // Emitir un evento al componente padre
        this.$emit('guestDeleted', deletedItemId);

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

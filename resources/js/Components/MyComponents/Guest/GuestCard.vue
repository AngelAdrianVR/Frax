<template>
  <div
    class="rounded-md shadow-md shadow-gray-200 border border-[#D9D9D9] text-sm transition duration-300 ease-out relative self-start"
  >
    <div class="px-5 py-3">
      <div class="flex items-center space-x-2 absolute top-2 right-2">
        <i class="fa-regular fa-trash-can bg-[#F2F2F2] rounded-md p-2 cursor-pointer"></i>
        <PrimaryButton class="rounded-md !py-1">Editar</PrimaryButton>
      </div>
      <!-- -----------photo--------- -->
      <div class="flex justify-between space-x-2">
        <figure class="bg-[#F2F2F2] w-44 h-36 rounded-sm">
          <img src="" alt="" />
        </figure>
        <div class="flex flex-col items-center justify-center">
          <p class="font-semibold ">{{ guest.name }}</p>
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
          <div v-if="cardDetails" class="flex items-center mb-1 col-span-2 text-primary">
            <i class="fa-regular fa-square-check mr-4"></i>
            <p>Solicitar foto o id del visitante</p>
          </div>
          <div
            v-if="cardDetails"
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
          <p class="mb-1">05:35 PM</p>
          <p v-if="cardDetails" class="mb-1">{{ guest.type }}</p>
          <p v-if="cardDetails" class="mb-1">{{ guest.notes }}</p>
        </section>
        <div
          v-if="vehicleDetails && cardDetails"
          class="rounded-md bg-[#F2F2F2] col-span-2 mx-auto w-4/5 px-2 py-4 space-y-2 text-xs"
        >
          <p class="text-gray-400 text-center">Foto del vehiculo</p>
          <figure class="w-2/3 h-32 rounded-xl border border-[#CCCCCC] mx-auto">
            <img src="" alt="" />
          </figure>
          <div
            class="w-full border-b border-dashed border-[#CCCCCC] mt-2 flex justify-between"
          >
            <p class="pl-9 text-gray-500">Marca</p>
            <p class="pr-9">{{ guest.vehicle_details?.branch }}</p>
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
      class="flex items-center text-primary font-bold cursor-pointer lg:mx-5"
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
      <div v-if="guest.arrived_at" class="flex items-center text-primary">
        <i class="fa-solid fa-check mr-3"></i>
        <p>Ingreso {{ guest.arrived_at }}</p>
      </div>
      <div v-if="guest.leaved_at" class="flex items-center text-primary">
        <i class="fa-solid fa-check mr-3"></i>
        <p>Salida {{ guest.leaved_at }}</p>
      </div>
    </div>
  </div>
  
</template>

<script>
import PrimaryButton from "@/Components/PrimaryButton.vue";

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

}
};
</script>

<style></style>

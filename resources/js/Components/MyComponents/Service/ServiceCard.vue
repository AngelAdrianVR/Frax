<template>
  <div
    class="mt-20 rounded-lg border-2 border-transparent hover:border-cyan-600 transition ease-in-out duration-200 bg-transparet"
  >
    <div class="bg-gray-100 shadow-md rounded-md px-2 py-3">
      <!-- component -->
      <div
        class="bg-gray-100 font-sans w-full flex flex-row justify-center items-center"
      >
        <div class="w-96 mx-auto bg-white shadow-xl hover:shadow">
          <img
            :class="service.is_active ? 'border-gray-200' : 'border-red-400'"
            class="w-32 mx-auto rounded-full -mt-20 border-4"
            src="https://avatars.githubusercontent.com/u/67946056?v=4"
            alt=""
          />
          <div class="text-center mt-1 text-2xl font-medium">{{service.name}}</div>
          <div class="text-center font-normal text-sm my-3"><i class="fa-solid fa-phone text-gray-600"></i><i class="fa-brands fa-whatsapp ml-1 text-green-600"></i> {{service.phone}}</div>
          <div class="mx-2 rounded-lg py-1 my-1 border">
            <div class="px-6 text-center mt-1 font-light text-sm">
              <p>{{service.description}}</p>
            </div>
          </div>
          <div class="mx-2 pb-1 rounded-lg border text-gray-700">
            <p v-if="service.social_networks != null" class="text-center pt-1 mt-2 text-gray-800 font-bold">Redes sociales</p>
            <p v-if="service.social_networks == null" class="text-center pt-1 mt-2 text-gray-800 font-bold">Sin redes sociales</p>
            <div v-if="service.social_networks?.website" class="text-center mt-1 font-light text-sm"><i class="fa-solid fa-earth-americas text-gray-500"></i> <a target="blank" class="inline-block py-1" :href="service.social_networks?.website"> {{service.social_networks?.website}}</a></div>
            <div v-if="service.social_networks?.facebook" class="text-center mt-1 font-light text-sm"><i class="fa-brands fa-facebook text-blue-600"></i> <a target="blank" class="inline-block py-1" :href="service.social_networks?.facebook"> {{service.social_networks?.facebook}}</a></div>
            <div v-if="service.social_networks?.instagram" class="text-center mt-1 font-light text-sm"><i class="fa-brands fa-instagram bg-gradient-to-tl from-orange-400 to-violet-500 text-gray-200"></i> <a target="blank" class="inline-block py-1" :href="service.social_networks?.facebook"> {{service.social_networks?.instagram}}</a></div>
            <div v-if="service.social_networks?.tiktok" class="text-center mt-1 font-light text-sm"><i class="fa-brands fa-tiktok"></i> <a target="blank" class="inline-block py-1" :href="service.social_networks?.facebook"> {{service.social_networks?.tiktok}}</a></div>
            <div v-if="service.social_networks?.x" class="text-center mt-1 font-light text-sm"><i class="fa-brands fa-x-twitter text-black"></i> <a target="blank" class="inline-block py-1" :href="service.social_networks?.x"> {{service.social_networks?.x}}</a></div>
          </div>
          <hr class="mt-8" />
          <div class="flex p-4">
            <div class="w-1/2 text-center">
              <SecondaryButton>Otra</SecondaryButton>
            </div>
            <div class="w-0 border border-gray-300"></div>
            <div class="w-1/2 text-center">
              <PrimaryButton>Solicitar</PrimaryButton>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";

export default {
  props: {
    service: Object,
  },
  components: {
    PrimaryButton,
    SecondaryButton,
  },
};
</script>

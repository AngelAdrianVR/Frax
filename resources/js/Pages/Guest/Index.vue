<template>
  <AppLayout title="Visitantes">
    <!-- ------------- tabs section starts ------------- -->
    <div class="border-y-2 border-[#D9D9D9] items-center py-2">
      <div class="flex lg:ml-20">
        <Tab
          @click="currentTab = index + 1"
          :label="tab"
          :active="currentTab == index + 1"
          v-for="(tab, index) in tabs"
          :key="index"
        />
      </div>
    </div>
    <!-- ------------- tabs section ends ------------- -->

    <!-- ------------- tab 1 section visitas programadas starts ------------- -->
    <div class="p-4" v-if="currentTab == 1">
      <div class="flex justify-between lg:mx-12">
        <h2 class="font-bold">Hoy</h2>
        <PrimaryButton>Programar visita</PrimaryButton>
      </div>
      <div class="mt-4 lg:mx-12">
        <div class="grid grid-cols-3 gap-5">
          <GuestCard v-for="guest in guests.data" :key="guest" :guest="guest" />
        </div>
      </div>
    </div>
    <!-- ------------- tab 1 section visitas programadas ends ------------- -->
  </AppLayout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { Link } from "@inertiajs/vue3";
import Tab from "@/Components/MyComponents/Tab.vue";
import GuestCard from "@/Components/MyComponents/Guest/GuestCard.vue";

export default {
  data() {
    return {
      currentTab: 1,
      tabs: ["Visitas programadas", "Visitas frecuentes", "Historial"],
    };
  },
  components: {
    AppLayout,
    PrimaryButton,
    GuestCard,
    Link,
    Tab,
  },
  props: {
    guests: Object
  },
  methods: {},
};
</script>

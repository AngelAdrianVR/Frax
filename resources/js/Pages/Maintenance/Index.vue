<template>
    <AppLayout title="Mantenimientos">
        <header class="flex items-center justify-between mb-2 mt-12 mx-2 lg:mx-20">
            <h1 class="font-bold text-sm">Reporte de problemáticas</h1>
            <Link :href="route('maintenances.create')">
                <PrimaryButton>Hacer reporte</PrimaryButton>
            </Link>
        </header>
        <p class="mx-2 lg:mx-20 text-sm">En este apartado se puede reportar algun problema que se presente en alguna área
            común, en caso de que ya se haya echo el reporte, ver el estatus en el que se encuentra </p>
        <div class="mt-4 mx-2 lg:mx-20 lg:grid grid-cols-3 gap-6">
            <MaintenanceCard v-for="item in maintenances" :key="item.id" :maintenance="item" />
        </div>
    </AppLayout>
</template>
  
<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import MaintenanceCard from "@/Components/MyComponents/Maintenance/MaintenanceCard.vue";
import { Link } from "@inertiajs/vue3";

export default {
    data() {
        return {
          
        };
    },
    components: {
        AppLayout,
        Link,
        MaintenanceCard,
        PrimaryButton,
    },
    props: {
        maintenances: Array,
    },
    methods: {

    },
};
</script>
  
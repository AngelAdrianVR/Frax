<template>
    <AppLayout title="Detalles de mantenimiento">
        <header class="mx-10 my-6">
            <Back />
        </header>
        <section class="grid grid-cols-3 gap-3 lg:mx-48 text-sm">
            <article class="col-span-2">
                <h1 class="font-bold">{{ maintenance.name }}</h1>
                <div class="grid grid-cols-4 gap-x-3 gap-y-1 mt-3">
                    <span>Creado por</span>
                    <span class="col-span-3">{{ maintenance.user.name }}</span>
                    <span>Fecha de reporte</span>
                    <span class="col-span-3">{{ maintenance.user.name }}</span>
                    <span>Ubicación</span>
                    <span class="col-span-3">{{ maintenance.user.name }}</span>
                    <span>Descripción</span>
                    <span class="col-span-3">{{ maintenance.user.name }}</span>
                    <span>Estatus</span>
                    <span class="col-span-3">{{ maintenance.user.name }}</span>
                </div>
            </article>
            <article>
                <div class="flex justify-end mb-3 space-x-1">
                    <button class="rounded-full bg-gray5 flex justify-center items-center w-7 h-7 text-xs"><i class="fa-regular fa-trash-can"></i></button>
                    <button class="rounded-full bg-gray5 flex justify-center items-center w-7 h-7 text-xs"><i class="fa-solid fa-pencil"></i></button>
                </div>
                <figure class="bg-gray-100">
                    <img :src="maintenance.media[0]?.original_url" class="rounded-[5px]">
                </figure>
            </article>
        </section>
    </AppLayout>
</template>
  
<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import MaintenanceCard from "@/Components/MyComponents/Maintenance/MaintenanceCard.vue";
import Back from "@/Components/MyComponents/Back.vue";
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
        Back,
    },
    props: {
        maintenance: Object,
    },
    methods: {

    },
};
</script>
  
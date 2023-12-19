<template>
    <AppLayout title="Detalles de mantenimiento">
        <header class="mx-10 my-6">
            <Back />
        </header>
        <main class="lg:mx-48 text-sm">
            <section class="grid grid-cols-3 gap-x-14 gap-y-2 border-b border-dashed pb-10 border-gray4">
                <article class="col-span-2">
                    <h1 class="font-bold">{{ maintenance.name }}</h1>
                    <div class="grid grid-cols-4 gap-x-10 gap-y-3 mt-3">
                        <span>Creado por</span>
                        <span class="col-span-3">{{ maintenance.user.name }}</span>
                        <span>Fecha de reporte</span>
                        <span class="col-span-3">{{ maintenance.created_at }}</span>
                        <span>Ubicación</span>
                        <span class="col-span-3">{{ maintenance.location }}</span>
                        <span>Descripción</span>
                        <span class="col-span-3">{{ maintenance.description }}</span>
                        <span>Estatus</span>
                        <el-steps :active="maintenance.status" finish-status="success" class="col-span-3 w-1/3  ">
                            <el-tooltip placement="top">
                                <template #content>
                                    <b>Reporte enviado</b> <br>
                                    <p>Estamos evaluando la situación</p>
                                </template>
                                <el-step />
                            </el-tooltip>
                            <el-tooltip placement="top">
                                <template #content>
                                    <b>En proceso</b> <br>
                                    <p>
                                        El mantenimiento esta en marcha. <br>
                                        Nuestro equipo está trabajando para <br>
                                        resolver la situación reportada
                                    </p>
                                </template>
                                <el-step />
                            </el-tooltip><el-tooltip placement="top">
                                <template #content>
                                    <b>Mantenimiento completo</b> <br>
                                    <p>La situación ha sido abordada y resuelta</p>
                                </template>
                                <el-step />
                            </el-tooltip>
                        </el-steps>
                        <span v-if="maintenance.finished_at">Fecha de término</span>
                        <span v-if="maintenance.finished_at" class="col-span-3">{{ maintenance.finished_at }}</span>
                    </div>
                </article>
                <article>
                    <div class="flex justify-end mb-3 space-x-1">
                        <button class="rounded-full bg-gray5 flex justify-center items-center w-7 h-7 text-xs"><i
                                class="fa-regular fa-trash-can"></i></button>
                        <button class="rounded-full bg-gray5 flex justify-center items-center w-7 h-7 text-xs"><i
                                class="fa-solid fa-pencil"></i></button>
                    </div>
                    <figure class="bg-gray-100">
                        <img :src="maintenance.media[0]?.original_url" class="rounded-[5px]">
                    </figure>
                </article>
            </section>
            <section class="mt-8">
                <h1 class="flex items-center space-x-3 font-bold">
                    <i class="fa-regular fa-comment"></i>
                    <span>Comentarios</span>
                    <span class="text-gray1">({{ '0' }})</span>
                </h1>
                <article class="mt-6">
                    <div class="flex items-start space-x-8 mb-5">
                        <figure class="flex text-sm border-2 rounded-full w-12">
                            <img class="h-8 w-8 rounded-full object-cover" :src="$page.props.auth.user.profile_photo_url"
                                :alt="$page.props.auth.user.name">
                        </figure>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Vel odio dolorum qui culpa ullam quasi
                            eaque nulla voluptatum! Doloremque dicta neque laborum perferendis doloribus et esse quidem odit
                            alias. Ut!</p>
                    </div>
                    <MakeComment />
                </article>
            </section>
        </main>
    </AppLayout>
</template>
  
<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import MaintenanceCard from "@/Components/MyComponents/Maintenance/MaintenanceCard.vue";
import MakeComment from "@/Components/MyComponents/MakeComment.vue";
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
        MakeComment,
    },
    props: {
        maintenance: Object,
    },
    methods: {

    },
};
</script>
  
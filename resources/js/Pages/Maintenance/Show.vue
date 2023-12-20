<template>
    <AppLayout title="Detalles de mantenimiento">
        <header class="mx-10 my-6">
            <Back />
        </header>
        <main class="lg:mx-48 text-sm pb-6">
            <section class="grid grid-cols-3 gap-x-14 gap-y-2 border-b border-dashed pb-10 border-gray4">
                <article class="col-span-2">
                    <h1 class="font-bold">{{ maintenance.name }}</h1>
                    <div class="grid grid-cols-4 gap-x-10 gap-y-3 mt-5">
                        <span>Creado por</span>
                        <span class="col-span-3">{{ maintenance.is_anonymous_report ? 'Anónimo' : maintenance.user.name }}</span>
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
                        <div v-if="maintenance.finished_at" class="flex items-center space-x-1">
                            <span>Fecha de término</span>
                            <el-tooltip placement="top">
                                <template #content>
                                    Fecha estimada para la resolución del reporte. <br>
                                    Ten en cuenta que esta fecha es tentativa <br>
                                    y puede ajustarse según el progreso en abordar <br>
                                    la situación reportada.
                                </template>
                                <div class="rounded-full border border-primary w-3 h-3 flex items-center justify-center">
                                    <i class="fa-solid fa-info text-primary text-[7px]"></i>
                                </div>
                            </el-tooltip>
                        </div>
                        <span v-if="maintenance.finished_at" class="col-span-3">{{ maintenance.finished_at }}</span>
                    </div>
                </article>
                <article>
                    <div v-if="maintenance.status == 0 && maintenance.user_id == $page.props.auth.user.id" class="flex justify-end mb-3 space-x-1">
                        <el-popconfirm confirm-button-text="Si" cancel-button-text="No" icon-color="#D90537"
                            title="¿Continuar?" @confirm="true">
                            <template #reference>
                                <button class="rounded-full bg-gray5 flex justify-center items-center w-7 h-7 text-xs"><i
                                        class="fa-regular fa-trash-can"></i></button>
                            </template>
                        </el-popconfirm>
                        <button @click="$inertia.get(route('maintenances.edit', maintenance))" class="rounded-full bg-gray5 flex justify-center items-center w-7 h-7 text-xs"><i
                                class="fa-solid fa-pencil"></i></button>
                    </div>
                    <article>
                        <figure class="bg-gray5 rounded-[3px] py-2">
                            <Carousel :wrap-around="true" v-model="currentManteinanceMedia">
                                <Slide v-for="media in maintenance.media" :key="media.id">
                                    <img class="object-contain" :src="media.original_url">
                                </Slide>
                            </Carousel>
                        </figure>
                        <div class="flex justify-center space-x-2 mt-2">
                            <button v-for="image in maintenance.media.length" :key="image"
                                @click="currentManteinanceMedia = image" class="w-2 h-2 rounded-full"
                                :class="currentManteinanceMedia == image ? 'bg-secondary' : 'bg-gray4'"></button>
                        </div>
                    </article>
                </article>
            </section>
            <section v-if="maintenance.evidence.length"
                class="grid grid-cols-3 gap-x-14 gap-y-2 border-b border-dashed pb-10 border-gray4">
                <article class="col-span-2 pt-10">
                    <h1 class="flex items-center space-x-3 font-bold text-secondary">
                        <i class="fa-solid fa-eye"></i>
                        <span>Evidencias</span>
                    </h1>
                    <div class="grid grid-cols-4 gap-x-10 gap-y-3 mt-5">
                        <span>Descripción del mantenimiento</span>
                        <span class="col-span-3">{{ maintenance.evidence?.description }}</span>
                    </div>
                </article>
                <article>
                    <figure class="bg-gray5 rounded-[3px] mt-8 py-2">
                        <Carousel :wrap-around="true" v-model="currentEvidenceMedia">
                            <Slide v-for="media in maintenance.evidence[0]?.media" :key="media.id">
                                <img :src="media.original_url">
                            </Slide>
                        </Carousel>
                    </figure>
                    <div class="flex justify-center space-x-2 mt-2">
                        <button v-for="image in maintenance.media.length" :key="image" @click="currentEvidenceMedia = image"
                            class="w-2 h-2 rounded-full"
                            :class="currentEvidenceMedia == image ? 'bg-secondary' : 'bg-gray4'"></button>
                    </div>
                </article>
            </section>
            <section class="mt-8">
                <h1 class="flex items-center space-x-3 font-bold text-secondary">
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
import { Carousel, Slide } from 'vue3-carousel';
import 'vue3-carousel/dist/carousel.css';

export default {
    data() {
        return {
            currentManteinanceMedia: 0,
            currentEvidenceMedia: 0,
        };
    },
    components: {
        AppLayout,
        Link,
        MaintenanceCard,
        PrimaryButton,
        Back,
        MakeComment,
        Carousel,
        Slide,
    },
    props: {
        maintenance: Object,
    },
    methods: {

    },
};
</script>
  
<template>
    <div class="border border-gray4 rounded-[5px] group pt-4 bg-transparent h-[300px]">
        <figure class="rounded-[5px] h-[60%] mx-3">
            <img :src="maintenance.media[0]?.original_url" class="rounded-[5px] h-full mx-auto">
        </figure>
        <div class="flex justify-between items-center font-bold h-[11%] px-4 text-sm">
            <h2 class="font-bold">
                <i class="mr-1 text-gray1" :class="problemTypes.find(item => item.label == maintenance.name)?.icon"></i>
                {{ maintenance.name }}
            </h2>
            <span class="text-gray1">
                <i class="fa-regular fa-comment mr-px"></i>
                {{ maintenance.comments_count }}
            </span>
        </div>
        <div class="h-[17%] w-1/3 pt-4 mx-auto">
            <el-steps :active="maintenance.status" finish-status="success">
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
        </div>
        <div class="h-[12%] flex">
            <button @click="$inertia.get(route('maintenances.show', maintenance))"
                class="text-sm text-primary bg-primarylight w-full py-1 rounded-b-[5px] opacity-0 group-hover:opacity-100 transition-opacity duration-300 ease-in-out">
                Ver más
            </button>
        </div>
    </div>
</template>
  
<script>
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { Link } from "@inertiajs/vue3";

export default {
    data() {
        return {
            problemTypes: [
                {
                    label: "Áreas verdes",
                    help: "(césped, arbustos, plantas, etc)",
                    icon: 'fa-solid fa-leaf'
                },
                {
                    label: "Iluminación",
                    help: "(Farolas, luces, etc)",
                    icon: 'fa-solid fa-lightbulb'
                },
                {
                    label: "Seguridad",
                    help: "(camáras de seguridad, etc)",
                    icon: 'fa-solid fa-shield-halved'
                },
                {
                    label: "Instalaciones deportivas",
                    help: "(cancha de fut-bol, etc)",
                    icon: 'fa-solid fa-person-running'
                },
                {
                    label: "Áreas de juego",
                    help: "(parques infantiles, etc)",
                    icon: 'fa-solid fa-puzzle-piece'
                },
                {
                    label: "Residuos",
                    help: "(contenedores de basura, etc)",
                    icon: 'fa-solid fa-recycle'
                },
                {
                    label: "Infraestructura del fraccionamiento",
                    help: "(calles, aceras, etc)",
                    icon: 'fa-solid fa-trowel-bricks'
                },
                {
                    label: "Áreas comunes",
                    help: "(salón de eventos, área de golf, etc) ",
                    icon: 'fa-solid fa-map'
                },
            ],
        };
    },
    components: {
        PrimaryButton,
        Link,
    },
    props: {
        maintenance: Object,
    },
    methods: {

    }
};
</script>
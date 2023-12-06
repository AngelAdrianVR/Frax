<template>
    <div class="border border-gray4 rounded-[5px] group pt-4 bg-transparent h-[300px]">
        <figure class="rounded-[5px] w-full h-[60%] px-4">
            <img src="" alt="">
        </figure>
        <div class="flex justify-between items-center font-bold h-[8%] px-4 text-sm">
            <h2 class="font-bold">
                <i class="fa-solid fa-leaf mr-1 text-gray1"></i>
                {{ maintenance.name }}
            </h2>
            <span class="text-gray1">
                <i class="fa-regular fa-comment mr-px"></i>
                {{ maintenance.comments_count }}
            </span>
        </div>
        <div class="h-[20%] w-1/3 pt-4 mx-auto">
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
<template>
    <div class="border border-gray4 rounded-[5px] p-6 bg-transparent h-[450px]">
        <figure class="rounded-[5px] w-full h-[60%]">
            <img src="" alt="">
        </figure>
        <h2 class="flex justify-center items-center font-bold h-[8%]">
            <i class="fa-solid fa-leaf mr-1"></i>
            {{ maintenance.name }}
        </h2>
        <div class="flex justify-center items-center flex-wrap h-[20%] text-secondary">
            <div class="flex flex-col items-center w-1/6">
                <el-tooltip content="Costo" placement="top">
                    <i class="fa-solid fa-dollar-sign text-xl"></i>
                </el-tooltip>
                <span class="text-xs">${{ maintenance.cost }}</span>
                <small>MXN</small>
            </div>
            <div class="flex flex-col items-center w-1/6">
                <el-tooltip content="Capacidad" placement="top">
                    <i class="fa-solid fa-users text-xl"></i>
                </el-tooltip>
                <span class="text-xs">{{ maintenance.capacity }}</span>
                <small>Personas</small>
            </div>
            <div v-for="(feature, index) in maintenances.features" :key="index" class="flex flex-col items-center w-1/6">
                <el-tooltip :content="feature.label" placement="top">
                    <i :class="feature.icon" class="text-xl"></i>
                </el-tooltip>
                <span class="text-xs">{{ feature.value.split(' ')[0] }}</span>
                <small>{{ feature.value.split(' ')[1] }}</small>
            </div>
        </div>
        <div class="h-[12%] flex">
            <PrimaryButton @click="$inertia.get(route('common-areas-users.create'), {common_area_id: maintenance.id})" class="w-full self-end">Reservar
            </PrimaryButton>
        </div>
    </div>
</template>
  
<script>
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { Link } from "@inertiajs/vue3";
import { Carousel, Slide } from 'vue3-carousel';
import 'vue3-carousel/dist/carousel.css';

export default {
    data() {
        return {

        };
    },
    components: {
        PrimaryButton,
        Carousel,
        Slide,
        Link,
    },
    props: {
        maintenance: Object,
    },
    methods: {

    }
};
</script>
<style scoped>
.carousel__item {
    height: 220px;
    width: 100%;
    background-color: var(--vc-clr-primary);
    color: var(--vc-clr-white);
    font-size: 20px;
    border-radius: 5px;
    display: flex;
    justify-content: center;
    align-items: center;
    margin-left: 2px;
    margin-right: 2px;
}
</style>
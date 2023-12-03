<template>
    <div class="border border-gray4 rounded-[5px] p-6 bg-transparent h-[450px]">
        <figure class="rounded-[5px] w-full h-[60%]">
            <Carousel :wrap-around="true" v-model="currentSlide">
                <Slide v-for="slide in 10" :key="slide">
                    <div class="carousel__item">{{ slide }}</div>
                </Slide>
                <!-- <template #addons>
                    <Pagination />
                </template> -->
            </Carousel>
            <div class="flex justify-center space-x-2 mt-2">
                <button v-for="image in 10" :key="image" @click="currentSlide = image" class="w-2 h-2 rounded-full"
                    :class="currentSlide == image ? 'bg-secondary' : 'bg-gray4'"></button>
            </div>
        </figure>
        <h2 class="flex justify-center items-center font-bold h-[8%]">{{ commonArea.name }}</h2>
        <div class="flex justify-center items-center flex-wrap h-[20%] text-secondary">
            <div class="flex flex-col items-center w-1/6">
                <el-tooltip content="Costo" placement="top">
                    <i class="fa-solid fa-dollar-sign text-xl"></i>
                </el-tooltip>
                <span class="text-xs">${{ commonArea.cost }}</span>
                <small>MXN</small>
            </div>
            <div class="flex flex-col items-center w-1/6">
                <el-tooltip content="Capacidad" placement="top">
                    <i class="fa-solid fa-users text-xl"></i>
                </el-tooltip>
                <span class="text-xs">{{ commonArea.capacity }}</span>
                <small>Personas</small>
            </div>
            <div v-for="(feature, index) in commonArea.features" :key="index" class="flex flex-col items-center w-1/6">
                <el-tooltip :content="feature.label" placement="top">
                    <i :class="feature.icon" class="text-xl"></i>
                </el-tooltip>
                <span class="text-xs">{{ feature.value.split(' ')[0] }}</span>
                <small>{{ feature.value.split(' ')[1] }}</small>
            </div>
        </div>
        <div class="h-[12%] flex">
            <PrimaryButton class="w-full self-end">Reservar</PrimaryButton>
        </div>
    </div>
</template>
  
<script>
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { Carousel, Pagination, Slide } from 'vue3-carousel';
import 'vue3-carousel/dist/carousel.css';
import axios from 'axios';

export default {
    data() {
        return {
            currentSlide: 0,
        };
    },
    components: {
        PrimaryButton,
        Carousel,
        Slide,
        Pagination,
    },
    props: {
        commonArea: Object,
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
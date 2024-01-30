<template>
    <LoadingState :loading="loading" />
    <div v-if="!loading" class="border border-gray4 rounded-[5px] p-6 bg-transparent h-[450px]">
        <article>
            <figure class="rounded-[5px] w-full h-[60%] relative">
                <Carousel :wrap-around="true">
                    <Slide v-for="media in commonArea.media" :key="media.id" class="h-full">
                        <img class="object-contain" :src="media.original_url">
                    </Slide>
                    <template #addons>
                        <Pagination />
                    </template>
                </Carousel>
            </figure>
        </article>
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
                <span class="text-xs">{{ feature.value ? feature.value.split(' ')[0] : 'Si' }}</span>
                <small>{{ feature.value ? feature.value.split(' ')[1] : '' }}</small>
            </div>
        </div>
        <div class="h-[12%] flex">
            <PrimaryButton @click="$inertia.get(route('common-areas-users.create'), { common_area_id: commonArea.id })"
                class="w-full self-end">Reservar
            </PrimaryButton>
        </div>
    </div>
</template>
  
<script>
import PrimaryButton from "@/Components/PrimaryButton.vue";
import LoadingState from "@/Components/MyComponents/LoadingState.vue";
import { Link } from "@inertiajs/vue3";
import axios from "axios";
import { Carousel, Slide, Pagination } from 'vue3-carousel';
import 'vue3-carousel/dist/carousel.css';

export default {
    data() {
        return {
            commonArea: null,
            loading: true,
        };
    },
    components: {
        PrimaryButton,
        Carousel,
        Slide,
        Link,
        Pagination,
        LoadingState,
    },
    props: {
        commonAreaId: Object,
    },
    methods: {
        async fetchCommonArea() {
            try {
                const response = await axios.get(route('common-areas.get-by-id', this.commonAreaId));

                if (response.status === 200) {
                    this.commonArea = response.data.item;
                }
            } catch (error) {
                console.log(error);
            } finally {
                this.loading = false;
            }
        }
    },
    mounted() {
        this.fetchCommonArea();
    }
};
</script>
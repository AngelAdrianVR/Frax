<template>
    <div class="border border-gray4 rounded-[5px] p-6 bg-transparent h-[400px]">
        <figure class="bg-gray4 rounded-[5px] w-full h-[60%]">

        </figure>
        <h2 class="text-center font-bold mt-1 h-[10%]">{{ commonArea.name }}</h2>
        <div class="flex justify-center items-center flex-wrap h-[20%]">
            <div v-for="(feature, index) in commonArea.features" :key="index" class="flex flex-col items-center w-1/4">
                <el-tooltip :content="feature.label" placement="top">
                    <i :class="feature.icon"></i>
                </el-tooltip>
                <small>{{ feature.value }}</small>
            </div>
        </div>
        <div class="h-[10%] flex">
            <PrimaryButton class="w-full self-end">Reservar</PrimaryButton>
        </div>
    </div>
</template>
  
<script>
import PrimaryButton from "@/Components/PrimaryButton.vue";
import axios from 'axios';

export default {
    data() {
        return {
        }
    },
    components: {
        PrimaryButton,
    },
    props: {
        commonArea: Object,
    },
    methods: {

    }
};
</script>
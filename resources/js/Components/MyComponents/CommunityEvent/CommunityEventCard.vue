<template>
    <div class="rounded-md border border-gray4 p-5 text-sm my-2 shadow-md">
        <h1 class="text-center font-bold mb-3">{{ communityEvent.name }}</h1>
        <p class="text-gray1">Fecha: <strong>{{ communityEvent.date }}</strong></p>
        <p class="text-gray1">Hora: <strong>{{ communityEvent.time }}</strong></p>
        <p class="text-gray1">Participantes: <strong>{{ communityEvent.participants }}</strong></p>

        <figure v-if="communityEvent.image_cover?.length > 0" class="bg-gray5 m-4 rounded-md lg:h-64">
            <img class="lg:h-64 w-full rounded-lg" :src="communityEvent.image_cover[0]?.original_url" alt="Sin imagen" >
        </figure>
        <div v-else class="bg-gray3 m-4 rounded-md lg:h-64"></div>

        <div class="text-center mt-9">
        <ThirthButton>Ver detalles</ThirthButton>
        </div>
    </div>
</template>

<script>
import ThirthButton from "@/Components/ThirthButton.vue";

export default {
data(){
    return {

    }
},
components:{
ThirthButton,
},
props:{
communityEvent: Object
},
methods:{

},
}
</script>

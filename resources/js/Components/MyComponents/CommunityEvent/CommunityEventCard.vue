<template>
    <div class="rounded-md border border-gray4 p-5 text-sm my-2 shadow-md group relative">
        <!-- Action buttons only for admin -->
        <div v-if="true"
            class="flex justify-end mb-3 space-x-1 lg:group-hover:opacity-100 lg:opacity-0 transition-opacity duration-300 absolute top-3 right-3">
            <el-popconfirm confirm-button-text="Si" cancel-button-text="No" icon-color="#D90537"
                title="¿Continuar?" @confirm="deleteCommunityEvent">
                <template #reference>
                    <button class="rounded-full bg-gray5 flex justify-center items-center w-7 h-7 text-xs"><i
                            class="fa-regular fa-trash-can"></i></button>
                </template>
            </el-popconfirm>
            <button @click="$inertia.get(route('community-events.edit', communityEvent))"
                class="rounded-full bg-gray5 flex justify-center items-center w-7 h-7 text-xs"><i
                    class="fa-solid fa-pencil"></i></button>
        </div>

        <h1 class="text-center font-bold mb-3">{{ communityEvent.name }}</h1>
        <p class="text-gray1">Fecha: <strong>{{ communityEvent.date }}</strong></p>
        <p class="text-gray1">Hora: <strong>{{ communityEvent.time }}</strong></p>
        <p class="text-gray1">Participantes: <strong>{{ communityEvent.participants }}</strong></p>

        <figure v-if="communityEvent.image_cover?.length > 0" class="bg-gray5 m-4 rounded-md lg:h-64">
            <img class="lg:h-64 w-full rounded-lg" :src="communityEvent.image_cover[0]?.original_url" alt="Sin imagen" >
        </figure>
        <div v-else class="bg-gray4 m-4 rounded-md lg:h-64 justify-center items-center flex text-white font-bold text-lg">Sin portada</div>

        <div class="text-center mt-9">
        <ThirthButton @click="$inertia.get(route('community-events.show', communityEvent.id))">Ver detalles</ThirthButton>
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
emits:['delete-community-event'],
methods:{
    deleteCommunityEvent() {
        this.$emit('delete-community-event', this.communityEvent.id);
    }
},
}
</script>

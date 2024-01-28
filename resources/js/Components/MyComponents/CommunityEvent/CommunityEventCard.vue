<template>
    <div class="rounded-lg border border-gray4 text-sm shadow-md group relative">
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
        <!-- -------------------------------- -->

        <!-- Imagen ---------------------------------- -->
        <figure v-if="communityEvent.image_cover?.length > 0" class="bg-gray5 lg:h-[358px]">
            <img class="lg:h-[358px] w-full rounded-t-lg" :src="communityEvent.image_cover[0]?.original_url" alt="Sin imagen" >
        </figure>
        <div v-else class="bg-gray4 rounded-t-lg lg:h-[358px] h-64 justify-center items-center flex text-white font-bold text-lg">Sin portada</div>
        <!-- ------------------------------------------ -->

        <!-- Information ---------------------------- -->
        <div class="grid grid-cols-6">
            <div class="p-4 clas border-r border-gray3 flex flex-col items-center justify-center pt-20 col-span-2">
                <p class="text-lg font-bold uppercase">{{ communityEvent.date.split('.')[0] }}</p>
                <p class="text-3xl font-bold uppercase">{{ communityEvent.date.split('-')[1] }}</p>
                <PrimaryButton class="mt-16">Registrarme</PrimaryButton>
            </div>
            <div class="p-4 col-span-4">
                <h1 class="lg:text-2xl text-lg font-bold mb-2">{{ communityEvent.name }}</h1>
                <p class="text-gray1 mt-2 lg:text-sm text-xs"><i class="fa-solid fa-user text-xs mr-2"></i>Evento dirigido a: <strong>{{ communityEvent.participants }}</strong></p>
                <p class="text-gray1 mt-2 lg:text-sm text-xs"><i class="fa-solid fa-grip-lines text-xs mr-2"></i>Descripción: <strong>{{ communityEvent.description }}</strong></p>
                <p class="text-gray1 mt-2 lg:text-sm text-xs"><i class="fa-solid fa-clock-rotate-left text-xs mr-2"></i>Hora: <strong>{{ communityEvent.time }}</strong></p>
                <p class="text-gray1 mt-2 lg:text-sm text-xs"><i class="fa-solid fa-location-dot text-xs mr-2"></i>Lugar: <strong>{{ communityEvent.place }}</strong></p>
                <p class="text-gray1 mt-2 lg:text-sm text-xs"><i class="fa-solid fa-dollar-sign text-xs mr-2"></i>Costo: <strong>${{ communityEvent.cost?.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",") }}</strong></p>
                <p class="text-gray1 mt-2 lg:text-sm text-xs"><i class="fa-solid fa-list-ol text-xs mr-2"></i>Reglas: <strong>{{ communityEvent.rules ?? '-' }}</strong></p>
            </div>
        </div>   
    </div>
</template>

<script>
import PrimaryButton from "@/Components/PrimaryButton.vue";

export default {
data(){
    return {

    }
},
components:{
PrimaryButton   
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

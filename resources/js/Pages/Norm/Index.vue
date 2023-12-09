<template>
    <AppLayout title="Normativas">
        <div class="py-8 px-3 lg:px-12">
            <div class="flex justify-between items-center lg:mx-12 mb-2">
            <h1 class="font-bold">Normativas</h1>
                <PrimaryButton class="hidden md:block" @click="$inertia.get(route('guests.create'))">Agregar normativa</PrimaryButton>
                <PrimaryButton class="lg:hidden" @click="$inertia.get(route('guests.create'))"><i class="fa-solid fa-plus"></i></PrimaryButton>
            </div>
            <p class="text-sm lg:mx-12">Te invitamos a leer las normativas para mantener una sana conviviencia y evitar disputas.</p>

            <div class="mt-4 lg:mx-12">
                <div v-if="norms.data?.length > 0 ||true" class="md:grid lg:grid-cols-3 md:grid-cols-2 gap-5">
                    <!-- Componente de normativa------- -->
                    <NormCard class="mt-3" />

                </div>
                <p class="text-xs text-gray-400 text-center" v-else>No hay normativas registradas de tu fraccionamiento</p>
            </div>
        </div>

    </AppLayout>
  
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import NormCard from "@/Components/MyComponents/Norms/NormCard.vue";

export default {
data(){
    return {

    }
},
components:{
AppLayout,
NormCard,
PrimaryButton
},
props:{
norms: Object
},
methods:{

}
}
</script>

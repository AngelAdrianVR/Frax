<template>
    <AppLayout title="Normativas">
        <div class="py-8 px-3 lg:px-12">
            <div class="flex justify-between items-center lg:mx-12 mb-2">
            <h1 class="font-bold">Normativas</h1>
                <PrimaryButton class="hidden md:block" @click="$inertia.get(route('norms.create'))">Nueva sección</PrimaryButton>
                <PrimaryButton class="lg:hidden" @click="$inertia.get(route('norms.create'))"><i class="fa-solid fa-plus"></i></PrimaryButton>
            </div>
            <p class="text-sm lg:mx-12">Te invitamos a leer las normativas para mantener una sana conviviencia y evitar disputas.</p>

            <div class="mt-4 lg:mx-12">
                <div v-if="norms.data?.length > 0 ||true" class="md:grid lg:grid-cols-4 md:grid-cols-2 gap-5">
                    <!-- Componente de normativa------- -->
                    <NormCard v-for="norm in norms.data" :key="norm" :norm="norm" class="mt-3" />

                    <!-- Solo lo puede ver el administrador deo fraccionamiento -->
                    <div @click="$inertia.get(route('norms.create'))" class="rounded-md border border-gray4 h-80 cursor-pointer flex justify-center mt-3">
                        <div class="flex flex-col justify-center text-primary items-center">
                            <i class="fa-solid fa-plus text-lg mb-2"></i>
                            <p>Agregar sección</p>
                        </div>
                    </div>

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

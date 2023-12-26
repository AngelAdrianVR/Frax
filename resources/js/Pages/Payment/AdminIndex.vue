<template>
    <AppLayout title="Administración de pagos">
        <!-- <LoadingState :loading="loading" /> -->
        <!-- ------------- tabs section starts ------------- -->
        <div class="border-y-2 border-[#D9D9D9] items-center py-2">
            <div class="flex lg:ml-20">
                <Tab @click="currentTab = (index + 1)" :label="tab" :active="currentTab == (index + 1)"
                    v-for="(tab, index) in tabs" :key="index" />
            </div>
        </div>
        <!-- ------------- tabs section ends ------------- -->

        <!-- ------------- tab 1 section pagos pendientes starts ------------- -->
        <div class="p-4" v-if="currentTab == 1">
            
            <div class="flex justify-between items-center mt-5 lg:mx-16">
                <p class="font-bold">Pagos</p>
                <PrimaryButton class="hidden md:block" @click="$inertia.get(route('payments.create'))">Agregar pago</PrimaryButton>
                <PrimaryButton class="lg:hidden" @click="$inertia.get(route('payments.create'))"><i class="fa-solid fa-plus"></i></PrimaryButton>
                <HideableLabel class="absolute right-0 top-32 z-50" iconClass="fa-solid fa-info">
                    <p>
                        Es importante pagar los montos si ya ha pasado la fecha de vencimiento para evitar cargos adicionales
                    </p>
                </HideableLabel>
            </div>

        </div>
        <!-- ------------- tab 1 section pagos pendientes ends ------------- -->
        
    </AppLayout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Link } from '@inertiajs/vue3';
import Tab from "@/Components/MyComponents/Tab.vue";
import ThirthButton from "@/Components/ThirthButton.vue";
import HideableLabel from "@/Components/MyComponents/HideableLabel.vue";
import LoadingState from "@/Components/MyComponents/LoadingState.vue";

export default {
data() {
    return {
        currentTab: 1,
        paymentTickets: null,
        paymentHistories: null,
        loading: false,
        tabs: [
            'Pagos pendientes',
            'Transacciones',
            'Historial',
        ],
    }
},
components:{
AppLayout,
PrimaryButton,
LoadingState,
HideableLabel,
ThirthButton,
Link,
Tab
},
props:{
payments: Object,
},
methods:{
    
},
computed: {

},
watch:{
  },
mounted() {},
};
</script>

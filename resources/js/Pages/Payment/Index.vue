<template>
    <AppLayout title="Pagos">

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
            <div class="flex justify-between mt-5 lg:mx-16">
                <p class="font-bold">Pagos pendientes</p>
                <div class="inline-flex text-right items-center text-primary bg-primarylight py-1 px-2 rounded-sm">
                    <i class="fa-solid fa-circle-exclamation mr-2"></i>
                    <p class=" text-sm text-right">Es importante pagar los montos si ya ha pasado la fecha de vencimiento para evitar cargos adicionales</p>
                </div>
            </div>
            <div class="mt-7">
                <div class="grid grid-cols-3 gap-5">
                    <PaymentCard class="self-start" v-for="payment in payments.data" :key="payment" :payment="payment" />
                </div>
            </div>
        </div>
        <!-- ------------- tab 1 section pagos pendientes ends ------------- -->

    </AppLayout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import PaymentCard from '@/Components/MyComponents/PaymentCard.vue';
import { Head, Link } from '@inertiajs/vue3';
import Tab from "@/Components/MyComponents/Tab.vue";

export default {
data() {
    return {
        currentTab: 1,
        tabs: [
            'Pagos pendientes',
            'Transacciones',
            'Historial',
        ]
    }
},
components:{
AppLayout,
PrimaryButton,
PaymentCard,
Link,
Tab
},
props:{
payments: Object
},
methods:{

}
};
</script>

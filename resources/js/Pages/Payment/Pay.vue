<template>
    <AppLayout title="Realizar pago">
        <div class="p-5">
            <div class="flex justify-between">
                <p class="font-bold">Realizar pago</p>
                <Back />
            </div>
            <div class="w-1/3 text-sm flex justify-between items-center mt-3">
            <p>Monto total</p>
            <p class="font-bold bg-primarylight py-1 px-2">${{ payment.data.total?.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",") }}</p>
            </div>
            <p class="mt-3 text-sm mb-2">Selecciona el método de pago</p>
            <!-- ---------- payment methods -->
            <div class="rounded-md border border-[#D9D9D9] flex justify-between items-center px-4 py-2 mt-1 lg:w-1/3 text-sm cursor-pointer">
            <div class="flex items-center">
                <i class="fa-regular fa-credit-card tex-sm mr-3"></i>
                <p>Tarjeta de crédito o débito</p>
            </div>
            <div class="flex items-center space-x-1">
                <!-- <img src="../../../public/images/visa.png" alt="visa"> -->
                <!-- <img src="../../../public/images/americanexpress.png" alt="americanexpress"> -->
                <!-- <img src="../../../public/images/mastercard.png" alt="mastercard"> -->
            </div>
            </div>
            <div class="rounded-md border border-[#D9D9D9] flex justify-between items-center px-4 py-2 mt-1 lg:w-1/3 text-sm cursor-pointer">
            <div class="flex items-center">
                <i class="fa-solid fa-money-bill tex-sm mr-3"></i>
                <p>Pago en efectivo</p>
            </div>
            <div class="flex items-center space-x-1">
                <!-- <img src="../../../public/images/oxxo.png" alt="visa"> -->
                <!-- <img src="../../../public/images/seven.png" alt="americanexpress"> -->
            </div>
            </div>
        </div>

        <PrimaryButton>Pagar</PrimaryButton>
            
    </AppLayout>
  
</template>

<script>
import AppLayout from '@/Layouts/AppLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import Back from '@/Components/MyComponents/Back.vue';
import { Link } from '@inertiajs/vue3';

export default {
data() {
    return {
        
    }
},
components:{
AppLayout,
PrimaryButton,
Back,
Link,
},
props:{
payment: Object
},
methods:{

}
};
</script>

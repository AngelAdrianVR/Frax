<template>
    <AppLayout title="Transacciones">
        <div class="lg:py-4 lg:px-12">
            <div class="flex justify-between mt-5">
                <div class="flex items-center">
                    <p class="font-bold">Transacciones</p>
                    <i class="fa-regular fa-money-bill-1 ml-3"></i>
                </div>
                <div class="inline-flex text-right items-center bg-primarylight py-1 px-2 rounded-sm">
                    <i class="fa-solid fa-circle-exclamation mr-2"></i>
                    <p class=" text-sm text-right">Es importante pagar los montos si ya ha pasado la fecha de vencimiento para evitar cargos adicionales</p>
                </div>
                <Back />
            </div>
            <div class="w-1/3 grid grid-cols-2 mt-6 text-sm">
                <div class="text-[#9A9A9A] space-y-2">
                    <p>Folio</p>
                    <p>Nombre</p>
                    <p>Fecha de vencimiento</p>
                    <p>Fecha de operación</p>
                    <p>Monto</p>
                    <p>Método de pago</p>
                    <p>Estatus</p>
                </div>
                <div class="space-y-2">
                    <p>{{ paymentTicket.data.id }}</p>
                    <p>{{ paymentTicket.data.payment.name }}</p>
                    <p>{{ paymentTicket.data.payment.limit_date }}</p>
                    <p>{{ paymentTicket.data.created_at }}</p>
                    <p>${{ paymentTicket.data.payment.total?.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",") }}</p>
                    <p>{{ paymentTicket.data.payment_method }}</p>
                    <div class="flex items-center">
                        <el-tooltip content="Espeando aprobación" placement="bottom">
                            <svg width="47" height="20" viewBox="0 0 47 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g clip-path="url(#clip0_4014_10)">
                                <path d="M11.5802 11.5L0.0892311 23H35.4644L47 11.5L35.3752 0H0L11.5802 11.5Z" fill="#F7FEAD"/>
                                </g>
                                <defs>
                                <clipPath id="clip0_4014_10">
                                <rect width="47" height="23" fill="white"/>
                                </clipPath>
                                </defs>
                            </svg>
                        </el-tooltip>
                        <el-tooltip content="Pago acreditado" placement="bottom">
                            <svg width="47" height="20" viewBox="0 0 47 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g clip-path="url(#clip0_4014_10)">
                                <path d="M11.5802 11.5L0.0892311 23H35.4644L47 11.5L35.3752 0H0L11.5802 11.5Z" fill="#F7FEAD"/>
                                </g>
                                <defs>
                                <clipPath id="clip0_4014_10">
                                <rect width="47" height="23" fill="white"/>
                                </clipPath>
                                </defs>
                            </svg>
                        </el-tooltip>
                        <el-tooltip content="Pagado" placement="bottom">
                            <svg width="47" height="20" viewBox="0 0 47 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g clip-path="url(#clip0_4014_10)">
                                <path d="M11.5802 11.5L0.0892311 23H35.4644L47 11.5L35.3752 0H0L11.5802 11.5Z" fill="#F7FEAD"/>
                                </g>
                                <defs>
                                <clipPath id="clip0_4014_10">
                                <rect width="47" height="23" fill="white"/>
                                </clipPath>
                                </defs>
                            </svg>
                        </el-tooltip>
                    </div>
                </div>
            </div>
                <p class="font-bold mt-5">Factura</p>
                <p class="text-sm">En proceso...</p>
        </div>
            
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
paymentTicket: Object
},
methods:{

}
};
</script>

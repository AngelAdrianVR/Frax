<template>
    <div class="rounded-md shadow-md shadow-gray-200 py-3 px-5 border border-[#D9D9D9] text-sm relative transition duration-300 ease-out hover:scale-105">
        <el-tooltip v-if="payment.is_expired" :content="'Venció el ' + payment.limit_date" placement="top">
            <i class="fa-regular fa-face-sad-tear text-lg text-red-500 absolute top-4 right-7"></i>
        </el-tooltip>
        <el-tooltip v-else :content="'Vence el ' + payment.limit_date" placement="top">
            <i class="fa-regular fa-face-smile-beam text-lg text-green-500 absolute top-4 right-7"></i>
        </el-tooltip>
        <div class="flex items-center my-1">
            <i class="fa-solid fa-calendar-days text-gray-300 mr-2"></i>
            <p class="font-bold">{{ payment.name }}</p>
        </div>
        <div class="flex items-center my-1">
            <i class="fa-solid fa-money-bill text-gray-300 mr-2"></i>
            <p :class="payment.is_expired ? 'text-red-500' : '' " class="font-bold">${{ payment.total?.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",") }}</p>
        </div>
        <div @click="showDetails = !showDetails" class="flex justify-between items-center cursor-pointer mt-4">
            <div class="flex items-center">
                <i class="fa-solid fa-caret-right text-gray-300 mr-2"></i>
                <p class="text-primary font-bold">Desgloce</p>
            </div>
            <i class="fa-solid fa-angle-up transform origin-center text-primary transition duration-200 ease-out"
            :class="{ '!rotate-180': showDetails }"></i>
        </div>
        <!-- Desgloce-------------------->
        <div v-if="showDetails" class="mt-5 grid grid-cols-2 mx-2 transition-all duration-500 ease-in-out">
            <div class="space-y-3">
                <p v-for="billConcept in payment.bills" :key="billConcept">{{ billConcept['concept'] }}</p>
            </div>
            <div class="space-y-3 text-right">
                <p v-for="billAmount in payment.bills" :key="billAmount">${{ billAmount['amount'] }}</p>
            </div>
            <div class="border-b-2 border-black w-full col-span-2 my-1"></div>
            <p class="font-bold">Total</p>
            <p class="font-bold text-right">${{ payment.total?.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",") }}</p>
        </div>
        <div class="text-center mt-5">
            <PrimaryButton @click="$inertia.get(route('payments.pay', payment.id))">Pagar</PrimaryButton>
            <p class="text-xs mt-2">Consulta los <a :href="route('dashboard')" target="_blank" class="text-primary cursor-pointer hover:underline font-bold">términos y condiciones de los pagos</a></p>
        </div>
    </div>
</template>

<script>
import PrimaryButton from '@/Components/PrimaryButton.vue';

export default {
data() {
    return {
        showDetails: false,
    }
},
components:{
PrimaryButton
},
props:{
payment: Object
},
methods:{
    
}
}
</script>

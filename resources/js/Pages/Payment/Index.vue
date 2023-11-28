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
                <div class="inline-flex text-right items-center text-amber-400 bg-amber-100 py-1 px-2 rounded-sm">
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

        <!-- ------------- tab 2 Transacciones starts ------------- -->
        <div class="p-4" v-if="currentTab == 2">
            <table v-if="paymentTickets.data.length > 0" class="w-full mx-auto text-sm mt-5">
                <thead>
                    <tr class="text-center">
                        <th class="font-bold pb-1 pl-2 text-left border-b border-primary">
                        Folio
                        </th>
                        <th class="font-bold pb-1 text-left border-b border-primary">
                        Transacción
                        </th>
                        <th class="font-bold pb-1 text-left border-b border-primary">
                        Fecha de vencimiento
                        </th>
                        <th class="font-bold pb-1 text-left border-b border-primary">
                        Fecha de operación
                        </th>
                        <th class="font-bold pb-1 text-left border-b border-primary">
                        Monto
                        </th>
                        <th class="font-bold pb-1 text-left border-b border-primary">
                        Método de pago
                        </th>
                        <th class="font-bold pb-1 text-left border-b border-primary">
                        Estatus
                        </th>
                        <!-- <th class="font-bold pb-3 text-left">
                        Tipo
                        </th> -->
                    </tr>
                </thead>
                <tbody>
                    <tr  v-for="(transaction, index) in paymentTickets.data" :key="transaction.id"
                        class="mb-4 cursor-pointer rounded-full hover:text-primary"
                        :class="{ 'bg-[#F2F2F2]': index % 2 == 0 }"
                        @click="$inertia.get(route('payment-tickets.show', transaction.id))"
                    >
                        <td class="py-2 pl-2 rounded-l-full">
                        {{ transaction.id}}
                        </td>
                        <td class="py-2">
                            <span :title="transaction.payment?.name" class="truncate">{{ transaction.payment?.name }}</span>
                        </td>
                        <td class="py-2">
                            {{ transaction.payment?.limit_date }}
                        </td>
                        <td class="py-2">
                            {{ transaction.created_at }}
                        </td>
                        <td class="py-2">
                            ${{ transaction.payment?.total?.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",") }}
                        </td>
                        <td class="py-2">
                            {{ transaction.payment_method }}
                        </td>
                        <td class="py-2 rounded-r-full">
                            <span class="py-1 px-3 rounded-full" :class="getStatusStiles(transaction)">{{ transaction.status }}</span>
                        </td>
                    </tr>
                </tbody>
         </table>
         <p class="text-xs text-gray-400 text-center" v-else>No tienes transacciones</p>
        </div>
        <!-- ------------- tab 2 Transacciones ends ------------- -->

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
payments: Object,
paymentTickets: Object,
},
methods:{
    getStatusStiles (transaction) {
        if (transaction.status == 'Esperando aprobación') {
            return 'text-[#D0D407] bg-[#F7FEAD]';
        } else if (transaction.status == 'Pago rechazado') {
            return 'text-[#E82828] bg-[#FEADAD]';
        } else if (transaction.status == 'Pagado') {
            return 'text-primary bg-primarylight';
        }
          
    }
}
};
</script>

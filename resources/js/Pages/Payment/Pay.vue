<template>
    <AppLayout title="Realizar pago">
        <div class="p-5">
           <Back />
            <div class="lg:mx-9 mt-8">
                <div class="flex justify-between">
                    <p class="font-bold">Realizar pago</p>
                </div>
                <div class="w-1/3 text-sm flex justify-between items-center mt-3">
                <p>Monto total</p>
                <p class="font-bold bg-primarylight py-1 px-2">${{ payment.data.total?.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",") }}</p>
                </div>
                <p class="mt-3 text-sm mb-2">Selecciona el método de pago</p>
                
                <!-- ---------- payment methods -------------->

                <!-- Credit card payment---- -->
                <div @click="showCardPayment = true" class="rounded-md border border-[#D9D9D9] flex justify-between items-center px-4 py-2 mt-1 lg:w-1/3 text-sm cursor-pointer">
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
                <!-------------------------->

                <!-- Cash payment ----------------->
                <div @click="showCashPayment = true" class="rounded-md border border-[#D9D9D9] flex justify-between items-center px-4 py-2 mt-1 lg:w-1/3 text-sm cursor-pointer">
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4 mr-3">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z" />
                        </svg>

                        <p>Pago en efectivo</p>
                    </div>
                    <div class="flex items-center space-x-1">
                        <!-- <img src="../../../public/images/oxxo.png" alt="visa"> -->
                        <!-- <img src="../../../public/images/seven.png" alt="americanexpress"> -->
                    </div>
                </div>
                <!---------------------->
            </div>
        </div>

        <!-- Modal pago en efectivo o con tarjeta -------------------------------------------------->
  <Modal :show="showCardPayment || showCashPayment"
        @close="showCardPayment = false; showCashPayment = false"
        maxWidth="xl">
        <div class="mx-7 my-4 space-y-2 relative">
          <div @click="showCardPayment = false; showCashPayment = false; cardForm.reset(); cashForm.reset()"
            class="cursor-pointer w-5 h-5 rounded-full border-2 border-black flex items-center justify-center absolute top-0 -right-2">
            <i class="fa-solid fa-xmark"></i>
          </div>

    <!-- Seccion de pago en efectivo -->
    <section v-if="showCardPayment">
        <h1 class="flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4 mr-2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Z" />
            </svg>
            Tarjeta de crédito o débito
        </h1>

        <div class="mt-1">
            <InputLabel value="Número de tarjeta" class="ml-3 mb-1" />
            <input v-model="cardForm.card_number" class="input" type="text" placeholder="XXXX-XXXX-XXXX-XXXX" />
        </div>

        <div class="mt-1">
            <InputLabel value="Nombre de quien pertenece la tarjeta" class="ml-3 mb-1" />
            <input v-model="cardForm.owner_name" class="input" type="text" />
        </div>

        <div class="mt-1">
            <InputLabel value="Fecha de vencimiento" class="ml-3 mb-1" />
            <input v-model="cardForm.expired_date" class="input" type="text" placeholder="00/00" />
        </div>

        <div class="mt-1">
            <InputLabel value="CVV" class="ml-3 mb-1" />
            <input v-model="cardForm.cvv" class="input" type="text" placeholder="0000" />
        </div>

        <label class="flex items-center mt-1 lg:mt-5 lg:ml-2     text-xs">
            <Checkbox v-model:checked="cardForm.default_card" class="bg-transparent disabled:border-gray-400" />
            <span class="ml-2 mr-2 text-xs">Usar como mi pago predeterminado</span>
        </label>

          <div class="flex justify-end space-x-1 pt-5 pb-1">
            <CancelButton @click="cardForm.reset(); showCardPayment = false">Cancelar</CancelButton>  
            <PrimaryButton :disabled="!cardForm.card_number && !cardForm.expired_date && !cardForm.cvv" @click="store">Continuar</PrimaryButton>
          </div>
    </section>
    <!-- ------------------------------------------->


    <!-- Seccion de pago en efectivo -->
    <section v-if="showCashPayment">
        <h1 class="flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4 mr-2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z" />
            </svg>

            Pago en efectivo
        </h1>

        <div class="mt-1">
            <InputLabel value="Selecciona la tienda" class="ml-3 mb-1" />
            <input v-model="cardForm.card_number" class="input" type="text" placeholder="XXXX-XXXX-XXXX-XXXX" />
        </div>

        <p class="text-xs text-center my-2">Al realizar el pago, puedes dar seguimiento al estatus en la pestaña de <strong class="text-primary cursor-pointer">Transacciones</strong></p>

        <div class="border-b border-gray4 my-7"></div>

        <p class="text-xs my-2 text-center">Tienes hasta 72 horas para realizar el pago con esta referencia</p>
        
        <figure class="text-center">
            <img src="'@/../public/images/oxxo.png'" alt="Oxxo">
        </figure>

          <div class="flex justify-end space-x-1 pt-5 pb-1">
            <CancelButton @click="cashForm.reset(); showCashPayment = false">Cancelar</CancelButton>  
            <PrimaryButton :disabled="!cardForm.card_number && !cardForm.expired_date && !cardForm.cvv" @click="store">Continuar</PrimaryButton>
          </div>
    </section>
    <!-- ------------------------------------------->
          
        </div>
      </Modal>            
    </AppLayout>
  
</template>

<script>
import AppLayout from '@/Layouts/AppLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import CancelButton from '@/Components/MyComponents/CancelButton.vue';
import Back from '@/Components/MyComponents/Back.vue';
import Modal from "@/Components/Modal.vue";
import InputLabel from "@/Components/InputLabel.vue";
import Checkbox from "@/Components/Checkbox.vue";
import { useForm } from "@inertiajs/vue3";
import { Link } from '@inertiajs/vue3';

export default {
data() {
     const cardForm = useForm({
    card_number: null,
    owner_name: null,
    expired_date: null,
    cvv: null,
    default_card: null,
  });

     const cashForm = useForm({
    card_number: null,
    owner_name: null,
    expired_date: null,
    cvv: null,
    default_card: null,
  });
    return {
        cardForm,
        cashForm,
        showCardPayment: false,
        showCashPayment: false,
    }
},
components:{
AppLayout,
PrimaryButton,
CancelButton,
Checkbox,
Back,
InputLabel,
Modal,
Link,
},
props:{
payment: Object
},
methods:{

}
};
</script>

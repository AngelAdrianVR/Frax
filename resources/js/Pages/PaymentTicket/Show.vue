<template>
    <AppLayout title="Transacciones">
        <div class="p-4">
            <div class="flex items-center">
                <p class="font-bold">Transacciones</p>
                <i class="fa-solid fa-money-bill-transfer ml-2"></i>
            </div>
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
payment: Object
},
methods:{

}
};
</script>

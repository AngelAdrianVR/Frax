<template>
    <AppLayout title="Realizaar pago">

            
    </AppLayout>
  
</template>

<script>
import AppLayout from '@/Layouts/AppLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Head, Link } from '@inertiajs/vue3';

export default {
data() {
    return {
        
    }
},
components:{
AppLayout,
PrimaryButton,
Link,
},
props:{
payment: Object
},
methods:{

}
};
</script>

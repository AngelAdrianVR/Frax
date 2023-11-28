<template>
    <AppLayout title="Visitantes">

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
            
        </div>
        <!-- ------------- tab 1 section pagos pendientes ends ------------- -->

    </AppLayout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Link } from '@inertiajs/vue3';
import Tab from "@/Components/MyComponents/Tab.vue";

export default {
data() {
    return {
        currentTab: 1,
        tabs: [
            'Visitas programadas',
            'Visitas frecuentes',
            'Historial',
        ],
    }
},
components:{
AppLayout,
PrimaryButton,
Link,
Tab
},
props:{

},
methods:{

},

};
</script>

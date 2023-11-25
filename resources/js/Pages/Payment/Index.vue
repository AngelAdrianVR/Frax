<template>
    <AppLayout title="Pagos">

        <!-- ------------- tabs section starts ------------- -->
        <div class="border-y-2 border-[#cccccc] items-center py-2">
            <div class="flex ml-20">
                <Tab @click="currentTab = (index + 1)" :label="tab" :active="currentTab == (index + 1)"
                    v-for="(tab, index) in tabs" :key="index" />
            </div>
        </div>
        <!-- ------------- tabs section ends ------------- -->

    </AppLayout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout.vue';
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
Link,
Tab
},
props:{

},
methods:{

}
};
</script>

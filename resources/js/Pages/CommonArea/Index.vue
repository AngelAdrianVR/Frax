<template>
    <AppLayout title="Áreas comunes">
        <h1 class="font-bold mt-12 mx-20">Reservación de áreas</h1>
        <p class="mt-6 mx-20 text-sm">En este apartado se puede visualizar las áreas comunes y se pueden reservar, es
            necesario leer
            el reglamento y
            las polícas establecidas para cada área. </p>
        <div class="mt-4 mx-20 lg:grid grid-cols-3 gap-6">
            <CommonAreaCard :commonArea="commonAreaTest" />
        </div>
    </AppLayout>
</template>
  
<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import CommonAreaCard from "@/Components/MyComponents/CommonArea/CommonAreaCard.vue";
import { Link } from "@inertiajs/vue3";

export default {
    data() {
        return {
            commonAreaTest: {
                name: 'Alberca común',
                cost: 200,
                capacity: 20,
                features: [
                    {
                        icon: "fa-solid fa-person-swimming",
                        label: 'Profundidad',
                        value: '1.52 metros'
                    },
                    {
                        icon: "fa-solid fa-fan",
                        label: 'Área infantil',
                        value: '10 niños'
                    },
                    {
                        icon: "fa-solid fa-person-swimming",
                        label: 'Profundidad',
                        value: '1.52 metros'
                    },
                    {
                        icon: "fa-solid fa-fan",
                        label: 'Área infantil',
                        value: '10 niños'
                    },
                ],
            },
        };
    },
    components: {
        AppLayout,
        Link,
        CommonAreaCard,
    },
    props: {
    },
    methods: {

    },
};
</script>
  
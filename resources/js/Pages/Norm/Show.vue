<template>
    <AppLayout title="Normativas">
        <div class="lg:py-7 lg:px-10 py-2 px-1">
          <Back />
          <div class="mt-7">
            <p class="mt-4">{{ norm.title }}</p>
            
          </div>
        
        </div>

    </AppLayout>
  
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import Back from '@/Components/MyComponents/Back.vue';

export default {
data(){
    return {

    }
},
components:{
AppLayout,
Back
},
props:{
norm: Object
},
methods:{

}
}
</script>

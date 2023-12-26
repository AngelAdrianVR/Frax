<template>
    <AppLayout title="Vecinos">
        <div class="py-8 px-3 lg:px-12">

            <h1 class="font-bold">Directorio de vecinos</h1>

            <div class="mt-4 lg:mx-12">
                <NeighborsDirectoryTable :users="users.data" />
                
            </div>
        </div>

    </AppLayout>
  
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import NeighborsDirectoryTable from "@/Components/MyComponents/Neighbors/NeighborsDirectoryTable.vue";

export default {
data(){
    return {

    }
},
components:{
AppLayout,
PrimaryButton,
NeighborsDirectoryTable,
},
props:{
users: Object
},
methods:{

}
}
</script>

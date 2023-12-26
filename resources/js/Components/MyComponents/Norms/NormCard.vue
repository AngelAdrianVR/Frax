<template>
    <div @click="$inertia.get(route('norms.show', norm.id))" class=" my-2 rounded-md border border-gray4 h-[330px] cursor-pointer shadow-md transition ease-in-out duration-100 active:scale-95">
        <figure v-if="norm.image_cover?.length > 0" class="bg-gray3 m-4 rounded-md h-52">
            <img class="h-52 w-full rounded-lg" :src="norm.image_cover[0]?.original_url" alt="Sin imagen" >
        </figure>
        <div v-else class="bg-gray3 m-4 rounded-md h-52"></div>
        <p class="pl-3 py-3 bg-primarylight">{{ norm.title }}</p>
        <p v-if="norm.updated_at == null" class="text-xs text-right pr-2 mt-4">Creado el {{ norm.created_at }}</p>
        <p v-if="norm.updated_at" class="text-xs text-right pr-2 mt-4">Actualizado el {{ norm.updated_at }}</p>
    </div>
</template>

<script>
export default {
data(){
    return{

    }
},
components:{

},
props:{
norm: Object
},
methods:{

}
}
</script>

<template>
    <table class="w-11/12 mx-auto text-sm mt-5">
                <thead>
                    <tr class="text-center *:text-left *:border-b *:border-primary *:font-bold *:pb-1">
                        <th class=" pl-2">
                        ID
                        </th>
                        <th>
                        Nombre
                        </th>
                        <th>
                        Tipo
                        </th>
                        <th>
                        Fecha de registro
                        </th>
                        <th>
                        Estatus
                        </th>
                        <th>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(history, index) in services_history" :key="index"
                        class="mb-4 rounded-full *:py-2"
                        :class="{ 'bg-[#F2F2F2]': index % 2 == 0 }"
                    >
                        <td class="pl-3 rounded-l-full">
                        {{ history.id}}
                        </td>
                        <td class="pr-2">
                            <span :title="history.name" class="truncate">{{ history.name }}</span>
                        </td>
                        <td class="pr-2">
                            {{ history.is_internal ? 'Interno' : 'Externo' }}
                        </td>
                        <td class="pr-2">
                            {{ history.created_at }}
                        </td>
                        <td>
                            <p class="pr-2" :class="statusColor(history.is_active)"> {{ history.is_active ? 'Activo' : 'Inactivo' }} </p>
                        </td>
                        <td class="rounded-r-full flex items-center">
                            <el-popconfirm confirm-button-text="Si" cancel-button-text="No" icon-color="#D90537"
                                title="¿Continuar?" @confirm="deleteService(history)">
                                <template #reference>
                                    <button class="rounded-full flex justify-center items-center w-7 h-7 text-xs"><i
                                            class="fa-regular fa-trash-can"></i></button>
                                </template>
                            </el-popconfirm>
                            <button @click="$inertia.get(route('services.edit', history.id))"
                                    class="rounded-full flex justify-center items-center w-7 h-7 text-xs"><i
                                    class="fa-solid fa-pencil"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
         </table>
    
</template>
  
<script>

export default {
data(){
    return {
        
    }
},
components:{
},
props:{
services_history: Array
},
emits:['delete-service'],
methods:{
    statusColor(is_active) {
        if (is_active) {
            return "text-green-500";
        } else {
            return "text-red-500";
        }
    },
    deleteService(history) {
        this.$emit('delete-service', history);
    }
}
};
</script>

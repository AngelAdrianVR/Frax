<template>
    <table class="w-full mx-auto text-sm mt-5">
                <thead>
                    <tr class="text-center">
                        <th class="font-bold pb-1 pl-2 text-left border-b border-primary">
                        ID
                        </th>
                        <th class="font-bold pb-1 text-left border-b border-primary">
                        Nombre
                        </th>
                        <th class="font-bold pb-1 text-left border-b border-primary">
                        Fecha de visita
                        </th>
                        <th class="font-bold pb-1 text-left border-b border-primary">
                        Hora
                        </th>
                        <th class="font-bold pb-1 text-left border-b border-primary">
                        Tipo de acceso
                        </th>
                        <th class="font-bold pb-1 text-left border-b border-primary">
                        Ingreso
                        </th>
                        <th class="font-bold pb-1 text-left border-b border-primary">
                        Salida
                        </th>
                        <th class="font-bold pb-1 text-left border-b border-primary">
                        Estatus
                        </th>
                        <th class="font-bold pb-3 text-left border-b border-primary">
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(history, index) in guestHistories" :key="index"
                        class="mb-4 rounded-full"
                        :class="{ 'bg-[#F2F2F2]': index % 2 == 0 }"
                    >
                        <td class="py-2 pl-3 rounded-l-full">
                        {{ history.id}}
                        </td>
                        <td class="py-2 pr-2">
                            <span :title="history.name" class="truncate">{{ history.name }}</span>
                        </td>
                        <td class="py-2 pr-2">
                            <p class="w-32">{{ history.date }}</p>
                        </td>
                        <td class="py-2 pr-2">
                            <p class="w-20">{{ history.time ?? '---' }}</p>
                        </td>
                        <td class="py-2 pr-2">
                            {{ history.type_access }}
                        </td>
                        <td class="py-2 pr-2">
                            <p class="w-20">{{ history.arrived_at }}</p>
                        </td>
                        <td class="py-2 pr-2">
                            <p class="w-20">{{ history.leaved_at }}</p>
                        </td>
                        <td class="py-2 rounded-r-full">
                            <p class="pr-2" :class="statusColor(history.status)"> {{ history.status }} </p>
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
guestHistories: Array
},
methods:{
    statusColor(status) {
        if (status == "Pendiente") {
            return "text-amber-500";
        } else if (status == "Ingresado") {
            return "text-green-500";
        } else if (status == "Expirado") {
            return "text-red-500";
        }
    }
}
};
</script>

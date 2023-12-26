<template>
  <table class="w-full mx-auto text-sm mt-5">
                <thead>
                    <tr class="text-center">
                        <th class="font-bold pb-1 pl-2 text-left border-b border-primary">
                        </th>
                        <th class="font-bold pb-1 text-left border-b border-primary">
                        Nombre
                        </th>
                        <th class="font-bold pb-1 text-left border-b border-primary">
                        Teléfono
                        </th>
                        <th class="font-bold pb-1 text-left border-b border-primary">
                        Dirección
                        </th>
                        <th class="font-bold pb-3 text-left border-b border-primary">
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(user, index) in users" :key="index"
                        class="mb-4 rounded-full"
                        :class="{ 'bg-[#F2F2F2]': index % 2 == 0 }"
                    >
                        <td class="py-2 pl-3 rounded-l-full">
                            <figure class="flex text-sm mr-6">
                                <img class="h-10 w-10 rounded-full object-cover" :src="user.profile_photo_url"
                                    :alt="user.profile_photo_url">
                            </figure>
                        </td>
                        <td class="py-2">
                            {{ user.name}}
                        </td>
                        <td class="py-2 pr-2">
                            {{ user.phone }}
                        </td>
                        <td class="py-2 pr-2">
                            {{ user.date }}
                        </td>
                        <td class="py-2 rounded-r-full">Actions
                        </td>
                    </tr>
                </tbody>
         </table>
</template>

<script>
export default {
data() {
    return {

    }
},
components:{

},
props:{
    users: Array
}, 
methods:{

}
}
</script>

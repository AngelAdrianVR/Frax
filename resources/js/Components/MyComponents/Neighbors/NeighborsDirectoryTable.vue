<template>
  <table class="w-full mx-auto text-sm mt-5">
                <thead>
                    <tr class="text-center *:font-bold pb-1 *:text-left *:border-b *:border-primary">
                        <th class="pl-2">
                        </th>
                        <th>
                        Nombre
                        </th>
                        <th>
                        Teléfono
                        </th>
                        <th>
                        Dirección
                        </th>
                        <th class="pb-3">
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(user, index) in users" :key="index"
                        class="mb-4 rounded-full *:py-2"
                        :class="{ 'bg-[#F2F2F2]': index % 2 == 0 }"
                    >
                        <td class="pl-3 rounded-l-full">
                            <figure class="flex text-sm mr-6">
                                <img class="size-10 rounded-full object-cover" :src="user.profile_photo_url"
                                    :alt="user.profile_photo_url">
                            </figure>
                        </td>
                        <td class="">
                            {{ user.name}}
                        </td>
                        <td class="pr-2">
                            {{ user.resident_properties?.phone }}
                        </td>
                        <td class="pr-2">
                            {{ user.resident_properties?.address }}
                        </td>
                        <td class="rounded-r-full">Actions
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

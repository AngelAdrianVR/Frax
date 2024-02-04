<template>
    <LoadingState :loading="loading" />
    <div v-if="!loading" class="min-h-[calc(100vh-9rem)]">
        <div class="flex justify-between items-center lg:mx-12 mb-10 mt-2">
            <h2 class="font-bold">Historial de visitas</h2>
        </div>
    
        <div class="overflow-auto">
            <GuestHistoryTable v-if="guestHistories.length" :guestHistories="guestHistories" />
            <p class="text-xs text-gray-400 text-center" v-else>No tienes historial de visitas</p>
        </div>
        <!-- --- pagination --- -->
        <!-- <div class="mt-4">
                  <Pagination :pagination="guestHistories" />
                </div> -->
    </div>
</template>
<script>
import GuestHistoryTable from "@/Components/MyComponents/Guest/GuestHistoryTable.vue";
import LoadingState from "@/Components/MyComponents/LoadingState.vue";

export default {
    data() {
        return {
            guestHistories: [],
            loading: true,
        }
    },
    components: {
        GuestHistoryTable,
        LoadingState,
    },
    methods: {
        async fetchGuestHistories() {
            try {
                this.loading = true;
                const response = await axios.get(route('guest-histories.get-all'));
                if (response.status === 200) {
                    this.guestHistories = response.data.items;
                }
            } catch (error) {
                console.log(error);
            } finally {
                this.loading = false;
            }
        }
    },
    mounted() {
        this.fetchGuestHistories();
    }
}
</script>
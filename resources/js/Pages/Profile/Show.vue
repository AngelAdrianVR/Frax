<template>
    <AppLayout title="Perfil">
        <header class="mb-6 mt-12 mx-20">
            <h1 class="font-bold text-lg">Mi perfil</h1>
        </header>
        <main class="px-20">
            <el-tabs v-model="activeTab" class="demo-tabs">
                <el-tab-pane name="1">
                    <template #label>
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="size-4 mr-1 mb-1">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                            </svg>
                            <span>Información personal</span>
                        </div>
                    </template>
                    <Personal />
                </el-tab-pane>
                <el-tab-pane name="2">
                    <template #label>
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="size-4 mr-1 mb-1">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M8.25 18.75a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 0 1-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 0 0-3.213-9.193 2.056 2.056 0 0 0-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 0 0-10.026 0 1.106 1.106 0 0 0-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12" />
                            </svg>
                            <span>Vehículos</span>
                        </div>
                    </template>
                    <Vehicles />
                </el-tab-pane>
                <el-tab-pane name="3">
                    <template #label>
                        <div class="flex items-center">
                            <i class="fa-solid fa-paw mr-[5px] mb-1"></i>
                            <span>Mascotas</span>
                        </div>
                    </template>
                    <Pets />
                </el-tab-pane>
                <el-tab-pane name="4">
                    <template #label>
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="size-4 mr-1 mb-1">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z" />
                            </svg>
                            <span>Privacidad y seguridad</span>
                        </div>
                    </template>
                    <Security />
                </el-tab-pane>
            </el-tabs>
        </main>
    </AppLayout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout.vue';
import Personal from '@/Pages/Profile/Partials/Personal.vue';
import Vehicles from '@/Pages/Profile/Partials/Vehicles.vue';
import Pets from '@/Pages/Profile/Partials/Pets.vue';
import Security from '@/Pages/Profile/Partials/Security.vue';

export default {
    data() {
        return {
            activeTab: '1',
        }
    },
    components: {
        AppLayout,
        Personal,
        Vehicles,
        Pets,
        Security,
    },
    methods: {
    }
}
</script>

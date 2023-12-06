<template>
    <AppLayout title="Registrar problema de mantenimiento">
        <div class="lg:py-7 lg:px-10">
            <Back />

            <h1 class="font-bold mx-28 mt-5">Hacer reporte</h1>
            <div class="grid grid-cols-2 gap-x-32 gap-y-1 mx-28 mt-5">
                <!-- columna izquierda -->
                <div>
                    <form @submit.prevent="store" class="mt-5 text-sm">
                        <div class="block ml-auto">
                            <label class="flex items-center">
                                <Checkbox v-model:checked="form.is_anonymous_report" name="is_anonymous_report" required />
                                <span class="ms-2 text-sm text-gray-600">
                                    Anónimo
                                    <el-tooltip content="No se mostrá tun nombre en los detalles del reporte"
                                        placement="top">
                                        <div
                                            class="rounded-full border border-primary w-3 h-3 flex items-center justify-center">
                                            <i class="fa-solid fa-info text-primary text-[7px]"></i>
                                        </div>
                                    </el-tooltip>
                                </span>
                            </label>
                        </div>
                        <div class="mt-2">
                            <InputLabel value="Problemática*" class="ml-3 mb-1" />
                            <input v-model="form.name" placeholder="Seleccione" class="input" type="text" required />
                            <InputError :message="form.errors.name" />
                        </div>
                        <div class="flex justify-end mt-7">
                            <PrimaryButton :disabled="!form.name || !form.description || !form.location">
                                Enviar reporte
                            </PrimaryButton>
                        </div>
                    </form>
                </div>
                <!-- columna derecha -->
            </div>
        </div>
    </AppLayout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import Back from '@/Components/MyComponents/Back.vue';
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import Checkbox from "@/Components/Checkbox.vue";
import { useForm, Link } from "@inertiajs/vue3";
import axios from "axios";

export default {
    data() {
        const form = useForm({
            name: null,
            description: null,
            location: null,
            is_anonymous_report: false,
        });
        return {
            form,
        };
    },
    components: {
        AppLayout,
        PrimaryButton,
        InputLabel,
        InputError,
        Checkbox,
        Back,
        Link,
    },
    props: {
    },
    methods: {

    }
};
</script>
<template>
    <AppLayout title="Editar problema de mantenimiento">
        <div class="lg:py-7 lg:px-10">
            <HideableLabel class="absolute right-0 top-28 z-50" iconClass="fa-solid fa-info">
                <p>
                    El tiempo de respuesta depende de la problemática, ya que en algunos casos puede tomar más tiempo por
                    <br>
                    situaciones que se encuentran fuera de nuestro alcance
                </p>
            </HideableLabel>
            <Back />

            <h1 class="font-bold mx-28 mt-5 flex items-center space-x-2">
                <i class="fa-solid fa-face-grin-wide"></i>
                <span>Editar reporte</span>
            </h1>
            <div class="grid grid-cols-2 gap-x-32 gap-y-1 mx-28 mt-5">
                <!-- columna izquierda -->
                <div>
                    <form @submit.prevent="update" class="mt-1 text-sm">
                        <div class="flex items-center justify-end">
                            <label class="flex space-x-2">
                                <Checkbox v-model:checked="form.is_anonymous_report" name="is_anonymous_report" />
                                <span class="mr-2 text-sm text-gray-600 flex items-center">
                                    <span class="mr-2">Anónimo</span>
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
                        <div class="mt-2">
                            <p class="flex items-center space-x-2">
                                <InputLabel value="Ubicación del reporte*" class="ml-3 mb-1" />
                                <el-tooltip content="Proporciona la ubicación específica donde se requiere el mantenimeinto"
                                    placement="top">
                                    <div
                                        class="rounded-full border border-primary w-3 h-3 flex items-center justify-center">
                                        <i class="fa-solid fa-info text-primary text-[7px]"></i>
                                    </div>
                                </el-tooltip>
                            </p>
                            <input v-model="form.location" placeholder="Escriba la ubicación" class="input" type="text"
                                required />
                            <InputError :message="form.errors.location" />
                        </div>
                        <div class="mt-2">
                            <InputLabel value="Descripción*" class="ml-3 mb-1" />
                            <textarea v-model="form.description" placeholder="Escriba la descripción" class="textarea"
                                rows="4" required></textarea>
                            <InputError :message="form.errors.description" />
                        </div>
                        <div class="mt-2">
                            <p class="flex items-center space-x-2">
                                <InputLabel value="Agregar fotografías*" class="ml-3 mb-1" />
                                <el-tooltip content="Añade fotografías para complementar el reporte " placement="top">
                                    <div
                                        class="rounded-full border border-primary w-3 h-3 flex items-center justify-center">
                                        <i class="fa-solid fa-info text-primary text-[7px]"></i>
                                    </div>
                                </el-tooltip>
                            </p>
                            <InputFilePreview @imagen="saveImage" />
                            <InputError :message="form.errors.location" />
                        </div>
                        <div class="flex justify-end mt-7">
                            <PrimaryButton :disabled="!form.name || !form.description || !form.location || form.processing">
                                Guardar cambios
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
import HideableLabel from '@/Components/MyComponents/HideableLabel.vue';
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import Checkbox from "@/Components/Checkbox.vue";
import InputFilePreview from "@/Components/MyComponents/InputFilePreview.vue";
import { useForm, Link } from "@inertiajs/vue3";

export default {
    data() {
        const form = useForm({
            name: this.maintenance.name,
            description: this.maintenance.description,
            location: this.maintenance.location,
            image: null,
            is_anonymous_report: Boolean(this.maintenance.is_anonymous_report),
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
        InputFilePreview,
        HideableLabel,
    },
    props: {
        maintenance: Object,
    },
    methods: {
        update() {
            if (this.form.image) {
                this.form.post(route("maintenances.update-with-media", this.maintenance), {
                    onSuccess: () => {
                        this.$notify({
                            title: "Correcto",
                            message: "Se ha actualizado el reporte. Espera respuesta pronto",
                            type: "success",
                        });
                    },
                });
            } else {
                this.form.put(route("maintenances.update", this.maintenance), {
                    onSuccess: () => {
                        this.$notify({
                            title: "Correcto",
                            message: "Se ha actualizado el reporte. Espera respuesta pronto",
                            type: "success",
                        });
                    },
                });
            }
        },
        saveImage(image) {
            this.form.image = image;
        },
    }
};
</script>
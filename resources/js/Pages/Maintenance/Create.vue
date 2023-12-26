<template>
    <AppLayout title="Registrar problema de mantenimiento">
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
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M21.75 6.75a4.5 4.5 0 0 1-4.884 4.484c-1.076-.091-2.264.071-2.95.904l-7.152 8.684a2.548 2.548 0 1 1-3.586-3.586l8.684-7.152c.833-.686.995-1.874.904-2.95a4.5 4.5 0 0 1 6.336-4.486l-3.276 3.276a3.004 3.004 0 0 0 2.25 2.25l3.276-3.276c.256.565.398 1.192.398 1.852Z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.867 19.125h.008v.008h-.008v-.008Z" />
                </svg>
                <span>Hacer reporte</span>
            </h1>
            <div class="grid grid-cols-2 gap-x-32 gap-y-1 mx-28 mt-5">
                <!-- columna izquierda -->
                <div>
                    <form @submit.prevent="store" class="mt-1 text-sm">
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
                            <el-select v-model="form.name" placeholder="Seleccione" class="w-full">
                                <el-option v-for="item in problemTypes" :key="item.label" :label="item.label"
                                    :value="item.label" class="flex items-center justify-between">
                                    <span>
                                        <i class="mr-2" :class="item.icon"></i>
                                        {{ item.label }}
                                    </span>
                                    <span class="text-[11px] text-gray1">{{ item.help }}</span>
                                </el-option>
                            </el-select>
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
                            <div class="flex flex-wrap">
                                <InputFilePreview v-for="(file, index) in form.images" :key="index" :canDelete="index == (form.images.length - 2)"
                                    @imagen="saveImage" @cleared="handleCleared(index)" class="my-2 mr-4" />
                            </div>
                        </div>
                        <div class="flex justify-end mt-7">
                            <PrimaryButton :disabled="!form.name || !form.description || !form.location || form.processing">
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
import HideableLabel from '@/Components/MyComponents/HideableLabel.vue';
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import Checkbox from "@/Components/Checkbox.vue";
import InputFilePreview from "@/Components/MyComponents/InputFilePreview.vue";
import { useForm, Link } from "@inertiajs/vue3";

export default {
    data() {
        const form = useForm({
            name: null,
            description: null,
            location: null,
            images: [null],
            is_anonymous_report: false,
        });
        return {
            form,
            problemTypes: [
                {
                    label: "Áreas verdes",
                    help: "(césped, arbustos, plantas, etc)",
                    icon: 'fa-solid fa-leaf'
                },
                {
                    label: "Iluminación",
                    help: "(Farolas, luces, etc)",
                    icon: 'fa-solid fa-lightbulb'
                },
                {
                    label: "Seguridad",
                    help: "(camáras de seguridad, etc)",
                    icon: 'fa-solid fa-shield-halved'
                },
                {
                    label: "Instalaciones deportivas",
                    help: "(cancha de fut-bol, etc)",
                    icon: 'fa-solid fa-person-running'
                },
                {
                    label: "Áreas de juego",
                    help: "(parques infantiles, etc)",
                    icon: 'fa-solid fa-puzzle-piece'
                },
                {
                    label: "Residuos",
                    help: "(contenedores de basura, etc)",
                    icon: 'fa-solid fa-recycle'
                },
                {
                    label: "Infraestructura del fraccionamiento",
                    help: "(calles, aceras, etc)",
                    icon: 'fa-solid fa-trowel-bricks'
                },
                {
                    label: "Áreas comunes",
                    help: "(salón de eventos, área de golf, etc) ",
                    icon: 'fa-solid fa-map'
                },
            ],
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
    },
    methods: {
        store() {
            this.form.post(route("maintenances.store"), {
                onSuccess: () => {
                    this.$notify({
                        title: "Correcto",
                        message: "Se ha registrado el reporte. Espera respuesta pronto",
                        type: "success",
                    });
                },
            });
        },
        handleCleared(index) {
            // Eliminar el componente y su información correspondiente cuando se borra la imagen
            this.form.images.splice(index, 1);
        },
        saveImage(image) {
            const currentIndex = this.form.images.length - 1;
            this.form.images[currentIndex] = image;
            this.form.images.push(null);
        },
    }
};
</script>
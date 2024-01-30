<template>
    <AppLayout title="Registrar área común">
        <div class="lg:py-7 lg:px-10">
            <Back />

            <h1 class="font-bold mx-5 lg:mx-28 mt-5">Agregar área común</h1>
            <form @submit.prevent="store" class="grid grid-cols-1 lg:grid-cols-2 gap-x-14 gap-y-1 mx-5 lg:mx-20 mt-5">
                <!-- columna izquierda -->
                <section>
                    <div>
                        <InputLabel value="Nombre del área*" class="ml-3 mb-1" />
                        <el-input v-model="form.name" placeholder="Escribe el nombre aqui" :maxlength="255" clearable />
                        <InputError :message="form.errors.name" />
                    </div>
                    <div class="mt-1">
                        <InputLabel value="Costo*" class="ml-3 mb-1" />
                        <el-input v-model="form.cost" placeholder=""
                            :formatter="(value) => `$ ${value}`.replace(/\B(?=(\d{3})+(?!\d))/g, ',')"
                            :parser="(value) => value.replace(/\D/g, '')" />
                        <InputError :message="form.errors.cost" />
                    </div>
                    <section class="lg:grid grid-cols-2 gap-x-1 gap-y-px">
                        <div class="mt-1">
                            <InputLabel value="Horas de preparación*" class="ml-3 mb-1" />
                            <el-input-number v-model="form.preparation_hours" size="small" :min="0" :max="31" />
                            <InputError :message="form.errors.preparation_hours" />
                        </div>
                        <div class="mt-1">
                            <InputLabel value="Días de anticipación para reservar*" class="ml-3 mb-1" />
                            <el-input-number v-model="form.days_anticipation_booking" size="small" :min="0" :max="31" />
                            <InputError :message="form.errors.days_anticipation_booking" />
                        </div>
                        <div class="mt-1">
                            <InputLabel value="Capacidad máxima*" class="ml-3 mb-1" />
                            <el-input-number v-model="form.capacity" size="small" :min="1" :max="1000" />
                            <InputError :message="form.errors.capacity" />
                        </div>
                    </section>
                    <div class="mt-1">
                        <el-checkbox v-model="form.is_multiple_reserved" label="Puede reservarse multiples veces en un día"
                            size="small" />
                    </div>
                    <div class="mt-1">
                        <InputLabel value="Descripción*" class="ml-3 mb-1" />
                        <el-input v-model="form.description" :autosize="{ minRows: 3, maxRows: 5 }" type="textarea"
                            placeholder="Proporciona detalles sobre las comodidades y actividades en esta área..."
                            :maxlength="800" show-word-limit clearable />
                        <InputError :message="form.errors.description" />
                    </div>
                    <div class="mt-1">
                        <InputLabel value="Notas*" class="ml-3 mb-1" />
                        <el-input v-model="form.notes" :autosize="{ minRows: 3, maxRows: 5 }" type="textarea"
                            placeholder="Agrega notas adicionales o comentarios aquí.." :maxlength="800" show-word-limit
                            clearable />
                        <InputError :message="form.errors.notes" />
                    </div>
                    <div class="flex flex-col items-center mt-7">
                        <PrimaryButton class="w-1/2" :disabled="!form.name || !form.description || form.processing">Guardar
                        </PrimaryButton>
                    </div>
                </section>
                <!-- columna derecha desktop-->
                <section>
                    <!-- horario semanal -->
                    <InputLabel value="Horario semanal*" class="ml-3 mb-1" />
                    <article class="text-sm border px-3 py-1 rounded-md">
                        <tr class="grid grid-cols-3 gap-x-3 text-xs">
                            <th class="flex items-center">Día</th>
                            <th class="col-span-2 flex items-center space-x-5">
                                <span class="w-1/3">Hora de apertura</span>
                                <span class="w-1/3">Hora de cierre</span>
                                <span class="w-1/3">Duración de reservación</span>
                            </th>
                        </tr>
                        <tr v-for="(day, index) in weekDays" :key="index" class="grid grid-cols-4 gap-x-3">
                            <div class="flex space-x-3 items-center">
                                <el-switch v-model="form.schedule[index].active" size="small" />
                                <span>{{ day }}</span>
                            </div>
                            <div v-if="form.schedule[index].active" class="col-span-3 flex items-center space-x-3 mb-1">
                                <el-time-select v-model="form.schedule[index].open" :max-time="form.schedule[index].close"
                                    placeholder="Apertura" start="05:00" step="00:15" end="23:30" format="hh:mm A" />
                                <el-time-select v-model="form.schedule[index].close" :min-time="form.schedule[index].open"
                                    placeholder="Cierre" start="05:00" step="00:15" end="23:30" format="hh:mm A"
                                    value-format="HH:mm" />
                                <el-input-number v-model="form.schedule[index].duration" size="small" :min="1" :max="8"
                                    class="!w-2/3" />
                            </div>
                            <div v-else class="col-span-2 my-2 text-gray2 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor" class="size-4 mr-2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M21.752 15.002A9.72 9.72 0 0 1 18 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 0 0 3 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 0 0 9.002-5.998Z" />
                                </svg>
                                <p>Cerrado</p>
                            </div>
                        </tr>
                    </article>
                    <div class="mt-2">
                        <InputLabel value="Características*" class="ml-3 mb-1" />
                        <div class="flex items-center space-x-2">
                            <el-select v-model="feature" placeholder="Seleccione" class="!w-1/2"
                                @change="featureValue = null" no-data-text="No hay opciones registradas"
                                no-match-text="No se encontraron coincidencias">
                                <el-option v-for="(item, index) in featureList" :key="index" :value="item.label"
                                    :disabled="form.features.some(feature => feature.label === item.label)">
                                    <i :class="item.icon"></i>
                                    <span class="ml-3">{{ item.label }}</span>
                                </el-option>
                            </el-select>
                            <el-input
                                v-if="feature !== null && featureList.find(item => item.label === feature)?.unit !== null"
                                v-model="featureValue" placeholder="Cantidad" :maxlength="255" clearable class="!w-1/3">
                                <template #append>
                                    {{ featureList.find(item => item.label === feature)?.unit }}
                                </template>
                            </el-input>
                            <el-tooltip content="Agregar a la lista" placement="top">
                                <el-button @click="addFeature" type="success" size="small" class="!ml-auto" circle
                                    :disabled="feature === null || (featureList.find(item => item.label === feature)?.unit !== null && !featureValue)">
                                    <i class="fa-solid fa-check"></i>
                                </el-button>
                            </el-tooltip>
                        </div>
                        <!-- lista de caracteristicas -->
                        <ul class="mt-3 text-xs text-gray1 grid grid-cols-2 gap-1">
                            <li v-for="(item, index) in form.features" :key="index"
                                class="flex items-center space-x-2 mb-1">
                                <i :class="item.icon"></i>
                                <span>{{ item.label }}</span>
                                <span>{{ item.value }}</span>
                                <button @click="removeFeature(index)" type="button"
                                    class="ml-auto pr-2 text-right hover:text-red-500">
                                    <i class="fa-regular fa-circle-xmark"></i>
                                </button>
                            </li>
                        </ul>
                        <div class="flex flex-wrap">
                            <InputFilePreview v-for="(file, index) in form.images" :key="index"
                                :canDelete="index == (form.images.length - 2)" @imagen="saveImage"
                                @cleared="handleCleared(index)" class="my-2 mr-4" />
                        </div>
                    </div>
                </section>
            </form>
        </div>
    </AppLayout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import Back from '@/Components/MyComponents/Back.vue';
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import InputFilePreview from "@/Components/MyComponents/InputFilePreview.vue";
import { useForm, Link } from "@inertiajs/vue3";

export default {
    data() {
        const form = useForm({
            name: null,
            description: null,
            notes: null,
            cost: null,
            capacity: 1,
            preparation_hours: 0,
            rules: null,
            policy: null,
            days_anticipation_booking: 0,
            is_multiple_reserved: true,
            features: [],
            images: [null],
            schedule: [
                { open: null, close: null, duration: 1, active: true },
                { open: null, close: null, duration: 1, active: true },
                { open: null, close: null, duration: 1, active: true },
                { open: null, close: null, duration: 1, active: true },
                { open: null, close: null, duration: 1, active: true },
                { open: null, close: null, duration: 1, active: true },
                { open: null, close: null, duration: 1, active: true },
            ],
        });
        return {
            form,
            value: null,
            weekDays: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado',],
            featureList: [
                {
                    label: 'Espacio para niños',
                    icon: 'fa-solid fa-fan',
                    unit: 'Niños',
                },
                {
                    label: 'Profundidad',
                    icon: 'fa-solid fa-person-swimming',
                    unit: 'Metros',
                },
                {
                    label: 'Estacionamiento',
                    icon: 'fa-solid fa-car-side',
                    unit: 'Vehículos',
                },
                {
                    label: 'Área para fumar',
                    icon: 'fa-solid fa-smoking',
                    unit: null,
                },
                {
                    label: 'Asadores',
                    icon: 'fa-solid fa-burger',
                    unit: 'Unidades',
                },
                {
                    label: 'Vigilancia',
                    icon: 'fa-solid fa-user-shield',
                    unit: null,
                },
                {
                    label: 'Acceso a mascotas',
                    icon: 'fa-solid fa-dog',
                    unit: null,
                },
                {
                    label: 'Sanitarios',
                    icon: 'fa-solid fa-restroom',
                    unit: null,
                },
                {
                    label: 'Accesible',
                    icon: 'fa-brands fa-accessible-icon',
                    unit: null,
                },
                {
                    label: 'Zona wifi',
                    icon: 'fa-solid fa-wifi',
                    unit: null,
                },
            ],
            feature: null,
            featureValue: null,
        };
    },
    components: {
        AppLayout,
        PrimaryButton,
        InputLabel,
        InputError,
        Back,
        Link,
        InputFilePreview,
    },
    props: {
        common_area: Object,
        reservations: Object,
    },
    methods: {
        handleCleared(index) {
            // Eliminar el componente y su información correspondiente cuando se borra la imagen
            this.form.images.splice(index, 1);
        },
        saveImage(image) {
            const currentIndex = this.form.images.length - 1;
            this.form.images[currentIndex] = image;
            this.form.images.push(null);
        },
        removeFeature(index) {
            this.form.features.splice(index, 1);
        },
        addFeature() {
            const selected = this.featureList.find(item => item.label === this.feature);
            let feature = {
                label: selected.label,
                icon: selected.icon,
                value: this.featureValue ? this.featureValue + ' ' + selected.unit : null,
            };
            this.form.features.push(feature);

            this.feature = null;
            this.featureValue = null;
        },
        store() {
            this.form.post(route("common-areas.store"), {
                onSuccess: () => {
                    this.$notify({
                        title: "Correcto",
                        message: "Se ha registrado el área común",
                        type: "success",
                    });
                },
            });
        },
    },
};
</script>

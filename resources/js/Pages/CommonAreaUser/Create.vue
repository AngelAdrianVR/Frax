<template>
    <AppLayout title="Registrar reservación de área común">
        <div class="lg:py-7 lg:px-10">
            <Back />

            <h1 class="font-bold mx-28 mt-5">{{ common_area.name }}</h1>
            <div class="grid grid-cols-2 gap-x-5 gap-y-1 mx-28 mt-5">
                <div>
                    <p class="w-full flex">
                        <span class="w-1/3">
                            <i class="fa-solid fa-dollar-sign w-1/6 text-center mr-2 text-secondary"></i>
                            <small>Costo</small>
                        </span>
                        <small class="w-2/3">${{ common_area.cost }} MXN</small>
                    </p>
                    <p class="w-full flex">
                        <span class="w-1/3">
                            <i class="fa-solid fa-users w-1/6 text-center mr-2 text-secondary"></i>
                            <small>Capacidad</small>
                        </span>
                        <small class="w-2/3">{{ common_area.capacity }} Personas</small>
                    </p>
                    <p v-for="(feature, index) in common_area.features" :key="index" class="w-full flex">
                        <span class="w-1/3">
                            <i :class="feature.icon" class="w-1/6 text-center mr-2 text-secondary"></i>
                            <small>{{ feature.label }}</small>
                        </span>
                        <small class="w-2/3">{{ feature.value }}</small>
                    </p>

                    <form @submit.prevent="store" class="mt-5 text-sm">
                        <div>
                            <InputLabel value="Fecha de reservación*" class="ml-3 mb-1" />
                            <el-date-picker v-model="form.date" type="date" placeholder="Seleccione"
                                :disabled-date="disabledDate" />
                            <InputError :message="form.errors.date" />
                        </div>
                        <div class="mt-2">
                            <InputLabel value="Horario disponible a reservar*" class="ml-3 mb-1" />
                            <el-select class="w-full" v-model="form.guest_type" clearable placeholder="Selecciona la fecha"
                                no-data-text="No hay opciones registradas" no-match-text="No se encontraron coincidencias">
                                <el-option v-for="item in guestTypes" :key="item" :label="item" :value="item" />
                            </el-select>
                            <InputError :message="form.errors.guest_type" />
                        </div>
                        <div class="mt-2">
                            <InputLabel value="Fecha de reservación*" class="ml-3 mb-1" />
                            <input v-model="form.people_quantity" placeholder="Escribe la cantidad de personas"
                                class="input" type="number" min="1" required />
                            <InputError :message="form.errors.people_quantity" />
                        </div>
                    </form>
                </div>
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
import { useForm } from "@inertiajs/vue3";

export default {
    data() {
        const form = useForm({
            people_quantity: null,
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
        Back
    },
    props: {
        common_area: Object
    },
    methods: {
        store() {
            this.form.post(route("guests.store"), {
                onSuccess: () => {
                    this.$notify({
                        title: "Correcto",
                        message: "Se ha registrado la visita",
                        type: "success",
                    });
                },
            });
        },
        triggerGuestImageInput() {
            // Simular clic en el input file cuando se hace clic en el icono de la cámara
            this.$refs.fileGuestInput.click();
        },
        triggerVehicleImageInput() {
            // Simular clic en el input file cuando se hace clic en el icono de la cámara
            this.$refs.fileVehicleInput.click();
        },
        handleGuestImageUpload(event) {
            const file = event.target.files[0];
            this.form.guest_image = file;

            if (file) {
                // Obtener la URL de la imagen cargada
                const imageURL = URL.createObjectURL(file);

                // Mostrar la vista previa de la imagen
                this.guestImage = imageURL;
            }
        },
        handleVehicleImageUpload(event) {
            const file = event.target.files[0];
            this.form.vehicle_image = file;

            if (file) {
                // Obtener la URL de la imagen cargada
                const imageURL = URL.createObjectURL(file);

                // Mostrar la vista previa de la imagen
                this.vehicleImage = imageURL;
            }
        },
        disabledDate(time) {
            const today = new Date();
            today.setHours(0, 0, 0, 0);
            return time.getTime() < today.getTime();
        },
    },
};
</script>

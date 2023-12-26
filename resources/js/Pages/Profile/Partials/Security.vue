<template>
    <section class="mb-6">
        <div class="col-span-4 lg:grid grid-cols-2 gap-x-4 gap-y-2 self-start mb-8">
            <h2 class="font-bold col-span-full mt-7">Seguridad y privacidad</h2>
        </div>
        <UpdatePasswordForm />
    </section>
</template>
<script>
import InputError from '@/Components/InputError.vue';
import PrimaryButton from "@/Components/PrimaryButton.vue";
import Back from '@/Components/MyComponents/Back.vue';
import InputLabel from "@/Components/InputLabel.vue";
import ThirthButton from "@/Components/ThirthButton.vue";
import InputFilePreview from "@/Components/MyComponents/InputFilePreview.vue";
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";
import { useForm, Link } from "@inertiajs/vue3";
import UpdatePasswordForm from "@/Pages/Profile/Partials/UpdatePasswordForm.vue";

export default {
    data() {
        const form = useForm({
            vehicles: [],
        });
        return {
            form,
        }
    },
    components: {
        InputError,
        InputLabel,
        PrimaryButton,
        Back,
        InputFilePreview,
        Link,
        ThirthButton,
        Dropdown,
        DropdownLink,
        UpdatePasswordForm
    },
    computed: {
        isVehicleCompleted() {
            return this.vehicle.brand &&
                this.vehicle.plate &&
                this.vehicle.color;
        },
    },
    methods: {
        update() {

        },
        saveImage(image) {
            this.vehicle.image = image;
        },
        clearVehicleImage() {
            this.vehicle.image = null;
        },
        isVehicleFormCorrect() {
            return true;
        },
        addVehicle() {
            if (this.isVehicleFormCorrect()) {
                // agregar vehiculo
                this.form.vehicles.push({ ...this.vehicle });
                this.resetVehicle();

                // hacer scroll hasta el final de la pagina
                this.$nextTick(() => {
                    const scrollTarget = this.$refs.vehicleList;
                    if (scrollTarget) {
                        // Scroll hacia el final de la página
                        scrollTarget.scrollIntoView({ behavior: "smooth", block: "end" });
                    }
                });
            }
        },
        updateVehicle() {
            if (this.isVehicleFormCorrect()) {
                // actualizar vehiculo
                this.form.vehicles[this.editIndex] = { ...this.vehicle };
                this.editIndex = null;
                this.resetVehicle();
            }
        },
        resetVehicle() {
            this.vehicle.brand = null;
            this.vehicle.plate = null;
            this.vehicle.color = null;
            this.vehicle.notes = null;
            this.vehicle.image = null;
            this.$refs.vehicleImage.image = null;
        },
        deleteVehicle(index) {
            this.form.vehicles.splice(index, 1);
        },
        editVehicle(index) {
            this.vehicle = { ...this.form.vehicles[index] };
            this.editIndex = index;
            this.$refs.vehicleImage.image = this.getURL(this.vehicle.image);
        },
        cancelVehicleEdition() {
            this.resetVehicle();
            this.editIndex = null;
        },
        getURL(file) {
            return URL.createObjectURL(file);
        },
    }
}
</script>
<template>
    <form @submit.prevent="update">
        <section class="my-6">
            <div class="col-span-4 lg:grid grid-cols-2 gap-x-4 gap-y-2 self-start">
                <h2 class="font-bold col-span-full mt-7">Vehículos</h2>
                <div>
                    <InputLabel value="Marca del vehículo" class="ml-2 mb-1" />
                    <el-select v-model="vehicle.brand" placeholder="Selecciona" class="w-full"
                        no-data-text="No hay opciones para mostrar" no-match-text="No se encontraron coincidencias">
                        <el-option v-for="(item, index) in brands" :key="index" :label="item" :value="item" />
                    </el-select>
                </div>
                <div>
                    <InputLabel value="Placas" class="ml-2 mb-1" />
                    <el-input v-model="vehicle.plate" placeholder="Escribe aqui las placas" maxlength="255" clearable />
                </div>
                <div>
                    <InputLabel value="Color" class="ml-2 mb-1" />
                    <el-input v-model="vehicle.color" placeholder="Ingresa el color" maxlength="255" clearable />
                </div>
                <div>
                    <InputLabel value="Notas" class="ml-2 mb-1" />
                    <el-input v-model="vehicle.notes" :autosize="{ minRows: 1, maxRows: 4 }" type="textarea"
                        placeholder="Escribe aqui tus notas" maxlength="255" show-word-limit clearable />
                </div>
                <div class="col-span-full flex">
                    <div>
                        <InputLabel value="Foto" class="ml-2" />
                        <InputFilePreview ref="vehicleImage" @imagen="saveImage" @cleared="clearVehicleImage" />
                    </div>
                    <ThirthButton v-if="editIndex !== null" @click="updateVehicle" type="button"
                        class="self-end ml-10 !rounded-full" :disabled="!isVehicleCompleted">
                        Actualizar vehículo
                    </ThirthButton>
                    <ThirthButton v-else @click="addVehicle" type="button" class="self-end ml-10 !rounded-full"
                        :disabled="!isVehicleCompleted">
                        Agregar a lista de vehículos
                    </ThirthButton>
                </div>
                <!-- vehicles list -->
                <div ref="vehicleList" v-if="form.vehicles.length"
                    class="col-span-full lg:grid grid-cols-3 gap-x-4 gap-y-2 mt-8 pb-5">
                    <h2 class="col-span-full mb-4">Lista de vehiculos</h2>
                    <div v-for="(item, index) in form.vehicles" :key="index">
                        <div class="border border-gray4 rounded-[3px] p-4 min-h-52 flex flex-col justify-between text-sm">
                            <div class="flex justify-between">
                                <figure class="h-1/2">
                                    <img v-if="item.image" class="size-16 rounded-full object-cover"
                                        :src="getURL(item.image)" :alt="item.name">
                                    <figure v-else
                                        class="flex items-center justify-center text-gray2  border-gray2 rounded-full size-16">
                                        <i class="fa-solid fa-car text-4xl"></i>
                                    </figure>
                                </figure>
                                <div class="flex space-x-1 items-center self-start">
                                    <el-popconfirm v-if="editIndex != index" confirm-button-text="Si"
                                        cancel-button-text="No" icon-color="#D90537" title="¿Continuar?"
                                        @confirm="deleteVehicle(index)">
                                        <template #reference>
                                            <button type="button"
                                                class="rounded-full bg-gray5 flex justify-center items-center size-7 text-xs"><i
                                                    class="fa-regular fa-trash-can"></i></button>
                                        </template>
                                    </el-popconfirm>
                                    <button type="button" v-if="editIndex != index" @click="editVehicle(index)"
                                        class="rounded-full bg-gray5 flex justify-center items-center size-7 text-xs"><i
                                            class="fa-solid fa-pencil"></i></button>
                                    <el-tag v-else effect="light" size="small" closable @close="cancelVehicleEdition"
                                        type="info">
                                        En edición
                                        <i class="fa-solid fa-arrow-up ml-2"></i>
                                    </el-tag>
                                </div>
                            </div>
                            <div class="h-1/2 grid grid-cols-3 gap-x-2 gap-y-1">
                                <b>Marca</b>
                                <span class="col-span-2">{{ item.brand }}</span>
                                <b>Placas</b>
                                <span class="col-span-2">{{ item.plate }}</span>
                                <b>Color</b>
                                <span class="col-span-2">{{ item.color }}</span>
                                <b>Notas</b>
                                <span class="col-span-2">{{ item.notes }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-span-full flex justify-end">
                <PrimaryButton class="ml-auto">Guardar</PrimaryButton>
            </div>
        </section>
    </form>
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

export default {
    data() {
        const form = useForm({
            vehicles: [],
        });
        return {
            form,
            vehicle: {
                brand: null,
                plate: null,
                color: null,
                notes: null,
                image: null,
            },
            editIndex: null,
            brands: [
                'Alfa romeo',
                'Audi',
                'BMW',
                'Cupra',
                'Ferrari',
                'Fiat',
                'Honda',
                'Kia',
                'Lamborghini',
                'Lexus',
                'Mazda',
                'Mercedes-benz',
                'Mitsubishi',
                'Renault',
                'Seat',
                'Subaru',
                'Tesla',
                'Toyota',
                'Volkswagen',
                'Volkswagen',
            ],
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
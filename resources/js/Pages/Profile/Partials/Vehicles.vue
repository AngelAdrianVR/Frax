<template>
    <LoadingState :loading="loading" />
    <section v-if="!loading" class="my-6">
        <div class="col-span-4 lg:grid grid-cols-2 gap-x-4 gap-y-2 self-start">
            <!-- lista de vehiculos -->
            <div ref="vehicleList" class="col-span-full lg:grid grid-cols-3 gap-x-4 gap-y-2 mt-1 pb-5">
                <h2 class="col-span-full mb-4 flex justify-between items-center font-bold">
                    <p>Vehiculos</p>
                    <PrimaryButton v-if="!showCreateForm" type="button" @click="prepareCreateForm">Agregar vehículo
                    </PrimaryButton>
                </h2>
                <p v-if="!vehicles.length" class="text-xs text-gray2">No has registrado ningún vehículo</p>
                <div v-for="(item, index) in vehicles" :key="index">
                    <div class="border border-gray4 rounded-[3px] p-4 my-2 lg:my-0 min-h-52 flex flex-col justify-between text-sm">
                        <div class="flex justify-between">
                            <figure class="h-1/2">
                                <img v-if="item.media?.length" class="size-16 rounded-full object-cover"
                                    :src="item.media[0].original_url">
                                <figure v-else
                                    class="flex items-center justify-center text-gray2 border-gray2 rounded-full size-16">
                                    <i class="fa-solid fa-car text-4xl"></i>
                                </figure>
                            </figure>
                            <div class="flex space-x-1 items-center self-start">
                                <el-popconfirm v-if="editIndex != index" confirm-button-text="Si" cancel-button-text="No"
                                    icon-color="#D90537" title="¿Continuar?" @confirm="deleteVehicle(index)">
                                    <template #reference>
                                        <button type="button"
                                            class="rounded-full bg-gray5 flex justify-center items-center size-7 text-xs"><i
                                                class="fa-regular fa-trash-can"></i></button>
                                    </template>
                                </el-popconfirm>
                                <button type="button" v-if="editIndex != index" @click="editVehicle(index)"
                                    class="rounded-full bg-gray5 flex justify-center items-center size-7 text-xs"><i
                                        class="fa-solid fa-pencil"></i></button>
                                <el-tag v-else effect="light" size="small" type="info">
                                    En edición
                                    <i class="fa-solid fa-arrow-down ml-2"></i>
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
                            <span class="col-span-2">{{ item.notes ?? '-' }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <form @submit.prevent="editIndex !== null ? updateVehicle() : store()" v-show="showCreateForm"
                class="col-span-full lg:grid grid-cols-2 gap-x-4 gap-y-2" ref="createForm">
                <h2 class="font-bold col-span-full mt-7">Agregar vehículo</h2>
                <div>
                    <InputLabel value="Marca" class="ml-2 mb-1" />
                    <el-select v-model="form.brand" placeholder="Selecciona" class="w-full"
                        no-data-text="No hay opciones para mostrar" no-match-text="No se encontraron coincidencias">
                        <el-option v-for="(item, index) in brands" :key="index" :label="item" :value="item" />
                    </el-select>
                </div>
                <div>
                    <InputLabel value="Placas" class="ml-2 mb-1" />
                    <el-input v-model="form.plate" placeholder="Ingresa las placas del vehículo" maxlength="7" clearable />
                </div>
                <div>
                    <InputLabel value="Color" class="ml-2 mb-1" />
                    <el-input v-model="form.color" placeholder="Escribe el color" maxlength="25" clearable />
                </div>
                <div>
                    <InputLabel value="Notas" class="ml-2 mb-1" />
                    <el-input v-model="form.notes" :autosize="{ minRows: 1, maxRows: 4 }" type="textarea"
                        placeholder="Escribe aqui tus notas" maxlength="255" show-word-limit clearable />
                </div>
                <div class="col-span-full flex">
                    <div>
                        <InputLabel value="Foto" class="ml-2 mb-1" />
                        <InputFilePreview ref="vehicleImage" @imagen="saveImage" @cleared="clearVehicleImage" />
                    </div>
                </div>
                <div class="col-span-full mt-10 lg:mt-0 flex justify-end space-x-2">
                    <CancelButton type="button" @click="showCreateForm = false; editIndex = null; resetForm();">Cancelar
                    </CancelButton>
                    <PrimaryButton :disabled="processing || !isFormCompleted">{{ editIndex !== null ? 'Guardar cambios' :
                        'Guardar' }}
                    </PrimaryButton>
                </div>
            </form>
        </div>
    </section>
</template>
<script>
import InputError from '@/Components/InputError.vue';
import PrimaryButton from "@/Components/PrimaryButton.vue";
import CancelButton from "@/Components/MyComponents/CancelButton.vue";
import InputLabel from "@/Components/InputLabel.vue";
import InputFilePreview from "@/Components/MyComponents/InputFilePreview.vue";
import { Link, useForm } from "@inertiajs/vue3";
import LoadingState from '@/Components/MyComponents/LoadingState.vue';
import axios from 'axios';

export default {
    data() {
        const form = useForm({
            brand: null,
            plate: null,
            color: null,
            notes: null,
            image: null,
        });
        return {
            form,
            processing: false,
            loading: false,
            showCreateForm: false,
            editIndex: null,
            vehicles: [],
            brands: [
                'BMW',
                'Tesla',
            ],
        }
    },
    components: {
        InputError,
        InputLabel,
        PrimaryButton,
        CancelButton,
        InputFilePreview,
        Link,
        LoadingState,
    },
    computed: {
        isFormCompleted() {
            return this.form.brand &&
                this.form.plate &&
                this.form.color;
        },
    },
    methods: {
        async store() {
            this.processing = true;
            try {
                const formData = new FormData();
                formData.append('brand', this.form.brand);
                formData.append('plate', this.form.plate);
                formData.append('color', this.form.color);

                if (this.form.notes) {
                    formData.append('notes', this.form.notes);
                }

                // Agregar la imagen al formulario
                if (this.form.image) {
                    formData.append('image', this.form.image);
                }
                const response = await axios.post(route('vehicles.store'), formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                    },
                });

                if (response.status === 200) {
                    this.vehicles.push(response.data.item);
                    this.resetForm();
                    this.$notify({
                        title: "Correcto",
                        message: "Se ha guardado el vehículo",
                        type: "success",
                    });
                }
            } catch (error) {
                console.log(error);
                this.$notify({
                    title: "Error de servidor",
                    message: "No se pudo guardar el vehículo por problema con el servidor. Favor de intentar más tarde",
                    type: "error",
                });
            } finally {
                this.processing = false;
            }
        },
        async deleteVehicle(index) {
            this.processing = true;
            try {
                const response = await axios.delete(route('vehicles.destroy', this.vehicles[index].id));

                if (response.status === 200) {
                    this.vehicles.splice(index, 1);
                    this.resetForm();
                    this.$notify({
                        title: "Correcto",
                        message: "Se ha eliminado el vehículo",
                        type: "success",
                    });
                }
            } catch (error) {
                console.log(error);
                this.$notify({
                    title: "Error de servidor",
                    message: "No se pudo eliminar el vehículo por problema con el servidor. Favor de intentar más tarde",
                    type: "error",
                });
            } finally {
                this.processing = false;
            }
        },
        async updateVehicle() {
            this.processing = true;
            try {
                const formData = new FormData();
                formData.append('brand', this.form.brand);
                formData.append('plate', this.form.plate);
                formData.append('color', this.form.color);
                
                if (this.form.notes) {
                    formData.append('notes', this.form.notes);
                }

                // Agregar la imagen al formulario
                if (this.form.image) {
                    formData.append('image', this.form.image);
                }
                const response = await axios.post(route('vehicles.update-with-media', this.vehicles[this.editIndex].id), formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                    },
                });

                if (response.status === 200) {
                    this.vehicles[this.editIndex] = response.data.item;
                    this.editIndex = null;
                    this.resetForm();
                    this.$notify({
                        title: "Correcto",
                        message: "Se ha actualizado el vehículo",
                        type: "success",
                    });
                }
            } catch (error) {
                console.log(error);
                this.$notify({
                    title: "Error de servidor",
                    message: "No se pudo actualizar el vehículo por problema con el servidor. Favor de intentar más tarde",
                    type: "error",
                });
            } finally {
                this.processing = false;
            }
        },
        prepareCreateForm() {
            this.showCreateForm = true;
            // hacer scroll hasta el final de la pagina
            this.$nextTick(() => {
                const scrollTarget = this.$refs.createForm;
                if (scrollTarget) {
                    // Scroll hacia el final de la página
                    scrollTarget.scrollIntoView({ behavior: "smooth", block: "end" });
                }
            });
        },
        saveImage(image) {
            this.form.image = image;
        },
        clearVehicleImage() {
            if (this.editIndex !== null) {
                this.form.image = 'deleted';
            } else {
                this.form.image = null;
            }
        },
        resetForm() {
            this.form.reset();
            this.$refs.vehicleImage.image = null;
        },
        editVehicle(index) {
            this.showCreateForm = true;
            this.form.brand = this.vehicles[index].brand;
            this.form.plate = this.vehicles[index].plate;
            this.form.color = this.vehicles[index].color;
            this.form.notes = this.vehicles[index].notes;
            this.form.image = null;
            this.editIndex = index;
            this.$refs.vehicleImage.image = this.vehicles[index].media[0].original_url;

            // hacer scroll hasta el final de la pagina
            this.$nextTick(() => {
                const scrollTarget = this.$refs.createForm;
                if (scrollTarget) {
                    // Scroll hacia el final de la página
                    scrollTarget.scrollIntoView({ behavior: "smooth", block: "end" });
                }
            });
        },
        async fetchVehicles() {
            this.loading = true;
            try {
                const response = await axios.get(route('vehicles.index'));

                if (response.status === 200) {
                    this.vehicles = response.data.items;
                }
            } catch (error) {
                console.log(error);
                this.$notify({
                    title: "Error de servidor",
                    message: "No se pudo obtener la lista de vehículos por problema con el servidor. Favor de intentar más tarde",
                    type: "error",
                });
            } finally {
                this.loading = false;
            }
        },
    },
    mounted() {
        this.fetchVehicles();
    }
}
</script>
<template>
    <LoadingState :loading="loading" />
    <section v-if="!loading" class="my-6">
        <div class="col-span-4 lg:grid grid-cols-2 gap-x-4 gap-y-2 self-start">
            <!-- lista de mascotas -->
            <div ref="petList" class="col-span-full lg:grid grid-cols-3 gap-x-4 gap-y-2 mt-1 pb-5">
                <h2 class="col-span-full mb-4 flex justify-between items-center font-bold">
                    <p>Mascotas</p>
                    <PrimaryButton v-if="!showCreateForm" type="button" @click="prepareCreateForm">Agregar mascota
                    </PrimaryButton>
                </h2>
                <p v-if="!pets.length" class="text-xs text-gray2">No has registrado ninguna mascota</p>
                <div v-for="(item, index) in pets" :key="index">
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
                                    icon-color="#D90537" title="¿Continuar?" @confirm="deletePet(index)">
                                    <template #reference>
                                        <button type="button"
                                            class="rounded-full bg-gray5 flex justify-center items-center size-7 text-xs"><i
                                                class="fa-regular fa-trash-can"></i></button>
                                    </template>
                                </el-popconfirm>
                                <button type="button" v-if="editIndex != index" @click="editPet(index)"
                                    class="rounded-full bg-gray5 flex justify-center items-center size-7 text-xs"><i
                                        class="fa-solid fa-pencil"></i></button>
                                <el-tag v-else effect="light" size="small" type="info">
                                    En edición
                                    <i class="fa-solid fa-arrow-down ml-2"></i>
                                </el-tag>
                            </div>
                        </div>
                        <div class="h-1/2 grid grid-cols-3 gap-x-2 gap-y-1">
                            <b>Nombre</b>
                            <span class="col-span-2">{{ item.name }}</span>
                            <b>Especie</b>
                            <span class="col-span-2">{{ item.species }}</span>
                            <b>Raza</b>
                            <span class="col-span-2">{{ item.race }}</span>
                            <b>Notas</b>
                            <span class="col-span-2">{{ item.notes ?? '-' }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <form @submit.prevent="editIndex !== null ? updatePet() : store()" v-show="showCreateForm"
                class="col-span-full lg:grid grid-cols-2 gap-x-4 gap-y-2" ref="createForm">
                <h2 class="font-bold col-span-full mt-7">Agregar mascota</h2>
                <div>
                    <InputLabel value="Nombre" class="ml-2 mb-1" />
                    <el-input v-model="form.name" placeholder="Escribe el nombre de tu mascota" maxlength="7" clearable />
                </div>
                <div>
                    <InputLabel value="Especie" class="ml-2 mb-1" />
                    <el-select v-model="form.species" placeholder="Selecciona" class="w-full"
                        no-data-text="No hay opciones para mostrar" no-match-text="No se encontraron coincidencias">
                        <el-option v-for="(item, index) in species" :key="index" :label="item" :value="item" />
                    </el-select>
                </div>
                <div>
                    <InputLabel value="Raza" class="ml-2 mb-1" />
                    <el-input v-model="form.race" placeholder="Escribe la raza" maxlength="255" clearable />
                </div>
                <div>
                    <InputLabel value="Notas" class="ml-2 mb-1" />
                    <el-input v-model="form.notes" :autosize="{ minRows: 1, maxRows: 4 }" type="textarea"
                        placeholder="Escribe aqui tus notas" maxlength="255" show-word-limit clearable />
                </div>
                <div class="col-span-full flex">
                    <div>
                        <InputLabel value="Foto" class="ml-2 mb-1" />
                        <InputFilePreview ref="petImage" @imagen="saveImage" @cleared="clearPetImage" />
                    </div>
                </div>
                <div class="col-span-full mt-10 lg:mt-0 flex justify-end space-x-2">
                    <CancelButton type="button" @click="showCreateForm = false; editIndex = null; resetForm();">Cancelar
                    </CancelButton>
                    <PrimaryButton :disabled="loading || !isFormCompleted">{{ editIndex !== null ? 'Guardar cambios' :
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
import LoadingState from '@/Components/MyComponents/LoadingState.vue';
import { Link, useForm } from "@inertiajs/vue3";
import axios from 'axios';

export default {
    data() {
        const form = useForm({
            name: null,
            species: null,
            race: null,
            notes: null,
            image: null,
        });
        return {
            form,
            processing: false,
            loading: false,
            showCreateForm: false,
            editIndex: null,
            pets: [],
            species: [
                'Gato',
                'Perro',
                'Otro',
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
            return this.form.name &&
                this.form.species &&
                this.form.race;
        },
    },
    methods: {
        async store() {
            this.processing = true;
            try {
                const formData = new FormData();
                formData.append('name', this.form.name);
                formData.append('species', this.form.species);
                formData.append('race', this.form.race);

                if (this.form.notes) {
                    formData.append('notes', this.form.notes);
                }
                // Agregar la imagen al formulario
                if (this.form.image) {
                    formData.append('image', this.form.image);
                }
                const response = await axios.post(route('pets.store'), formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                    },
                });

                if (response.status === 200) {
                    this.pets.push(response.data.item);
                    this.resetForm();
                    this.$notify({
                        title: "Correcto",
                        message: "Se ha guardado la mascota",
                        type: "success",
                    });
                }
            } catch (error) {
                console.log(error);
                this.$notify({
                    title: "Error de servidor",
                    message: "No se pudo guardar la mascota por problema con el servidor. Favor de intentar más tarde",
                    type: "error",
                });
            } finally {
                this.processing = false;
            }
        },
        async deletePet(index) {
            this.processing = true;
            try {
                const response = await axios.delete(route('pets.destroy', this.pets[index].id));

                if (response.status === 200) {
                    this.pets.splice(index, 1);
                    this.resetForm();
                    this.$notify({
                        title: "Correcto",
                        message: "Se ha eliminado la mascota",
                        type: "success",
                    });
                }
            } catch (error) {
                console.log(error);
                this.$notify({
                    title: "Error de servidor",
                    message: "No se pudo eliminar la mascota por problema con el servidor. Favor de intentar más tarde",
                    type: "error",
                });
            } finally {
                this.processing = false;
            }
        },
        async updatePet() {
            this.processing = true;
            try {
                const formData = new FormData();
                formData.append('name', this.form.name);
                formData.append('species', this.form.species);
                formData.append('race', this.form.race);

                if (this.form.notes) {
                    formData.append('notes', this.form.notes);
                }

                // Agregar la imagen al formulario
                if (this.form.image) {
                    formData.append('image', this.form.image);
                }
                const response = await axios.post(route('pets.update-with-media', this.pets[this.editIndex].id), formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                    },
                });

                if (response.status === 200) {
                    this.pets[this.editIndex] = response.data.item;
                    this.editIndex = null;
                    this.resetForm();
                    this.$notify({
                        title: "Correcto",
                        message: "Se ha actualizado la mascota",
                        type: "success",
                    });
                }
            } catch (error) {
                console.log(error);
                this.$notify({
                    title: "Error de servidor",
                    message: "No se pudo actualizar la mascota por problema con el servidor. Favor de intentar más tarde",
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
        clearPetImage() {
            if (this.editIndex !== null) {
                this.form.image = 'deleted';
            } else {
                this.form.image = null;
            }
        },
        resetForm() {
            this.form.reset();
            this.$refs.petImage.image = null;
        },
        editPet(index) {
            this.showCreateForm = true;
            this.form.name = this.pets[index].name;
            this.form.species = this.pets[index].species;
            this.form.race = this.pets[index].race;
            this.form.notes = this.pets[index].notes;
            this.form.image = null;
            this.editIndex = index;
            this.$refs.petImage.image = this.pets[index].media[0].original_url;

            // hacer scroll hasta el final de la pagina
            this.$nextTick(() => {
                const scrollTarget = this.$refs.createForm;
                if (scrollTarget) {
                    // Scroll hacia el final de la página
                    scrollTarget.scrollIntoView({ behavior: "smooth", block: "end" });
                }
            });
        },
        async fetchPets() {
            this.loading = true;
            try {
                const response = await axios.get(route('pets.index'));

                if (response.status === 200) {
                    this.pets = response.data.items;
                }
            } catch (error) {
                console.log(error);
                this.$notify({
                    title: "Error de servidor",
                    message: "No se pudo obtener la lista de mascotas por problema con el servidor. Favor de intentar más tarde",
                    type: "error",
                });
            } finally {
                this.loading = false;
            }
        },
    },
    mounted() {
        this.fetchPets();
    }
}
</script>
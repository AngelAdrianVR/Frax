<template>
    <LoadingState :loading="loading" />
    <section v-if="!loading" class="my-6">
        <div class="col-span-4 lg:grid grid-cols-2 gap-x-4 gap-y-2 self-start">
            <!-- lista de contactos -->
            <div ref="contactList"
                class="col-span-full lg:grid grid-cols-3 gap-x-4 gap-y-2 mt-1 pb-5">
                <h2 class="col-span-full mb-4 flex justify-between items-center font-bold">
                    <p>Contactos de emergencia</p>
                    <PrimaryButton v-if="!showCreateForm" type="button" @click="prepareCreateForm">Crear contacto
                    </PrimaryButton>
                </h2>
                <p v-if="!contacts.length" class="text-xs text-gray2">No has registrado ningún contacto</p>
                <div v-for="(item, index) in contacts" :key="index">
                    <div class="border border-gray4 rounded-[3px] my-2 lg:my-0 p-4 min-h-52 flex flex-col justify-between text-sm">
                        <div class="flex justify-between">
                            <figure class="h-1/2">
                                <img v-if="item.media?.length" class="size-16 rounded-full object-cover"
                                    :src="item.media[0].original_url" :alt="item.name">
                                <figure v-else
                                    class="flex items-center justify-center text-gray2  border-gray2 rounded-full size-16">
                                    <i class="fa-solid fa-user text-4xl"></i>
                                </figure>
                            </figure>
                            <div class="flex space-x-1 items-center self-start">
                                <el-popconfirm v-if="editIndex != index" confirm-button-text="Si" cancel-button-text="No"
                                    icon-color="#D90537" title="¿Continuar?" @confirm="deleteContact(index)">
                                    <template #reference>
                                        <button type="button"
                                            class="rounded-full bg-gray5 flex justify-center items-center size-7 text-xs"><i
                                                class="fa-regular fa-trash-can"></i></button>
                                    </template>
                                </el-popconfirm>
                                <button type="button" v-if="editIndex != index" @click="editContact(index)"
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
                            <b>Télefono</b>
                            <span class="col-span-2">{{ item.phone }}</span>
                            <b>Parentesco</b>
                            <span class="col-span-2">{{ item.relationship }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <form @submit.prevent="editIndex !== null ? updateContact() : store()" v-show="showCreateForm"
                class="col-span-full lg:grid grid-cols-2 gap-x-4 gap-y-2" ref="createForm">
                <h2 class="font-bold col-span-full mt-7">Agregar contacto</h2>
                <div>
                    <InputLabel value="Nombre" class="ml-2 mb-1" />
                    <el-input v-model="form.name" placeholder="Escribe aqui el nombre completo" maxlength="255" clearable />
                </div>
                <div>
                    <InputLabel value="Número de télefono" class="ml-2 mb-1" />
                    <el-input v-model="form.phone" placeholder="Escribe el número del contacto"
                        :formatter="(value) => `${value}`.replace(/(\d{2})(\d{4})(\d{4})/, '$1 $2 $3')"
                        :parser="(value) => value.replace(/\D/g, '')" maxlength="10" clearable />
                </div>
                <div>
                    <InputLabel value="Parentesco" class="ml-2" />
                    <el-select v-model="form.relationship" placeholder="Selecciona" class="w-full mt-1"
                        no-data-text="No hay opciones para mostrar" no-match-text="No se encontraron coincidencias">
                        <el-option v-for="(item, index) in relationships" :key="index" :label="item" :value="item" />
                    </el-select>
                </div>
                <div class="col-span-full flex">
                    <div>
                        <InputLabel value="Foto" class="ml-2" />
                        <InputFilePreview ref="contactImage" @imagen="saveImage" @cleared="clearContactImage" />
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
import LoadingState from '@/Components/MyComponents/LoadingState.vue';
import InputLabel from "@/Components/InputLabel.vue";
import InputFilePreview from "@/Components/MyComponents/InputFilePreview.vue";
import { Link, useForm } from "@inertiajs/vue3";
import axios from 'axios';

export default {
    data() {
        const form = useForm({
            name: null,
            phone: null,
            relationship: null,
            image: null,
        });
        return {
            form,
            processing: false,
            loading: false,
            showCreateForm: false,
            editIndex: null,
            contacts: [],
            relationships: [
                'Madre',
                'Padre',
                'Amigo (a)',
                'Hermano (a)',
                'Pareja',
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
                this.form.phone &&
                this.form.relationship;
        },
    },
    methods: {
        async store() {
            this.processing = true;
            try {
                const formData = new FormData();
                formData.append('name', this.form.name);
                formData.append('phone', this.form.phone);
                formData.append('relationship', this.form.relationship);

                // Agregar la imagen al formulario
                if (this.form.image) {
                    formData.append('image', this.form.image);
                }
                const response = await axios.post(route('emergency-contacts.store'), formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                    },
                });

                if (response.status === 200) {
                    this.contacts.push(response.data.item);
                    this.resetForm();
                    this.$notify({
                        title: "Correcto",
                        message: "Se ha guardado el contacto",
                        type: "success",
                    });
                }
            } catch (error) {
                console.log(error);
                this.$notify({
                    title: "Error de servidor",
                    message: "No se pudo guardar al contacto por problema con el servidor. Favor de intentar más tarde",
                    type: "error",
                });
            } finally {
                this.processing = false;
            }
        },
        async deleteContact(index) {
            this.processing = true;
            try {
                const response = await axios.delete(route('emergency-contacts.destroy', this.contacts[index].id));

                if (response.status === 200) {
                    this.contacts.splice(index, 1);
                    this.resetForm();
                    this.$notify({
                        title: "Correcto",
                        message: "Se ha eliminado el contacto",
                        type: "success",
                    });
                }
            } catch (error) {
                console.log(error);
                this.$notify({
                    title: "Error de servidor",
                    message: "No se pudo eliminar al contacto por problema con el servidor. Favor de intentar más tarde",
                    type: "error",
                });
            } finally {
                this.processing = false;
            }
        },
        async updateContact() {
            this.processing = true;
            try {
                const formData = new FormData();
                formData.append('name', this.form.name);
                formData.append('phone', this.form.phone);
                formData.append('relationship', this.form.relationship);

                // Agregar la imagen al formulario
                if (this.form.image) {
                    formData.append('image', this.form.image);
                }
                const response = await axios.post(route('emergency-contacts.update-with-media', this.contacts[this.editIndex].id), formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                    },
                });

                if (response.status === 200) {
                    this.contacts[this.editIndex] = response.data.item;
                    this.editIndex = null;
                    this.resetForm();
                    this.$notify({
                        title: "Correcto",
                        message: "Se ha actualizado el contacto",
                        type: "success",
                    });
                }
            } catch (error) {
                console.log(error);
                this.$notify({
                    title: "Error de servidor",
                    message: "No se pudo actualizar al contacto por problema con el servidor. Favor de intentar más tarde",
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
        clearContactImage() {
            if (this.editIndex !== null) {
                this.form.image = 'deleted';
            } else {
                this.form.image = null;
            }
        },
        resetForm() {
            this.form.reset();
            this.$refs.contactImage.image = null;
        },
        editContact(index) {
            this.showCreateForm = true;
            this.form.name = this.contacts[index].name;
            this.form.phone = this.contacts[index].phone;
            this.form.relationship = this.contacts[index].relationship;
            this.form.image = null;
            this.editIndex = index;
            this.$refs.contactImage.image = this.contacts[index].media[0].original_url;

            // hacer scroll hasta el final de la pagina
            this.$nextTick(() => {
                const scrollTarget = this.$refs.createForm;
                if (scrollTarget) {
                    // Scroll hacia el final de la página
                    scrollTarget.scrollIntoView({ behavior: "smooth", block: "end" });
                }
            });
        },
        async fetchContacts() {
            this.loading = true;
            try {
                const response = await axios.get(route('emergency-contacts.index'));

                if (response.status === 200) {
                    this.contacts = response.data.items;
                }
            } catch (error) {
                console.log(error);
                this.$notify({
                    title: "Error de servidor",
                    message: "No se pudo obtener la lista de contactos por problema con el servidor. Favor de intentar más tarde",
                    type: "error",
                });
            } finally {
                this.loading = false;
            }
        },
    },
    mounted() {
        this.fetchContacts();
    }
}
</script>
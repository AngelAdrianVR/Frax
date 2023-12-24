<template>
    <AppLayout title="Perfil">
        <header class="mb-6 mt-12 mx-20">
            <h1 class="font-bold text-lg">Mi perfil</h1>
        </header>
        <main class="px-8">
            <form @submit.prevent="update">
                <section class="lg:grid grid-cols-5 gap-x-4 gap-y-1 mb-6">
                    <div>
                        <div @click="openFileInput" v-if="!selectedProfilePhoto"
                            class="rounded-full w-20 lg:w-52 h-20 lg:h-52 bg-gray2 mx-auto flex items-center justify-center cursor-pointer">
                            <label for="fileInput">
                                <i class="fa-solid fa-camera text-white text-3xl"></i>
                            </label>
                            <input @change="previewImage" type="file" id="fileInput" name="fileInput" style="display: none"
                                accept="image/*" />
                        </div>
                        <Dropdown v-else align="right" width="24">
                            <template #trigger>
                                <div
                                    class="rounded-full w-20 lg:w-52 h-20 lg:h-52 bg-gray2 mx-auto flex items-center justify-center cursor-pointer">
                                    <img :src="selectedProfilePhoto" alt="User Profile"
                                        class="object-cover rounded-full w-20 lg:w-52 h-20 lg:h-52 mx-auto" />
                                    <input @change="previewImage" type="file" id="fileInput" name="fileInput"
                                        style="display: none" accept="image/*" />
                                </div>
                            </template>
                            <template #content>
                                <DropdownLink @click="editProfilePhoto()" as="no-submit-button">
                                    Editar
                                </DropdownLink>
                                <DropdownLink @click="deleteProfilePhoto()" as="no-submit-button">
                                    Eliminar
                                </DropdownLink>
                            </template>
                        </Dropdown>
                        <InputError :message="form.errors.photo" />
                    </div>
                    <div class="col-span-4 lg:grid grid-cols-2 gap-x-4 gap-y-2 self-start">
                        <h2 class="font-bold col-span-full">Información personal </h2>
                        <div>
                            <InputLabel value="Nombre *" class="ml-2" />
                            <input v-model="form.name" type="text" class="input mt-1"
                                placeholder="Escribe aqui tu nombre completo" required />
                            <InputError :message="form.errors.name" />
                        </div>
                        <div>
                            <InputLabel value="Fecha de nacimiento *" class="ml-2 mb-1" />
                            <el-date-picker v-model="form.resident_properties.birthdate" type="date"
                                placeholder="Selecciona" />
                            <InputError :message="form.errors['resident_properties.birthdate']" />
                        </div>
                        <div>
                            <InputLabel value="Género" class="ml-2" />
                            <el-select v-model="form.resident_properties.gender" placeholder="Selecciona"
                                class="w-full mt-1" no-data-text="No hay opciones para mostrar"
                                no-match-text="No se encontraron coincidencias">
                                <el-option v-for="(item, index) in genders" :key="index" :label="item" :value="item" />
                            </el-select>
                            <InputError :message="form.errors['resident_properties.gender']" />
                        </div>
                        <h2 class="font-bold col-span-full mt-7">Datos de contacto</h2>
                        <div>
                            <InputLabel value="Número de télefono *" class="ml-2" />
                            <input v-model="form.resident_properties.phone" type="text" class="input mt-1"
                                placeholder="Escribe aqui tu número" required />
                            <InputError :message="form.errors['resident_properties.phone']" />
                        </div>
                        <div>
                            <InputLabel value="Correo electrónico *" class="ml-2" />
                            <input v-model="form.email" type="email" class="input mt-1" placeholder="Escribe tu correo"
                                required />
                            <InputError :message="form.errors.email" />
                        </div>
                        <div>
                            <InputLabel value="Dirección de vivienda en el fraccionamiento *" class="ml-2" />
                            <input v-model="form.address" type="text" class="input mt-1" placeholder="Escribe tu dirección"
                                required />
                            <InputError :message="form.errors.address" />
                        </div>
                        <h2 class="font-bold col-span-full mt-7">Información de contacto de emergencia</h2>
                        <div>
                            <InputLabel value="Nombre" class="ml-2" />
                            <input v-model="contact.name" type="text" class="input mt-1"
                                placeholder="Escribe aqui tu nombre completo" />
                            <!-- <InputError :message="contact.name" /> -->
                        </div>
                        <div>
                            <InputLabel value="Número de télefono" class="ml-2" />
                            <input v-model="contact.phone" type="text" class="input mt-1"
                                placeholder="Escribe aqui el número" />
                            <InputError :message="phoneErrorMessage" />
                        </div>
                        <div>
                            <InputLabel value="Parentesco" class="ml-2" />
                            <el-select v-model="contact.relationship" placeholder="Selecciona" class="w-full mt-1"
                                no-data-text="No hay opciones para mostrar" no-match-text="No se encontraron coincidencias">
                                <el-option v-for="(item, index) in relationships" :key="index" :label="item"
                                    :value="item" />
                            </el-select>
                            <!-- <InputError :message="contact.relationship" /> -->
                        </div>
                        <div class="col-span-full flex">
                            <div>
                                <InputLabel value="Foto" class="ml-2" />
                                <InputFilePreview ref="contactImage" @imagen="saveImage" @cleared="clearContactImage" />
                            </div>
                            <ThirthButton v-if="editContactIndex !== null" @click="updateContact" type="button"
                                class="self-end ml-10 !rounded-full" :disabled="!isContactCompleted">
                                Actualizar de contactos de emergencia
                            </ThirthButton>
                            <ThirthButton v-else @click="addContact" type="button" class="self-end ml-10 !rounded-full"
                                :disabled="!isContactCompleted">
                                Agregar a lista de contactos de emergencia
                            </ThirthButton>
                        </div>
                        <!-- contact list -->
                        <div ref="contactList" v-if="form.emergency_contacts.length"
                            class="col-span-full lg:grid grid-cols-3 gap-x-4 gap-y-2 mt-8">
                            <h2 class="col-span-full mb-4">Lista de contactos de emergencia</h2>
                            <div v-for="(item, index) in form.emergency_contacts" :key="index">
                                <div
                                    class="border border-gray4 rounded-[3px] p-4 h-52 flex flex-col justify-between text-sm">
                                    <div class="flex justify-between">
                                        <figure class="h-1/2">
                                            <img v-if="item.image" class="size-16 rounded-full object-cover"
                                                :src="getURL(item.image)" :alt="item.name">
                                            <figure v-else class="flex items-center justify-center text-gray2  border-gray2 rounded-full size-16">
                                                <i class="fa-solid fa-user text-4xl"></i>
                                            </figure>
                                        </figure>
                                        <div class="flex space-x-1 items-center self-start">
                                            <el-popconfirm v-if="editContactIndex != index" confirm-button-text="Si"
                                                cancel-button-text="No" icon-color="#D90537" title="¿Continuar?"
                                                @confirm="deleteContact(index)">
                                                <template #reference>
                                                    <button type="button"
                                                        class="rounded-full bg-gray5 flex justify-center items-center size-7 text-xs"><i
                                                            class="fa-regular fa-trash-can"></i></button>
                                                </template>
                                            </el-popconfirm>
                                            <button type="button" v-if="editContactIndex != index"
                                                @click="editContact(index)"
                                                class="rounded-full bg-gray5 flex justify-center items-center size-7 text-xs"><i
                                                    class="fa-solid fa-pencil"></i></button>
                                            <el-tag v-else effect="light" size="small" closable
                                                @close="cancelContactEdition" type="info">
                                                En edición
                                                <i class="fa-solid fa-arrow-up ml-2"></i>
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
                    </div>
                </section>
            </form>
        </main>
    </AppLayout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout.vue';
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
            name: null,
            email: null,
            photo: null,
            emergency_contacts: [],
            resident_properties: {
                gender: null,
                phone: null,
                birthdate: null,
            }
        });
        return {
            form,
            contact: {
                name: null,
                phone: null,
                relationship: null,
                image: null,
            },
            selectedProfilePhoto: null,
            phoneErrorMessage: null,
            editContactIndex: null,
            genders: [
                'Masculino',
                'Femenino',
                'Otro',
            ],
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
        AppLayout,
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
        isContactCompleted() {
            return this.contact.name &&
                this.contact.phone &&
                this.contact.relationship;
        },
    },
    methods: {
        update() {

        },
        // Contacts -----------
        saveImage(image) {
            this.contact.image = image;
        },
        clearContactImage() {
            this.contact.image = null;
        },
        addContact() {
            if (this.contact.phone.length > 14) {
                this.phoneErrorMessage = "No debe exceder 14 caracteres";
            } else {
                this.phoneErrorMessage = null;
                this.form.emergency_contacts.push({ ...this.contact });
                this.resetContact();

                // hacer scroll hasta el final de la pagina
                this.$nextTick(() => {
                    const scrollTarget = this.$refs.contactList;
                    if (scrollTarget) {
                        // Scroll hacia el final de la página
                        scrollTarget.scrollIntoView({ behavior: "smooth", block: "end" });
                    }
                });
            }
        },
        updateContact() {
            this.form.emergency_contacts[this.editContactIndex] = { ...this.contact };
            this.editContactIndex = null;
            this.resetContact();
        },
        resetContact() {
            this.contact.name = null;
            this.contact.phone = null;
            this.contact.relationship = null;
            this.contact.image = null;
            this.$refs.contactImage.image = null;
        },
        deleteContact(index) {
            this.form.emergency_contacts.splice(index, 1);
        },
        editContact(index) {
            this.contact = { ...this.form.emergency_contacts[index] };
            this.editContactIndex = index;
            this.$refs.contactImage.image = this.getURL(this.contact.image);
        },
        cancelContactEdition() {
            this.resetContact();
            this.editContactIndex = null;
        },
        getURL(file) {
            return URL.createObjectURL(file);
        },
        // profile photo ------------
        openFileInput() {
            // Al hacer clic en el div, activar el input de tipo "file" invisible
            document.getElementById('fileInput').click();
        },
        previewImage(event) {
            const file = event.target.files[0];
            if (file) {
                // Almacena el archivo seleccionado en una propiedad 'selectedProfilePhoto'
                this.form.photo = file;

                // Crea una URL temporal para mostrar la vista previa
                this.selectedProfilePhoto = URL.createObjectURL(file);
            }
        },
        editProfilePhoto() {
            this.openFileInput();
        },
        deleteProfilePhoto() {
            this.form.photo = null;
            this.selectedProfilePhoto = null;
        },
    }
}
</script>

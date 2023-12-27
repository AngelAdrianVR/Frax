<template>
    <form @submit.prevent="update">
        <section class="my-6">
            <div class="col-span-4 lg:grid grid-cols-2 gap-x-4 gap-y-2 self-start">
                  <!-- lista de contactos -->
                  <div ref="contactList" v-if="form.contacts.length"
                    class="col-span-full lg:grid grid-cols-3 gap-x-4 gap-y-2 mt-8 pb-5">
                    <h2 class="col-span-full mb-4 font-bold">Contactos de emergencia</h2>
                    <div v-for="(item, index) in form.contacts" :key="index">
                        <div class="border border-gray4 rounded-[3px] p-4 min-h-52 flex flex-col justify-between text-sm">
                            <div class="flex justify-between">
                                <figure class="h-1/2">
                                    <img v-if="item.image" class="size-16 rounded-full object-cover"
                                        :src="getURL(item.image)" :alt="item.name">
                                    <figure v-else
                                        class="flex items-center justify-center text-gray2  border-gray2 rounded-full size-16">
                                        <i class="fa-solid fa-user text-4xl"></i>
                                    </figure>
                                </figure>
                                <div class="flex space-x-1 items-center self-start">
                                    <el-popconfirm v-if="editIndex != index" confirm-button-text="Si"
                                        cancel-button-text="No" icon-color="#D90537" title="¿Continuar?"
                                        @confirm="deleteContact(index)">
                                        <template #reference>
                                            <button type="button"
                                                class="rounded-full bg-gray5 flex justify-center items-center size-7 text-xs"><i
                                                    class="fa-regular fa-trash-can"></i></button>
                                        </template>
                                    </el-popconfirm>
                                    <button type="button" v-if="editIndex != index" @click="editContact(index)"
                                        class="rounded-full bg-gray5 flex justify-center items-center size-7 text-xs"><i
                                            class="fa-solid fa-pencil"></i></button>
                                    <el-tag v-else effect="light" size="small" closable @close="cancelContactEdition"
                                        type="info">
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
                <h2 class="font-bold col-span-full mt-7">Agregar contacto</h2>
                <div>
                    <InputLabel value="Nombre" class="ml-2 mb-1" />
                    <el-input v-model="contact.name" placeholder="Escribe aqui el nombre completo" maxlength="255"
                        clearable />
                </div>
                <div>
                    <InputLabel value="Número de télefono" class="ml-2 mb-1" />
                    <el-input v-model="contact.phone" placeholder="Escribe el número del contacto"
                        :formatter="(value) => `${value}`.replace(/(\d{2})(\d{4})(\d{4})/, '$1 $2 $3')"
                        :parser="(value) => value.replace(/\D/g, '')" maxlength="10" clearable />
                </div>
                <div>
                    <InputLabel value="Parentesco" class="ml-2" />
                    <el-select v-model="contact.relationship" placeholder="Selecciona" class="w-full mt-1"
                        no-data-text="No hay opciones para mostrar" no-match-text="No se encontraron coincidencias">
                        <el-option v-for="(item, index) in relationships" :key="index" :label="item" :value="item" />
                    </el-select>
                </div>
                <div class="col-span-full flex">
                    <div>
                        <InputLabel value="Foto" class="ml-2" />
                        <InputFilePreview ref="contactImage" @imagen="saveImage" @cleared="clearContactImage" />
                    </div>
                    <ThirthButton v-if="editIndex !== null" @click="updateContact" type="button"
                        class="self-end ml-10 !rounded-full" :disabled="!isContactCompleted">
                        Actualizar contacto
                    </ThirthButton>
                    <ThirthButton v-else @click="addContact" type="button" class="self-end ml-10 !rounded-full"
                        :disabled="!isContactCompleted">
                        Agregar a lista de contactos
                    </ThirthButton>
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
            contacts: [],
        });
        return {
            form,
            contact: {
                id: null,
                name: null,
                phone: null,
                relationship: null,
                image: null,
            },
            editIndex: null,
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
        saveImage(image) {
            this.contact.image = image;
        },
        clearContactImage() {
            this.contact.image = null;
        },
        isContactFormCorrect() {
            return true;
        },
        addContact() {
            if (this.isContactFormCorrect()) {
                // agregar contacto
                this.form.contacts.push({ ...this.contact });
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
            if (this.isContactFormCorrect()) {
                // limpiar textos de validacion
                this.phoneErrorMessage = null;
                this.nameErrorMessage = null;
                // actualizar contacto
                this.form.contacts[this.editIndex] = { ...this.contact };
                this.editIndex = null;
                this.resetContact();
            }
        },
        resetContact() {
            this.contact.id = null;
            this.contact.name = null;
            this.contact.phone = null;
            this.contact.relationship = null;
            this.contact.image = null;
            this.$refs.contactImage.image = null;
        },
        deleteContact(index) {
            this.form.contacts.splice(index, 1);
        },
        editContact(index) {
            this.contact = { ...this.form.contacts[index] };
            this.editIndex = index;
            this.$refs.contactImage.image = this.getURL(this.contact.image);
        },
        cancelContactEdition() {
            this.resetContact();
            this.editIndex = null;
        },
        getURL(file) {
            return URL.createObjectURL(file);
        },
    },
    mounted() {
        this.form.contacts = this.$page.props.auth.user.emergencyContacts.map(item => {
            return {
                id: item.id,
                name: item.name,
                phone: item.phone,
                relationship: item.relationship,
                image: item.media[0]?.original_url,
            };
        })
    }
}
</script>
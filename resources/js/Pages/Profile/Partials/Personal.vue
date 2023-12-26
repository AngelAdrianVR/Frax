<template>
    <form v-if="inEdition" @submit.prevent="update">
        <section class="lg:grid grid-cols-5 gap-x-28 gap-y-1 my-6 text-sm">
            <div class="col-span-full flex justify-end">
                <CancelButton @click="inEdition = false">Cancelar edición</CancelButton>
            </div>
            <div>
                <div @click="openFileInput" v-if="!selectedProfilePhoto"
                    class="rounded-full size-20 lg:size-52 mx-auto flex items-center justify-center cursor-pointer">
                    <label for="fileInput">
                        <i class="fa-solid fa-camera text-white text-3xl"></i>
                    </label>
                    <input @change="previewImage" type="file" id="fileInput" name="fileInput" style="display: none"
                        accept="image/*" />
                </div>
                <Dropdown v-else align="right" width="24">
                    <template #trigger>
                        <div
                            class="rounded-full size-20 lg:size-52 mx-auto flex items-center justify-center cursor-pointer">
                            <img :src="selectedProfilePhoto" alt="User Profile"
                                class="object-cover rounded-full size-20 lg:size-52 mx-auto" />
                            <input @change="previewImage" type="file" id="fileInput" name="fileInput" style="display: none"
                                accept="image/*" />
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
                    <InputLabel value="Nombre *" class="ml-2 mb-1" />
                    <el-input v-model="form.name" placeholder="Escribe aqui tu nombre completo" clearable />
                    <InputError :message="form.errors.name" />
                </div>
                <div>
                    <InputLabel value="Fecha de nacimiento" class="ml-2 mb-1" />
                    <el-date-picker v-model="form.resident_properties.birthdate" type="date" placeholder="Selecciona" />
                    <InputError :message="form.errors['resident_properties.birthdate']" />
                </div>
                <div>
                    <InputLabel value="Género" class="ml-2 mb-1" />
                    <el-select v-model="form.resident_properties.gender" placeholder="Selecciona" class="w-full"
                        no-data-text="No hay opciones para mostrar" no-match-text="No se encontraron coincidencias">
                        <el-option v-for="(item, index) in genders" :key="index" :label="item" :value="item" />
                    </el-select>
                    <InputError :message="form.errors['resident_properties.gender']" />
                </div>
                <h2 class="font-bold col-span-full mt-7">Datos de contacto</h2>
                <div>
                    <InputLabel value="Número de télefono" class="ml-2 mb-1" />
                    <el-input v-model="form.resident_properties.phone" placeholder="Escribe aqui tu número"
                        :formatter="(value) => `${value}`.replace(/(\d{2})(\d{4})(\d{4})/, '$1 $2 $3')"
                        :parser="(value) => value.replace(/\D/g, '')" maxlength="10" clearable />
                    <InputError :message="form.errors['resident_properties.phone']" />
                </div>
                <div>
                    <InputLabel value="Correo electrónico *" class="ml-2 mb-1" />
                    <el-input v-model="form.email" placeholder="Escribe aqui tu correo" maxlength="255" type="email"
                        clearable />
                    <InputError :message="form.errors.email" />
                </div>
                <div>
                    <InputLabel value="Dirección de vivienda en el fraccionamiento " class="ml-2 mb-1" />
                    <el-input v-model="form.resident_properties.address" placeholder="Escribe la calle y el número de casa" maxlength="255"
                        clearable />
                    <InputError :message="form.errors['resident_properties.address']" />
                </div>
            </div>
            <div class="col-span-full flex justify-end">
                <PrimaryButton class="ml-auto" :disabled="!form.isDirty || form.processing">Guardar</PrimaryButton>
            </div>
        </section>
    </form>
    <section v-else>
        <section class="lg:grid grid-cols-5 gap-x-28 gap-y-1 my-6 text-sm">
            <div class="col-span-full flex justify-end">
                <PrimaryButton @click="inEdition = true">Editar</PrimaryButton>
            </div>
            <div>
                <figure class="rounded-full size-52 mx-auto">
                    <img :src="user.profile_photo_url" class="object-cover rounded-full size-52">
                </figure>
            </div>
            <div class="col-span-4 lg:grid grid-cols-4 gap-x-4 gap-y-2 self-start">
                <h2 class="font-bold col-span-full">Información personal</h2>
                <span>Nombre</span>
                <span class="col-span-3">{{ user.name }}</span>
                <span>Fecha de nacimiento</span>
                <span class="col-span-3">{{ user.resident_properties?.birthdate ?? '-' }}</span>
                <span>Género</span>
                <span class="col-span-3">{{ user.resident_properties?.gender ?? '-' }}</span>

                <h2 class="font-bold col-span-full mt-7">Información de contacto</h2>
                <span>Número de télefono</span>
                <span class="col-span-3">{{ user.resident_properties?.phone ?? '-' }}</span>
                <span>Correo electrónico</span>
                <span class="col-span-3">{{ user.email }}</span>
                <span>Dirección de vivienda en el fraccionamiento</span>
                <span class="col-span-3">{{ user.resident_properties?.address ?? '-' }}</span>
            </div>
        </section>
    </section>
</template>
<script>
import InputError from '@/Components/InputError.vue';
import PrimaryButton from "@/Components/PrimaryButton.vue";
import CancelButton from "@/Components/MyComponents/CancelButton.vue";
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
            name: this.$page.props.auth.user.name,
            email: this.$page.props.auth.user.email,
            photo: null,
            emergency_contacts: [],
            resident_properties: {
                gender: this.$page.props.auth.user.residentProperties.gender,
                phone: this.$page.props.auth.user.residentProperties.phone,
                address: this.$page.props.auth.user.residentProperties.address,
                birthdate: this.$page.props.auth.user.residentProperties.birthdate,
            }
        });
        return {
            inEdition: false,
            user: this.$page.props.auth.user,
            form,
            selectedProfilePhoto: this.$page.props.auth.user.profile_photo_url,
            genders: [
                'Masculino',
                'Femenino',
                'Otro',
            ],
        }
    },
    components: {
        InputError,
        InputLabel,
        PrimaryButton,
        CancelButton,
        Back,
        InputFilePreview,
        Link,
        ThirthButton,
        Dropdown,
        DropdownLink,
    },
    methods: {
        update() {
            this.form.post(route("users.profile.update-personal", this.user.id), {
                onSuccess: () => {
                    this.user = this.$page.props.auth.user;
                    this.user = this.$page.props.auth.user;
                    this.inEdition = false;
                    this.$notify({
                        title: "Correcto",
                        message: "Información personal actualizada",
                        type: "success",
                    });
                },
            });
        },
        // Contacts -----------
        saveImage(image) {
            this.contact.image = image;
        },
        getURL(file) {
            if (typeof file == 'string') {
                return file;
            } else {
                return URL.createObjectURL(file);
            }
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
    },
}
</script>
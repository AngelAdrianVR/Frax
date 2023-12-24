<template>
    <AppLayout title="Perfil">
        <header class="mb-6 mt-12 mx-20">
            <h1 class="font-bold text-sm">Mi perfil</h1>
        </header>
        <main class="px-8">
            <form @submit.prevent="update">
                <section class="lg:grid grid-cols-5 gap-x-4 gap-y-1">
                    <div>
                        <div @click="openFileInput" v-if="!selectedImage"
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
                                    <img :src="selectedImage" alt="User Profile"
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
                        <div>
                            <InputLabel value="Nombre *" class="ml-2" />
                            <input v-model="form.name" type="text" class="input mt-1"
                                placeholder="Escribe aqui tu nombre completo" required />
                            <InputError :message="form.errors.name" />
                        </div>
                        <div>
                            <InputLabel value="Fecha de nacimiento *" class="ml-2 mb-1" />
                            <el-date-picker v-model="form.resident_properties.birthdate" type="date" placeholder="Selecciona" />
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
                        <div>
                            <InputLabel value="Correo electrónico *" class="ml-2" />
                            <input v-model="form.email" type="email" class="input mt-1" placeholder="Escribe tu correo"
                                required />
                            <InputError :message="form.errors.email" />
                        </div>
                        <div>
                            <InputLabel value="Número de télefono *" class="ml-2" />
                            <input v-model="form.resident_properties.phone" type="text" class="input mt-1"
                                placeholder="Escribe aqui tu número" required />
                            <InputError :message="form.errors['resident_properties.phone']" />
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
import InputFilePreview from "@/Components/MyComponents/InputFilePreview.vue";
import { useForm, Link } from "@inertiajs/vue3";

export default {
    data() {
        const form = useForm({
            name: null,
            email: null,
            resident_properties: {
                gender: null,
                phone: null,
                birthdate: null,
            }
        });
        return {
            form,
            genders: [
                'Masculino',
                'Femenino',
                'Otro',
            ]
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
    },
    methods: {
        update() {

        },
    }
}
</script>

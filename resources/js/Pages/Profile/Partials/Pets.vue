<template>
    <form @submit.prevent="update">
        <section class="my-6">
            <div class="col-span-4 lg:grid grid-cols-2 gap-x-4 gap-y-2 self-start">
                <h2 class="font-bold col-span-full mt-7">Mascotas</h2>
                <div>
                    <InputLabel value="Nombre" class="ml-2 mb-1" />
                    <el-input v-model="pet.name" placeholder="Escribe aqui el nombre" maxlength="255" clearable />
                </div>
                <div>
                    <InputLabel value="Especie" class="ml-2 mb-1" />
                    <el-select v-model="pet.species" placeholder="Selecciona" class="w-full"
                        no-data-text="No hay opciones para mostrar" no-match-text="No se encontraron coincidencias">
                        <el-option v-for="(item, index) in ['Gato', 'Perro', 'Otra']" :key="index" :label="item" :value="item" />
                    </el-select>
                </div>
                <div>
                    <InputLabel value="Raza" class="ml-2 mb-1" />
                    <el-input v-model="pet.race" placeholder="Escribe aqui la raza" maxlength="255" clearable />
                </div>
                <div>
                    <InputLabel value="Notas" class="ml-2 mb-1" />
                    <el-input v-model="pet.notes" :autosize="{ minRows: 1, maxRows: 4 }" type="textarea"
                        placeholder="Escribe aqui tus notas" maxlength="255" show-word-limit clearable />
                </div>
                <div class="col-span-full flex">
                    <div>
                        <InputLabel value="Foto" class="ml-2" />
                        <InputFilePreview ref="petImage" @imagen="saveImage" @cleared="clearPetImage" />
                        <InputError :message="form.errors.name" />
                    </div>
                    <ThirthButton v-if="editIndex !== null" @click="updatePet" type="button"
                        class="self-end ml-10 !rounded-full" :disabled="!isPetCompleted">
                        Actualizar
                    </ThirthButton>
                    <ThirthButton v-else @click="addPet" type="button" class="self-end ml-10 !rounded-full"
                        :disabled="!isPetCompleted">
                        Agregar a lista de mascotas
                    </ThirthButton>
                </div>
                <!-- pets list -->
                <div ref="petList" v-if="form.pets.length"
                    class="col-span-full lg:grid grid-cols-3 gap-x-4 gap-y-2 mt-8 pb-5">
                    <h2 class="col-span-full mb-4">Lista de mascotas</h2>
                    <div v-for="(item, index) in form.pets" :key="index">
                        <div class="border border-gray4 rounded-[3px] p-4 min-h-52 flex flex-col justify-between text-sm">
                            <div class="flex justify-between">
                                <figure class="h-1/2">
                                    <img v-if="item.image" class="size-16 rounded-full object-cover"
                                        :src="getURL(item.image)" :alt="item.name">
                                    <figure v-else
                                        class="flex items-center justify-center text-gray2  border-gray2 rounded-full size-16">
                                        <i class="fa-solid fa-dog text-4xl"></i>
                                    </figure>
                                </figure>
                                <div class="flex space-x-1 items-center self-start">
                                    <el-popconfirm v-if="editIndex != index" confirm-button-text="Si"
                                        cancel-button-text="No" icon-color="#D90537" title="¿Continuar?"
                                        @confirm="deletePet(index)">
                                        <template #reference>
                                            <button type="button"
                                                class="rounded-full bg-gray5 flex justify-center items-center size-7 text-xs"><i
                                                    class="fa-regular fa-trash-can"></i></button>
                                        </template>
                                    </el-popconfirm>
                                    <button type="button" v-if="editIndex != index" @click="editPet(index)"
                                        class="rounded-full bg-gray5 flex justify-center items-center size-7 text-xs"><i
                                            class="fa-solid fa-pencil"></i></button>
                                    <el-tag v-else effect="light" size="small" closable @close="cancelPetEdition"
                                        type="info">
                                        En edición
                                        <i class="fa-solid fa-arrow-up ml-2"></i>
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
            pets: [],
        });
        return {
            form,
            pet: {
                name: null,
                species: null,
                race: null,
                notes: null,
                image: null,
            },
            editIndex: null,
            breeds: [
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
        isPetCompleted() {
            return this.pet.name &&
            this.pet.species &&
            this.pet.race;
        },
    },
    methods: {
        update() {

        },
        saveImage(image) {
            this.pet.image = image;
        },
        clearPetImage() {
            this.pet.image = null;
        },
        isPetFormCorrect() {
            return true;
        },
        addPet() {
            if (this.isPetFormCorrect()) {
                // agregar vehiculo
                this.form.pets.push({ ...this.pet });
                this.resetPet();

                // hacer scroll hasta el final de la pagina
                this.$nextTick(() => {
                    const scrollTarget = this.$refs.petList;
                    if (scrollTarget) {
                        // Scroll hacia el final de la página
                        scrollTarget.scrollIntoView({ behavior: "smooth", block: "end" });
                    }
                });
            }
        },
        updatePet() {
            if (this.isPetFormCorrect()) {
                // actualizar vehiculo
                this.form.pets[this.editIndex] = { ...this.pet };
                this.editIndex = null;
                this.resetPet();
            }
        },
        resetPet() {
            this.pet.name = null;
            this.pet.species = null;
            this.pet.race = null;
            this.pet.notes = null;
            this.pet.image = null;
            this.$refs.petImage.image = null;
        },
        deletePet(index) {
            this.form.pets.splice(index, 1);
        },
        editPet(index) {
            this.pet = { ...this.form.pets[index] };
            this.editIndex = index;
            this.$refs.petImage.image = this.getURL(this.pet.image);
        },
        cancelPetEdition() {
            this.resetPet();
            this.editIndex = null;
        },
        getURL(file) {
            return URL.createObjectURL(file);
        },
    }
}
</script>
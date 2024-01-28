<template>
    <div class="rounded-lg border border-gray4 text-sm shadow-md group relative lg:w-[870px]">
        <!-- Action buttons only for admin -->
        <div v-if="true"
            class="flex justify-end mb-3 space-x-1 lg:group-hover:opacity-100 lg:opacity-0 transition-opacity duration-300 absolute top-3 right-3">
            <el-popconfirm confirm-button-text="Si" cancel-button-text="No" icon-color="#D90537"
                title="¿Continuar?" @confirm="deleteCommunityEvent">
                <template #reference>
                    <button class="rounded-full bg-gray5 flex justify-center items-center w-7 h-7 text-xs"><i
                            class="fa-regular fa-trash-can"></i></button>
                </template>
            </el-popconfirm>
            <button @click="$inertia.get(route('community-events.edit', communityEvent))"
                class="rounded-full bg-gray5 flex justify-center items-center w-7 h-7 text-xs"><i
                    class="fa-solid fa-pencil"></i></button>
        </div>
        <!-- -------------------------------- -->

        <!-- Imagen ---------------------------------- -->
        <figure v-if="communityEvent.image_cover?.length > 0" class="bg-gray5 lg:h-[440px]">
            <img class="lg:h-[440px] w-full rounded-t-lg" :src="communityEvent.image_cover[0]?.original_url" alt="Sin imagen" >
        </figure>
        <div v-else class="bg-gray4 rounded-t-lg lg:h-[440px] h-64 justify-center items-center flex text-white font-bold text-lg">Sin portada</div>
        <!-- ------------------------------------------ -->

        <!-- Information ---------------------------- -->
        <div class="grid grid-cols-6">
            <div class="p-4 clas border-r border-gray3 flex flex-col items-center justify-center pt-20 col-span-2">
                <p class="text-lg font-bold uppercase">{{ communityEvent.date.split('.')[0] }}</p>
                <p class="text-3xl font-bold uppercase">{{ communityEvent.date.split('-')[1] }}</p>
                <PrimaryButton v-if="registeredObj"
                    @click="cancelRegister" 
                    class="mt-16 !bg-red-600">
                    Cancelar registro
                </PrimaryButton>
                <PrimaryButton v-else
                    @click="$inertia.get(route('community-event-user.create', { community_event_id: communityEvent.id}))" 
                    class="mt-16">
                    Registrarme
                </PrimaryButton>
            </div>
            <div class="p-4 col-span-4">
                <h1 class="lg:text-2xl text-lg font-bold mb-2">{{ communityEvent?.name }}</h1>
                <p class="text-gray1 mt-2 lg:text-sm text-xs"><i class="fa-solid fa-user text-xs mr-2"></i>Evento dirigido a: <strong>{{ communityEvent?.participants }}</strong></p>
                <p class="text-gray1 mt-2 lg:text-sm text-xs"><i class="fa-solid fa-grip-lines text-xs mr-2"></i>Descripción: <strong>{{ communityEvent?.description }}</strong></p>
                <p class="text-gray1 mt-2 lg:text-sm text-xs"><i class="fa-solid fa-clock-rotate-left text-xs mr-2"></i>Hora: <strong>{{ communityEvent?.time }}</strong></p>
                <p class="text-gray1 mt-2 lg:text-sm text-xs"><i class="fa-solid fa-location-dot text-xs mr-2"></i>Lugar: <strong>{{ communityEvent?.place }}</strong></p>
                <p class="text-gray1 mt-2 lg:text-sm text-xs"><i class="fa-solid fa-dollar-sign text-xs mr-2"></i>Costo: <strong>${{ communityEvent?.cost?.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",") }}</strong></p>
                <p v-if="communityEvent?.capacity_event" class="text-gray1 mt-2 lg:text-sm text-xs"><i class="fa-solid fa-users text-xs mr-2"></i>Capacidad máx: <strong>{{ communityEvent?.capacity_event }}</strong></p>
                <p v-if="communityEvent?.capacity_per_resident" class="text-gray1 mt-2 lg:text-sm text-xs"><i class="fa-solid fa-people-roof text-xs mr-2"></i>Participantes por residencia: <strong>{{ communityEvent?.capacity_per_resident }}</strong></p>
                <p v-if="communityEvent?.rules" class="text-gray1 mt-2 lg:text-sm text-xs"><i class="fa-solid fa-list-ol text-xs mr-2"></i>Reglas: <strong>{{ communityEvent?.rules }}</strong></p>
            </div>
        </div> 
        <!-- ----------------------------------------- -->

        <!-- Editable in my event ------------------- -->
        <div v-if="is_my_event" class="border-t border-gray3 lg:mx-7 mx-3 p-3 mt-2">
            <div class="lg:ml-56 text-xs lg:text-sm">
                <p class="bg-gray4 rounded-full py-1 px-5 font-bold">Datos de registro</p>
                <p class="ml-7 my-1 text-gray3">Nombre: <span class="text-gray1">{{ registeredObj?.name }}</span></p>
                <p class="ml-7 my-1 text-gray3">Domicilio: <span class="text-gray1">{{ registeredObj?.address }}</span></p>
                <p class="ml-7 my-1 text-gray3">Teléfono de contacto: <span class="text-gray1">{{ registeredObj?.phone }}</span></p>
                <div class="ml-7 my-1 text-gray3">Asistentes: 
                    <span v-if="!edit_participants_quantity" class="text-gray1">{{ registeredObj?.participants_quantity }} personas</span>

                    <!-- Logica de edicion comentada porque no se ve viable que se pueda editar, ya que intervienen varios factores como precio, capacidad maxima y por residencia -->
                    <!-- <span v-if="!edit_participants_quantity && communityEvent?.cost == 0" @click="edit_participants_quantity = true" class="text-primary cursor-pointer underline ml-4">Editar</span>
                    <div v-if="edit_participants_quantity" class="flex items-center space-x-2">
                        <el-select class="w-1/2" v-model="form.participants_quantity"
                            placeholder="Seleccione" no-data-text="No hay opciones registradas"
                            no-match-text="No se encontraron coincidencias">
                            <el-option v-for="item in participants" :key="item" :label="item" :value="item" />
                        </el-select>
                        <PrimaryButton @click="updateParticipantsQuantity">Actualizar</PrimaryButton>
                        <CancelButton @click="edit_participants_quantity = false">Cancelar</CancelButton>
                    </div> -->
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import PrimaryButton from "@/Components/PrimaryButton.vue";
import CancelButton from "@/Components/MyComponents/CancelButton.vue";
import { useForm } from "@inertiajs/vue3";

export default {
data(){
    const form = useForm({
        participants_quantity: null,
    });
    return {
        form,
        registeredObj: null,
        edit_participants_quantity: false,
        participants: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
    }
},
components:{
PrimaryButton,
CancelButton 
},
props:{
communityEvent: Object,
registered_events: Array,
is_my_event: {
    type: Boolean,
    default: false
}
},
emits:['delete-community-event'],
methods:{
    deleteCommunityEvent() {
        this.$emit('delete-community-event', this.communityEvent.id);
    },
    cancelRegister() {
        this.$inertia.delete(route('community-event-user.destroy', this.registeredObj.id));
        this.$notify({
          title: "Correcto",
          message: "Se ha eliminado tu registro",
          type: "success",
        });
        location.reload();
    },
    updateParticipantsQuantity() {
        this.form.put(route('community-event-user.update', this.registeredObj?.id), {
                onSuccess: () => {
                this.$notify({
                title: "Correcto",
                message: "Se ha actualizado tu registro",
                type: "success",
                });
                this.registeredObj.participants_quantity = this.form.participants_quantity;
                this.edit_participants_quantity = false;
            },
        });
    }
},
mounted() {
    // Revisa si el usuario ya esta registrado al evento
    this.registered_events.map((registered_event) => {
        if (registered_event.community_event_id == this.communityEvent?.id) {
            this.registeredObj = registered_event; // guarda el id del registo y del evento para eliminarlo si se cancela
        }
    });
}
}
</script>

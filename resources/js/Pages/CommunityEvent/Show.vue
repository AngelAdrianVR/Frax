<template>
    <AppLayout :title="community_event.data.name">
        <div class="lg:py-7 lg:px-10 py-2 px-1">
          <Back />
          <form @submit.prevent="store" class="mx-8 mt-9 md:grid grid-cols-2 md:gap-9 md:p-4">
            <!-- Primera parte del grid (izquierda) -->
            <section> 
                <h1 class="font-bold mb-1">Registro</h1>
                <p class="text-sm mb-4">Si estás interesado en participar en este evento, por favor completa el siguiente formulario de registro: </p>
                <div class="mt-3">
                    <InputLabel value="Nombre*" class="ml-3 mb-1" />
                    <input v-model="form.name" class="input" type="text" placeholder="Escriba el nombre del representante" />
                    <InputError :message="form.errors.name" />
                </div>

                <div class="mt-3">
                    <InputLabel value="Domicilio*" class="ml-3 mb-1" />
                    <input v-model="form.address" class="input" type="text" placeholder="Domicilio del representante" />
                    <InputError :message="form.errors.address" />
                </div>

                <div class="mt-3">
                    <InputLabel value="Teléfono de contacto*" class="ml-3 mb-1" />
                    <input v-model="form.phone" class="input" type="text" placeholder="número de contacto" />
                    <InputError :message="form.errors.phone" />
                </div>

                <div class="mt-3">
                  <InputLabel value="Asistentes*" class="ml-3 mb-1" />
                  <div class="flex items-center space-x-4">
                    <p class="text-xs">Min. 1</p>
                    <el-slider v-model="form.people_quantity" :min="1" :max="community_event.capacity ?? 10"
                        class="!w-2/3 pl-3" :format-tooltip="formatTooltip" />
                    <p class="text-xs">Máx. {{ community_event.capacity ?? 10 }}</p>
                  </div>
                  <InputError :message="form.errors.people_quantity" />
                </div>

                <label class="flex items-center mt-4 ml-4 text-xs">
                  <Checkbox v-model:checked="form.conditions" class="bg-transparent disabled:border-gray-400" />
                  <span class="ml-2 mr-2 text-xs">Acepto los <a class="text-primary underline" href="#"> términos y condiciones </a> del evento </span>
                </label>

                <div class="text-right mt-5 mb-3">
                    <PrimaryButton>Crear</PrimaryButton>
                </div>
            </section>
          </form>
        
        </div>

    </AppLayout>
  
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import Back from '@/Components/MyComponents/Back.vue';
import Checkbox from "@/Components/Checkbox.vue";
import { useForm } from "@inertiajs/vue3";

export default {
data(){
   const form = useForm({
    name: null,
    address: null,
    phone: null,
    people_quantity: null,
    conditions: false,
  });
    return {
      form,
    }
},
components:{
AppLayout,
PrimaryButton,
InputLabel,
InputError,
Checkbox,
Back
},
props:{
community_event: Object
},
methods:{

}
}
</script>

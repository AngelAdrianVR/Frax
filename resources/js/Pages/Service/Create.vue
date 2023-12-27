<template>
    <AppLayout title="Agregar servicio">
        <div class="lg:py-7 lg:px-10 py-2 px-1">
          <Back />
          <form @submit.prevent="store" class="mx-8 mt-9 md:grid grid-cols-2 md:gap-9 md:p-4">
            <!-- Primera parte del grid (izquierda) -->
            <section> 
                <h1 class="font-bold mb-5">Agregar servicio</h1>
                <div class="mt-3">
                    <InputLabel value="Nombre del negocio*" class="ml-3 mb-1" />
                    <input v-model="form.name" class="input" type="text" />
                    <InputError :message="form.errors.name" />
                </div>

                <div class="mt-3">
                    <InputLabel value="Número de teléfono*" class="ml-3 mb-1" />
                    <input v-model="form.phone" class="input" type="text" />
                    <InputError :message="form.errors.phone" />
                </div>

                <div class="mt-3">
                    <InputLabel value="Dirección" class="ml-3 mb-1" />
                    <input v-model="form.address" class="input" type="text" />
                    <InputError :message="form.errors.address" />
                </div>

                <div class="mt-3">
                    <InputLabel value="Descripción del negocio*" class="ml-3 mb-1" />
                    <textarea v-model="form.description" class="textarea" placeholder="Descripción breve de tu negocio, qué ofreces, horarios de atención, etc... " rows="3"></textarea>
                    <InputError :message="form.errors.description" />
                </div>

                <div class="mt-3">
                    <InputLabel value="Imagen portada" class="ml-3 mb-1" />
                    <InputFilePreview @imagen="saveImage" />
                </div>
            </section>
            <!-- ------------------------------------------------------------------------------- -->

            <!-- Segunda parte del grid (Derecha) Redes sociales -->
            <section> 
                <h1 class="font-bold mb-5 mt-7 lg:mt-0">Plataformas digitales</h1>
                <div class="mt-3">
                    <InputLabel value="Pagina web" class="ml-3 mb-1" />
                    <input v-model="social_networks.website" class="input" type="text" />
                </div>

                <div class="mt-3">
                    <InputLabel value="Facebook" class="ml-3 mb-1" />
                    <input v-model="social_networks.facebook" class="input" type="text" />
                </div>

                <div class="mt-3">
                    <InputLabel value="Instagram" class="ml-3 mb-1" />
                    <input v-model="social_networks.instagram" class="input" type="text" />
                </div>

                <div class="mt-3">
                    <InputLabel value="Tiktok" class="ml-3 mb-1" />
                    <input v-model="social_networks.tiktok" class="input" type="text" />
                </div>

                <div class="mt-3">
                    <InputLabel value="X (twitter)" class="ml-3 mb-1" />
                    <input v-model="social_networks.x" class="input" type="text" />
                </div>

                <label class="flex items-center mt-4 text-xs">
                    <Checkbox v-model:checked="form.is_internal" class="bg-transparent disabled:border-gray-400" />
                    <span class="ml-2 mr-2 text-xs">Servicio interno</span>
                    <el-tooltip
                    content="El servicio lo brinda personal del fraccionamiento"
                    placement="top">
                    <div class="rounded-full border border-primary w-3 h-3 flex items-center justify-center">
                    <i class="fa-solid fa-info text-primary text-[7px]"></i>
                    </div>
                </el-tooltip>
                </label>

                <div class="text-right mt-5 mb-3">
                    <PrimaryButton>Crear</PrimaryButton>
                </div>
            </section>
            <!-- -------------------------------------------------------------------- -->
          </form>
        </div>
     </AppLayout>
  
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import Back from '@/Components/MyComponents/Back.vue';
import InputFilePreview from '@/Components/MyComponents/InputFilePreview.vue';
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import Checkbox from "@/Components/Checkbox.vue";
import { useForm } from "@inertiajs/vue3";

export default {
data(){
    const form = useForm({
    name: null,
    phone: null,
    address: null,
    description: null,
    is_internal: false,
    social_networks: {},
    imageCover: null,
  });
    return {
        form,
        social_networks: {
            website: null,
            facebbok: null,
            instagram: null,
            tiktok: null,
            x: null,
        },
    }
},
components:{
AppLayout,
PrimaryButton,
Back,
InputLabel,
InputFilePreview,
Checkbox,
InputError
},
props:{

},
methods:{
store() {
    this.form.social_networks = this.social_networks;
    this.form.post(route("services.store"), {
      onSuccess: () => {
        this.$notify({
          title: "Correcto",
          message: "Se ha agregado un nuevo servicio",
          type: "success",
        });
      },
    });
  },
  saveImage(image) {
    this.form.imageCover = image;
  }
}
}
</script>

<template>
  <AppLayout title="Soporte técnico">
    <div class="py-8 px-3 lg:px-12">
      <p>Soporte técnico</p>
      <form @submit.prevent="store" class="lg:mx-8 mx-2 mt-9 md:grid grid-cols-3 md:gap-9 md:p-4">
        <!-- Primera parte del grid (izquierda) 2 partes del grid -->
        <section class="col-span-2">
          <h1 class="font-bold mb-5">Reporta tu problema</h1>
          <div class="mt-3">
            <InputLabel value="Nombre*" class="ml-3 mb-1" />
            <el-input v-model="form.name" placeholder="Escribe tu nombre" :maxlength="100" clearable />
            <InputError :message="form.errors.name" />
          </div>

          <div class="mt-3">
            <InputLabel value="¿Tienes algún problema?" class="ml-3 mb-1" />
            <el-input v-model="form.description" :autosize="{ minRows: 3, maxRows: 5 }" type="textarea"
                            placeholder="Describe el problema" :maxlength="200" show-word-limit clearable />
            <InputError :message="form.errors.description" />
          </div>

          <div class="mt-3">
            <InputLabel value="Ingresa la captura de pantalla si es posible" class="ml-3 mb-1" />
            <InputFilePreview @imagen="saveImage" />
          </div>

          <div class="text-left mt-5 mb-3">
            <PrimaryButton>Enviar</PrimaryButton>
          </div>
        </section>
      </form>
    </div>
  </AppLayout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputFilePreview from '@/Components/MyComponents/InputFilePreview.vue';
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import { useForm } from "@inertiajs/vue3";

export default {
  data() {
    const form = useForm({
      name: null,
      description: null,
      image: null,
    });
    return {
      form,
    }
  },
  components: {
    AppLayout,
    PrimaryButton,
    InputFilePreview,
    InputLabel,
    InputError
  },
  props: {

  },
  methods: {
    store() {
      this.form.post(route("supports.store"), {
        onSuccess: () => {
          this.$notify({
            title: "Correcto",
            message: "Se ha enviado tu reporte. Te contestaremos a la brevedad",
            type: "success",
          });
        },
      });
    },
    saveImage(image) {
      this.form.image = image;
    }
  }
}
</script>

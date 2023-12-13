<template>
  <AppLayout title="Soporte técnico">
    <div class="py-8 px-3 lg:px-12">
      <p>Soporte técnico</p>
      <form @submit.prevent="store" class="mx-8 mt-9 md:grid grid-cols-3 md:gap-9 md:p-4">
        <!-- Primera parte del grid (izquierda) 2 partes del grid -->
        <section class="col-span-2">
          <h1 class="font-bold mb-5">Reporta tu problema</h1>
          <div class="mt-3">
            <InputLabel value="Nombre*" class="ml-3 mb-1" />
            <input v-model="form.name" class="input" type="text" placeholder="Escribe tu nombre" />
            <InputError :message="form.errors.name" />
          </div>

          <div class="mt-3">
            <InputLabel value="¿Tienes algún problema?" class="ml-3 mb-1" />
            <textarea v-model="form.description" class="textarea" rows="3" placeholder="Describe el problema"></textarea>
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

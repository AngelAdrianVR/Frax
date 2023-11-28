<template>
  <button @click="goBack" class="back-button rounded-full border border-[#35F69A] text-primary px-3 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2">
    <div class="flex items-center ">
        <i class="fa-solid fa-reply lg:mr-3"></i>
        <p class="hidden lg:block">Regresar</p>
    </div>
  </button>
</template>

<script>
export default {
  methods: {
    goBack() {
      // Puedes personalizar esta lógica según tus necesidades
      // En este ejemplo, se utiliza la función history.back() para retroceder una página
      window.history.back();
    },
  },
};
</script>

<style scoped>
.back-button {
  transition: background-color 0.3s ease; /* Transición de color de fondo */
}
</style>
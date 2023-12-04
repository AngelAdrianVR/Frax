<template>
  <button @click="goBack" class="back-button flex justify-center items-center rounded-full border hover:bg-primarylight hover:border-transparent py-[9px] px-3 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2">
        <i class="fa-solid fa-angle-left"></i>
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
  transition: background-color 0.5s ease-out; /* Transición de color de fondo */
}
</style>
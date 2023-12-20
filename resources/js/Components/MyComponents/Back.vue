<template>
  <button @click="goBack" class="back-button1 flex justify-center items-center rounded-full hover:bg-gray51 py-[9px] px-3 focus:outline-none hover:shadow-md transition ease-in-out duration-300 hover:-translate-y-2">
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
  transition: background-color 0.3s ease-out; /* Transición de color de fondo */
}
</style>
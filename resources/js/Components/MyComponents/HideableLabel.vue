<template>
  <div>
    <div class="notification-tab" @click="toggleNotification">
        <i :class="iconClass"></i>
        <p v-if="showNotification" class="text-sm ml-3">{{ buttonText }}</p>
    </div>
    <transition name="fade">
      <div v-if="showNotification" class="notification-content">
        <p class="font-bold">{{ notificationTitle }}</p>
        <p class="text-sm">{{ notificationText }}</p>
      </div>
    </transition>
  </div>
</template>

<script>
export default {
  props: {
    buttonText: {
      type: String,
      default: 'Click me',
    },
    iconClass: {
      type: String,
      default: 'fa-solid fa-circle-exclamation',
    },
    notificationTitle: {
      type: String,
      default: 'Notification Title',
    },
    notificationText: {
      type: String,
      default: 'Notification text goes here.',
    },
  },
  data() {
    return {
      showNotification: false,
    };
  },
  methods: {
    toggleNotification() {
      this.showNotification = !this.showNotification;
    },
  },
};
</script>

<style scoped>
.notification-tab {
  cursor: pointer;
  display: flex;
  align-items: center;
  background-color: #fff;
  padding: 5px;
  border: 1px solid #dddddd;
  border-top-left-radius: 10px; /* Redondeo en la esquina superior izquierda */
  border-bottom-left-radius: 10px; /* Redondeo en la esquina inferior izquierda */
}

.notification-content {
  background-color: #fff;
  border: 1px solid #ddd;
  border-top-left-radius: 5px; /* Redondeo en la esquina superior izquierda */
  border-bottom-left-radius: 5px; /* Redondeo en la esquina inferior izquierda */
  padding: 10px;
  margin-top: 5px;
}

.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.5s;
}

.fade-enter,
.fade-leave-to /* .fade-leave-active in <2.1.8 */ {
  opacity: 0;
}

.fade-enter, .fade-enter-active {
  opacity: 1;
}
</style>

<template>
  <AppLayout title="Pagos">
    <LoadingState :loading="loading" />
    <!-- ------------- tabs section starts ------------- -->
    <div class="border-y-2 border-[#D9D9D9] items-center py-2">
      <div class="flex lg:ml-20">
        <Tab @click="currentTab = (index + 1)" :label="tab" :active="currentTab == (index + 1)"
          v-for="(tab, index) in tabs" :key="index" />
      </div>
    </div>
    <!-- ------------- tabs section ends ------------- -->

    <!-- ------------- tab 1 section pagos pendientes starts ------------- -->
    <div class="p-4" v-if="currentTab == 1">

      <div class="flex justify-between mt-5 lg:mx-16">
        <p class="font-bold">Pagos pendientes</p>
        <HideableLabel class="absolute right-0 top-32 z-50" iconClass="fa-solid fa-info">
          <p>
            Es importante pagar los montos si ya ha pasado la fecha de vencimiento para evitar cargos adicionales
          </p>
        </HideableLabel>
      </div>
      <div class="mt-7">
        <div class="md:grid lg:grid-cols-3 md:grid-cols-2 gap-5 space-y-4 lg:space-y-0">
          <PaymentCard class="self-start" v-for="payment in payments.data" :key="payment" :payment="payment" />
        </div>
      </div>
      <div class="text-right mt-5 lg:mr-9">
        <ThirthButton @click="$inertia.get(route('payment-feedbacks.create'))">Envía tus comentarios</ThirthButton>
      </div>
    </div>
    <!-- ------------- tab 1 section pagos pendientes ends ------------- -->

    <!-- ------------- tab 2 Transacciones starts ------------- -->
    <div class="p-4" v-if="currentTab == 2">
      <PaymentTicketTable v-if="paymentTickets?.length > 0" :paymentTickets="paymentTickets" />
      <p class="text-xs text-gray-400 text-center" v-else>No tienes transacciones</p>
    </div>
    <!-- ------------- tab 2 Transacciones ends ------------- -->

    <!-- ------------- tab 3 Historial starts ------------- -->
    <div class="p-4" v-if="currentTab == 3">
      <div class="lg:mx-7">
        <el-timeline>
          <template v-for="(monthActivities, month) in groupedActivities" :key="month">
            <el-timeline-item v-for="(activity, index) in monthActivities" :key="index"
              :timestamp="activity.description + ' el ' + activity.created_at" color="#000000" hollow="true">
              {{ activity.month }}
            </el-timeline-item>
          </template>
        </el-timeline>
      </div>
    </div>
    <!-- ------------- tab 3 Historial ends ------------- -->


  </AppLayout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import PaymentCard from '@/Components/MyComponents/Payment/PaymentCard.vue';
import { Link } from '@inertiajs/vue3';
import Tab from "@/Components/MyComponents/Tab.vue";
import ThirthButton from "@/Components/ThirthButton.vue";
import HideableLabel from "@/Components/MyComponents/HideableLabel.vue";
import LoadingState from "@/Components/MyComponents/LoadingState.vue";
import PaymentTicketTable from "@/Components/MyComponents/Payment/PaymentTicketTable.vue";

export default {
  data() {
    return {
      currentTab: 1,
      paymentTickets: null,
      paymentHistories: null,
      loading: false,
      tabs: [
        'Pagos pendientes',
        'Transacciones',
        'Historial',
      ],
    }
  },
  components: {
    AppLayout,
    PaymentTicketTable,
    PrimaryButton,
    LoadingState,
    HideableLabel,
    ThirthButton,
    PaymentCard,
    Link,
    Tab
  },
  props: {
    payments: Object,
  },
  methods: {
    getStatusStiles(transaction) {
      if (transaction.status == 'Esperando aprobación') {
        return 'text-[#D0D407] bg-[#F7FEAD]';
      } else if (transaction.status == 'Pago rechazado') {
        return 'text-[#E82828] bg-[#FEADAD]';
      } else if (transaction.status == 'Pagado') {
        return 'text-primary bg-primarylight';
      }

    },
    async fetchPaymentTickets() {
      try {
        this.loading = true;
        const response = await axios.get(route('payment-tickets.get-all'));
        if (response.status === 200) {
          this.paymentTickets = response.data.items;
          this.loading = false;
        }
      } catch (error) {
        console.log(error);
      }
    },
    async fetchPaymentHistories() {
      try {
        this.loading = true;
        const response = await axios.get(route('payment-histories.get-all'));
        if (response.status === 200) {
          this.paymentHistories = response.data.items;
          this.loading = false;
        }
      } catch (error) {
        console.log(error);
      }
    }
  },
  computed: {
    groupedActivities() {
      // Agrupar actividades por mes
      const grouped = {};
      this.paymentHistories?.forEach((activity) => {
        const month = activity.month;
        if (!grouped[month]) {
          grouped[month] = [];
        }
        grouped[month].push(activity);
      });
      return grouped;
    },
  },
  watch: {
    currentTab(newVal) {
      if (newVal == 2 && this.paymentTickets === null) {
        //recupera la información de visitas frecuentes
        this.fetchPaymentTickets();

      }
      if (newVal == 3 && this.paymentHistories === null) {
        //recupera la información de visitas frecuentes
        this.fetchPaymentHistories();
      }

      // Agrega la variable currentTab=newVal a la URL para mejorar la navegacion al actalizar o cambiar de pagina
      const currentURL = new URL(window.location.href);
      currentURL.searchParams.set('currentTab', newVal);

      // Actualiza la URL
      window.history.replaceState({}, document.title, currentURL.href);
    }
  },
  mounted() {
    // Obtén la URL actual
    const currentURL = new URL(window.location.href);

    // Extrae el valor de 'currentTab' de los parámetros de búsqueda
    const currentTabFromURL = currentURL.searchParams.get('currentTab');

    // Convierte el valor a un número, ya que los parámetros de búsqueda son cadenas
    this.currentTab = parseInt(currentTabFromURL) || 1;

    // ... el resto de tu lógica en el mounted ...
  },
};
</script>

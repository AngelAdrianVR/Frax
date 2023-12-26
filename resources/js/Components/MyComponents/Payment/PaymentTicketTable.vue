<template>
  <table class="w-full mx-auto text-sm mt-5">
    <thead>
      <tr class="text-center">
        <th class="font-bold pb-1 pl-2 text-left border-b border-primary">Folio</th>
        <th class="font-bold pb-1 text-left border-b border-primary">Transacción</th>
        <th class="font-bold pb-1 text-left border-b border-primary">
          Fecha de vencimiento
        </th>
        <th class="font-bold pb-1 text-left border-b border-primary">
          Fecha de operación
        </th>
        <th class="font-bold pb-1 text-left border-b border-primary">Monto</th>
        <th class="font-bold pb-1 text-left border-b border-primary">Método de pago</th>
        <th class="font-bold pb-1 text-left border-b border-primary">Estatus</th>
        <!-- <th class="font-bold pb-3 text-left">
                        Tipo
                        </th> -->
      </tr>
    </thead>
    <tbody>
      <tr
        v-for="(transaction, index) in paymentTickets"
        :key="transaction.id"
        class="mb-4 cursor-pointer rounded-full"
        :class="{ 'bg-[#F2F2F2]': index % 2 == 0 }"
        @click="$inertia.get(route('payment-tickets.show', transaction.id))"
      >
        <td class="py-2 pl-2 rounded-l-full">
          {{ transaction.id }}
        </td>
        <td class="py-2">
          <span :title="transaction.payment?.name" class="truncate">{{
            transaction.payment?.name
          }}</span>
        </td>
        <td class="py-2">
          {{ transaction.payment?.limit_date }}
        </td>
        <td class="py-2">
          {{ transaction.created_at }}
        </td>
        <td class="py-2">
          ${{
            transaction.payment?.total?.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",")
          }}
        </td>
        <td class="py-2">
          {{ transaction.payment_method }}
        </td>
        <td class="py-2 rounded-r-full">
          <span class="py-1 px-3 rounded-full" :class="getStatusStiles(transaction)">{{
            transaction.status
          }}</span>
        </td>
      </tr>
    </tbody>
  </table>
</template>

<script>
export default {
  data() {
    return {};
  },
  components: {
    
  },
  props: {
    paymentTickets: Array,
  },
  methods: {
    getStatusStiles(transaction) {
      if (transaction.status == "Esperando aprobación") {
        return "text-[#D0D407] bg-[#F7FEAD]";
      } else if (transaction.status == "Pago rechazado") {
        return "text-[#E82828] bg-[#FEADAD]";
      } else if (transaction.status == "Pagado") {
        return "text-primary bg-primarylight";
      }
    },
  },
};
</script>

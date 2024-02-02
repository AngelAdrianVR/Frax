<template>
  <AppLayout title="Calendario">
       <p class="mt-4 pr-10 -mb-5 text-2xl font-bold text-right lg:mr-10 uppercase">{{ currentMonth.toLocaleDateString('es-ES', {
              year: 'numeric'
            })
          }}</p>
    <div class="relative overflow-hidden lg:flex">
      <section class="text-lg mx-auto lg:mx-2 w-1/4 lg:mt-14">
        <div class="flex flex-col justify-center items-center">
          <p class="text-8xl font-bold">{{ daySelection }}</p>
          <div class="flex items-center">
            <i @click="changeMonth(-1)" class="fa-solid fa-angle-left text-primary text-xs mr-1 cursor-pointer p-1"></i>
            <p class="text-center text-xl ml-2 uppercase w-44">{{ currentMonth.toLocaleDateString('es-ES', {
              month: 'long'
            })
            }}</p>
            <i @click="changeMonth(1)" class="fa-solid fa-angle-right text-primary text-xs ml-1 cursor-pointer p-1"></i>
          </div>
        </div>
      </section>

      <!-- <div class="mx-14">
        <button @click="showPendentInvitationsModal = true" v-if="pendent_invitations.length"
          class="bg-[#FEDBBD] text-[#FD8827] px-2 py-1 rounded-[5px] text-sm">Invitaciones pendientes <span
            class="ml-2">({{
              pendent_invitations.length }})</span></button>
      </div> -->

      <!-- -------------- calendar section --------------- -->
      <section @click="selectedDay = null" class="lg:w-3/4 w-full mx-auto lg:ml-auto mb-10 lg:mr-14">
        <table class="w-full mt-8">
            <tr class="text-center text-base *:bg-primarylight *:py-2">
                <th>DOM</th>
                <th>LUN</th>
                <th>MAR</th>
                <th>MIE</th>
                <th>JUE</th>
                <th>VIE</th>
                <th>SAB</th>
            </tr>
            <tr v-for="(week, index) in weeks" :key="index" class="text-xs text-right">
                <td v-for="day in week" :key="day" class="h-10 relative text-center">
                    <!-- Agrega la clase 'text-red-500' si hay tareas para este día -->
                    <p @click="daySelection = day" :class="{'text-white size-8 pt-1.5 bg-red-600': hasTasks(day), 'bg-gray-100': day === daySelection}" class="rounded-full text-sm cursor-pointer hover:bg-gray-100 hover:text-gray1 inline-block size-8 pt-1.5">{{ day }}</p>
                </td>
            </tr>
        </table>
    </section>
    </div>

    <!-- Tasks section ---------------------- -->
      <div v-if="daySelection" class="border-t border-gray4 lg:mx-7 lg:py-7 lg:px-8 text-sm">
        <div class="flex justify-between text-right">
          <p class="font-bold">Actividades programadas <span class="text-gray3 ml-4">{{ formattedSelectedDate }}</span></p>
          <Link :href="getCreateTaskUrl()">
            <PrimaryButton>Agendar</PrimaryButton>
          </Link>
        </div>
        <section class="grid grid-cols-2 lg:grid-cols-3 gap-3 mt-5">
         <TaskCard v-for="task in filteredTasks" :key="task.id" :task="task" />
        </section>
      </div>
      <!-- -------------------------------------- -->

    <DialogModal :show="showPendentInvitationsModal" @close="showPendentInvitationsModal = false">
      <template #title>
        Invitaciones pendientes
      </template>
      <template #content>
        <div v-for="(meeting, index) in pendent_invitations_local" :key="index"
          class="lg:grid grid-cols-3 px-3 py-2 border-b border-[#a9a9a9]">
          <div>
            <h2 class="font-bold ml-2 mb-3">{{ meeting.title }}</h2>
            <p class="text-sm">Fecha: {{ formatDateDns(meeting.start_date) }} </p>
            <p v-if="!meeting.is_full_day" class="text-sm">Hora: {{ meeting.start_time }} - {{ meeting.end_time }} </p>
            <p class="text-sm">Ubicación: {{ meeting.location }} </p>
          </div>
          <div
            class="grid grid-cols-2 lg:grid-cols-5 border-t-2 border-[#cccccc] pt-2 mt-2 lg:border-none col-span-2 text-sm">
            <p>Anfitrión:</p> <span class="lg:col-span-4 truncate">{{ meeting.user?.name }}</span>
            <p>Descripción:</p> <span class="lg:col-span-4 truncate">{{ meeting.description }}</span>
            <p v-if="meeting.user.id !== $page.props.auth.user.id">Asistenca:</p>
            <span v-if="meeting.user.id !== $page.props.auth.user.id" class="lg:col-span-4 flex space-x-2">
              <div
                v-if="meeting.participants.find(item => item.user_id == $page.props.auth.user.id && item.status == 'Pendiente')">
                <el-popconfirm confirm-button-text="Si" cancel-button-text="No" icon-color="#0355B5" title="¿Continuar?"
                  @confirm="setAttendanceConfirmation('Confirmado', index)">
                  <template #reference>
                    <button
                      class="text-sm text-white bg-[#2CC513] rounded-[10px] py-px px-2 mr-3 disabled:opacity-25 disabled:cursor-not-allowed"
                      :disabled="loading">Aceptar</button>
                  </template>
                </el-popconfirm>
                <el-popconfirm confirm-button-text="Si" cancel-button-text="No" icon-color="#0355B5" title="¿Continuar?"
                  @confirm="setAttendanceConfirmation('Rechazado', index)">
                  <template #reference>
                    <button
                      class="text-sm text-white bg-primary rounded-[10px] py-px px-2 mr-3 disabled:opacity-25 disabled:cursor-not-allowed"
                      :disabled="loading">Rechazar</button>
                  </template>
                </el-popconfirm>
                <i v-if="loading" class="fa-solid fa-spinner fa-spin text-sm text-primary"></i>
              </div>
            </span>
          </div>
        </div>
      </template>
      <template #footer>

      </template>
    </DialogModal>
  </AppLayout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";
import DialogModal from "@/Components/DialogModal.vue";
import TaskCard from "@/Components/MyComponents/Calendar/TaskCard.vue";
import axios from 'axios';
import moment from 'moment';
import { format } from 'date-fns';
import { es } from 'date-fns/locale';
import { Link } from "@inertiajs/vue3";

export default {
  data() {
    return {
      currentMonth: new Date(),
      // selectedTask: null, // Variable para realizar un seguimiento de la tarea seleccionada
      // selectedDay: null, // Seguinmiento del dia seleccionado
      showPendentInvitationsModal: false,
      pendent_invitations_local: this.pendent_invitations,
      daySelection: new Date().getDate(), // Asigna el número del día actual
    }
  },
  components: {
    AppLayout,
    PrimaryButton,
    SecondaryButton,
    Dropdown,
    DropdownLink,
    DialogModal,
    TaskCard,
    Link
  },
  props: {
    tasks: Object,
    pendent_invitations: Array,
  },
  methods: {
    hasTasks(day) {
        // Verifica si hay tareas para el día seleccionado
        const tasksForDay = this.tasks.data.filter(task => {
            const taskDate = new Date(task.start_date);
            const taskDay = taskDate.getDate();
            const taskMonth = taskDate.getMonth() + 1; // Nota: getMonth devuelve 0-11, por eso sumamos 1
            const taskYear = taskDate.getFullYear();

            return taskDay === day && taskMonth === this.currentMonth.getMonth() + 1 && taskYear === this.currentMonth.getFullYear();
        });

        return tasksForDay.length > 0;
    },
    getCreateTaskUrl() {
        // Formatea la fecha del día seleccionado en un formato adecuado para la URL
        const formattedDateForUrl = format(new Date(this.currentMonth.getFullYear(), this.currentMonth.getMonth(), this.daySelection), 'yyyy-MM-dd', { locale: es });

        // Construye la URL con la fecha como parámetro de consulta
        return this.route('calendars.create', { date: formattedDateForUrl });
    },
    // async setAttendanceConfirmation(status, index) {
    //   this.loading = true;
    //   try {
    //     const response = await axios.put(route('calendars.set-attendance-confirmation', this.pendent_invitations[index].id), {
    //       status: status
    //     });

    //     if (response.status === 200) {
    //       this.pendent_invitations_local.splice(index, 1);

    //       if (response.data.item) {
    //         this.tasks.data.push(response.data.item);
    //       }

    //       this.$notify({
    //         title: 'Éxito',
    //         message: 'Se ha cambiado el status de la invitacion a ' + status,
    //         type: 'success'
    //       });
    //     }
    //   } catch (error) {
    //     this.$notify({
    //       title: 'Error',
    //       message: error.message,
    //       type: 'error'
    //     });
    //   } finally {
    //     this.loading = false;
    //   }
    // },
    // formatDateDns(date) {
    //   const parsedDate = new Date(date);
    //   return format(parsedDate, "dd MMM, yyyy", { locale: es }); // Formato personalizado
    // },
    async taskDone() {
      try {
        const response = await axios.put(route('calendars.task-done', this.selectedTask));

        if (response.status === 200) {
          this.$notify({
            title: "Éxito",
            message: "Tarea terminada",
            type: "success",
          });
          this.selectedTask.status = 'Terminada';
        }
      } catch (error) {
        console.log(error);
      }
    },
    // deleteTask() {
    //   this.$inertia.delete(route('calendars.destroy', this.selectedTask));
    //   this.$notify({
    //     title: "Éxito",
    //     message: "Tarea terminada",
    //     type: "success",
    //   });
    // },
    changeMonth(offset) {
      const newMonth = new Date(this.currentMonth.getFullYear(), this.currentMonth.getMonth() + offset, 1);
      this.currentMonth = newMonth;
    },
    // isTaskDay(task, day) {
    //   if (day) {
    //     const taskStartDate = new Date(task.start_date);
    //     const currentDay = new Date(this.currentMonth.getFullYear(), this.currentMonth.getMonth(), day);

    //     // Convierte las fechas a objetos Moment
    //     const momentFecha1 = moment(taskStartDate);
    //     const momentFecha2 = moment(currentDay);

    //     return momentFecha1.isSame(momentFecha2);
    //   }
    //   return false;
    // },
    // getDurationTask() {
    //   // Convierte las fechas en objetos Date
    //   const startDate = new Date(this.selectedTask.start_date);
    //   const finishDate = new Date(this.selectedTask.finish_date);

    //   // Calcula la diferencia en milisegundos
    //   const diferenciaEnMilisegundos = finishDate - startDate;

    //   // Convierte la diferencia en días
    //   const duracionEnDias = diferenciaEnMilisegundos / (1000 * 60 * 60 * 24);

    //   return duracionEnDias;
    // },
    formatDate(dateString) {
      if (dateString) {
        const date = new Date(dateString);
        const options = {
          hour: 'numeric',
          minute: 'numeric',
          hour12: true, // Habilitar el formato AM/PM
        };
        return date.toLocaleTimeString(undefined, options);
      }
      return ''; // Manejar el caso en el que la fecha sea nula
    }
  },
  computed: {
    weeks() {
      const firstDayOfMonth = new Date(this.currentMonth.getFullYear(), this.currentMonth.getMonth(), 1);
      const lastDayOfMonth = new Date(this.currentMonth.getFullYear(), this.currentMonth.getMonth() + 1, 0);
      const startDayOfWeek = firstDayOfMonth.getDay(); // 0 (Domingo) a 6 (Sábado)
      const totalDaysInMonth = lastDayOfMonth.getDate();
      const days = [];
      let currentWeek = [];

      // Llena los días previos al primer día del mes con celdas vacías
      for (let i = 0; i < startDayOfWeek; i++) {
        currentWeek.push('');
      }

      // Agrega los números de los días del mes
      for (let i = 1; i <= totalDaysInMonth; i++) {
        currentWeek.push(i);
        if (currentWeek.length === 7) {
          days.push([...currentWeek]);
          currentWeek = [];
        }
      }

      // Añade la última semana si es necesario
      if (currentWeek.length > 0) {
        days.push([...currentWeek]);
      }

      return days;
    },
    formattedSelectedDate() {
        const selectedDate = new Date(this.currentMonth);
        selectedDate.setDate(this.daySelection);

        return format(selectedDate, 'EEEE, d MMMM yyyy', { locale: es });
    },
    filteredTasks() {
        if (!this.tasks.data) return [];

        // Filtra las tareas que corresponden al día seleccionado
        return this.tasks.data.filter(task => {
            const taskDate = new Date(task.start_date);
            const taskDay = taskDate.getDate();
            const taskMonth = taskDate.getMonth() + 1; // Nota: getMonth devuelve 0-11, por eso sumamos 1
            const taskYear = taskDate.getFullYear();

            return taskDay === this.daySelection && taskMonth === this.currentMonth.getMonth() + 1 && taskYear === this.currentMonth.getFullYear();
        });
    },
  },
}
</script>

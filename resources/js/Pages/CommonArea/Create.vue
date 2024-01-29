<template>
    <AppLayout title="Registrar área común">
        <div class="lg:py-7 lg:px-10">
            <Back />

            <h1 class="font-bold mx-5 lg:mx-28 mt-5">Agregar área común</h1>
            <form @submit.prevent="store" class="grid grid-cols-1 lg:grid-cols-2 gap-x-14 gap-y-1 mx-5 lg:mx-20 mt-5">
                <!-- columna izquierda -->
                <div>
                    <div>
                        <InputLabel value="Nombre del área*" class="ml-3 mb-1" />
                        <el-input v-model="form.name" placeholder="Escribe el nombre aqui" :maxlength="255" clearable />
                        <InputError :message="form.errors.name" />
                    </div>
                    <div class="mt-1">
                        <InputLabel value="Costo*" class="ml-3 mb-1" />
                        <el-input v-model="form.cost" placeholder=""
                            :formatter="(value) => `$ ${value}`.replace(/\B(?=(\d{3})+(?!\d))/g, ',')"
                            :parser="(value) => value.replace(/\$\s?|(,*)/g, '')" />
                        <InputError :message="form.errors.cost" />
                    </div>
                    <section class="lg:grid grid-cols-2 gap-x-1 gap-y-px">
                        <div class="mt-1">
                            <InputLabel value="Horas de preparación*" class="ml-3 mb-1" />
                            <el-input-number v-model="form.preparation_hours" size="small" :min="0" :max="31" />
                            <InputError :message="form.errors.preparation_hours" />
                        </div>
                        <div class="mt-1">
                            <InputLabel value="Días de anticipación para reservar*" class="ml-3 mb-1" />
                            <el-input-number v-model="form.days_anticipation_booking" size="small" :min="0" :max="31" />
                            <InputError :message="form.errors.days_anticipation_booking" />
                        </div>
                        <div class="mt-1">
                            <InputLabel value="Capacidad máxima*" class="ml-3 mb-1" />
                            <el-input-number v-model="form.capacity" size="small" :min="1" :max="1000" />
                            <InputError :message="form.errors.capacity" />
                        </div>
                    </section>
                    <div class="mt-1">
                        <el-checkbox v-model="form.is_multiple_reserved" label="Puede reservarse multiples veces en un día"
                            size="small" />
                    </div>
                    <div class="mt-1">
                        <InputLabel value="Descripción*" class="ml-3 mb-1" />
                        <el-input v-model="form.description" :autosize="{ minRows: 3, maxRows: 5 }" type="textarea"
                            placeholder="Please input" :maxlength="800" show-word-limit clearable />
                        <InputError :message="form.errors.description" />
                    </div>
                    <div class="mt-1">
                        <InputLabel value="Notas*" class="ml-3 mb-1" />
                        <el-input v-model="form.notes" :autosize="{ minRows: 3, maxRows: 5 }" type="textarea"
                            placeholder="Please input" :maxlength="800" show-word-limit clearable />
                        <InputError :message="form.errors.notes" />
                    </div>
                    <div class="flex flex-col items-center mt-7">
                        <PrimaryButton class="w-1/2" :disabled="!form.name || !form.description">Guardar
                        </PrimaryButton>
                    </div>
                </div>
                <!-- columna derecha desktop-->
                <div>
                    <!-- horario semanal -->
                    <InputLabel value="Horario semanal*" class="ml-3 mb-1" />
                    <section class="text-sm">
                        <tr class="grid grid-cols-3 gap-x-3 text-xs">
                            <th class="flex items-center">Día</th>
                            <th class="col-span-2 flex items-center space-x-5">
                                <span class="w-1/3">Hora de apertura</span>
                                <span class="w-1/3">Hora de cierre</span>
                                <span class="w-1/3">Duración de reservación</span>
                            </th>
                        </tr>
                        <tr v-for="(day, index) in weekDays" :key="index" class="grid grid-cols-3 gap-x-3">
                            <div class="flex space-x-3 items-center">
                                <el-switch v-model="form.schedule[index].active" size="small" />
                                <span>{{ day }}</span>
                            </div>
                            <div v-if="form.schedule[index].active" class="col-span-2 flex items-center space-x-5 mb-1">
                                <el-time-select v-model="form.schedule[index].open" :max-time="form.schedule[index].close"
                                    placeholder="Apertura" start="05:00" step="00:15" end="23:30"
                                    format="hh:mm A" class="w-1/3" />
                                <el-time-select v-model="form.schedule[index].close" :min-time="form.schedule[index].open"
                                    placeholder="Cierre" start="05:00" step="00:15" end="23:30" format="hh:mm A"
                                    value-format="HH:mm" class="w-1/3" />
                                <el-input-number v-model="form.schedule[index].duration" size="small" :min="1" :max="8" class="w-1/3" />
                            </div>
                            <div v-else class="col-span-2 my-2 text-gray2 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor" class="size-4 mr-2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M21.752 15.002A9.72 9.72 0 0 1 18 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 0 0 3 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 0 0 9.002-5.998Z" />
                                </svg>
                                <p>Cerrado</p>
                            </div>
                        </tr>
                    </section>
                </div>
            </form>
        </div>
    </AppLayout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import Back from '@/Components/MyComponents/Back.vue';
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import Checkbox from "@/Components/Checkbox.vue";
import { useForm, Link } from "@inertiajs/vue3";
import { Carousel, Slide } from 'vue3-carousel';
import 'vue3-carousel/dist/carousel.css';
import moment from "moment";

export default {
    data() {
        const form = useForm({
            name: null,
            description: null,
            notes: null,
            cost: 0,
            capacity: 1,
            preparation_hours: 0,
            rules: null,
            policy: null,
            days_anticipation_booking: 0,
            is_multiple_reserved: true,
            schedule: [
                { open: null, close: null, duration: 1, active: true },
                { open: null, close: null, duration: 1, active: true },
                { open: null, close: null, duration: 1, active: true },
                { open: null, close: null, duration: 1, active: true },
                { open: null, close: null, duration: 1, active: true },
                { open: null, close: null, duration: 1, active: true },
                { open: null, close: null, duration: 1, active: true },
            ],
        });
        return {
            form,
            currentSlide: 1,
            weekDays: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado',],
        };
    },
    components: {
        AppLayout,
        PrimaryButton,
        InputLabel,
        InputError,
        Checkbox,
        Back,
        Link,
        Carousel,
        Slide,
    },
    props: {
        common_area: Object,
        reservations: Object,
    },
    methods: {
        formatTooltip(value) {
            if (value == 1) {
                return value + ' persona';
            } else {
                return value + ' personas';
            }
        },
        updateTimeOptions() {
            if (this.form.date) {
                const reservationDate = parseISO(this.form.date);

                const scheduleInfo = this.common_area.schedule[reservationDate.getDay()];

                if (scheduleInfo && scheduleInfo !== null) {
                    const openTime = scheduleInfo.open;
                    const closeTime = scheduleInfo.close;
                    const duration = scheduleInfo.duration;
                    const preparation = this.common_area.preparation_hours;

                    // Filtra las reservaciones del día seleccionado
                    const reservationsOfDay = this.reservations.data.filter(reservation => reservation.date == this.formatDate(reservationDate));

                    // Genera la lista de horarios disponibles
                    const timeOptions = this.generateTimeOptions(openTime, closeTime, duration, preparation, reservationsOfDay);

                    // Actualiza el modelo timePickerOptions con el resultado
                    this.timePickerOptions = timeOptions;
                }
            }
        },
        generateTimeOptions(openTime, closeTime, duration, preparation, reservationsOfDay) {
            const timeOptions = [];
            let currentTime = moment(`2000-01-01 ${openTime}`, 'YYYY-MM-DD HH:mm');
            const closeDateTime = moment(`2000-01-01 ${closeTime}`, 'YYYY-MM-DD HH:mm');

            while (currentTime.isBefore(closeDateTime)) {
                const nextTime = moment(currentTime).add(duration, 'hours');

                const isDisabled = reservationsOfDay.some(reservation =>
                    reservation.time == currentTime.format('HH:mm')
                );

                if (nextTime.isBefore(closeDateTime)) {
                    let label = currentTime.format('h:mm A');
                    if (isDisabled) label += ' (Reservado)';
                    timeOptions.push({
                        label: label,
                        value: currentTime.format('HH:mm'),
                        disabled: isDisabled
                    });
                }

                currentTime.add(duration + preparation, 'hours');
            }

            return timeOptions;
        },
        formatTime(date) {
            // Formatea la hora en el formato "HH:mm"
            const hours = String(date.getHours()).padStart(2, "0");
            const minutes = String(date.getMinutes()).padStart(2, "0");
            return `${hours}:${minutes}`;
        },
        store() {
            this.form.post(route("common-areas-users.store"), {
                onSuccess: () => {
                    this.$notify({
                        title: "Correcto",
                        message: "Se ha registrado la reservación",
                        type: "success",
                    });
                },
            });
        },
        disabledDate(time) {
            // Obtén el día de la semana (0 = domingo, 1 = lunes, ..., 6 = sábado)
            const dayOfWeek = time.getDay();

            // Verifica si el día de la semana está configurado como "null" en el schedule
            const isDayNull = this.common_area.schedule[dayOfWeek] === null;

            // Formatea la fecha para compararla con las fechas reservadas
            const formattedDate = this.formatDate(time);

            // Verifica si la fecha y hora está en la lista de reservaciones
            const isReservedDateTime = this.reservations.data.some(reservation => {
                return formattedDate == reservation.date;
            });

            // Verifica si la fecha está dentro de la anticipación de la reserva
            const today = new Date();
            const anticipationDate = new Date();
            anticipationDate.setDate(today.getDate() + this.common_area.days_anticipation_booking);
            const isWithinAnticipation = time < anticipationDate;

            // Verifica si la fecha es anterior a la fecha actual
            const isPastDate = time < today;

            // La fecha se deshabilita si es un día configurado como "null", una fecha reservada, está dentro de la anticipación o es una fecha pasada
            // return isDayNull || isReservedDateTime || isWithinAnticipation || isPastDate;
            return isDayNull || isWithinAnticipation || isPastDate;
        },
        formatDate(date) {
            // Formatea la fecha en el formato "YYYY-MM-DD"
            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, "0");
            const day = String(date.getDate()).padStart(2, "0");
            return `${year}-${month}-${day}`;
        },
    },
};
</script>
<style scoped>
.carousel__item {
    height: 300px;
    width: 100%;
    background-color: var(--vc-clr-primary);
    color: var(--vc-clr-white);
    font-size: 20px;
    border-radius: 5px;
    display: flex;
    justify-content: center;
    align-items: center;
    margin-left: 2px;
    margin-right: 2px;
}
</style>

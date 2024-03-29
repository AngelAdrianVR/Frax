<template>
    <AppLayout title="Registrar reservación de área común">
        <div class="lg:py-7 lg:px-10">
            <Back />

            <h1 class="font-bold mx-5 lg:mx-28 mt-5">{{ common_area.name }}</h1>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-x-32 gap-y-1 mx-5 lg:mx-20 mt-5">
                <!-- columna izquierda -->
                <div>
                    <p class="w-full flex items-center space-x-2">
                        <span class="w-1/2">
                            <i class="fa-solid fa-dollar-sign w-1/6 text-center mr-px text-secondary"></i>
                            <small>Costo</small>
                        </span>
                        <small class="w-1/2">${{ common_area.cost }} MXN</small>
                    </p>
                    <p class="w-full flex items-center space-x-2">
                        <span class="w-1/2">
                            <i class="fa-solid fa-users w-1/6 text-center mr-px text-secondary"></i>
                            <small>Capacidad</small>
                        </span>
                        <small class="w-1/2">{{ common_area.capacity }} Personas</small>
                    </p>
                    <p v-for="(feature, index) in common_area.features" :key="index"
                        class="w-full flex items-center space-x-2">
                        <span class="w-1/2">
                            <i :class="feature.icon" class="w-1/6 text-center mr-px text-secondary"></i>
                            <small>{{ feature.label }}</small>
                        </span>
                        <small class="w-1/2">{{ feature.value }}</small>
                    </p>
                    <!-- carrusel vista movil -->
                    <div class="md:hidden my-3">
                        <figure class="rounded-[5px] w-full">
                            <Carousel :autoplay="4000" :wrap-around="true" v-model="currentSlide">
                                <Slide v-for="slide in 10" :key="slide">
                                    <div class="carousel__item">{{ slide }}</div>
                                </Slide>
                            </Carousel>
                            <div class="flex justify-center space-x-2 mt-2">
                                <button v-for="image in 10" :key="image" @click="currentSlide = image"
                                    class="w-2 h-2 rounded-full"
                                    :class="currentSlide == image ? 'bg-secondary' : 'bg-gray4'"></button>
                            </div>
                        </figure>
                        <p class="mt-4 mx-6 text-center text-xs">{{ common_area.notes }}</p>
                    </div>
                    <form @submit.prevent="store" class="mt-5 text-sm">
                        <div>
                            <InputLabel value="Fecha de reservación*" class="ml-3 mb-1" />
                            <el-date-picker v-model="form.date" @change="updateTimeOptions" type="date"
                                placeholder="Seleccione" :disabled-date="disabledDate" format="dddd, DD/MMM/YYYY"
                                value-format="YYYY-MM-DD" />
                            <InputError :message="form.errors.date" />
                        </div>
                        <div v-if="form.date" class="mt-2">
                            <InputLabel value="Horario disponible a reservar*" class="ml-3 mb-1" />
                            <el-select v-model="form.time" placeholder="Elige la hora">
                                <el-option v-for="item in timePickerOptions" :key="item.value" :label="item.label"
                                    :value="item.value" :disabled="item.disabled" />
                            </el-select>
                            <InputError :message="form.errors.time" />
                        </div>
                        <div class="mt-2">
                            <InputLabel value="Cantidad de personas*" class="ml-3 mb-1" />
                            <el-slider v-model="form.people_quantity" :min="1" :max="common_area.capacity"
                                class="!w-2/3 pl-3" :format-tooltip="formatTooltip" />
                            <InputError :message="form.errors.people_quantity" />
                        </div>
                        <div class="block mt-4">
                            <label class="flex items-center">
                                <Checkbox v-model:checked="form.agree" name="agree" required />
                                <span class="ms-2 text-sm text-gray-600">
                                    He leído el
                                    <Link href="#" class="text-primary hover:underline">reglamento</Link>,
                                    <Link href="#" class="text-primary hover:underline">políticas</Link> y
                                    <Link href="#" class="text-primary hover:underline">términos</Link> establecidos*
                                </span>
                            </label>
                        </div>
                        <div class="flex flex-col items-center mt-7">
                            <PrimaryButton class="w-1/2"
                                :disabled="!form.people_quantity || !form.date || !form.time || !form.agree">Pasar al pago
                            </PrimaryButton>
                            <small class="mt-2">La reservación se debe hacer con al menos {{
                                common_area.days_anticipation_booking }} día(s) de
                                anticipación</small>
                        </div>
                    </form>
                </div>
                <!-- columna derecha desktop-->
                <div class="hidden md:block">
                    <figure class="rounded-[5px] w-full">
                        <Carousel :autoplay="4000" :wrap-around="true" v-model="currentSlide">
                            <Slide v-for="slide in 10" :key="slide">
                                <div class="carousel__item">{{ slide }}</div>
                            </Slide>
                        </Carousel>
                        <div class="flex justify-center space-x-2 mt-2">
                            <button v-for="image in 10" :key="image" @click="currentSlide = image"
                                class="w-2 h-2 rounded-full"
                                :class="currentSlide == image ? 'bg-secondary' : 'bg-gray4'"></button>
                        </div>
                    </figure>
                    <p class="mt-4 mx-6 text-center text-sm">{{ common_area.notes }}</p>
                </div>
            </div>
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
import { parse, parseISO, format, addHours, isBefore } from 'date-fns';
import axios from "axios";

export default {
    data() {
        const form = useForm({
            date: null,
            time: null,
            people_quantity: 1,
            agree: false,
            common_area_id: this.common_area.id,
        });
        return {
            form,
            currentSlide: 1,
            // reservations: [],
            timePickerOptions: [],
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

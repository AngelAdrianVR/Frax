<template>
    <AppLayout title="Registrar visita">
        <div class="lg:py-7 lg:px-10">
            <Back />
            <form @submit.prevent="store" class="mx-8 mt-9 grid grid-cols-2 gap-9 p-4">
                <div>
                    <div class="flex justify-center items-start space-x-12 text-sm mb-8">
                        <div class="flex items-center mr-5">
                        <input v-model="guestForm.type" value="Visita"
                            class="checked:bg-primary focus:text-primary focus:ring-primary bg-transparent w-3 h-3 cursor-pointer"
                            type="radio" name="task_type" />
                        <p class="ml-3 flex items-center">
                            <i class="fa-regular fa-user mr-2"></i>
                            Programar visita
                        </p>
                        </div>
                        <div class="flex items-center">
                        <input v-model="guestForm.type" value="Evento"
                            class="checked:bg-primary focus:text-primary focus:ring-primary bg-transparent w-3 h-3 cursor-pointer"
                            type="radio" name="task_type" />
                        <p class="ml-3 flex items-center">
                            <i class="fa-regular fa-calendar mr-2"></i>
                            Evento
                        </p>
                        </div>
                    </div>
                    <!-- --------------- Programar visita -------------- -->
                    <section v-if="guestForm.type == 'Visita'">
                        <div class="relative">
                            <InputLabel value="Nombre del visitante*" class="ml-3 mb-1" />
                            <p @click="guestForm.reset(); favoriteGuestModal = true" class="text-primary text-xs underline cursor-pointer absolute right-2 top-[2px]">Seleccionar visita frecuente</p>
                            <input v-model="guestForm.name" class="input" type="text" />
                            <InputError :message="guestForm.errors.name" />
                            <p class="text-xs ml-3">En caso de no saber el nombre de la visita, solo puede agregar  el nombre de la empresa o el tipo de servicio que le realizarán. (p ej. servicio de comida)</p>
                        </div>

                        <div class="mt-4">
                            <InputLabel value="Foto del visitante" class="ml-3 mb-1" />
                            <figure @click="triggerGuestImageInput" class="flex items-center justify-center rounded-md border border-dashed border-[#373737] w-48 h-36 cursor-pointer relative">
                                <i v-if="guestImage" @click.stop="guestImage = null; guestForm.guest_image = null" class="fa-solid fa-xmark absolute p-1 top-1 right-1 z-10 text-sm"></i>
                                <i v-if="!guestImage" class="fa-solid fa-camera text-gray-400 text-xl"></i>
                                 <img v-if="guestImage" :src="guestImage" alt="Vista previa" class="w-full h-full object-contain bg-no-repeat rounded-md opacity-50" />
                                <input ref="fileGuestInput" type="file" @change="handleGuestImageUpload" class="hidden" />
                            </figure>
                        </div>

                        <div class="mt-3">
                            <InputLabel value="Fecha de la visita*" class="ml-3 mb-1" />
                            <el-date-picker v-model="guestForm.visit_date" type="date" placeholder="Seleccione" :disabled-date="disabledDate" />
                            <InputError :message="guestForm.errors.visit_date" />
                        </div>

                        <div class="mt-3">
                            <InputLabel value="Hora" class="ml-3 mb-1" />
                            <el-time-picker v-model="guestForm.time" placeholder="Seleccione (opcional)" />
                            <InputError :message="guestForm.errors.time" />
                        </div>

                        <label class="flex items-center mt-4 text-xs">
                            <Checkbox v-model:checked="guestForm.identification" class="bg-transparent disabled:border-gray-400" />
                            <span class="ml-2 mr-2 text-xs">Solictar foto o identificación del visitante</span>
                            <el-tooltip
                            content="Puedes requerirlo para mayor seguridad"
                            placement="top">
                            <div class="rounded-full border border-primary w-3 h-3 flex items-center justify-center">
                              <i class="fa-solid fa-info text-primary text-[7px]"></i>
                            </div>
                          </el-tooltip>
                        </label>
                    </section>
                </div>
            
                <section v-if="guestForm.type == 'Visita'" class="mt-14">
                  <div>
                    <InputLabel value="Tipo de acceso*" class="ml-3 mb-1" />
                    <el-select @change="resetVehicleData" class="w-full" v-model="guestForm.guest_type" clearable
                        placeholder="Seleccione" no-data-text="No hay opciones registradas"
                        no-match-text="No se encontraron coincidencias">
                        <el-option v-for="item in guestTypes" :key="item" :label="item" :value="item" />
                    </el-select>
                    <InputError :message="guestForm.errors.guest_type" />
                  </div>

                  <div class="rounded-md border border-[#D9D9D9] mt-3" v-if="guestForm.guest_type == 'Vehicular'">
                    <div class="bg-[#F2F2F2] rounded-t-md p-2 flex items-center text-gray-500">
                      <i class="fa-solid fa-car mx-3"></i>
                      <p>Datos del vehículo</p>
                    </div>

                    <div class="pt-1 pb-5 px-7">
                      <div>
                        <InputLabel value="Foto del visitante (opcional)" class="ml-3 mb-1" />
                        <figure @click="triggerVehicleImageInput" class="flex items-center justify-center rounded-md border border-dashed border-[#373737] w-48 h-36 cursor-pointer relative">
                            <i v-if="vehicleImage" @click.stop="vehicleImage = null; guestForm.vehicle_image = null" class="fa-solid fa-xmark absolute p-1 top-1 right-1 z-10 text-sm"></i>
                            <i v-if="!vehicleImage" class="fa-solid fa-camera text-gray-400 text-xl"></i>
                              <img v-if="vehicleImage" :src="vehicleImage" alt="Vista previa" class="w-full h-full  object-contain bg-no-repeat rounded-md opacity-50" />
                            <input ref="fileVehicleInput" type="file" @change="handleVehicleImageUpload" class="hidden" />
                        </figure>
                      </div>

                        <div class="mt-3">
                            <InputLabel value="Marca*" class="ml-3 mb-1" />
                            <input class="input" v-model="guestForm.vehicle_details.brand" type="text" required />
                            <!-- <InputError :message="guestForm.errors?.vehicle_details?.brand" /> -->
                        </div>

                        <div class="mt-3">
                            <InputLabel value="Modelo*" class="ml-3 mb-1" />
                            <input class="input" v-model="guestForm.vehicle_details.model" type="text" required />
                            <!-- <InputError :message="guestForm.errors.vehicle_details.model" /> -->
                        </div>

                        <div class="mt-3">
                            <InputLabel value="Color*" class="ml-3 mb-1" />
                            <input class="input" v-model="guestForm.vehicle_details.color" type="text" required />
                            <!-- <InputError :message="guestForm.errors.vehicle_details.color" /> -->
                        </div>

                        <div class="mt-3">
                            <InputLabel value="Placa*" class="ml-3 mb-1" />
                            <input class="input uppercase" v-model="guestForm.vehicle_details.plate" type="text" required />
                            <!-- <InputError :message="guestForm.errors.vehicle_details.plate" /> -->
                        </div>
                    </div>
                  </div>

                  <div class="mt-3">
                    <InputLabel value="Notas" class="ml-3 mb-1" />
                    <textarea v-model="guestForm.notes" class="textarea" rows="3"></textarea>
                    <InputError :message="guestForm.errors.notes" />
                  </div>
                  
                  <label class="flex items-center mt-1 lg:mt-5 lg:ml-4 text-xs">
                      <Checkbox v-model:checked="guestForm.is_favorite_guest" class="bg-transparent disabled:border-gray-400" />
                      <span class="ml-2 mr-2 text-xs">Agregar esta visita como frecuente</span>
                      <el-tooltip
                      content="Marca esta visita como frecuente para agilizar futuras programaciones de acceso"
                      placement="top">
                      <div class="rounded-full border border-primary w-3 h-3 flex items-center justify-center">
                        <i class="fa-solid fa-info text-primary text-[7px]"></i>
                      </div>
                    </el-tooltip>
                  </label>
                </section>
                <!----------------- Evento -------------------------------------->
                <section class="col-start-1" v-if="guestForm.type == 'Evento'">
                        <div>
                            <InputLabel value="Título del evento*" class="ml-3 mb-1" />
                            <input v-model="eventForm.title" class="input" type="text" />
                            <InputError :message="eventForm.errors.title" />
                        </div>

                        <div class="mt-3">
                            <InputLabel value="Cantidad de invitados*" class="ml-3 mb-1" />
                            <input v-model="eventForm.guests_quantity" class="input" type="number" min="0" />
                            <InputError :message="eventForm.errors.guests_quantity" />
                        </div>

                        <div class="mt-3">
                            <InputLabel value="Fecha*" class="ml-3 mb-1" />
                            <div class="flex items-center">
                              <el-date-picker v-model="eventForm.event_date" type="date" placeholder="Seleccione" :disabled-date="disabledDate" />
                              <InputError :message="eventForm.errors.event_date" />

                              <label class="flex items-center text-xs ml-4">
                              <Checkbox @change="eventFullDay" v-model:checked="eventForm.is_all_day" class="bg-transparent disabled:border-gray-400" />
                              <span class="ml-2 mr-2 text-xs">Todo el día</span>
                              </label>
                            </div>
                        </div>

                        <div class="mt-3">
                            <InputLabel value="Horario" class="ml-3 mb-1" />
                              <el-time-select
                                v-model="eventForm.start_time"
                                class="mr-4"
                                placeholder="Hora de inicio"
                                start="07:00"
                                step="00:15"
                                end="20:00"
                                :disabled="eventForm.is_all_day"
                              />
                              <el-time-select
                                v-model="eventForm.end_time"
                                placeholder="Hora de terminación"
                                start="07:00"
                                step="00:15"
                                end="22:00"
                                :disabled="eventForm.is_all_day"
                              />
                            <InputError :message="eventForm.errors.schedule" />
                        </div>

                        <div class="mt-3">
                            <InputLabel value="Ubicación" class="ml-3 mb-1" />
                            <input v-model="eventForm.location" class="input" type="text" />
                            <InputError :message="eventForm.errors.location" />
                        </div>

                        <div class="mt-3">
                            <InputLabel value="Descripción" class="ml-3 mb-1" />
                            <textarea v-model="eventForm.description" class="textarea" rows="3"></textarea>
                            <InputError :message="eventForm.errors.description" />
                        </div>
                    </section>

                    <section v-if="guestForm.type == 'Evento'">
                      <h1 class="font-bold text-xl text-center">Envia QR o código de autorización</h1>
                      <div class="text-center mt-7">
                        <i class="fa-solid fa-qrcode text-9xl"></i>
                        <p ref="qrCode" class="text-[#9A9A9A] my-4">{{ eventForm.qr_code }}</p>
                        <div class="flex items-center justify-center space-x-4">
                          <PrimaryButton type="button" @click="copyQRCode" class="!py-1">Copiar QR</PrimaryButton>
                          <i class="fa-solid fa-share-nodes text-gray2 bg-[#F2F2F2] rounded-full p-2 cursor-pointer"></i>
                        </div>
                        <p class="text-sm mt-3">Generamos dos códigos para su evento: un código QR y un código de autorización. Al ingresar 
                          sus invitados deben mostrar cualquiera de ellos al personal de seguridad para un ingreso.
                        </p>
                        <p class="text-sm mt-5 font-semibold">El código sólo será válido y vigente el día del evento.</p>
                      </div>
                    </section>
                
                <div class="text-left col-span-2">
                  <PrimaryButton>Guardar</PrimaryButton>
                </div>
        </form>
        </div>
        <!-- Visitante frecuente modal -------------------------------------------------->
        <Modal :show="favoriteGuestModal"
          @close="favoriteGuestModal = false">
          <div class="mx-7 my-4 space-y-4 relative">
            <div @click="favoriteGuestModal = false"
              class="cursor-pointer w-5 h-5 rounded-full border-2 border-black flex items-center justify-center absolute top-0 -right-2">
              <i class="fa-solid fa-xmark"></i>
            </div>

            <h1>Programar visita frecuente</h1>

            <div class="mt-4">
              <el-select @change="findFavoriteGuest" class="w-full" v-model="favoriteGuestId" clearable filterable
                  placeholder="Seleccione" no-data-text="No hay opciones registradas"
                  no-match-text="No se encontraron coincidencias">
                  <el-option v-for="item in favorite_guests.data" :key="item" :label="item.name" :value="item.id">
                    <figure v-if="item.media_guest?.length > 0" style="float: left">
                      <img class="object-contain bg-no-repeat w-6 h-6 rounded-full mt-1" :src="item.media_guest[0]?.original_url" alt="" />
                    </figure>
                    <span v-else figurestyle="float: left"><i class="fa-solid fa-circle-user text-blue-200 text-2xl mt-[2px]"></i></span>
                    <span style="float: center; margin-left: 12px; font-size: 13px">
                      {{ item.name }}
                    </span>
                  </el-option>
              </el-select>
              <InputError :message="guestForm.errors.guest_type" />
            </div>

            <section v-if="selectedFavoriteGuest" class="grid grid-cols-2">
              <!-- Primer mitad del grid del formulariovisita frecuente ------------------ -->
              <div>
                <figure v-if="selectedFavoriteGuest?.media_guest?.length > 0" class="bg-[#F2F2F2] w-44 h-36 rounded-sm">
                  <img class="object-contain bg-no-repeat w-44 h-36" :src="selectedFavoriteGuest?.media_guest[0]?.original_url" alt="" />
                </figure>
                <div class="bg-[#F2F2F2] w-44 h-36 rounded-sm flex justify-center items-center" v-else><i class="fa-regular fa-user text-4xl text-gray3"></i></div>
                <p class="font-bold text-center w-44 mt-1">{{ selectedFavoriteGuest?.name }}</p>

                  <div class="mt-7">
                    <InputLabel value="Fecha de la visita*" class="ml-3 mb-1" />
                    <el-date-picker v-model="guestForm.visit_date" type="date" placeholder="Seleccione" :disabled-date="disabledDate" />
                    <InputError :message="guestForm.errors.visit_date" />
                  </div>

                  <div class="mt-2">
                    <InputLabel value="Hora" class="ml-3 mb-1" />
                    <el-time-picker v-model="guestForm.time" placeholder="Seleccione (opcional)" />
                    <InputError :message="guestForm.errors.time" />
                  </div>

                  <label class="flex items-center mt-4 text-xs">
                      <Checkbox v-model:checked="guestForm.identification" class="bg-transparent disabled:border-gray-400" />
                      <span class="ml-2 mr-2 text-xs">Solictar foto o identificación del visitante</span>
                      <el-tooltip
                      content="Puedes requerirlo para mayor seguridad"
                      placement="top">
                      <div class="rounded-full border border-primary w-3 h-3 flex items-center justify-center">
                        <i class="fa-solid fa-info text-primary text-[7px]"></i>
                      </div>
                    </el-tooltip>
                  </label>
              </div>

              <!-- Primer mitad del grid del formulariovisita frecuente ------------------ -->
              <div>
                <div>
                  <InputLabel value="Tipo de acceso*" class="ml-3 mb-1" />
                  <el-select class="w-full" v-model="guestForm.guest_type" clearable
                      placeholder="Seleccione" no-data-text="No hay opciones registradas"
                      no-match-text="No se encontraron coincidencias">
                      <el-option v-for="item in guestTypes" :key="item" :label="item" :value="item" />
                  </el-select>
                  <InputError :message="guestForm.errors.guest_type" />
                </div>

                <div v-if="guestForm.guest_type == 'Vehicular'" class="border border-[#D9D9D9] rounded-sm mt-2 py-3 px-5">
                  <div class="flex justify-between items-center text-sm mb-3">
                    <p class="font-bold">Selecciona el vehículo</p>
                    <el-tooltip
                      content="Selecciona el vehículo en el que vendrá tu visita"
                      placement="top">
                      <div class="rounded-full border border-primary w-3 h-3 flex items-center justify-center">
                        <i class="fa-solid fa-info text-primary text-[7px]"></i>
                      </div>
                    </el-tooltip>
                  </div>
                  <!-- --------- info vehículos ----------- -->
                  <div v-for="(vehicle, index) in selectedFavoriteGuest?.vehicle_details" :key="index"
                    class="rounded-md bg-[#F2F2F2] col-span-2 mx-auto w-full px-2 py-2 space-y-2 text-xs mt-1"
                  >
                    <div @click="vehicleDetails[index] = !vehicleDetails[index]" class="flex justify-between items-center cursor-pointer relative">
                      <input v-model="selectedVehicleIndex" :value="index" @click.stop="" @change="saveVehicleDetails" class="absolute left-0 bg-transparent checked:text-primary active:text-primary focus:ring-primary transition duration-300 ease-out" type="radio" name="selectedVehicle">
                      <p class="text-gray-800 text-center font-bold ml-7">Vehículo {{ index + 1 }}</p>
                      <i
                        class="fa-solid fa-angle-up transform origin-center transition duration-200 ease-out ml-5"
                        :class="{ '!rotate-180': vehicleDetails[index] }"
                      ></i>
                    </div>
                    <section v-if="vehicleDetails[index]">
                      <div class="border border-[#CCCCCC] border-dashed w-full"></div>
                      <p class="text-gray-400 text-center">Foto del vehículo</p>
                      <figure v-if="selectedFavoriteGuest?.media_vehicle?.length > 0" class="w-48 h-32 rounded-xl mx-auto">
                        <img class="object-contain bg-no-repeat h-32 rounded-lg" :src="selectedFavoriteGuest?.media_vehicle[index]?.original_url" alt="Sin imagen" />
                      </figure>
                      <div class="w-48 h-32 rounded-xl flex border border-dashed border-gray2 mx-auto" v-else></div>
                      <div
                        class="w-full border-b border-dashed border-[#CCCCCC] mt-2 flex justify-between"
                      >
                        <p class="pl-9 text-gray-500">Marca</p>
                        <p class="pr-9">{{ vehicle.brand }}</p>
                      </div>
                      <div
                        class="w-full border-b border-dashed border-[#CCCCCC] mt-2 flex justify-between"
                      >
                        <p class="pl-9 text-gray-500">Modelo</p>
                        <p class="pr-9">{{ vehicle.model }}</p>
                      </div>
                      <div
                        class="w-full border-b border-dashed border-[#CCCCCC] mt-2 flex justify-between"
                      >
                        <p class="pl-9 text-gray-500">Color</p>
                        <p class="pr-9">{{ vehicle.color }}</p>
                      </div>
                      <div
                        class="w-full border-b border-dashed border-[#CCCCCC] mt-2 flex justify-between"
                      >
                        <p class="pl-9 text-gray-500">Placas</p>
                        <p class="pr-9">{{ vehicle.plate }}</p>
                      </div>
                    </section>
                  </div>
                </div>
                <div class="mt-3">
                  <InputLabel value="Notas" class="ml-3 mb-1" />
                  <textarea v-model="guestForm.notes" class="textarea" rows="3"></textarea>
                  <InputError :message="guestForm.errors.notes" />
                </div>
              </div>
            </section>

            <div class="flex justify-end space-x-1 pt-5 pb-1">
              <CancelButton @click="guestForm.reset(); favoriteGuestModal = false">Cancelar</CancelButton>  
              <PrimaryButton @click="store">Continuar</PrimaryButton>
            </div>
          </div>
        </Modal>
    </AppLayout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import CancelButton from "@/Components/MyComponents/CancelButton.vue";
import Back from '@/Components/MyComponents/Back.vue';
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import Checkbox from "@/Components/Checkbox.vue";
import Modal from "@/Components/Modal.vue";
import { ElMessage } from 'element-plus'
import { useForm } from "@inertiajs/vue3";

export default {
  data() {
    const guestForm = useForm({
      type: "Visita",
      guest_type: null, //solo para hacer validación desde metodo store.
      name: null,
      visit_date: null,
      time: null,
      identification: false,
      notes: null,
      is_favorite_guest: false,
      vehicle_details: {
        brand: null,
        model: null,
        color: null,
        plate: null,
      },
      guest_image: null,
      vehicle_image: null,
      qr_code: null,
    });

    const eventForm = useForm({
      title: null,
      guests_quantity: null,
      event_date: null,
      is_all_day: false,
      start_time: null,
      end_time: null,
      location: null,
      description: null,
      qr_code: null,
    });

    return {
      guestForm,
      eventForm,
      guestImage: null,
      vehicleImage: null,
      favoriteGuestId: null, //modal visita frecuente
      selectedFavoriteGuest: null, //modal visita frecuente
      selectedVehicleIndex: null, //modal visita frecuente
      favoriteGuestModal: false, //modal visita frecuente
      vehicleDetails: Array.from({ length: this.selectedFavoriteGuest?.vehicle_details?.length }, () => false), //modal visita frecuente
      guestTypes: ["Peatonal", "Vehicular"],
    };
  },
  components: {
    AppLayout,
    PrimaryButton,
    CancelButton,
    InputLabel,
    InputError,
    Checkbox,
    Modal,
    Back
  },
  props: {
    guests: Object,
    favorite_guests: Object,
  },
  methods: {
    store() {
      if (this.guestForm.type == 'Visita') {
       if (this.guestForm.guest_type == 'Peatonal'){ //si no es vehicular el json de vehicle_details es null para no guardar el formato en la bd.
          this.guestForm.vehicle_details = null;
       }
      this.guestForm.post(route("guests.store"), {
        onSuccess: () => {
          this.$notify({
            title: "Correcto",
            message: "Se ha registrado la visita",
            type: "success",
          });
        },
      });
    } else if ((this.guestForm.type == 'Evento')) {
      console.log('Evento');
      this.eventForm.post(route("events.store"), {
        onSuccess: () => {
          this.$notify({
            title: "Correcto",
            message: "Se ha registrado el evento",
            type: "success",
          });
        },
      });
    }
    },
    // Función para generar una cadena de texto aleatoria
    qrGenerator(longitud) {
      const caracteres =
        "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
      let cadenaAleatoria = "";

      for (let i = 0; i < longitud; i++) {
        const indiceAleatorio = Math.floor(Math.random() * caracteres.length);
        cadenaAleatoria += caracteres.charAt(indiceAleatorio);
      }

      // Asignar la cadena aleatoria al dato 'cadenaAleatoria'
      this.eventForm.qr_code = cadenaAleatoria;
      this.guestForm.qr_code = cadenaAleatoria;
    },
    triggerGuestImageInput() {
      // Simular clic en el input file cuando se hace clic en el icono de la cámara
      this.$refs.fileGuestInput.click();
    },
    triggerVehicleImageInput() {
      // Simular clic en el input file cuando se hace clic en el icono de la cámara
      this.$refs.fileVehicleInput.click();
    },
    handleGuestImageUpload(event) {
      const file = event.target.files[0];
      this.guestForm.guest_image = file;

      if (file) {
        // Obtener la URL de la imagen cargada
        const imageURL = URL.createObjectURL(file);

        // Mostrar la vista previa de la imagen
        this.guestImage = imageURL;
      }
    },
    handleVehicleImageUpload(event) {
      const file = event.target.files[0];
      this.guestForm.vehicle_image = file;

      if (file) {
        // Obtener la URL de la imagen cargada
        const imageURL = URL.createObjectURL(file);

        // Mostrar la vista previa de la imagen
        this.vehicleImage = imageURL;
      }
    },
    disabledDate(time) {
      const today = new Date();
      today.setHours(0, 0, 0, 0);
      return time.getTime() < today.getTime();
    },
    eventFullDay() {
      if (this.eventForm.is_all_day == true) {
        this.eventForm.start_time = '07:00';
        this.eventForm.end_time = '23:59';
      } else{
        this.eventForm.start_time = null;
        this.eventForm.end_time = null;
      }
    },
    copyQRCode() {
      // Seleccionar el contenido del elemento ref qrCode
      const qrCodeElement = this.$refs.qrCode;
      const range = document.createRange();
      range.selectNode(qrCodeElement);
      window.getSelection().removeAllRanges();
      window.getSelection().addRange(range);

      // Copiar al portapapeles
      try {
        document.execCommand('copy');
        window.getSelection().removeAllRanges();

        ElMessage({
        message: 'Código QR copiado al portapapeles',
        type: 'success',
      });

      } catch (err) {
        console.error('Error al copiar el código QR al portapapeles', err);
      }
    },
    findFavoriteGuest() {
      this.guestForm.reset();
      this.vehicleDetails = Array.from({ length: this.selectedFavoriteGuest?.vehicle_details?.length }, () => false)
      this.selectedVehicleIndex = null;
      this.selectedFavoriteGuest = this.favorite_guests.data.find( item => item.id == this.favoriteGuestId);

      //guardar informacion a variables de formulario
      this.guestForm.name = this.selectedFavoriteGuest.name;
    },
    saveVehicleDetails() {
      this.guestForm.vehicle_details = { ... this.selectedFavoriteGuest.vehicle_details[this.selectedVehicleIndex]};
    },
    resetVehicleData() {
      this.guestForm.vehicle_image = null;
      this.vehicleImage = null;
      this.guestForm.vehicle_details.brand = null;
      this.guestForm.vehicle_details.model = null;
      this.guestForm.vehicle_details.color = null;
      this.guestForm.vehicle_details.plate = null;
    }
  },
  mounted() {
     this.qrGenerator(5);
  }
};
</script>

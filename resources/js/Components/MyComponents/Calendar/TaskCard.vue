<template>
  <div :class="getTaskColor()" class="border rounded-sm">
        <div class="flex justify-between px-2">
            <p class="font-bold p-2">{{ task.type }}<i v-if="task.status == 'Terminada'" class="fa-solid fa-check text-green-600 ml-2 text-sm"></i></p>
            <div class="flex items-center space-x-1">
            <el-popconfirm confirm-button-text="Si" cancel-button-text="No" icon-color="#D90537"
                title="Eliminar tarea?" @confirm="deleteTask">
                <template #reference>
                <i class="fa-regular fa-trash-can text-xs py-2 px-[10px] rounded-full bg-gray5 cursor-pointer"></i>
                </template>
            </el-popconfirm>
            <el-popconfirm v-if="task.status === 'Pendiente'" confirm-button-text="Si" cancel-button-text="No" icon-color="#D90537"
                title="Finalizar tarea?" @confirm="taskDone">
                <template #reference>
                <i class="fa-solid fa-check text-xs py-2 px-[10px] rounded-full bg-green-100 text-green-600 cursor-pointer"></i>
                </template>
            </el-popconfirm>
            </div>
        </div>
        <div :class="getTaskColor()" class="border-t p-2">
            <div class="flex items-center space-x-2">
                <p class="text-gray1">Título de evento:</p>
                <p>{{ task.title }}</p>
            </div>
            <div v-if="task.type == 'Evento'" class="flex items-center space-x-2 mt-2">
                <p class="text-gray1">Invitados:</p>
                <p>{{ task.guests + ' Personas' }}</p>
            </div>
            <div class="flex items-center space-x-2 mt-2">
                <p class="text-gray1">Hora:</p>
                <p>{{ task.start_time ? task.start_time + ' - ' + task.end_time : 'Todo el día' }}</p>
            </div>
            <div v-if="task.type == 'Evento'" class="flex items-center space-x-2 mt-2">
                <p class="text-gray1">Ubicación:</p>
                <p>{{ task.location ?? '-' }}</p>
            </div>
            <div class="flex items-center space-x-2 mt-2">
                <p class="text-gray1">Descripción:</p>
                <p>{{ task.description ?? '-' }}</p>
            </div>
        </div>
    </div>
</template>

<script>
export default {
data(){
    return {

    }
},
props:{
    task: Object
},
methods:{
    deleteTask() {
      this.$inertia.delete(route('calendars.destroy', this.task.id));
      this.$notify({
        title: "Éxito",
        message: "Tarea terminada",
        type: "success",
      });
    },
    async taskDone() {
      try {
        const response = await axios.put(route('calendars.task-done', this.task.id));

        if (response.status === 200) {
          this.$notify({
            title: "Éxito",
            message: "Tarea terminada",
            type: "success",
          });
          this.task.status = 'Terminada';
        }
      } catch (error) {
        console.log(error);
      }
    },
    getTaskColor() {
        if (this.task.status == 'Terminada') {
            return 'border-green-500';
        } else {
            if (this.task.type == 'Tarea') {
                return 'border-blue-500';
            } else {
                return 'border-orange-500';
            }
        }
    }
}

}
</script>

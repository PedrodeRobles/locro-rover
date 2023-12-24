<template>
<transition enter-active-class="ease-out duration-300"
enter-class="opacity-0" enter-to-class="opacity-100"
leave-active-class="ease-in duration-200"
leave-class="opacity-100" leave-to-class="opacity-0"
>
    <div class="relative z-10" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

        <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <transition enter-active-class="ease-out duration-300"
                    enter-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" enter-to-class="opacity-100 translate-y-0 sm:scale-100"
                    leave-active-class="ease-in duration-200"
                    leave-class="opacity-100 translate-y-0 sm:scale-100" leave-to-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                >
                    <div class="relative transform overflow-hidden rounded-xl bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                        <div class="bg-gray-800 pb-10 pt-4">
                            <div class="flex justify-end mr-4">
                                <div class="bg-red-500 p-2 rounded-full cursor-pointer" @click="closeModal">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 15 15"><path fill="#ffffff" d="M3.64 2.27L7.5 6.13l3.84-3.84A.92.92 0 0 1 12 2a1 1 0 0 1 1 1a.9.9 0 0 1-.27.66L8.84 7.5l3.89 3.89A.9.9 0 0 1 13 12a1 1 0 0 1-1 1a.92.92 0 0 1-.69-.27L7.5 8.87l-3.85 3.85A.92.92 0 0 1 3 13a1 1 0 0 1-1-1a.9.9 0 0 1 .27-.66L6.16 7.5L2.27 3.61A.9.9 0 0 1 2 3a1 1 0 0 1 1-1c.24.003.47.1.64.27"/></svg>
                                </div>
                            </div>

                            <div class="flex justify-center">
                                <form @submit.prevent="submit" class="text-white w-96 p-2 md:p-0">
                                    <div v-if="form.mode == 'create'" class="p-2 border-b border-gray-600">
                                        <h1 class="text-center text-[45px]">Agregar cliente</h1>
                                    </div>
                                    <div v-if="form.mode == 'edit'" class="p-2 border-b border-gray-600">
                                        <h1 class="text-center text-[45px]">Editar cliente</h1>
                                    </div>
                                    <div class="space-y-4 my-4 text-[22px] sm:text-[25px]">
                                        <div class="space-x-2">
                                            <label for="" class="text-">Nombre:</label>
                                            <input required type="text" placeholder="Ingrese nombre" class="bg-gray-900" v-model="form.name" >
                                            <p v-if="form.mode == 'edit'" class="text-[2vh] text-gray-400">Nombre anterior: {{ props.client.name }}</p>
                                        </div>
                                        <div class="space-x-2">
                                            <label for="">Apellido:</label>
                                            <input required type="text" placeholder="Ingrese apellido" class="bg-gray-900" v-model="form.last_name" >
                                            <p v-if="form.mode == 'edit'" class="text-[2vh] text-gray-400">Apellido anterior: {{ props.client.last_name }}</p>
                                        </div>
                                        <div class="space-x-2">
                                            <label for="">Telefono:</label>
                                            <input required type="text" placeholder="Ingrese telefono" class="bg-gray-900" v-model="form.phone_number" >
                                            <p v-if="form.mode == 'edit'" class="text-[2vh] text-gray-400">Telefono anterior: {{ props.client.phone_number }}</p>
                                        </div>
                                        <div class="space-x-2">
                                            <label for="">Dirección:</label>
                                            <input type="text" placeholder="Ingrese dirección" class="bg-gray-900" v-model="form.direction" >
                                            <p v-if="form.mode == 'edit'" class="text-[2vh] text-gray-400">Dirección anterior: {{ props.client.direction }}</p>
                                        </div>
                                        <div class="space-x-2">
                                            <label for="">Código postal:</label>
                                            <input type="text" placeholder="Ingrese código postal" class="bg-gray-900" v-model="form.postal_code" >
                                            <p v-if="form.mode == 'edit'" class="text-[2vh] text-gray-400">Código postal anterior: {{ props.client.postal_code }}</p>
                                        </div>
                                        <div class="flex justify-center">
                                            <button v-if="form.mode == 'create'" class="bg-green-500 hover:bg-green-600 py-2 px-4 rounded-md">
                                                Crear
                                            </button>
                                            <button v-if="form.mode == 'edit'" class="bg-blue-600 hover:bg-blue-500 py-2 px-4 rounded-md cursor-pointer">
                                                Editar
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </transition>
            </div>
        </div>
    </div>
</transition>

</template>

<script setup>
import { reactive } from 'vue'
import { router } from '@inertiajs/vue3'
import { defineProps } from 'vue';

const props = defineProps({
    client: {
        type: Object,
        default: null,
    },
    closeModal: Function
});

const form = reactive({
    name: null,
    last_name: null,
    phone_number: null,
    direction: null,
    postal_code: null,
    mode: 'create'
});

// Función para cargar los datos de un registro existente si estamos editando
function cargarDatosRegistro(client) {
    form.name = client.name;
    form.last_name = client.last_name;
    form.phone_number = client.phone_number;
    form.direction = client.direction;
    form.postal_code = client.postal_code;
    form.mode = 'edit'; // Cambiamos a "edit" al cargar un registro existente
}

// Evento para cargar los datos de un registro existente (editar)
if (props.client) {
    cargarDatosRegistro(props.client);
}

function submit() {
    try {
        if (form.mode === 'create') {
            // Realizar una solicitud POST para crear un nuevo registro
            router.post('/client/create', form);
            props.closeModal();
        } else if (form.mode === 'edit') {
            // Realizar una solicitud PUT para actualizar el registro existente
            router.put(`/client/edit/${props.client.id}`, form);
            props.closeModal();
        }
    } catch (error) {
        console.error('Error:', error);
    }
}

</script>
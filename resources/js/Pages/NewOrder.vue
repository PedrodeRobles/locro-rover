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
                            <div class="bg-gray-800 pb-4 pt-4">
                                <div class="flex justify-end mr-4">
                                    <div class="bg-red-500 p-2 rounded-full cursor-pointer" @click="closeModal">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 15 15"><path fill="#ffffff" d="M3.64 2.27L7.5 6.13l3.84-3.84A.92.92 0 0 1 12 2a1 1 0 0 1 1 1a.9.9 0 0 1-.27.66L8.84 7.5l3.89 3.89A.9.9 0 0 1 13 12a1 1 0 0 1-1 1a.92.92 0 0 1-.69-.27L7.5 8.87l-3.85 3.85A.92.92 0 0 1 3 13a1 1 0 0 1-1-1a.9.9 0 0 1 .27-.66L6.16 7.5L2.27 3.61A.9.9 0 0 1 2 3a1 1 0 0 1 1-1c.24.003.47.1.64.27"/></svg>
                                    </div>
                                </div>
    
                                <div class="flex justify-center">
                                    <form @submit.prevent="submit" class="text-white w-96 p-2 md:p-0">
                                        <div class="p-2 border-b border-gray-600">
                                            <h1 class="text-center text-[45px]">Nueva Orden</h1>
                                        </div>
                                        <div class="border border-gray-600 mt-2 rounded-md">
                                            <h2 class="text-xl text-gray-400 p-2">Datos del cliente:</h2>
                                            <div class="space-y-4 pl-2 mb-4 text-[22px] sm:text-[25px]">
                                                <div class="space-x-2">
                                                    <label for="" class="text-">Nombre*:</label>
                                                    <input required type="text" placeholder="Ingrese nombre" class="bg-gray-900" v-model="form.name" >
                                                </div>
                                                <div class="space-x-2">
                                                    <label for="">Apellido*:</label>
                                                    <input required type="text" placeholder="Ingrese apellido" class="bg-gray-900" v-model="form.last_name" >
                                                </div>
                                                <div class="space-x-2">
                                                    <label for="">Telefono*:</label>
                                                    <input required type="number" placeholder="Ingrese telefono" class="bg-gray-900" v-model="form.phone_number" >
                                                </div>
                                                <div class="space-x-2">
                                                    <label for="">Dirección*:</label>
                                                    <input type="text" placeholder="Ingrese dirección" class="bg-gray-900" v-model="form.direction" >
                                                </div>
                                                <div class="space-x-2">
                                                    <label for="">Código postal:</label>
                                                    <input type="text" placeholder="OPCIONAL" class="bg-gray-900" v-model="form.postal_code" >
                                                </div>
                                            </div>
                                        </div>
                                        <div class="border border-gray-600 mt-2 rounded-md">
                                            <h2 class="text-xl text-gray-400 p-2">Orden:</h2>
                                            <div class="space-y-4 pl-2 mb-4 text-[22px] sm:text-[25px]">
                                                <div class="space-x-2">
                                                    <label for="" class="text-">Cantidad*:</label>
                                                    <input required type="number" placeholder="Ingrese cantidad" class="bg-gray-900" v-model="form.portions">
                                                </div>
                                                <div class="space-x-2">
                                                    <label for="">¿Retira?:</label>
                                                    <input type="checkbox" class="bg-gray-700 w-10 h-10" v-model="form.take_away">
                                                </div>
                                                <div class="space-x-2">
                                                    <label for="">Observación:</label>
                                                    <input type="text" placeholder="OPCIONAL" class="bg-gray-900" v-model="form.observation">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="my-4 flex justify-center items-center space-x-1">
                                            <label for="" class="text-2xl">Asignarme orden: </label>
                                            <input type="checkbox" class="bg-gray-700 w-8 h-8" v-model="form.assign_order">
                                        </div>
                                        <div class="flex justify-center mt-2">
                                            <button class="bg-green-500 hover:bg-green-600 py-2 px-4 rounded-md text-3xl">
                                                Crear
                                            </button>
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
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';

const props = defineProps({
    closeModal: Function
});

const form = reactive({
    name: null,
    last_name: null,
    phone_number: null,
    direction: null,
    postal_code: null,
    portions: null,
    take_away: null,
    observation: null,
    assign_order: true
});

async function submit() {
    try {
        await router.post('/order/create', form);
        props.closeModal();
        await toast.success(`Orden generada con éxito!`, { autoClose: 4000 });
    } catch (error) {
        console.error('Error:', error);
        await toast.error('Error al generar orden!');
    }
}

</script>
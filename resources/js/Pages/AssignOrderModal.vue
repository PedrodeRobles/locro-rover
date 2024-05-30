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
                                    <form @submit.prevent="assign" class="text-white w-[500px] p-2 md:p-0">
                                        <div class="border border-gray-600 mt-2 rounded-md">
                                            <h2 class="text-[30px] text-gray-100 p-2">Ordenes seleccionadas:</h2>
                                            <div class="space-y-4 mb-4 text-[20px] sm:text-[22px]">
                                                <table class="min-w-full bg-gray-800">
                                                    <thead>
                                                        <tr>
                                                            <th class="py-1 px-1 text-center border bg-slate-700 border-gray-600 text-gray-200">Nombre</th>
                                                            <th class="py-1 px-1 text-center border bg-slate-700 border-gray-600 text-gray-200">Porciones</th>
                                                            <th class="py-1 px-1 text-center border bg-slate-700 border-gray-600 text-gray-200">Salsas</th>
                                                            <th class="py-1 px-1 text-center border bg-slate-700 border-gray-600 text-gray-200">Monto</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr v-for="order in ordenesTildadas" :key="order.id" class="border-b border-gray-700">
                                                            <td class="py-1 px-1 text-center border border-gray-600 text-gray-200">{{ order.name }} {{ order.last_name }}</td>
                                                            <td class="py-1 px-1 text-center border border-gray-600 text-gray-200">{{ order.portions }}</td>
                                                            <td class="py-1 px-1 text-center border border-gray-600 text-gray-200">{{ order.sauces }}</td>
                                                            <td class="py-1 px-1 text-center border border-gray-600 text-gray-200">${{ order.amount }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="py-1 px-1 text-center border bg-gray-500 border-gray-600 text-gray-200">Totales</td>
                                                            <td class="py-1 px-1 text-center border bg-gray-500 border-gray-600 text-gray-200">{{ totalSelectedPortions }}</td>
                                                            <td class="py-1 px-1 text-center border bg-gray-500 border-gray-600 text-gray-200">{{ totalSelectedSauces }}</td>
                                                            <td class="py-1 px-1 text-center border bg-gray-500 border-gray-600 text-gray-200">${{ totalSelectedAmount }}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="border border-gray-600 mt-2 rounded-md">
                                            <h2 class="text-xl text-gray-400 p-2">Asiganción masiva:</h2>
                                            <div class="items-center space-y-4 pl-2 mb-4 text-[22px] sm:text-[25px]">
                                                <div class="flex items-center space-x-2">
                                                    <div>
                                                        <label for="" class="text-">Rover:</label>
                                                        <select class="bg-gray-900" v-model="form.rover">
                                                            <option :value="null">Seleccionar Rover</option>
                                                            <option v-for="(rover, index) in rovers" :key="rover.id" :value="rover">{{ rover.name }}</option>
                                                        </select>
                                                    </div>
                                                    <div>
                                                        <button class="bg-indigo-500 hover:bg-indigo-600 py-1 px-4 rounded-md text-2xl">
                                                            Asignar ordenes
                                                        </button>
                                                    </div>
                                                </div>
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
import 'vue3-toastify/dist/index.css';
import { toast } from 'vue3-toastify';

const props = defineProps({
    closeModal: Function,
    rovers: {
        type: Object,
    },
    idsTildados: Array,
    ordenesTildadas: Array,
    totalSelectedAmount: Number,
    totalSelectedPortions: Number,
    totalSelectedSauces: Number,
});

console.log(props.idsTildados);

const form = reactive({
    rover: null,
});

function assign() {
    try {
        if(props.idsTildados[0] == undefined) {
            toast.info(`No hay ordenes seleccionadas. Seleccionalas y vuelve a intentarlo`, { autoClose: 4000 });
        } else {
            router.put('/order/assignOrders', { ordersID: props.idsTildados, roverID: form.rover.id });
            props.closeModal();
            toast.success(`Ordenes asignadas con éxito para ${form.rover.name}!`, { autoClose: 4000 });
        }
    } catch (error) {
        console.error('Error:', error);
        toast.error('Error al asignar ordenes masivamente!');
    }
}

</script>
<template>
    <transition enter-active-class="ease-out duration-300"
    enter-class="opacity-0" enter-to-class="opacity-100"
    leave-active-class="ease-in duration-200"
    leave-class="opacity-100" leave-to-class="opacity-0"
    >
        <div class="relative z-10" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
    
            <div class="fixed inset-0 z-10 w-screen overflow-y-auto mb-80">
                <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                    <transition enter-active-class="ease-out duration-300"
                        enter-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" enter-to-class="opacity-100 translate-y-0 sm:scale-100"
                        leave-active-class="ease-in duration-200"
                        leave-class="opacity-100 translate-y-0 sm:scale-100" leave-to-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    >
                        <div class="relative transform overflow-hidden rounded-xl bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                            <div class="bg-gray-800 p-4 space-y-4">
                                <div class="flex justify-end">
                                    <div class="bg-red-500 p-2 rounded-full cursor-pointer" @click="closeModal">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 15 15"><path fill="#ffffff" d="M3.64 2.27L7.5 6.13l3.84-3.84A.92.92 0 0 1 12 2a1 1 0 0 1 1 1a.9.9 0 0 1-.27.66L8.84 7.5l3.89 3.89A.9.9 0 0 1 13 12a1 1 0 0 1-1 1a.92.92 0 0 1-.69-.27L7.5 8.87l-3.85 3.85A.92.92 0 0 1 3 13a1 1 0 0 1-1-1a.9.9 0 0 1 .27-.66L6.16 7.5L2.27 3.61A.9.9 0 0 1 2 3a1 1 0 0 1 1-1c.24.003.47.1.64.27"/></svg>
                                    </div>
                                </div>
                                <h3 class="text-white text-center text-[30px]">
                                    Filtrar ordenes
                                </h3>

                                <div class="text-white flex justify-center">
                                    <div class="space-y-4">
                                        <div class="flex items-center">
                                            <p class="text-xl">Retira:</p>
                                            <select v-model="withdrawalFilter" class="bg-gray-700 rounded-md ml-2">
                                                <option value="all">Sin filtro</option>
                                                <option value="1">Retiradas</option>
                                                <option value="0">Sin retirar</option>
                                            </select>
                                        </div>
                                        <div class="flex items-center">
                                            <p class="text-xl">Pagos:</p>
                                            <select v-model="MPFilter" class="bg-gray-700 rounded-md ml-2">
                                                <option value="all">Sin filtro</option>
                                                <option value="1">Pagadas con MP</option>
                                                <option value="0">Pagadas en efectivo</option>
                                            </select>
                                        </div>
                                        <div class="flex items-center">
                                            <p class="text-xl">Delivery:</p>
                                            <select v-model="takeAwayFilter" class="bg-gray-700 rounded-md ml-2">
                                                <option value="all">Sin filtro</option>
                                                <option value="1">Con delivery</option>
                                                <option value="0">Sin delivery</option>
                                            </select>
                                        </div>
                                        <div class="flex justify-center">
                                            <button @click="sendFilters" class="bg-blue-600 hover:bg-blue-500 p-2 rounded-md text-xl">
                                                Filtrar
                                            </button>
                                        </div>
                                    </div>
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
import { ref } from 'vue';

const props = defineProps({
    closeModal: Function,
});

const emit = defineEmits(['update:filters']);
const withdrawalFilter = ref('all');
const MPFilter = ref('all');
const takeAwayFilter = ref('all');

// Define una función para alternar el estado de columnStates
const sendFilters = () => {
    // console.log(withdrawalFilter.value);
    const filters = {
        withdrawal: withdrawalFilter.value,
        MPFilter: MPFilter.value,
        takeAwayFilter: takeAwayFilter.value,
    }
    emit('update:filters', filters);
}
</script>
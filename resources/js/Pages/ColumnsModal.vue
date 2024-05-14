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
                                <h3 class="text-white text-center text-[20px]">
                                    Visualizar columnas
                                </h3>

                                <div class="grid grid-cols-2 gap-3 text-white">
                                        <div>
                                            <button @click="toggleColumn('phone')" class="p-1 rounded-md" :class="{'bg-lime-700': columnStates.phone, 'bg-red-700': !columnStates.phone}">
                                                Teléfono {{ columnStates.phone ? 'Activo' : 'Inactivo' }}
                                            </button>
                                        </div>
                                        <div>
                                            <button @click="toggleColumn('direction')" class="p-1 rounded-md" :class="{'bg-lime-700': columnStates.direction, 'bg-red-700': !columnStates.direction}">
                                                Dirección {{ columnStates.direction ? 'Activo' : 'Inactivo' }}
                                            </button>
                                        </div>
                                        <div>
                                            <button @click="toggleColumn('postal_code')" class="p-1 rounded-md" :class="{'bg-lime-700': columnStates.postal_code, 'bg-red-700': !columnStates.postal_code}">
                                                Cód. postal {{ columnStates.postal_code ? 'Activo' : 'Inactivo' }}
                                            </button>
                                        </div>
                                        <div>
                                            <button @click="toggleColumn('take_away')" class="p-1 rounded-md" :class="{'bg-lime-700': columnStates.take_away, 'bg-red-700': !columnStates.take_away}">
                                                Retira {{ columnStates.take_away ? 'Activo' : 'Inactivo' }}
                                            </button>
                                        </div>
                                        <div>
                                            <button @click="toggleColumn('portions')" class="p-1 rounded-md" :class="{'bg-lime-700': columnStates.portions, 'bg-red-700': !columnStates.portions}">
                                                {{ $page.props.pastelitosEvent ? 'Cant. 1/2 docenas' : 'Cantidad' }} {{ columnStates.portions ? 'Activo' : 'Inactivo' }}
                                            </button>
                                        </div>
                                        <div>
                                            <button @click="toggleColumn('amount')" class="p-1 rounded-md" :class="{'bg-lime-700': columnStates.amount, 'bg-red-700': !columnStates.amount}">
                                                Importe {{ columnStates.amount ? 'Activo' : 'Inactivo' }}
                                            </button>
                                        </div>
                                        <div>
                                            <button @click="toggleColumn('sauces')" class="p-1 rounded-md" :class="{'bg-lime-700': columnStates.sauces, 'bg-red-700': !columnStates.sauces}">
                                                Salsas {{ columnStates.sauces ? 'Activo' : 'Inactivo' }}
                                            </button>
                                        </div>
                                        <div>
                                            <button @click="toggleColumn('observations')" class="p-1 rounded-md" :class="{'bg-lime-700': columnStates.observations, 'bg-red-700': !columnStates.observations}">
                                                Observaciones {{ columnStates.observations ? 'Activo' : 'Inactivo' }}
                                            </button>
                                        </div>
                                        <div>
                                            <button @click="toggleColumn('last_edition')" class="p-1 rounded-md" :class="{'bg-lime-700': columnStates.last_edition, 'bg-red-700': !columnStates.last_edition}">
                                                Últ. edición {{ columnStates.last_edition ? 'Activo' : 'Inactivo' }}
                                            </button>
                                        </div>
                                        <div>
                                            <button @click="toggleColumn('money_collected')" class="p-1 rounded-md" :class="{'bg-lime-700': columnStates.money_collected, 'bg-red-700': !columnStates.money_collected}">
                                                Dinero cobrado {{ columnStates.money_collected ? 'Activo' : 'Inactivo' }}
                                            </button>
                                        </div>
                                        <div>
                                            <button @click="toggleColumn('to_pay')" class="p-1 rounded-md" :class="{'bg-lime-700': columnStates.to_pay, 'bg-red-700': !columnStates.to_pay}">
                                                A cobrar {{ columnStates.to_pay ? 'Activo' : 'Inactivo' }}
                                            </button>
                                        </div>
                                        <div>
                                            <button @click="toggleColumn('mp')" class="p-1 rounded-md" :class="{'bg-lime-700': columnStates.mp, 'bg-red-700': !columnStates.mp}">
                                                MP {{ columnStates.mp ? 'Activo' : 'Inactivo' }}
                                            </button>
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
import { ref, watchEffect } from 'vue';

const props = defineProps({
    closeModal: Function,
});

const columns = [
    'phone',
    'direction',
    'postal_code',
    'take_away',
    'portions',
    'amount',
    'sauces',
    'observations',
    'last_edition',
    'money_collected',
    'to_pay',
    'mp'
];

const storedValue = localStorage.getItem('columnStates');

// Si no hay ningún valor almacenado, creamos un objeto con todas las columnas en true
const defaultColumnStates = columns.reduce((acc, column) => {
    acc[column] = true;
    return acc;
}, {});

const columnStates = ref(storedValue !== null ? JSON.parse(storedValue) : defaultColumnStates);
// console.log(JSON.parse(storedValue));

// Guarda el estado de columnStates en localStorage cuando cambia
watchEffect(() => {
    localStorage.setItem('columnStates', JSON.stringify(columnStates.value))
})

const emit = defineEmits(['update:columnStates']);

// Define una función para alternar el estado de columnStates
const toggleColumn = (columnName) => {
    columnStates.value[columnName] = !columnStates.value[columnName];
    localStorage.setItem('columnStates', JSON.stringify(columnStates.value))
    emit('update:columnStates', JSON.parse(localStorage.getItem('columnStates')));
}
</script>
<template>
    <Header></Header>

    <div class="pt-28">

        <div v-if="parameter === null" class="flex justify-center mt-4">
            <form @submit.prevent="submit" class="text-white border border-gray-600 rounded-lg mx-2 px-2 w-96">
                <div class="p-2 border-b border-gray-600">
                    <h1 class="text-center text-xl">Definir parametros para la promoción {{ year.year }}</h1>
                </div>
                <div class="space-y-4 my-4">
                    <div>
                        <label for="">Precio por unidad:</label>
                        <div>
                            <input type="text" placeholder="Ingrese precio por unidad" class="bg-gray-900 w-60" v-model="form.unit_price">
                        </div>
                    </div>
                    <div>
                        <label for="">Precio por unidad promo:</label>
                        <div>
                            <input type="text" placeholder="Ingrese precio por unidad" class="bg-gray-900 w-60" v-model="form.promo_unit_price">
                        </div>
                    </div>
                    <div>
                        <label for="">Unidades para promo:</label>
                        <div>
                            <input type="text" placeholder="Ingrese unidades para promo" class="bg-gray-900 w-60" v-model="form.amount_for_promo">
                        </div>
                    </div>
                    <div class="flex justify-center">
                        <button class="bg-green-500 hover:bg-green-600 py-2 px-4 rounded-md">
                            Guardar
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <div v-else class="flex justify-center text-white">
            <div v-if="parameter !== null">
                <div class="border border-gray-500 rounded-md p-2">
                    <p>Precio por unidad: ${{ parameter.unit_price }}</p>
                    <p>Precio por unidad promo: ${{ parameter.promo_unit_price }}</p>
                    <p>Unidades para promo: {{ parameter.amount_for_promo }}</p>
                </div>
                <div class="flex justify-center mt-4">
                    <button @click="openEditModal" class="bg-blue-600 hover:bg-blue-500 py-2 px-4 rounded-md cursor-pointer">
                        Editar parametros
                    </button>
                </div>
            </div>
        </div>
        <div v-if="isFormModalOpen" class="text-white">
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
                                            <div class="bg-red-500 p-2 rounded-full cursor-pointer" @click="closeEditModal">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 15 15"><path fill="#ffffff" d="M3.64 2.27L7.5 6.13l3.84-3.84A.92.92 0 0 1 12 2a1 1 0 0 1 1 1a.9.9 0 0 1-.27.66L8.84 7.5l3.89 3.89A.9.9 0 0 1 13 12a1 1 0 0 1-1 1a.92.92 0 0 1-.69-.27L7.5 8.87l-3.85 3.85A.92.92 0 0 1 3 13a1 1 0 0 1-1-1a.9.9 0 0 1 .27-.66L6.16 7.5L2.27 3.61A.9.9 0 0 1 2 3a1 1 0 0 1 1-1c.24.003.47.1.64.27"/></svg>
                                            </div>
                                        </div>

                                        <div class="flex justify-center">
                                            <form @submit.prevent="update" class="text-white w-96 p-2 md:p-0">
                                                <div class="p-2 border-b border-gray-600">
                                                    <h1 class="text-center text-[30px]">Editar parametros</h1>
                                                </div>
                                                <div class="space-y-4 my-4 text-[22px] sm:text-[25px]">
                                                    <div class="space-x-2">
                                                        <label for="" class="text-">Precio por unidad:</label>
                                                        <input required type="text" placeholder="Ingrese precio por unidad" class="bg-gray-900" v-model="form.unit_price">
                                                        <p class="text-[2vh] text-gray-400">Precio por unidad anterior: {{ props.parameter.unit_price }}</p>
                                                    </div>
                                                    <div class="space-x-2">
                                                        <label for="">Precio por unidad promo:</label>
                                                        <input required type="text" placeholder="Ingrese precio promo" class="bg-gray-900" v-model="form.promo_unit_price" >
                                                        <p class="text-[2vh] text-gray-400">Precio por unidad promo anterior: {{ props.parameter.promo_unit_price }}</p>
                                                    </div>
                                                    <div class="space-x-2">
                                                        <label for="">Unidades para promo:</label>
                                                        <input required type="text" placeholder="Ingrese unidades promo" class="bg-gray-900" v-model="form.amount_for_promo" >
                                                        <p class="text-[2vh] text-gray-400">Unidades para promo anterior: {{ props.parameter.amount_for_promo }}</p>
                                                    </div>
                                                    <p class="text-amber-300 text-[15px]">Editar los parametros tambien actualizara todas las ordenes de este año con los precios y promos que se asignen en esta edición</p>
                                                    <div class="flex justify-center">
                                                        <button class="bg-blue-600 hover:bg-blue-500 py-2 px-4 rounded-md cursor-pointer">
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
        </div>
    </div>
</template>

<script setup>
import { defineProps } from 'vue';
import { router } from '@inertiajs/vue3'
import { ref } from 'vue';

const props = defineProps({
    year: {
        type: Object,
    },
    parameter: {
        type: Object,
    }
});

// MODAL
const isFormModalOpen = ref(false);

const openEditModal = () => {
    isFormModalOpen.value = true;
};
const closeEditModal = () => {
    isFormModalOpen.value = false;
};
// FIN MODAL

const form = {
    unit_price: null,
    promo_unit_price: null,
    amount_for_promo: null,
};

function submit() {
    // Realizar una solicitud POST para crear un nuevo registro
    router.post('/parameters/store', form);
}

function update() {
    try {
        // Realizar una solicitud PUT para actualizar el registro existente
        if (confirm(`Editar los parametros tambien actualizara todas las ordenes de este año con los precios y promos que se asignen en esta edición
        ¿Confirmas estos cambios?`)) {
            router.put(`/parameters/edit/${props.parameter.id}`, form);
        }
        closeEditModal();
    } catch (error) {
        console.error('Error:', error);
    }
}
</script>
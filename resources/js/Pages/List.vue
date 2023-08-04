<template>
    <div>
        <Header></Header>

        <div class="bg-gray-800 text-white pt-20">
            <div class="overflow-x-auto">
                <table class="w-full table-auto">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 border border-gray-600">Rover encargado</th>
                            <th class="px-4 py-2 border border-gray-600">Nombre</th>
                            <th class="px-4 py-2 border border-gray-600">Apellido</th>
                            <th class="px-4 py-2 border border-gray-600">Teléfono</th>
                            <th class="px-4 py-2 border border-gray-600">Dirección</th>
                            <th class="px-4 py-2 border border-gray-600">Cod. Postal</th>
                            <th class="px-4 py-2 border border-gray-600">¿Retira?</th>
                            <th class="px-4 py-2 border border-gray-600">Cantidad</th>
                            <th class="px-4 py-2 border border-gray-600">Importe</th>
                            <th class="px-4 py-2 border border-gray-600">Salsas</th>
                            <th class="px-4 py-2 border border-gray-600">Observaciones ...</th>
                            <th class="px-4 py-2 border border-gray-600">Últ. edición</th>
                            <th class="px-4 py-2 border border-gray-600">Dinero cobrado</th>
                            <th class="px-4 py-2 border border-gray-600">A cobrar</th>
                            <th class="px-4 py-2 border border-gray-600">MP</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="order in orders" :key="order.id">
                            <td class="px-4 py-2 border border-gray-600" v-if="order.user_id">{{ order.user_name }}</td>
                            <td class="px-4 py-2 border border-gray-600" v-else="order.user_id">-</td>

                            <td class="px-4 py-2 border border-gray-600">{{ order.client_name }}</td>
                            <td class="px-4 py-2 border border-gray-600">{{ order.client_last_name }}</td>
                            <td class="px-4 py-2 border border-gray-600">{{ order.client_phone_number }}</td>
                            <td class="px-4 py-2 border border-gray-600">{{ order.client_direction }}</td>
                            <td class="px-4 py-2 border border-gray-600">{{ order.client_postal_code }}</td>

                            <td class="px-4 py-2 border border-gray-600" v-if="order.take_away == 0">No</td>
                            <td class="px-4 py-2 border border-gray-600" v-else-if="order.take_away == 1">Sí</td>
                            <td class="px-4 py-2 border border-gray-600" v-else>-</td>

                            <td class="px-4 py-2 border border-gray-600">{{ order.portions }}</td>
                            <td class="px-4 py-2 border border-gray-600">{{ '$' + order.amount }}</td>
                            <td class="px-4 py-2 border border-gray-600">{{ order.sauces }}</td>

                            <td v-if="order.client_observations" class="border border-gray-600">
                                <div v-for="observation in order.client_observations" class="w-96 h-full px-4 border border-gray-600">
                                    {{ observation.observation }}
                                </div>
                            </td>
                            <td v-else class="px-4 py-2 border border-gray-600">-</td>
                            <!-- <div v-if="order.client.observations" v-for="observation in order.client.observations">
                                <td class="px-4 py-2 border border-gray-600">{{ observation }}</td>
                            </div> -->

                            <td class="px-4 py-2 border border-gray-600">Dato 4</td>
                            <td class="px-4 py-2 border border-gray-600">Dato 5</td>
                            <td class="px-4 py-2 border border-gray-600">Dato 6</td>
                            <td class="px-4 py-2 border border-gray-600">Dato 6</td>
                            <td class="px-4 py-2 border border-gray-600 bg-blue-500">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                </svg>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</template>

<script setup>
import { defineProps } from 'vue';

const props = defineProps({
    orders: {
        type: Array,
    },
});

// console.log(props.orders[0].client.observations);
</script>
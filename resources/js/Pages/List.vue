<template>
    <div>
        <Header></Header>

        <div class="bg-gray-800 text-white pt-32">
            <div  id="table-scroll" class="table-scroll" >
                <table id="main-table" class="main-table">
                    <thead class="bg-gray-900">
                        <tr>
                            <th class="px-4 py-2 border border-gray-600">Rover encargado</th>
                            <th class="px-4 py-2 border border-gray-600 primary-column">Nombre</th>
                            <th class="px-4 py-2 border border-gray-600 primary-column">Apellido</th>
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
                        <tr v-for="(order, index) in orders" :key="order.id">
                            <th class="px-4 py-2 border border-gray-600" v-if="order.user_id">{{ order.user_name }}</th>
                            <th class="px-4 py-2 border border-gray-600" v-else="order.user_id">-</th>

                            <th class="px-4 py-2 border border-gray-600">{{ order.client_name }}</th>
                            <th class="px-4 py-2 border border-gray-600">{{ order.client_last_name }}</th>
                            <td class="px-4 py-2 border border-gray-600">{{ order.client_phone_number }}</td>
                            <td class="px-4 py-2 border border-gray-600">{{ order.client_direction }}</td>
                            <td class="px-4 py-2 border border-gray-600">{{ order.client_postal_code }}</td>

                            <td class="px-4 py-2 border border-gray-600" v-if="order.take_away == 0">No</td>
                            <td class="px-4 py-2 border border-gray-600" v-else-if="order.take_away == 1">Sí</td>
                            <td class="px-4 py-2 border border-gray-600" v-else>-</td>

                            <!-- <td class="px-4 py-2 border border-gray-600">{{ order.portions }}</td> -->
                            <td @click="startEditing(index)" class="px-4 py-2 border border-gray-600">
                              <div v-if="!isEditing(index)">{{ order.portions }}</div>
                              <input v-else type="number" v-model="editedNumber" @blur="stopEditing(index)" @keydown.enter="stopEditing(index)" class="text-black w-20">
                            </td>

                            <th class="px-4 py-2 border border-gray-600" v-if="order.amount">{{ '$' + order.amount }}</th>
                            <th class="px-4 py-2 border border-gray-600" v-else="order.user_id">-</th>

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

                <div v-if="orders.length == 0" class="flex mt-4">
                  <h1 class="px-4 py-2 border border-gray-600">No tenes clientes en tu lista. Ponete las pilas porfa.</h1>
                  <div class="border border-red-500">
                    <img src="../../img/cosas/sin-lista.jpg" alt="Sos ese">
                    <p class="text-center">{{ user_auth_name }}</p>
                  </div>
                </div>

            </div>
        </div>
    </div>
</template>

<style>
body {
  overflow-y: hidden;
  background-color: #1f2937;
}
.primary-column {
    width: 200px;
}
.table-scroll {
  position: relative;
  width:100% - 8px;
  z-index: 1;
  margin: auto;
  overflow: auto;
  height: 80vh;
  margin-left: 8px;
}
.table-scroll table {
  width: 100%;
  min-width: 1280px;
  margin: auto;
  border-collapse: separate;
  border-spacing: 0;
}
.table-wrap {
  position: relative;
}
.table-scroll th,
.table-scroll td {
  padding: 5px 10px;
  /* border: 1px solid #000;
  background: #fff; */
  vertical-align: top;
}
.table-scroll thead th {
  background: #161616;
  color: #fff;
  position: -webkit-sticky;
  position: sticky;
  top: 0;
}

.table-scroll tfoot,
.table-scroll tfoot th,
.table-scroll tfoot td {
  position: -webkit-sticky;
  position: sticky;
  bottom: 0;
  background: #202020;
  color: #fff;
  z-index:4;
}

th:nth-child(-n + 3) {
  position: -webkit-sticky;
  position: sticky;
  left: 0;
  z-index: 2;
  background: #383737;
}
thead th:nth-child(-n + 3),
tfoot th:first-child {
  z-index: 5;
}
</style>

<script setup>
import { defineProps } from 'vue';
import { ref } from 'vue';
import axios from 'axios';

const props = defineProps({
    orders: {
        type: Object,
    },
    user_auth_name: String
});

const editingIndex = ref(null);
const editedNumber = ref(null);

const startEditing = (index) => {
  editingIndex.value = index;
  editedNumber.value = props.orders[index].portions;
};

const stopEditing = (index) => {
  const orderId = props.orders[index].id;
  updateOrder(orderId, index);
  editingIndex.value = null;
};

async function updateOrder(orderId, index) {
    try {
      // Hacer la petición a la ruta de verificación usando Axios
      const response = await axios.put(`/order/${orderId}/edit`, {
        number: editedNumber.value,
      });

      props.orders[index] = response.data.order;

      // editingIndex.value = null;
    } catch (error) {
        console.error('Error al realizar la operación:', error);
    }
}

const isEditing = (index) => {
  return editingIndex.value === index;
};
</script>
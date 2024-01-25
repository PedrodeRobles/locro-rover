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
                            <th class="px-4 py-2 border border-gray-600" v-if="order.user_id">
                              <div class="w-32 truncate">
                                {{ order.user_name }}
                              </div>
                            </th>
                            <th class="px-4 py-2 border border-gray-600" v-else="order.user_id">-</th>

                            <th class="px-4 py-2 border border-gray-600">{{ order.client_name }}</th>
                            <th class="px-4 py-2 border border-gray-600">
                              <div class="w-32 truncate">
                                {{ order.client_last_name }}
                              </div>
                            </th>
                            <td class="px-4 py-2 border border-gray-600">{{ order.client_phone_number }}</td>
                            <td class="px-4 py-2 border border-gray-600">{{ order.client_direction }}</td>
                            <td class="px-4 py-2 border border-gray-600">{{ order.client_postal_code }}</td>

                            <td class="px-4 py-2 border border-gray-600">
                              <label :for="'take-away-checkbox-' + order.id" class="mr-2">
                                {{ order.take_away ? 'SI' : 'NO' }}
                              </label>
                              <input type="checkbox" v-model="order.take_away" @click="updateOrder(order.id, index, 'take_away', !order.take_away)" :id="'take-away-checkbox-' + order.id"  class="cursor-pointer"/>
                            </td>

                            <!-- <td class="px-4 py-2 border border-gray-600">{{ order.portions }}</td> -->
                            <td @click="startEditing(index)" class="px-4 py-2 border border-gray-600">
                              <div :id="'portion-' + index" :class="{'portion': !isEditing(index), 'hidden': isEditing(index) || (loading && loadingIndex === index)}">
                                {{ order.portions }}
                              </div>
                              <input v-show="isEditing(index)" type="number" v-model="editedNumber" @blur="stopEditing(index, 'portions')" @keydown.enter="stopEditing(index, 'portions')" class="text-black w-20">
                              <div v-if="loading && loadingIndex === index">
                                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24"><path fill="none" stroke="#ffffff" stroke-dasharray="15" stroke-dashoffset="15" stroke-linecap="round" stroke-width="2" d="M12 3C16.9706 3 21 7.02944 21 12"><animate fill="freeze" attributeName="stroke-dashoffset" dur="0.3s" values="15;0"/><animateTransform attributeName="transform" dur="1.5s" repeatCount="indefinite" type="rotate" values="0 12 12;360 12 12"/></path></svg>
                              </div>
                            </td>

                            <td class="px-4 py-2 border border-gray-600" v-if="order.amount">{{ '$' + order.amount }}</td>
                            <td class="px-4 py-2 border border-gray-600" v-else="order.user_id">-</td>

                            <td class="px-4 py-2 border border-gray-600">{{ order.sauces }}</td>

                            <td v-if="order.client_observations" @click="editObservation(order)" class="border border-gray-600">
                              <div v-if="editMode && activeOrderId == order.id">
                                <input v-model="newObservation" v-show="!loadingObservation" @blur="saveObservation(order.id, index)" class="text-black placeholder-gray-300" placeholder="Observación..."/>
                                <div v-if="loadingObservation">
                                  <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24">
                                    <path fill="none" stroke="#ffffff" stroke-dasharray="15" stroke-dashoffset="15" stroke-linecap="round" stroke-width="2" d="M12 3C16.9706 3 21 7.02944 21 12"><animate fill="freeze" attributeName="stroke-dashoffset" dur="0.3s" values="15;0"/><animateTransform attributeName="transform" dur="1.5s" repeatCount="indefinite" type="rotate" values="0 12 12;360 12 12"/></path>
                                  </svg>
                                </div>
                              </div>
                              <div v-for="observation in order.client_observations" class="w-52 h-full px-4 border border-gray-600">
                                <div class="flex items-center justify-between">
                                  <div>
                                    <div v-html="formatObservation(observation)"></div>
                                  </div>
                                  <div @click="deleteObservation(observation, order.id, index)" class="cursor-pointer">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24"><path fill="#e11d48" d="m9.4 16.5l2.6-2.6l2.6 2.6l1.4-1.4l-2.6-2.6L16 9.9l-1.4-1.4l-2.6 2.6l-2.6-2.6L8 9.9l2.6 2.6L8 15.1zM7 21q-.825 0-1.412-.587T5 19V6H4V4h5V3h6v1h5v2h-1v13q0 .825-.587 1.413T17 21z"/></svg>
                                  </div>
                                </div> 
                              </div>
                            </td>
                            <td v-else class="px-4 py-2 border border-gray-600">-</td>


                            <td class="px-4 py-2 border border-gray-600">
                              <div class="w-20 overflow-x-auto">
                                {{ order.updated_at }}   
                              </div>
                              <div>
                                {{ order.last_edition }} 
                              </div>
                            </td>
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

const formatObservation = (observation) => {
  // Asegúrate de tener esta función en tu código
  function nl2br(str) {
      return str.replace(/(?:\r\n|\r|\n)/g, '<br>');
  }

  // Usa nl2br y escape para evitar inyecciones de código
  return nl2br(observation.observation);
}

// ELIMINAR OBSERVACION
const deleteObservation = async (observation, order_id, index) => {
  if(confirm(`¿Deseas eliminar la observación: ${observation.observation}?`)){
    try {
      loadingObservation.value = true;

      // Realiza la solicitud POST para guardar la nueva observación
      const response = await axios.delete(`/order/${order_id}/${observation.id}/deleteObservation`);

      props.orders[index] = response.data.order;
    } catch (error) {
      console.error('Error al eliminar observación:', error);
    } finally {
      loadingObservation.value = false;
    }
    }
}
;
// FIN ELIMINAR OBSERVACION

// AGREGAR OBSERVACIONES
const editMode = ref(false);
const activeOrderId = ref(null);
const newObservation = ref('');
const loadingObservation = ref(false);

const editObservation = (order) => {
  // Habilita el modo de edición y configura la orden actual
  activeOrderId.value = order.id;
  editMode.value = true;
  newObservation.value = order.observation;
};

const saveObservation = async (order_id, index) => {
  try {
    loadingObservation.value = true;

    const dataToUpdate = {
      observation: newObservation.value,
    };

    // Realiza la solicitud POST para guardar la nueva observación
    const response = await axios.post(`/order/${order_id}/addObservation`, dataToUpdate);

    props.orders[index] = response.data.order;

    // Desactiva el modo de edición
    activeOrderId.value = null;
    editMode.value = false;
  } catch (error) {
    console.error('Error al realizar la operación:', error);
  } finally {
    loadingObservation.value = false;
  }
};
//FIN AGREGAR OBSERVACIONES

// EDITAR PORCIONES, DELIVERY
const editingIndex = ref(null);
const editedNumber = ref(null);
const loading = ref(false);
const loadingIndex = ref(null);

const startEditing = (index) => {
  editingIndex.value = index;
  editedNumber.value = props.orders[index].portions;
};

const stopEditing = (index, field) => {
  const orderId = props.orders[index].id;
  updateOrder(orderId, index, field);
  editingIndex.value = null;
};

async function updateOrder(orderId, index, field, value = null) {
    try {
      loading.value = true;
      loadingIndex.value = index;

      let dataToUpdate = null;
      // Si se edita porciones
      if (editedNumber.value != null) {
        dataToUpdate = {
          [field]: editedNumber.value,
        };
      }
      
      // Si se trata de campos diferentes a porciones
      if (field != 'portions') {
        dataToUpdate = {
          [field]: value,
        };
      }

      const response = await axios.put(`/order/${orderId}/edit/${field}`, dataToUpdate);

      props.orders[index] = response.data.order;

      editingIndex.value = null;
    } catch (error) {
        console.error('Error al realizar la operación:', error);
    } finally {
    loading.value = false;
    loadingIndex.value = null;
  }
}

const isEditing = (index) => {
  return editingIndex.value === index;
};
// FIN EDITAR PORCIONES
</script>
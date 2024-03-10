<template>
    <div>
        <Header></Header>

        <div class="bg-gray-800 text-white pt-32">

            <div class="flex justify-center hidden md:block pb-2 pl-2">
                <input type="text" v-model="search" class="bg-gray-700 rounded-md w-80" placeholder="Buscar por nombre/apellido/tel./direc.">
            </div>
            <div class="flex justify-center mb-2 md:hidden">
                <input type="text" v-model="search" class="bg-gray-700 rounded-md w-full" placeholder="Buscar por nombre/apellido/tel./direc.">
            </div>
            <div  id="table-scroll" class="table-scroll" >
                <table id="main-table" class="main-table">
                    <thead class="bg-gray-900">
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
                        <tr v-for="(order, index) in orders" :key="order.id">
                            <th class="px-4 py-2 border border-gray-600" v-if="order.user_id">
                              <div class="w-32 truncate">
                                {{ order.user_name }}
                              </div>
                            </th>
                            <th class="px-4 py-2 border border-gray-600" v-else="order.user_id">-</th>

                            <td @click="startEditing(index, 'client_name')" class="px-4 py-2 border border-gray-600">
                              <div :id="'client_last_name-' + index" :class="{'client_last_name': !isEditing(index, 'client_name'), 'hidden': isEditing(index, 'client_name') || (loadingName && loadingNameIndex === index)}">
                                {{ order.client_name }}
                              </div>
                              <input v-show="isEditing(index, 'client_name')" type="text" v-model="editedName" @blur="stopEditing(index, 'client_name', order)" @keydown.enter="stopEditing(index, 'client_name', order)" class="text-black w-full">
                              <div v-if="loadingName && loadingNameIndex === index">
                                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24"><path fill="none" stroke="#ffffff" stroke-dasharray="15" stroke-dashoffset="15" stroke-linecap="round" stroke-width="2" d="M12 3C16.9706 3 21 7.02944 21 12"><animate fill="freeze" attributeName="stroke-dashoffset" dur="0.3s" values="15;0"/><animateTransform attributeName="transform" dur="1.5s" repeatCount="indefinite" type="rotate" values="0 12 12;360 12 12"/></path></svg>
                              </div>
                            </td>

                            <td @click="startEditing(index, 'client_last_name')" class="px-4 py-2 border border-gray-600">
                              <div :id="'client_last_name-' + index" :class="{'client_last_name': !isEditing(index, 'client_last_name'), 'hidden': isEditing(index, 'client_last_name') || (loadingLastName && loadingLastNameIndex === index)}" class="w-[128px]">
                                {{ order.client_last_name }}
                              </div>
                              <input v-show="isEditing(index, 'client_last_name')" type="text" v-model="editedLastName" @blur="stopEditing(index, 'client_last_name', order)" @keydown.enter="stopEditing(index, 'client_last_name', order)" class="text-black w-full">
                              <div v-if="loadingLastName && loadingLastNameIndex === index">
                                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24"><path fill="none" stroke="#ffffff" stroke-dasharray="15" stroke-dashoffset="15" stroke-linecap="round" stroke-width="2" d="M12 3C16.9706 3 21 7.02944 21 12"><animate fill="freeze" attributeName="stroke-dashoffset" dur="0.3s" values="15;0"/><animateTransform attributeName="transform" dur="1.5s" repeatCount="indefinite" type="rotate" values="0 12 12;360 12 12"/></path></svg>
                              </div>
                            </td>

                            <td @click="startEditing(index, 'client_phone_number')" class="px-4 py-2 border border-gray-600">
                              <div :id="'client_phone_number-' + index" :class="{'client_phone_number': !isEditing(index, 'client_phone_number'), 'hidden': isEditing(index, 'client_phone_number') || (loadingPhoneNumber && loadingPhoneNumberIndex === index)}" class="w-32">
                                {{ order.client_phone_number }}
                              </div>
                              <input v-show="isEditing(index, 'client_phone_number')" type="text" v-model="editedPhoneNumber" @blur="stopEditing(index, 'client_phone_number', order)" @keydown.enter="stopEditing(index, 'client_phone_number', order)" class="text-black w-full">
                              <div v-if="loadingPhoneNumber && loadingPhoneNumberIndex === index">
                                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24"><path fill="none" stroke="#ffffff" stroke-dasharray="15" stroke-dashoffset="15" stroke-linecap="round" stroke-width="2" d="M12 3C16.9706 3 21 7.02944 21 12"><animate fill="freeze" attributeName="stroke-dashoffset" dur="0.3s" values="15;0"/><animateTransform attributeName="transform" dur="1.5s" repeatCount="indefinite" type="rotate" values="0 12 12;360 12 12"/></path></svg>
                              </div>
                            </td>

                            <td @click="startEditing(index, 'client_direction')" class="px-4 py-2 border border-gray-600">
                              <div :id="'client_direction-' + index" :class="{'client_direction': !isEditing(index, 'client_direction'), 'hidden': isEditing(index, 'client_direction') || (loadingDirection && loadingDirectionIndex === index)}" class="w-32 md:w-44">
                                {{ order.client_direction }}
                              </div>
                              <input v-show="isEditing(index, 'client_direction')" type="text" v-model="editedDirection" @blur="stopEditing(index, 'client_direction', order)" @keydown.enter="stopEditing(index, 'client_direction', order)" class="text-black w-full">
                              <div v-if="loadingDirection && loadingDirectionIndex === index">
                                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24"><path fill="none" stroke="#ffffff" stroke-dasharray="15" stroke-dashoffset="15" stroke-linecap="round" stroke-width="2" d="M12 3C16.9706 3 21 7.02944 21 12"><animate fill="freeze" attributeName="stroke-dashoffset" dur="0.3s" values="15;0"/><animateTransform attributeName="transform" dur="1.5s" repeatCount="indefinite" type="rotate" values="0 12 12;360 12 12"/></path></svg>
                              </div>
                            </td>

                            <!-- <td class="px-4 py-2 border border-gray-600">{{ order.client_postal_code }}</td> -->
                            <td @click="startEditing(index, 'client_postal_code')" class="px-4 py-2 border border-gray-600">
                              <div :id="'client_postal_code-' + index" :class="{'client_postal_code': !isEditing(index, 'client_postal_code'), 'hidden': isEditing(index, 'client_postal_code') || (loadingPostalCode && loadingPostalCodeIndex === index)}">
                                {{ order.client_postal_code }}
                              </div>
                              <input v-show="isEditing(index, 'client_postal_code')" type="text" v-model="editedPostalCode" @blur="stopEditing(index, 'client_postal_code', order)" @keydown.enter="stopEditing(index, 'client_postal_code', order)" class="text-black w-full">
                              <div v-if="loadingPostalCode && loadingPostalCodeIndex === index">
                                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24"><path fill="none" stroke="#ffffff" stroke-dasharray="15" stroke-dashoffset="15" stroke-linecap="round" stroke-width="2" d="M12 3C16.9706 3 21 7.02944 21 12"><animate fill="freeze" attributeName="stroke-dashoffset" dur="0.3s" values="15;0"/><animateTransform attributeName="transform" dur="1.5s" repeatCount="indefinite" type="rotate" values="0 12 12;360 12 12"/></path></svg>
                              </div>
                            </td>

                            <td class="px-4 py-2 border border-gray-600">
                              <label :for="'take-away-checkbox-' + order.id" class="mr-2">
                                {{ order.take_away ? 'SI' : 'NO' }}
                              </label>
                              <input
                                type="checkbox"
                                v-model="order.take_away"
                                @click="confirmUpdateTakeAway(order, index, 'take_away', !order.take_away)"
                                :id="'take-away-checkbox-' + order.id"
                                class="cursor-pointer"
                              />
                              <div v-if="loadingTakeAway && loadingTakeAwayIndex === index">
                                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24"><path fill="none" stroke="#ffffff" stroke-dasharray="15" stroke-dashoffset="15" stroke-linecap="round" stroke-width="2" d="M12 3C16.9706 3 21 7.02944 21 12"><animate fill="freeze" attributeName="stroke-dashoffset" dur="0.3s" values="15;0"/><animateTransform attributeName="transform" dur="1.5s" repeatCount="indefinite" type="rotate" values="0 12 12;360 12 12"/></path></svg>
                              </div>                    
                            </td>

                            <!-- <td class="px-4 py-2 border border-gray-600">{{ order.portions }}</td> -->
                            <td @click="startEditing(index, 'portions')" class="px-4 py-2 border border-gray-600">
                              <div :id="'portion-' + index" :class="{'portion': !isEditing(index, 'portions'), 'hidden': isEditing(index, 'portions') || (loading && loadingIndex === index)}">
                                {{ order.portions }}
                              </div>
                              <input v-show="isEditing(index, 'portions')" type="number" v-model="editedNumber" @blur="stopEditing(index, 'portions', order)" @keydown.enter="stopEditing(index, 'portions', order)" class="text-black w-full">
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

                            <td @click="startEditing(index, 'money_collected')" class="px-4 py-2 border border-gray-600">
                              <div :id="'money_collected-' + index" :class="{'money_collected': !isEditing(index, 'money_collected'), 'hidden': isEditing(index, 'money_collected') || (loadingMoneyCollected && loadingMoneyCollectedIndex == index)}">
                                ${{ order.money_collected }}
                              </div>
                              <input v-show="isEditing(index, 'money_collected')" type="number" v-model="order.money_collected" @blur="stopEditing(index, 'money_collected', order)" class="text-black w-20">
                              <div v-if="loadingMoneyCollected && loadingMoneyCollectedIndex == index">
                                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24"><path fill="none" stroke="#ffffff" stroke-dasharray="15" stroke-dashoffset="15" stroke-linecap="round" stroke-width="2" d="M12 3C16.9706 3 21 7.02944 21 12"><animate fill="freeze" attributeName="stroke-dashoffset" dur="0.3s" values="15;0"/><animateTransform attributeName="transform" dur="1.5s" repeatCount="indefinite" type="rotate" values="0 12 12;360 12 12"/></path></svg>
                              </div>
                            </td>

                            <td class="px-4 py-2 border border-gray-600">${{ order.to_collect }}</td>

                            <td class="px-4 py-2 border border-gray-600">
                              <label :for="'mp-checkbox-' + order.id" class="mr-2">
                                {{ order.mp ? 'SI' : 'NO' }}
                              </label>
                              <input
                                type="checkbox"
                                v-model="order.mp"
                                @click="confirmUpdateMP(order, index, 'mp', !order.mp)"
                                :id="'mp-checkbox-' + order.id"
                                class="cursor-pointer"
                              />
                              <div v-if="loadingMP && loadingMPIndex === index">
                                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24"><path fill="none" stroke="#ffffff" stroke-dasharray="15" stroke-dashoffset="15" stroke-linecap="round" stroke-width="2" d="M12 3C16.9706 3 21 7.02944 21 12"><animate fill="freeze" attributeName="stroke-dashoffset" dur="0.3s" values="15;0"/><animateTransform attributeName="transform" dur="1.5s" repeatCount="indefinite" type="rotate" values="0 12 12;360 12 12"/></path></svg>
                              </div>                    
                            </td>
                            <td class="px-4 py-2 border border-gray-600 bg-blue-500">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                </svg>
                            </td>
                            
                            <td @click.prevent="destroy(order.id, order.client_name, order.client_last_name)" class="border border-gray-600 bg-red-600 h-9 cursor-pointer">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                            <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6Z"/>
                            <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1ZM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118ZM2.5 3h11V2h-11v1Z"/>
                            </svg>
                        </td>
                        </tr>
                    </tbody>
                </table>

                <div v-if="!user_has_orders && list_type !== 'general'" class="flex mt-4">
                  <h1 class="px-4 py-2 border border-gray-600 text-[30px]">No tenes clientes en tu lista. Ponete las pilas porfa.</h1>
                  <div class="border border-red-500">
                    <img src="../../img/cosas/sin-lista.jpg" alt="Sos ese">
                    <p class="text-center text-[20px]">{{ user_auth_name }}</p>
                  </div>
                </div>

                <div v-if="orders.length == 0 && list_type === 'my_list' && user_has_orders" class="mt-4">
                  <p class="px-4 py-2 text-[30px] text-red-400">No existen ordenes con estos datos</p>
                    <img src="../../img/cosas/busqueda-erronea-mi-lista.jpg" alt="Sos ese buscando">
                </div>

                <div v-if="orders.length == 0 && list_type === 'general'" class="mt-4">
                  <p class="px-4 py-2 text-[30px] text-red-400">No existen ordenes con estos datos</p>
                    <img src="../../img/cosas/busqueda-erronea.jpg" alt="Sos ese buscando">
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
.table-scroll {
  position: relative;
  width: calc(100% - 8px);
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

th:nth-child(-n + 3), td:nth-child(-n + 3) {
    position: -webkit-sticky;
    position: sticky;
    left: 0;
    z-index: 3; /* Modificado de 2 a 3 */
    background: #383737;
}
thead th:nth-child(-n + 3),
tfoot th:first-child {
        z-index: 5;
}
</style>

<script setup>
import { defineProps } from 'vue';
import { ref, watch } from 'vue';
import { router } from '@inertiajs/vue3';
import axios from 'axios';

const props = defineProps({
    orders: {
        type: Object,
    },
    user_auth_name: String,
    list_type: String,
    user_has_orders: Boolean
});

// BUSCAR ORDENES
const search = ref(null);
watch(search, value => {
    if (props.list_type === 'general') {
      router.get('/', {search: value}, 
        {
            preserveState: true,
            replace: true,
        }
      );
    }

    if (props.list_type === 'my_list') {
      router.get('/my-list', {search: value}, 
        {
            preserveState: true,
            replace: true,
        }
      );
    }
});
// FIN BUSCAR ORDENES

const formatObservation = (observation) => {
  // Asegúrate de tener esta función en tu código
  function nl2br(str) {
      return str.replace(/(?:\r\n|\r|\n)/g, '<br>');
  }

  // Usa nl2br y escape para evitar inyecciones de código
  return nl2br(observation.observation);
}

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
// FIN AGREGAR OBSERVACIONES


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

// EDITAR NOMBRE
const editingNameIndex = ref(null);
const editedName = ref(null);
const loadingName = ref(false);
const loadingNameIndex = ref(null);

function updateName(order_id, index, field) {
  loadingName.value = true;
  loadingNameIndex.value = index;

  const dataToUpdate = {
          [field]: editedName.value,
        };

  updateClient(order_id, index, field, dataToUpdate);
}
// FIN EDITAR NOMBRE

// EDITAR APELLIDO
const editingLastNameIndex = ref(null);
const editedLastName = ref(null);
const loadingLastName = ref(false);
const loadingLastNameIndex = ref(null);

function updateLastName(order_id, index, field) {
  loadingLastName.value = true;
  loadingLastNameIndex.value = index;

  const dataToUpdate = {
          [field]: editedLastName.value,
        };

  updateClient(order_id, index, field, dataToUpdate);
}
// FIN EDITAR APELLIDO

// EDITAR NUMERO DE TELEFONO
const editingPhoneNumberIndex = ref(null);
const editedPhoneNumber = ref(null);
const loadingPhoneNumber = ref(false);
const loadingPhoneNumberIndex = ref(null);

function updatePhoneNumber(order_id, index, field) {
  loadingPhoneNumber.value = true;
  loadingPhoneNumberIndex.value = index;

  const dataToUpdate = {
          [field]: editedPhoneNumber.value,
        };

  updateClient(order_id, index, field, dataToUpdate);
}
// FIN EDITAR NUMERO DE TELEFONO

// EDITAR DIRECCION
const editingDirection = ref(null);
const editedDirection = ref(null);
const loadingDirection= ref(false);
const loadingDirectionIndex = ref(null);

function updateDirection(order_id, index, field) {
  loadingDirection.value = true;
  loadingDirectionIndex.value = index;

  const dataToUpdate = {
          [field]: editedDirection.value,
        };

  updateClient(order_id, index, field, dataToUpdate);
}
// FIN EDITAR DIRECCION

// EDITAR CODIGO POSTAL
const editingPostalCode = ref(null);
const editedPostalCode = ref(null);
const loadingPostalCode= ref(false);
const loadingPostalCodeIndex = ref(null);

function updatePostalCode(order_id, index, field) {
  loadingPostalCode.value = true;
  loadingPostalCodeIndex.value = index;

  const dataToUpdate = {
          [field]: editedPostalCode.value,
        };

  updateClient(order_id, index, field, dataToUpdate);
}
// FIN CODIGO POSTAL

// EDITAR PORCIONES, DELIVERY
const editingIndex = ref(null);
const editedNumber = ref(null);
const loading = ref(false);
const loadingIndex = ref(null);

function updatePortions(orderId, index, field) {
  loading.value = true;
  loadingIndex.value = index;

  const dataToUpdate = {
          [field]: editedNumber.value,
        };
  updateOrder(orderId, index, field, dataToUpdate);
}

const isEditing = (index, field) => {
  return editingIndex.value === index + '-' + field;
};
// FIN EDITAR PORCIONES

// EDITAR DINERO COBRADO
const loadingMoneyCollected = ref(false);
const loadingMoneyCollectedIndex = ref(null);

const updateMoneyCollected = (order, index, field, value) => {
    // console.log(index);
    // const confirmationText = `¿Deseas cobrar $${value} a la orden de ${order.client_name} ${order.client_last_name}?`;

    // if (confirm(confirmationText)) {
      loadingMoneyCollected.value = true;
      loadingMoneyCollectedIndex.value = index;

      const dataToUpdate = {
          [field]: value,
      };
      updateOrder(order.id, index, field, dataToUpdate);
    // }
}
// FIN EDITAR DINERO COBRADO


// EDITAR MERCADO PAGO
const loadingMP = ref(false);
const loadingMPIndex = ref(null);

const confirmUpdateMP = (order, index, field, value) => {
    const confirmationText = `¿Confirmas que ${order.client_name} ${order.client_last_name} ${value ? "SI" : "NO"} paga con mercado pago?`;

    if (!confirm(confirmationText)) {
      // Si se cancela el confirm, revertir el cambio en el checkbox
      // order.take_away = !value;
      event.preventDefault();
    } else {
      loadingMP.value = true;
      loadingMPIndex.value = index;

      const dataToUpdate = {
          [field]: value,
      };
      updateOrder(order.id, index, field, dataToUpdate);
    }
}
// FIN EDITAR MERCADO PAGO

// EDITAR DELIVERY
const loadingTakeAway = ref(false);
const loadingTakeAwayIndex = ref(null);

const confirmUpdateTakeAway = (order, index, field, value) => {
    const confirmationText = `¿Confirmas que ${order.client_name} ${order.client_last_name} ${value ? "SI" : "NO"} quiere retirar su orden?`;

    if (!confirm(confirmationText)) {
      // Si se cancela el confirm, revertir el cambio en el checkbox
      // order.take_away = !value;
      event.preventDefault();
    } else {
      loadingTakeAway.value = true;
      loadingTakeAwayIndex.value = index;

      const dataToUpdate = {
          [field]: value,
      };
      updateOrder(order.id, index, field, dataToUpdate);
    }
}
// FIN EDITAR DELIVERY

// Iniciar edicion de celda
const startEditing = (index, field) => {
  editingIndex.value = index + '-' + field;
  editedNumber.value = props.orders[index][field];
  editedLastName.value = props.orders[index][field];
  editedName.value = props.orders[index][field];
  editedPhoneNumber.value = props.orders[index][field];
  editedDirection.value = props.orders[index][field];
  editedPostalCode.value = props.orders[index][field];
};

const stopEditing = (index, field, order) => {
  if (field == 'portions') {
    updatePortions(order.id, index, field);
    editingIndex.value = null;
  }

  if (field == 'money_collected') {
    updateMoneyCollected(order, index, field, order.money_collected);
    editingIndex.value = null;
  }

  if (field == 'client_name') {
    updateName(order.id, index, 'name');
    editingIndex.value = null;
  }

  if (field == 'client_last_name') {
    updateLastName(order.id, index, 'last_name');
    editingIndex.value = null;
  }

  if (field == 'client_phone_number') {
    updatePhoneNumber(order.id, index, 'phone_number');
    editingIndex.value = null;
  }

  if (field == 'client_direction') {
    updateDirection(order.id, index, 'direction');
    editingIndex.value = null;
  }

  if (field == 'client_postal_code') {
    updatePostalCode(order.id, index, 'postal_code');
    editingIndex.value = null;
  }
};
// FIN Iniciar edicion de celda

// FUNCION MAIN PARA EDITAR ORDENES
async function updateOrder(orderId, index, field, dataToUpdate) {
    try {
      const response = await axios.put(`/order/${orderId}/edit/${field}`, dataToUpdate);

      props.orders[index] = response.data.order;

      editingIndex.value = null;
    } catch (error) {
        console.error('Error al realizar la operación:', error);
    } finally {
    loading.value = false;
    loadingIndex.value = null;
    loadingTakeAway.value = false;
    loadingTakeAwayIndex.value = null;
    loadingMoneyCollected.value = false;
    loadingMoneyCollectedIndex.value = null;
    loadingMP.value = false;
    loadingMPIndex.value = null;
    }
}
// FIN FUNCION MAIN PARA EDITAR ORDENES


// FUNCION MAIN PARA EDITAR CLIENTES
async function updateClient(order_id, index, field, dataToUpdate) {
    try {
      const response = await axios.put(`/client/${order_id}/edit/${field}`, dataToUpdate);

      props.orders[index] = response.data.order;

      editingIndex.value = null;
    } catch (error) {
        console.error('Error al realizar la operación:', error);
    } finally {
    loadingLastName.value = false;
    loadingLastNameIndex.value = null;
    loadingName.value = null;
    loadingNameIndex.value = null;
    loadingPhoneNumber.value = null;
    loadingPhoneNumberIndex.value = null;
    loadingDirection.value = null;
    loadingDirectionIndex.value = null;
    loadingPostalCode.value = null;
    loadingPostalCodeIndex.value = null;
    }
}
// FIN FUNCION MAIN PARA EDITAR ORDENES

// ELIMINAR ORDEN
async function destroy(order_id, name, last_name) {
    try {
        if (confirm(`¿Estás seguro que queres borrar la orden de ${name} ${last_name}?`)) {
            router.delete(`/order/${order_id}/delete`);
        }
    } catch (error) {
        console.error('Error al realizar la operación:', error);
    }
}
// FIN ELIMINAR ORDEN
</script>
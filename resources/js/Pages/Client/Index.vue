<template>
    <Header></Header>

    <div class="bg-gray-800 text-white pt-24">
        
        <div class="flex justify-center md:justify-between items-center pb-6 md:px-4">
            <div class="flex justify-center hidden md:block">
                <input type="text" v-model="search" class="bg-gray-700 rounded-md" placeholder="Buscar por apellido">
            </div>
            <div class="flex space-x-4">
                <Link :href="route('client.deleteClients')" class="flex items-center rounded-md bg-red-600 hover:bg-red-500 cursor-pointer p-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6Z"/>
                    <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1ZM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118ZM2.5 3h11V2h-11v1Z"/>
                    </svg>
                    <p>Papelera</p>
                </Link>
                <Link :href="route('client.import_view')" class="text-white">
                    <div class="flex items-center bg-blue-600 hover:bg-blue-500 rounded-md p-2 space-x-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 20 20"><path fill="#ffffff" d="M12.5 4.5a2.5 2.5 0 1 1-5 0a2.5 2.5 0 0 1 5 0m5 .5a2 2 0 1 1-4 0a2 2 0 0 1 4 0m-13 2a2 2 0 1 0 0-4a2 2 0 0 0 0 4M6 9.25C6 8.56 6.56 8 7.25 8h5.5a1.25 1.25 0 0 1 1.23 1.024a5.5 5.5 0 0 0-3.73 8.968A4 4 0 0 1 6 14zm8.989-.229c1.139.1 2.178.548 3.011 1.236V9.25C18 8.56 17.44 8 16.75 8h-2.129c.2.298.33.646.367 1.021M5 9.25c0-.463.14-.892.379-1.25H3.25C2.56 8 2 8.56 2 9.25V13a3 3 0 0 0 3.404 2.973A4.983 4.983 0 0 1 5 14zm14 5.25a4.5 4.5 0 1 1-9 0a4.5 4.5 0 0 1 9 0m-4-2a.5.5 0 0 0-1 0V14h-1.5a.5.5 0 0 0 0 1H14v1.5a.5.5 0 0 0 1 0V15h1.5a.5.5 0 0 0 0-1H15z"/></svg>
                        <p>Importar</p>
                    </div>
                </Link>
                <!-- <Link :href="route('client.create')" class="flex items-center rounded-md w-40 bg-green-500 hover:bg-green-400"> -->
                <div @click="openEditModal(client = null)" class="flex items-center rounded-md bg-green-500 hover:bg-green-400 cursor-pointer p-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24"><path fill="#ffffff" d="M11 13H5v-2h6V5h2v6h6v2h-6v6h-2z"/></svg>
                    <p>Agregar</p>
                </div>
                <!-- </Link> -->
            </div>
        </div>

        <div class="flex justify-center mb-2 md:hidden">
            <input type="text" v-model="search" class="bg-gray-700 rounded-md" placeholder="Buscar por apellido">
        </div>

        <div  id="table-scroll" class="table-scroll">
            <table id="main-table" class="main-table">
                <thead class="bg-gray-900">
                    <tr>
                        <th class="px-4 py-2 border border-gray-600">ID</th>
                        <th class="px-4 py-2 border border-gray-600 primary-column">Nombre</th>
                        <th class="px-4 py-2 border border-gray-600 primary-column">Apellido</th>
                        <th class="px-4 py-2 border border-gray-600">Teléfono</th>
                        <th class="px-4 py-2 border border-gray-600">Dirección</th>
                        <th class="px-4 py-2 border border-gray-600">Cod. Postal</th>
                        <th class="px-4 py-2 border border-gray-600">Últ. edición</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="client in clients" :key="client.id">
                        <th class="px-4 py-2 border border-gray-600">{{ client.id }}</th>
                        <th class="px-4 py-2 border border-gray-600">{{ client.name }}</th>
                        <th class="px-4 py-2 border border-gray-600">{{ client.last_name }}</th>
                        <th class="px-4 py-2 border border-gray-600">{{ client.phone_number }}</th>
                        <th class="px-4 py-2 border border-gray-600">{{ client.direction }}</th>
                        <th class="px-4 py-2 border border-gray-600">{{ client.postal_code }}</th>
                        <th class="px-4 py-2 border border-gray-600">Aca va un rover</th>

                        <!-- <Link :href="route('client.edit', client.id)"> -->
                        <td class="border border-gray-600 bg-blue-500 h-9 cursor-pointer" @click="openEditModal(client)">
                            <!-- <button @click="openEditModal(client)"> -->
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                </svg>
                            <!-- </button> -->
                        </td>
                        <!-- </Link> -->

                        <td @click.prevent="destroy(client.id, client.name, client.last_name)" class="border border-gray-600 bg-red-600 h-9 cursor-pointer">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                            <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6Z"/>
                            <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1ZM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118ZM2.5 3h11V2h-11v1Z"/>
                            </svg>
                        </td>
                    </tr>
                </tbody>
            </table>
            <FormModal v-if="isFormModalOpen" :closeModal="closeEditModal" :client="selectedClient"/>
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
import { router } from '@inertiajs/vue3';
import { ref, watch } from 'vue';
import FormModal from './Modal.vue';
import axios from 'axios';

// SEARCH BAR
const search = ref(null);

watch(search, value => {
    router.get('/clients', {search: value}, 
    {
        preserveState: true,
        replace: true,
    }
    );
});

// MODAL
const isFormModalOpen = ref(false);
const selectedClient = ref(null);

const openEditModal = (client) => {
    selectedClient.value = client;
    isFormModalOpen.value = true;
};
const closeEditModal = () => {
    isFormModalOpen.value = false;
    selectedClient.value = null;
};
// FIN MODAL

const props = defineProps({
    clients: {
        type: Array,
    }
});

async function destroy (id, name, last_name) {
    try {
        // Hacer la petición a la ruta de verificación usando Axios
        const response = await axios.get(`/client/clientHasOrder/${id}`);

        // Verificar si tiene órdenes antes de borrar
        if (response.data.clientHasOrder) {
            alert(`No podes borrar al cliente ${name} ${last_name} porque tiene una orden asociada.`);
        } else {
            // Borrar el cliente si no tiene órdenes
            if (confirm(`¿Estás seguro que queres borrar este cliente? ${name} ${last_name}`)) {
                router.delete(`/client/delete/${id}`);
            }
        }
    } catch (error) {
        console.error('Error al realizar la operación:', error);
    }
}
</script>
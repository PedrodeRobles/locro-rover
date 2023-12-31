<template>
    <Header></Header>

    <div class="bg-gray-800 text-white pt-24">
        
        <div class="flex justify-center md:justify-between items-center pb-6 md:px-4">
            <div class="flex justify-center hidden md:block">
                <input type="text" v-model="search" class="bg-gray-700 rounded-md" placeholder="Buscar por apellido">
            </div>
            <div class="flex space-x-4">
                <Link :href="route('client.index')" class="text-white">
                    <div class="flex items-center bg-blue-600 hover:bg-blue-500 rounded-md p-2 space-x-1">
                        <p>Volver al listado de clientes</p>
                    </div>
                </Link>
            </div>
        </div>

        <div class="flex justify-center mb-2 md:hidden">
            <input type="text" v-model="search" class="bg-gray-700 rounded-md" placeholder="Buscar por apellido">
        </div>

        <p class="text-xl">Clientes borrados:</p>
        <div  id="table-scroll" class="table-scroll">
            <table id="main-table" class="main-table">
                <thead class="bg-gray-900">
                    <tr>
                        <th class="px-4 py-2 border border-gray-600">ID</th>
                        <th class="px-4 py-2 border border-gray-600">Nombre</th>
                        <th class="px-4 py-2 border border-gray-600">Apellido</th>
                        <th class="px-4 py-2 border border-gray-600">Teléfono</th>
                        <th class="px-4 py-2 border border-gray-600">Dirección</th>
                        <th class="px-4 py-2 border border-gray-600">Cod. Postal</th>
                        <th class="px-4 py-2 border border-gray-600">Últ. edición</th>
                        <th class="px-4 py-2 border border-gray-600">Recuperar</th>
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

                        <td class="flex justify-center border border-gray-600 bg-blue-500 h-9 cursor-pointer" @click="rollbackClient(client)">
                            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 24 24"><path fill="#ffffff" d="M20.93 14A7.002 7.002 0 0 1 14 20H5.5v-2H14a5 5 0 1 0 0-10H6.914l2.5 2.5L8 11.914L3.086 7L8 2.086L9.414 3.5L6.914 6H14a7 7 0 0 1 7 7v1z"/></svg>
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

const props = defineProps({
    clients: {
        type: Array,
    }
});

function rollbackClient(client) {
    if (confirm(`¿Queres recuperar este cliente? ${client.name} ${client.last_name}`)) {
        router.put(`/client/rollback/${client.id}`);
    }
}
</script>
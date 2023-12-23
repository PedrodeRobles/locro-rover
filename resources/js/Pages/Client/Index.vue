<template>
    <Header></Header>

    <div class="bg-gray-800 text-white pt-24">
        
        <div class="flex justify-center sm:justify-end sm:mr-10 pb-6">
            <Link :href="route('client.create')" class="flex items-center rounded-md w-40 bg-green-500 hover:bg-green-400">
                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24"><path fill="#ffffff" d="M11 13H5v-2h6V5h2v6h6v2h-6v6h-2z"/></svg>
                Agregar cliente
            </Link>
        </div>

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

                        <Link :href="route('client.edit', client.id)">
                            <td class="border border-gray-600 bg-blue-500 h-9">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                </svg>
                            </td>
                        </Link>

                        <td @click.prevent="destroy(client.id, client.name, client.last_name)" class="border border-gray-600 bg-red-600 h-9 cursor-pointer">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                            <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6Z"/>
                            <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1ZM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118ZM2.5 3h11V2h-11v1Z"/>
                            </svg>
                        </td>
                    </tr>
                </tbody>
            </table>
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
import { router } from '@inertiajs/vue3'

const props = defineProps({
    clients: {
        type: Array,
    }
});

function destroy(id, name, last_name) {
    if (confirm(`¿Estas seguro que queres eliminar a ${name} ${last_name}?`)) {
        router.delete(`/client/delete/${id}`);
    }
}
</script>
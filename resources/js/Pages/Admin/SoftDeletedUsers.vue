<template>
    <Header></Header>

    <div class="bg-gray-800 text-white pt-24">
        
        <div class="flex justify-center md:justify-end items-center pb-6 md:px-4">
            <div class="flex space-x-4">
                <Link :href="route('admin.roles')" class="flex items-center rounded-md bg-blue-600 hover:bg-blue-500 cursor-pointer p-2">
                    <p>Usuarios y Roles</p>
                </Link>
            </div>
        </div>

        <div class="text-xl ml-2 flex justify-center">
            Rovers inactivos
        </div>

        <div  id="table-scroll" class="table-scroll">
            <table id="main-table" class="main-table">
                <thead class="bg-gray-900">
                    <tr>
                        <th class="px-4 py-2 border border-gray-600">ID</th>
                        <th class="px-4 py-2 border border-gray-600 primary-column">Nombre</th>
                        <th class="px-4 py-2 border border-gray-600">Activar/Recuperar rover</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="user in users" :key="user.id">
                        <th class="px-4 py-2 border border-gray-600">{{ user.id }}</th>
                        <th class="px-4 py-2 border border-gray-600">{{ user.name }}</th>

                        <th class="px-4 py-2 border border-gray-600">
                            <td @click.prevent="rollbackUser(user)" class="border border-gray-600 h-9 cursor-pointer bg-blue-500 hover:bg-blue-700">
                                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 24 24"><path fill="#ffffff" d="M20.93 14A7.002 7.002 0 0 1 14 20H5.5v-2H14a5 5 0 1 0 0-10H6.914l2.5 2.5L8 11.914L3.086 7L8 2.086L9.414 3.5L6.914 6H14a7 7 0 0 1 7 7v1z"/></svg>
                            </td>
                        </th>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<style scoped>
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
  /* width: 100%; */
  min-width: 100px;
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

th:nth-child(-n + 2) {
  position: -webkit-sticky;
  position: sticky;
  left: 0;
  z-index: 2;
  background: #383737;
}
thead th:nth-child(-n + 2),
tfoot th:first-child {
  z-index: 5;
}
</style>

<script setup>
import { defineProps } from 'vue';
import { router } from '@inertiajs/vue3';
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';

const props = defineProps({
    users: {
        type: Array,
    }
});

async function rollbackUser(user) {
    try {
        if (confirm(`¿Queres recupear a ${user.name}?`)) {
            await router.put(`/admin/users/${user.id}/rollbackUser`);
            await toast.success(`Rover recuperado con éxito!`, { autoClose: 2500 });
        }
    } catch (error) {
        console.error('Error al realizar la operación:', error);
        await toast.error(`Error al recuperar rover: ${user.name}`, { autoClose: 2500 });
    }
}
</script>
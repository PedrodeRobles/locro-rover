<template>
    <Header></Header>

    <div class="bg-gray-800 text-white pt-24">
        
        <div class="flex justify-center md:justify-end items-center pb-6 md:px-4">
            <div class="flex space-x-4">
                <Link :href="route('client.deleteClients')" class="flex items-center rounded-md bg-red-600 hover:bg-red-500 cursor-pointer p-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6Z"/>
                    <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1ZM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118ZM2.5 3h11V2h-11v1Z"/>
                    </svg>
                    <p>Rovers inactivos</p>
                </Link>
            </div>
        </div>

        <div class="text-xl ml-2 flex justify-center">
            Gestion de Roles y Usuarios:
        </div>

        <div  id="table-scroll" class="table-scroll">
            <table id="main-table" class="main-table">
                <thead class="bg-gray-900">
                    <tr>
                        <th class="px-4 py-2 border border-gray-600">ID</th>
                        <th class="px-4 py-2 border border-gray-600 primary-column">Nombre</th>
                        <th class="px-4 py-2 border border-gray-600 primary-column">ROL</th>
                        <th class="px-4 py-2 border border-gray-600">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="user in users" :key="user.id">
                        <th class="px-4 py-2 border border-gray-600">{{ user.id }}</th>
                        <th class="px-4 py-2 border border-gray-600">{{ user.name }}</th>
                        <th class="px-4 py-2 border border-gray-600">
                            <div v-for="role in user.roles">
                                {{ role }}
                            </div>
                        </th>
                        <td class="px-4 py-2 border border-gray-600">
                            <td class="h-9 cursor-pointer border border-black" @click="assignRole(user, 'Logistica')" :class="{ 'bg-red-500': userHasRole(user.roles, 'Logistica'), 'bg-green-600': !userHasRole(user.roles, 'Logistica') }">
                                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24"><path fill="#ffffff" d="m16 21l-.3-1.5q-.3-.125-.562-.262T14.6 18.9l-1.45.45l-1-1.7l1.15-1q-.05-.35-.05-.65t.05-.65l-1.15-1l1-1.7l1.45.45q.275-.2.538-.337t.562-.263L16 11h2l.3 1.5q.3.125.563.275t.537.375l1.45-.5l1 1.75l-1.15 1q.05.3.05.625t-.05.625l1.15 1l-1 1.7l-1.45-.45q-.275.2-.537.338t-.563.262L18 21zM2 20v-2.8q0-.825.425-1.55t1.175-1.1q1.275-.65 2.875-1.1T10 13h.35q.15 0 .3.05q-.725 1.8-.6 3.575T11.25 20zm15-2q.825 0 1.413-.587T19 16q0-.825-.587-1.412T17 14q-.825 0-1.412.588T15 16q0 .825.588 1.413T17 18m-7-6q-1.65 0-2.825-1.175T6 8q0-1.65 1.175-2.825T10 4q1.65 0 2.825 1.175T14 8q0 1.65-1.175 2.825T10 12"/></svg>
                            </td>
                            <td class="h-9 cursor-pointer border border-black" @click="assignRole(user, 'Compras')" :class="{ 'bg-red-500': userHasRole(user.roles, 'Compras'), 'bg-green-600': !userHasRole(user.roles, 'Compras') }">
                                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24"><path fill="#ffffff" d="M7 22q-.825 0-1.412-.587T5 20q0-.825.588-1.412T7 18q.825 0 1.413.588T9 20q0 .825-.587 1.413T7 22m10 0q-.825 0-1.412-.587T15 20q0-.825.588-1.412T17 18q.825 0 1.413.588T19 20q0 .825-.587 1.413T17 22M5.2 4h14.75q.575 0 .875.513t.025 1.037l-3.55 6.4q-.275.5-.737.775T15.55 13H8.1L7 15h11q.425 0 .713.288T19 16q0 .425-.288.713T18 17H7q-1.125 0-1.7-.987t-.05-1.963L6.6 11.6L3 4H2q-.425 0-.712-.288T1 3q0-.425.288-.712T2 2h1.625q.275 0 .525.15t.375.425z"/></svg>  
                            </td>
                            <td class="h-9 cursor-pointer border border-black" @click="assignRole(user, 'Publicidad')" :class="{ 'bg-red-500': userHasRole(user.roles, 'Publicidad'), 'bg-green-600': !userHasRole(user.roles, 'Publicidad') }">
                                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24"><path fill="#ffffff" d="m7.552 13l.847-2.115L9.244 13zM16 12h1v2h-1a1 1 0 1 1 0-2m5-9H3a1 1 0 0 0-1 1v16a1 1 0 0 0 1 1h18a1 1 0 0 0 1-1V4a1 1 0 0 0-1-1m-8.402 13h-2.155l-.4-1h-3.29l-.4 1H4.199l1.199-2.998l.001-.002l2-5h2zM17 8h2v8h-3a3 3 0 1 1 0-6h1z"/></svg>
                            </td>
                            <td class="h-9 cursor-pointer border border-black" @click="assignRole(user, 'Intendencia')" :class="{ 'bg-red-500': userHasRole(user.roles, 'Intendencia'), 'bg-green-600': !userHasRole(user.roles, 'Intendencia') }">
                                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 36 36"><path fill="#ffffff" d="M10.65 24.44a9.51 9.51 0 0 1 7.06-9.17L13 3a1 1 0 0 0-1.87 0L2.07 26.56A1 1 0 0 0 3 27.92h8.32a9.44 9.44 0 0 1-.67-3.48" class="clr-i-solid clr-i-solid-path-1"/><path fill="#ffffff" d="M32 10H20a1 1 0 0 0-1 1v4a9.43 9.43 0 0 1 10.63 9H32a1 1 0 0 0 1-1V11a1 1 0 0 0-1-1" class="clr-i-solid clr-i-solid-path-2"/><circle cx="20.15" cy="24.44" r="7.5" fill="#ffffff" class="clr-i-solid clr-i-solid-path-3"/><path fill="none" d="M0 0h36v36H0z"/></svg>
                            </td>
                            <td class="h-9 cursor-pointer border border-black" @click="assignRole(user, 'Rover')" :class="{ 'bg-red-500': userHasRole(user.roles, 'Rover'), 'bg-green-600': !userHasRole(user.roles, 'Rover') }">
                                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24"><path fill="#ffffff" d="M12 12q-1.65 0-2.825-1.175T8 8q0-1.65 1.175-2.825T12 4q1.65 0 2.825 1.175T16 8q0 1.65-1.175 2.825T12 12m-8 6v-.8q0-.85.438-1.562T5.6 14.55q1.55-.775 3.15-1.162T12 13q1.65 0 3.25.388t3.15 1.162q.725.375 1.163 1.088T20 17.2v.8q0 .825-.587 1.413T18 20H6q-.825 0-1.412-.587T4 18"/></svg>
                            </td>
                            <td class="h-9 cursor-pointer border border-black" @click="assignRole(user, 'DIOS')" :class="{ 'bg-red-500': userHasRole(user.roles, 'DIOS'), 'bg-green-600': !userHasRole(user.roles, 'DIOS') }">
                                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24"><path fill="#ffffff" d="M9 20v-4q-1.275-.1-2.5-.275t-2.45-.45q-.425-.1-.675-.475T3.25 14q.125-.425.513-.625t.812-.1q1.825.425 3.688.575T12 14q1.875 0 3.738-.15t3.687-.575q.45-.1.825.1t.5.625q.125.425-.137.8t-.688.475q-1.225.275-2.45.45T15 16v4q0 .425-.287.713T14 21h-4q-.425 0-.712-.288T9 20m3-7q-.85 0-1.425-.575T10 11q0-.825.575-1.412T12 9q.825 0 1.413.588T14 11q0 .85-.587 1.425T12 13m-7.5-3q-.65 0-1.075-.425T3 8.5q0-.625.425-1.062T4.5 7q.625 0 1.063.438T6 8.5q0 .65-.437 1.075T4.5 10m15 0q-.65 0-1.075-.425T18 8.5q0-.625.425-1.062T19.5 7q.625 0 1.063.438T21 8.5q0 .65-.437 1.075T19.5 10M7.25 6.25q-.65 0-1.075-.425T5.75 4.75q0-.625.425-1.062T7.25 3.25q.625 0 1.063.438T8.75 4.75q0 .65-.437 1.075T7.25 6.25m9.5 0q-.65 0-1.075-.425T15.25 4.75q0-.625.425-1.062t1.075-.438q.625 0 1.063.438t.437 1.062q0 .65-.437 1.075t-1.063.425M12 5q-.65 0-1.075-.425T10.5 3.5q0-.625.425-1.062T12 2q.625 0 1.063.438T13.5 3.5q0 .65-.437 1.075T12 5"/></svg>
                            </td>
                            <td @click.prevent="destroy(user.id, user.name, user.last_name)" class="border border-gray-600 h-9 cursor-pointer" style="background-color: #dc2626;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24"><path fill="#ffffff" d="M7 21q-.825 0-1.412-.587T5 19V6H4V4h5V3h6v1h5v2h-1v13q0 .825-.587 1.413T17 21zM17 6H7v13h10zM9 17h2V8H9zm4 0h2V8h-2zM7 6v13z"/></svg>
                            </td>
                        </td>
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
import axios from 'axios';
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';

const props = defineProps({
    users: {
        type: Array,
    },
    roles: {
        type: Array,
    }
});

function userHasRole(userRoles, roleName) {
    return userRoles.includes(roleName);
}

const assignRole = async (user, role_name) => {
    try {
        let text;
        if(userHasRole(user.roles, role_name)) {
            text = `¿Deseas quitarle el rol ${role_name} a ${user.name}?`;
        } else {
            text = `¿Deseas asignarle el rol ${role_name} a ${user.name}?`;
        }

        if (confirm(text)) {
            await router.put(`/admin/assign_roles/${user.id}/${role_name}`);
            await toast.success(`Cambios realizados respecto a ${user.name} y el rol ${role_name}`, { autoClose: 2500 });
        }
    } catch (error) {
        console.error(`Error al asignar o eliminar rol ${role_name} a ${user.name}:`, error);
        await toast.error(`Error al asignar o eliminar rol ${role_name} a ${user.name}`, { autoClose: 2500 });
    }
};

async function destroy (id, name, last_name) {
    try {
        // Hacer la petición a la ruta de verificación usando Axios
        const response = await axios.get(`/client/clientHasOrder/${id}`);

        // Verificar si tiene órdenes antes de borrar
        if (response.data.clientHasOrder) {
            alert(`No podes borrar al cliente ${name} ${last_name} porque tiene una orden actual asociada.`);
        } else {
            // Borrar el cliente si no tiene órdenes
            if (confirm(`¿Estás seguro que queres borrar este cliente? ${name} ${last_name}`)) {
                await router.delete(`/client/delete/${id}`);
                await toast.success(`Cliente ${name} ${last_name} eliminado con éxito!`, { autoClose: 4000 });
            }
        }
    } catch (error) {
        console.error('Error al realizar la operación:', error);
        await toast.error(`Error al eliminar cliente: ${name} ${last_name}`, { autoClose: 4000 });
    }
}
</script>
<template>
    <Header></Header>

    <div class="pt-28 space-y-4 md:space-y-0 md:space-x-4 md:flex md:justify-center md:items-center">
        <Link :href="route('client.index')" class="flex justify-center text-white">
            <div class="bg-blue-600 hover:bg-blue-500 rounded-md p-2">
                Lista de clientes
            </div>
        </Link>

        <Link :href="route('admin.roles')" class="flex justify-center text-white">
            <div class="bg-indigo-400 hover:bg-indigo-300 rounded-md p-2">
                Usuarios/Roles
            </div>
        </Link>

        <Link :href="route('admin.years')" class="flex justify-center text-white">
            <div class="bg-amber-500 hover:bg-amber-400 rounded-md p-2">
                Gestionar años
            </div>
        </Link>

        <Link :href="route('admin.parameters')" class="flex justify-center text-white">
            <div class="bg-sky-600 hover:bg-sky-500 rounded-md p-2">
                Definir Parametros
            </div>
        </Link>

        <a href="/admin/export-orders" class="flex justify-center text-white">
            <div class="bg-orange-600 hover:bg-orange-500 rounded-md p-2">
                Exportar listado de ordenes
            </div>
        </a>

        <div class="flex justify-center text-white">
            <button @click="openMadePortionsModal" class="bg-blue-600 p-2 rounded-md">
                Definir porciones hechas
            </button>
        </div>
        <MadePortionsModal v-if="isMadePortionsModalOpen" :closeModal="closeMadePortionsModal"/>

    </div>
</template>

<script setup>
import { ref } from 'vue';
import MadePortionsModal from './MadePortionsModal.vue';


// MODAL PORCIONES HECHAS
const isMadePortionsModalOpen = ref(false);

const openMadePortionsModal = () => {
    isMadePortionsModalOpen.value = true;
};
const closeMadePortionsModal = () => {
    isMadePortionsModalOpen.value = false;
};
// FIN MODAL PORCIONES HECHAS

</script>
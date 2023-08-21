<template>
    <Header></Header>

    <div class="bg-gray-800 pt-32 flex justify-center">
        <form @submit.prevent="submit" class="text-white border border-gray-600 rounded-lg mx-2 px-2 w-96">
            <div class="p-2 border-b border-gray-600">
                <h1 class="text-center text-xl">Agregar cliente</h1>
            </div>
            <div class="space-y-4 my-4">
                <div class="space-x-2">
                    <label for="">Nombre:</label>
                    <input type="text" placeholder="Ingrese nombre" class="bg-gray-900" v-model="form.name" >
                    <p v-if="form.mode == 'edit'" class="text-[2vh] text-gray-400">Nombre anterior: {{ props.client.name }}</p>
                </div>
                <div class="space-x-2">
                    <label for="">Apellido:</label>
                    <input type="text" placeholder="Ingrese apellido" class="bg-gray-900" v-model="form.last_name" >
                    <p v-if="form.mode == 'edit'" class="text-[2vh] text-gray-400">Apellido anterior: {{ props.client.last_name }}</p>
                </div>
                <div class="space-x-2">
                    <label for="">Telefono:</label>
                    <input type="text" placeholder="Ingrese telefono" class="bg-gray-900" v-model="form.phone_number" >
                    <p v-if="form.mode == 'edit'" class="text-[2vh] text-gray-400">Telefono anterior: {{ props.client.phone_number }}</p>
                </div>
                <div class="space-x-2">
                    <label for="">Dirección:</label>
                    <input type="text" placeholder="Ingrese dirección" class="bg-gray-900" v-model="form.direction" >
                    <p v-if="form.mode == 'edit'" class="text-[2vh] text-gray-400">Dirección anterior: {{ props.client.direction }}</p>
                </div>
                <div class="space-x-2">
                    <label for="">Código postal:</label>
                    <input type="text" placeholder="Ingrese código postal" class="bg-gray-900" v-model="form.postal_code" >
                    <p v-if="form.mode == 'edit'" class="text-[2vh] text-gray-400">Código postal anterior: {{ props.client.postal_code }}</p>
                </div>
                <div class="flex justify-center">
                    <button v-if="form.mode == 'create'" class="bg-green-500 hover:bg-green-600 py-2 px-4 rounded-md">
                        Crear
                    </button>
                    <button v-if="form.mode == 'edit'" class="bg-green-500 hover:bg-green-600 py-2 px-4 rounded-md">
                        Editar
                    </button>
                </div>
            </div>
        </form>
    </div>
</template>

<script setup>
import { reactive } from 'vue'
import { router } from '@inertiajs/vue3'
import { defineProps } from 'vue';

const props = defineProps({
    client: {
        type: Object,
    }
});

const form = reactive({
    name: null,
    last_name: null,
    phone_number: null,
    direction: null,
    postal_code: null,
    mode: 'create'
});

// Función para cargar los datos de un registro existente si estamos editando
function cargarDatosRegistro(client) {
    form.name = client.name;
    form.last_name = client.last_name;
    form.phone_number = client.phone_number;
    form.direction = client.direction;
    form.postal_code = client.postal_code;
    form.mode = 'edit'; // Cambiamos a "edit" al cargar un registro existente
}

// Evento para cargar los datos de un registro existente (editar)
if (props.client) {
    cargarDatosRegistro(props.client);
}

function submit() {
    if (form.mode === 'create') {
        // Realizar una solicitud POST para crear un nuevo registro
        router.post('/client/create', form);
    } else if (form.mode === 'edit') {
        // Realizar una solicitud PUT para actualizar el registro existente
        router.put(`/client/edit/${props.client.id}`, form);
    }
}

</script>
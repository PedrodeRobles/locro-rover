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
                </div>
                <div class="space-x-2">
                    <label for="">Apellido:</label>
                    <input type="text" placeholder="Ingrese apellido" class="bg-gray-900" v-model="form.last_name" >
                </div>
                <div class="space-x-2">
                    <label for="">Telefono:</label>
                    <input type="text" placeholder="Ingrese telefono" class="bg-gray-900" v-model="form.phone_number" >
                </div>
                <div class="space-x-2">
                    <label for="">Dirección:</label>
                    <input type="text" placeholder="Ingrese dirección" class="bg-gray-900" v-model="form.direction" >
                </div>
                <div class="space-x-2">
                    <label for="">Código postal:</label>
                    <input type="text" placeholder="Ingrese código postal" class="bg-gray-900" v-model="form.postal_code" >
                </div>
                <div class="flex justify-center">
                    <button class="bg-green-500 hover:bg-green-600 py-2 px-4 rounded-md">
                        Crear
                    </button>
                </div>
            </div>
        </form>
    </div>
</template>

<script setup>
import { reactive } from 'vue'
import { router } from '@inertiajs/vue3'

const form = reactive({
    name: null,
    last_name: null,
    phone_number: null,
    direction: null,
    postal_code: null,
});

function submit() {
    router.post('/client/create', form)

    // form.name = null;
    // form.last_name = null;
    // form.phone_number = null;
    // form.direction = null;
    // form.postal_code = null;
}

</script>
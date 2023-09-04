<template>
    <Header></Header>

    <div class="pt-28">
        <div class="flex justify-center mt-4">
            <form @submit.prevent="submit" class="text-white border border-gray-600 rounded-lg mx-2 px-2 w-96">
                <div class="p-2 border-b border-gray-600">
                    <h1 class="text-center text-xl">Definir parametros para la promoción {{ year.year }}</h1>
                </div>
                <div class="space-y-4 my-4">
                    <div>
                        <label for="">Precio por unidad:</label>
                        <div>
                            <input type="text" placeholder="Ingrese precio por unidad" class="bg-gray-900 w-60" v-model="form.unit_price">
                        </div>
                    </div>
                    <div>
                        <label for="">Precio por unidad promo:</label>
                        <div>
                            <input type="text" placeholder="Ingrese precio por unidad" class="bg-gray-900 w-60" v-model="form.promo_unit_price">
                        </div>
                    </div>
                    <div>
                        <label for="">Unidades para promo:</label>
                        <div>
                            <input type="text" placeholder="Ingrese unidades para promo" class="bg-gray-900 w-60" v-model="form.amount_for_promo">
                        </div>
                    </div>
                    <div class="flex justify-center">
                        <button class="bg-green-500 hover:bg-green-600 py-2 px-4 rounded-md">
                            Guardar
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>

<script setup>
import { defineProps } from 'vue';
import { router } from '@inertiajs/vue3'

const props = defineProps({
    year: {
        type: Object,
    },
    parameter: {
        type: Object,
    }
});

const form = {
    unit_price: null,
    promo_unit_price: null,
    amount_for_promo: null,
};

function submit() {
    // Realizar una solicitud POST para crear un nuevo registro
    router.post('/parameters/store', form);
}
</script>
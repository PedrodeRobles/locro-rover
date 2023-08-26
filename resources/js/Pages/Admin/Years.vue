<template>
    <Header></Header>

    <!-- <div class="pt-28 space-y-4">
        <Link :href="route('client.index')" class="flex justify-center text-white">
            <div class="bg-blue-600 hover:bg-blue-500 rounded-md p-2">
                Generar año
            </div>
        </Link>
    </div> -->
    <div class="pt-28">
        <form v-if="!thisYearExists" @submit.prevent="submit" class="text-white">
            <div class="flex justify-center">
                <button class="bg-amber-500 hover:bg-amber-400 py-2 px-4 rounded-md">
                    Agregar el año actúal
                </button>
            </div>
        </form>
    
        <div class="flex justify-center mt-10">
            <table class="text-white">
                <thead class="bg-gray-900">
                    <tr>
                        <th class="px-4 py-2 border border-gray-600">Año</th>
                        <th class="px-4 py-2 border border-gray-600">Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="year in years" :key="year.id">
                        <th class="px-4 py-2 border border-gray-600">{{ year.year }}</th>
                        <th v-if="year.active == true" class="px-4 py-2 border border-gray-600">Activo</th>
                        <th v-else class="px-4 py-2 border border-gray-600">Inactivo</th>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script setup>
import { defineProps } from 'vue';
import { router } from '@inertiajs/vue3'

const props = defineProps({
    years: {
        type: Array,
    },
    thisYearExists: {
        type: Boolean,
    }
});
function submit() {
        router.post('/year/store');
}
</script>
<template>
    <Header></Header>

    <div class="pt-28 space-y-4">
        <Link :href="route('client.index')" class="flex justify-center text-white">
            <div class="bg-blue-600 hover:bg-blue-500 rounded-md p-2">
                Lista de clientes
            </div>
        </Link>

        <Link :href="route('client.import_view')" class="flex justify-center text-white">
            <div class="bg-blue-600 hover:bg-blue-500 rounded-md p-2">
                Importar clientes masivamente
            </div>
        </Link>

        <Link :href="route('admin.years')" class="flex justify-center text-white">
            <div class="bg-amber-500 hover:bg-amber-400 rounded-md p-2">
                Gestionar años
            </div>
        </Link>
    </div>
</template>

<script setup>
</script>
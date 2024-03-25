<template>
    <Header></Header>

    <div class="pt-28 space-y-4 md:space-y-0 md:space-x-4 md:flex md:justify-center md:items-center">
        <Link :href="route('client.index')" class="flex justify-center text-white">
            <div class="bg-blue-600 hover:bg-blue-500 rounded-md p-2">
                Lista de clientes
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
    </div>
</template>

<script setup>
</script>
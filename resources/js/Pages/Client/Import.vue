<template>
    <Header></Header>

    <div class="pt-28 pb-4 px-4 flex justify-center">
      <p class="text-amber-300">
        Este proceso importa clientes desde un archivo .xlsx. Tambien por cada uno de los clientes se genera una orden correspondiente, para el año actual
      </p>
    </div>

    <div class="text-white flex justify-center">
      <div class="border border-gray-500 rounded-md p-2 mx-4">
        <h1 class="border-b border-gray-500 text-center text-xl pb-2">Importar clientes desde un Excel</h1>
        <form @submit.prevent="importFile" class="py-4">
            <input type="file" ref="import_file" accept=".xlsx, .xls" class="cursor-pointer">
            <div class="flex justify-center">
              <button type="submit" :disabled="isLoading" class=" mt-6 p-1 cursor-pointer w-full" :class="{ 'bg-gray-700': isLoading,  'bg-green-500': !isLoading, 'hover:bg-green-600': !isLoading}">
                <!-- Si isLoading es true, muestra la animación de carga, de lo contrario, muestra 'Importar' -->
                <span v-if="isLoading">Cargando</span>
                <span v-else>Importar</span>
              </button>
            </div>
            <div class="flex justify-center ml-4">
              <div>
                <p>El orden las columnas debe ser:</p>
                <p>Nombre / Apellido / Teléfono / Dirección / Cod. Postal</p>
              </div>
            </div>
        </form>
      </div>
    </div>
</template>

<script>
export default {
    data() {
      return {
        isLoading: false, // Inicialmente no está cargando
      };
    },
    methods: {
        async importFile() {
          this.isLoading = true;

          const archivo = this.$refs.import_file.files[0];
          const formData = new FormData();
          formData.append('import_file', archivo);

          try {
            // Realiza una solicitud POST al backend de Laravel para procesar el archivo
              const response = await axios.post('/client/import-clients', formData);

            // Puedes manejar la respuesta como desees, por ejemplo, mostrar un mensaje de éxito
              alert('Clientes importados con éxito');

              this.$inertia.visit('/');
          } catch (error) {
            // Maneja cualquier error que pueda ocurrir, como mostrar un mensaje de error
              alert('Error al importar el archivo');
              console.error(error);
              this.isLoading = false;
          }
        },
    },
};
</script>
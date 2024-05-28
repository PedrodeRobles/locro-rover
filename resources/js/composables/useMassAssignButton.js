// resources/js/Composables/useMassAssignButton.js
import { ref, onMounted } from 'vue';

export function useMassAssignButton(orders) {
    const checkboxes = ref([]);
    const boton = ref(null);
    const boton_desk = ref(null);
    const isAssignModalOpen = ref(false);
    let idsTildados = [];
    let nombresTildados = [];

    const openAssignModal = () => {
        isAssignModalOpen.value = true;
    };

    const closeAssignModal = () => {
        isAssignModalOpen.value = false;
        idsTildados = [];
        nombresTildados = [];

        // Destildar todos los checkboxes
        checkboxes.value.forEach((checkbox) => {
        checkbox.checked = false;
        });

        // Ocultar los botones
        boton.value.classList.add('hidden');
        boton_desk.value.classList.add('hidden');
    };

    onMounted(() => {
        checkboxes.value = document.querySelectorAll('.checkbox');
        boton.value = document.getElementById('boton');
        boton_desk.value = document.getElementById('boton-desk');

        checkboxes.value.forEach((checkbox, index) => {
        checkbox.addEventListener('change', () => {
            // Verificar si al menos un checkbox está marcado
            const alMenosUnoMarcado = [...checkboxes.value].some(checkbox => checkbox.checked);

            // Mostrar u ocultar el botón según el resultado
            if (alMenosUnoMarcado) {
            boton.value.classList.remove('hidden');
            boton_desk.value.classList.remove('hidden');
            } else {
            boton.value.classList.add('hidden');
            boton_desk.value.classList.add('hidden');
            }

            if (checkbox.checked) {
            idsTildados.push(orders[index].id);
            nombresTildados.push(`${orders[index].name} ${orders[index].last_name}`);
            } else {
            // Remover del array si se desmarca el checkbox
            idsTildados = idsTildados.filter(id => id !== orders[index].id);
            nombresTildados = nombresTildados.filter(
                name => name !== `${orders[index].name} ${orders[index].last_name}`
            );
            }
        });
        });
    });

    return {
        checkboxes,
        boton,
        boton_desk,
        isAssignModalOpen,
        openAssignModal,
        closeAssignModal,
        idsTildados,
        nombresTildados
    };
}
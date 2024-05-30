// resources/js/Composables/useMassAssignButton.js
import { ref, onMounted, watch } from 'vue';

export function useMassAssignButton(orders) {
    const checkboxes = ref([]);
    const boton = ref(null);
    const boton_desk = ref(null);
    const isAssignModalOpen = ref(false);
    const idsTildados = ref([]);
    const nombresTildados = ref([]);

    const openAssignModal = () => {
        isAssignModalOpen.value = true;
    };

    const closeAssignModal = () => {
        isAssignModalOpen.value = false;
        idsTildados.value = [];
        nombresTildados.value = [];

        // Destildar todos los checkboxes
        checkboxes.value.forEach((checkbox) => {
            checkbox.checked = false;
        });

        // Ocultar los botones
        boton.value.classList.add('hidden');
        boton_desk.value.classList.add('hidden');
    };

    const updateCheckboxListeners = () => {
        checkboxes.value = document.querySelectorAll('.checkbox');
        boton.value = document.getElementById('boton');
        boton_desk.value = document.getElementById('boton-desk');

        checkboxes.value.forEach((checkbox) => {
            const orderId = parseInt(checkbox.getAttribute('data-order-id'));
            const order = orders.find(o => o.id === orderId);
            if (!order) return;

            const orderName = `${order.name} ${order.last_name}`;

            checkbox.removeEventListener('change', handleCheckboxChange);
            checkbox.addEventListener('change', handleCheckboxChange);

            function handleCheckboxChange() {
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
                    if (!idsTildados.value.includes(orderId)) {
                        idsTildados.value.push(orderId);
                        nombresTildados.value.push(orderName);
                    }
                } else {
                    idsTildados.value = idsTildados.value.filter(id => id !== orderId);
                    nombresTildados.value = nombresTildados.value.filter(name => name !== orderName);
                }
            }
        });
    };

    onMounted(() => {
        updateCheckboxListeners();
    });

    watch(orders, () => {
        updateCheckboxListeners();
    }, { deep: true });

    return {
        isAssignModalOpen,
        openAssignModal,
        closeAssignModal,
        idsTildados,
        nombresTildados,
        updateCheckboxListeners 
    };
}

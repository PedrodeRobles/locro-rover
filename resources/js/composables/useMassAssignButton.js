import { ref, onMounted, watch } from 'vue';

export function useMassAssignButton(initialOrders) {
    const orders = ref([...initialOrders]);
    const allSelectedOrders = ref([]); // Mantiene todas las órdenes seleccionadas
    const checkboxes = ref([]);
    const boton = ref(null);
    const boton_desk = ref(null);
    const isAssignModalOpen = ref(false);
    const idsTildados = ref([]);
    const ordenesTildadas = ref([]);
    const totalSelectedAmount = ref(0);
    const totalSelectedPortions = ref(0);
    const totalSelectedSauces = ref(0);

    const openAssignModal = () => {
        isAssignModalOpen.value = true;
    };

    const closeAssignModal = () => {
        isAssignModalOpen.value = false;
        idsTildados.value = [];
        ordenesTildadas.value = [];
        totalSelectedAmount.value = 0;
        totalSelectedPortions.value = 0;
        totalSelectedSauces.value = 0;

        checkboxes.value.forEach((checkbox) => {
            checkbox.checked = false;
        });

        boton.value.classList.add('hidden');
        boton_desk.value.classList.add('hidden');
    };

    const recalculateTotals = () => {
        recalculateTotalSelectedAmount();
        recalculateTotalPortions();
        recalculateTotalSauces();
        recalculateOrdenesTildadas();
    };

    const recalculateTotalSelectedAmount = () => {
        totalSelectedAmount.value = idsTildados.value.reduce((sum, id) => {
            const order = orders.value.find(order => order.id === id);
            return sum + (order ? order.amount : 0);
        }, 0);
    };

    const recalculateTotalPortions = () => {
        totalSelectedPortions.value = idsTildados.value.reduce((sum, id) => {
            const order = orders.value.find(order => order.id === id);
            return sum + (order ? order.portions : 0);
        }, 0);
    };

    const recalculateTotalSauces = () => {
        totalSelectedSauces.value = idsTildados.value.reduce((sum, id) => {
            const order = orders.value.find(order => order.id === id);
            return sum + (order ? order.sauces : 0);
        }, 0);
    };

    const recalculateOrdenesTildadas = () => {
        ordenesTildadas.value = idsTildados.value.map(id => {
            return orders.value.find(order => order.id === id);
        }).filter(order => order !== undefined);
    };

    const updateCheckboxListeners = () => {
        checkboxes.value = document.querySelectorAll('.checkbox');
        boton.value = document.getElementById('boton');
        boton_desk.value = document.getElementById('boton-desk');

        checkboxes.value.forEach((checkbox) => {
            const orderId = parseInt(checkbox.getAttribute('data-order-id'));
            const order = orders.value.find(o => o.id === orderId);
            if (!order) return;

            checkbox.removeEventListener('change', handleCheckboxChange);
            checkbox.addEventListener('change', handleCheckboxChange);

            function handleCheckboxChange() {
                const alMenosUnoMarcado = [...checkboxes.value].some(checkbox => checkbox.checked);

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
                        ordenesTildadas.value.push(order);
                        totalSelectedAmount.value += order.amount;
                        totalSelectedPortions.value += order.portions;
                        totalSelectedSauces.value += order.sauces;
                        allSelectedOrders.value.push(order); // Añadir a la lista global de órdenes seleccionadas
                    }
                } else {
                    if (idsTildados.value.includes(orderId)) {
                        idsTildados.value = idsTildados.value.filter(id => id !== orderId);
                        ordenesTildadas.value = ordenesTildadas.value.filter(o => o.id !== orderId);
                        totalSelectedAmount.value -= order.amount;
                        totalSelectedPortions.value -= order.portions;
                        totalSelectedSauces.value -= order.sauces;
                        allSelectedOrders.value = allSelectedOrders.value.filter(o => o.id !== orderId); // Remover de la lista global
                    }
                }
                recalculateTotals(); // Recalcula totales después de cambios en la selección
            }
        });
    };

    const setOrders = (newOrders) => {
        orders.value = [...newOrders];
        recalculateTotals();
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
        ordenesTildadas,
        updateCheckboxListeners,
        totalSelectedAmount,
        totalSelectedPortions,
        totalSelectedSauces,
        setOrders,
        recalculateTotals,
        allSelectedOrders // Añadido para acceder a la lista global
    };
}

import { computed } from 'vue';

export function acountants(props, made_portions) {
    // Calcular la suma de portions
    const totalPortions = computed(() => {
        const sum = props.orders.reduce((sum, order) => sum + order.portions, 0);
        return sum / 2;
    });

    // Calcular la suma de batata
    const totalBatata = computed(() => {
        const sum = props.orders.reduce((sum, order) => sum + order.batata, 0);
        return sum / 2;
    });

    // Calcular la suma de porciones retiradas
    const totalWithdrawalPortions = computed(() => {
        const sum = props.orders.reduce((sum, order) => {
            if (order.withdrawal == 1) {
                return sum + order.portions;
            }
            return sum;
        }, 0);
        return sum;
    });

    // Calcular la suma de porciones restantes
    const totalRemainingPortions = computed(() => {
        return made_portions - totalWithdrawalPortions.value;
    });

    // Calcular la suma del dinero total de ventas
    const totalSalesMoney = computed(() => {
        const sum = props.orders.reduce((sum, order) => sum + order.amount, 0);
        return sum;
    });

    // Calcular la suma del dinero total del dinero cobrado
    const totalMoneyCollected = computed(() => {
        const sum = props.orders.reduce((sum, order) => sum + order.money_collected, 0);
        return sum;
    });

    // Calcular la suma total de salsas
    const totalSauces = computed(() => {
        const sum = props.orders.reduce((sum, order) => sum + order.sauces, 0);
        return sum;
    });

    return {
        totalPortions,
        totalBatata,
        totalSalesMoney,
        totalMoneyCollected,
        totalSauces,
        totalWithdrawalPortions,
        totalRemainingPortions
    };
}
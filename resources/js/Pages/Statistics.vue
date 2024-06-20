<template>
    <Header></Header>

    <div class="pt-20 text-white" style="height: 700px;"> <!-- Ajusta la altura según sea necesario -->
        <Bar
            id="my-chart-id"
            :options="chartOptions"
            :data="chartData"
            class="md:mx-2"
        />
    </div>
</template>

<script setup>
import { Bar } from 'vue-chartjs'
import { ref, computed, watchEffect } from 'vue'
import { Chart as ChartJS, Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale } from 'chart.js'
import ChartDataLabels from 'chartjs-plugin-datalabels'

ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale, ChartDataLabels)

// Define props
const props = defineProps({
    activeUsers: Array
})

// Computed properties
const userNames = computed(() => props.activeUsers.map(user => user.name))

// Define reactive chartData and chartOptions
const chartData = ref({
    labels: [],
    datasets: []
})

watchEffect(() => {
    chartData.value = {
        labels: userNames.value,
        datasets: [
        {
            label: 'Porciones vendidas',
            backgroundColor: '#3490dc',
            data: props.activeUsers.map(user => user.total_portions),
            barThickness: 25,  // Ajusta el grosor de las barras
            datalabels: {
            anchor: 'end',
            align: 'end',
            color: '#fff',
            formatter: (value) => value
            }
        }
        ]
    }
})

const chartOptions = {
    responsive: true,
    maintainAspectRatio: false,  // Permitir que la altura del gráfico cambie
    aspectRatio: 1,  // Relación de aspecto 1:1
    layout: {
        padding: {
            top: 10,
            left: 20,
            right: 20,
            bottom: 10
        }
    },
    plugins: {
        legend: {
        display: true
        },
        title: {
        display: true,
        text: 'Porciones vendidas por usuario'
        },
        datalabels: {
        anchor: 'end',
        align: 'right',
        color: '#fff',
        font: {
            weight: 'bold'
        }
        }
    },
    indexAxis: 'y',  // Cambia el gráfico de barras a orientación vertical
    scales: {
        x: {
        beginAtZero: true
        }
    }
}
</script>

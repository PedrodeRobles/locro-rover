<template>
    <Header></Header>

    <div class="pt-20 text-white">
        <Bar
            id="my-chart-id"
            :options="chartOptions"
            :data="chartData"
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
    maintainAspectRatio: false,
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
        align: 'top',
        color: '#fff',
        font: {
            weight: 'bold'
        }
        }
    },
    scales: {
        y: {
        beginAtZero: true
        }
    }
}
</script>

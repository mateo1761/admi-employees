<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import { Bar } from 'vue-chartjs';
import { Chart as ChartJS, Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale } from 'chart.js'

ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale);

const props = defineProps({
    data: {type: Array, required: true}
});

const chartState = ref({
    departments: [],
    employees: [],
    colors: [],
});

const generateRandomColor = () => {
    return `rgb(${Math.floor(Math.random() * 256)}, ${Math.floor(Math.random() * 256)}, ${Math.floor(Math.random() * 256)}, 0.2)`;
}

try {
    props.data.forEach(row => {
        chartState.value.departments.push(row.name || 'undefined');
        chartState.value.employees.push(row.employees_count || 0);
        chartState.value.colors.push(generateRandomColor());
    });
} catch (error) {
    console.error('Error processing data:', error);
}

const chartData = computed(() => ({
    labels: chartState.value.departments,
    datasets: [
        {
            label: 'Empleados',
            data: chartState.value.employees,
            backgroundColor: chartState.value.colors,
            borderColor: chartState.value.colors,
            borderWidth: 1
        },
    ],
}));

const chartOptions = computed(() => ({
    responsive: true,
    plugins: {
        title: {
            display: true,
            text: 'Cantidad de Empleados por Departamento',
        },
        legend: {
            position: 'top',
        },
    },
}));

</script>

<template>
    <Head title="Graphica" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Gráfica de Empleados</h2>
        </template>

        <div class="py-12">
            <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div v-if="chartData.datasets[0].data.length > 0">
                        <Bar :data="chartData" :options="chartOptions" />
                    </div>
                    <p v-else class="text-center text-gray-500 py-4">No hay datos disponibles para mostrar.</p>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { onMounted } from 'vue';
import 'flowbite';
import { DataTable } from 'simple-datatables';

// Props del backend
const props = defineProps({
    employees: { type: Array, required: true },
    deparments: { type: Array, required: true },
});

// Inicializar DataTables con Flowbite
onMounted(() => {
    // Inicializar tabla de empleados
    if (document.getElementById('employee-table')) {
        new DataTable('#employee-table', {
            searchable: true,
            sortable: true,
            data: {
                headings: ['#', 'Nombre', 'Email', 'Teléfono', 'Departamento'],
                data: props.employees.map(emp => [
                    emp.id,
                    emp.name,
                    emp.email,
                    emp.phone,
                    emp.department?.name || 'Sin Departamento',
                ]),
            },
        });
    }

    // Inicializar tabla de departamentos
    if (document.getElementById('department-table')) {
        new DataTable('#department-table', {
            searchable: true,
            sortable: true,
            data: {
                headings: ['#', 'Nombre'],
                data: props.deparments.map(dept => [dept.id, dept.name]),
            },
        });
    }
});
</script>


<template>
    <Head title="Reportes" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Reportes de Empleados y Departamentos</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
                <!-- Tabla de Empleados -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4">
                    <h3 class="text-lg font-semibold mb-4">Reporte de Empleados</h3>
                    <table id="employee-table" class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th>#</th>
                                <th>Nombre</th>
                                <th>Email</th>
                                <th>Teléfono</th>
                                <th>Departamento</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- El cuerpo se llenará dinámicamente -->
                        </tbody>
                    </table>
                </div>

                <!-- Tabla de Departamentos -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4">
                    <h3 class="text-lg font-semibold mb-4">Reporte de Departamentos</h3>
                    <table id="department-table" class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th>#</th>
                                <th>Nombre</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- El cuerpo se llenará dinámicamente -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>


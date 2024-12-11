<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import EmployeeModal from '@/Components/EmployeeModal.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import WarningButton from '@/Components/WarningButton.vue';
import VueTailwindPagination from '@ocrv/vue-tailwind-pagination';
import { Head, useForm, usePage, } from '@inertiajs/vue3';
import Swal from 'sweetalert2';
import { ref, watch } from 'vue';

const modalVisible = ref(false);
const selectedEmployee = ref(null);

const page = usePage();
const departments = page.props.deparments;
const employees = ref(page.props.employees);
const formPage = useForm({});
const form = useForm({});

const openModal = (employee = null) => {
    selectedEmployee.value = employee ? { ...employee } : null;
    modalVisible.value = true;
};

const closeModal = () => {
    modalVisible.value = false;
    selectedEmployee.value = null;
};

const onPageClick = (page) => {
    formPage.get(route('employees.index', { page }));
};

watch(() => page.props.flash.success, (message) => {
    if(message) {
        Swal.fire({
            title: 'Éxito',
            text: message,
            icon: 'success',
        });
        formPage.get(route('employees.index'), { replace: true });
    }
});

const deleteEmployee = (id, name) => {
    Swal.fire({
        title: `¿Estás seguro de eliminar este empleado ${name}?`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar',
    }).then((result) => {
        if (result.isConfirmed) {
            form.delete(route('employees.destroy', id), {
                onSuccess: () => {
                    Swal.fire({
                        title: 'Éxito',
                        text:  page.props.flash.success,
                        icon: 'success',
                    });
                    formPage.get(route('employees.index'), { replace: true });
                },
            });
        }
    });
};
</script>

<template>
    <Head title="Empleados" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Empleados</h2>
        </template>

        <div class="py-12">
            <div class="bg-white grid place-items-center overflow-x-auto">
                <div class="mt-3 mb-3 flex">
                    <PrimaryButton @click="openModal()">
                        <i class="fa-solid fa-plus-circle mr-1"></i> Agregar
                    </PrimaryButton>
                </div>
                <table class="table-auto border border-gray-400">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-2 py-2">#</th>
                            <th class="px-2 py-2">Nombre</th>
                            <th class="px-2 py-2">Email</th>
                            <th class="px-2 py-2">Teléfono</th>
                            <th class="px-2 py-2">Departamento</th>
                            <th class="px-2 py-2" colspan="2">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="employee in employees.data" :key="employee.id">
                            <td class="border px-2 py-2">{{ employee.id }}</td>
                            <td class="border px-2 py-2">{{ employee.name }}</td>
                            <td class="border px-2 py-2">{{ employee.email }}</td>
                            <td class="border px-2 py-2">{{ employee.phone }}</td>
                            <td class="border px-2 py-2">{{ employee.department?.name }}</td>
                            <td class="border px-2 py-2 text-center">
                                <WarningButton @click="openModal(employee)">
                                    <i class="fa-solid fa-edit"></i>
                                </WarningButton>
                            </td>
                            <td class="border px-2 py-2 text-center">
                                <DangerButton @click="deleteEmployee(employee.id, employee.name)">
                                    <i class="fa-solid fa-trash"></i>
                                </DangerButton>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="bg-white flex justify-center">
                <VueTailwindPagination
                    :current="employees.current_page"
                    :total="employees.total"
                    :per-page="employees.per_page"
                    @page-changed="onPageClick"
                />
            </div>

            <EmployeeModal
                v-if="modalVisible"
                :employee="selectedEmployee"
                :departments="departments"
                @close="closeModal"
                @saved="closeModal"
            />
        </div>
    </AuthenticatedLayout>
</template>

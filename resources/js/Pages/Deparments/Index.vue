<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DangerButton from '@/Components/DangerButton.vue';
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';
import Swal from 'sweetalert2';
import { onMounted } from 'vue';

const props = defineProps({
    deparments: {type: Object},
});

const form = useForm({
    id: ''
});

const page = usePage();

onMounted(() => {
    if (page.props.flash.success) {
        Swal.fire({
            title: 'Éxito',
            text: page.props.flash.success,
            icon: 'success'
        });
    }
});

const deleteDeparments = (id, name) => {
    const alert = Swal.mixin({
        buttonsStyling: true,
    });
    alert.fire({
        title: `¿Estás seguro de eliminar este departamento ${name}?`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: '<i class="fa-solid fa-check"></i> Sí, eliminar.',
        cancelButtonText: '<i class="fa-solid fa-ban"></i> Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            form.delete(route('departments.destroy', id), {
                onSuccess: () => {
                    Swal.fire({
                        title: 'Éxito',
                        text: page.props.flash.success,
                        icon: 'success'
                    });
                }
            });
        }
    })
}
</script>

<template>
    <Head title="Departments" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Departamentos</h2>
        </template>

        <div class="py-12">
            <div class="bg-white grid v-screen place-items-center">
                <div class="mt-3 mb-3 flex">
                    <Link :href="route('deparments.create')" :class="'px-4 py-2 bg-gray-800 text-white border rounded-md font-semibold text-xs'">
                        <i class="fa-solid fa-plus-circle"></i>
                        Agregar
                    </Link>
                </div>
            </div>
            <div class="bg-white grid v-screen place-items-center">
                <table class="table-auto border border-gray-400">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-4 py-4">#</th>
                            <th class="px-4 py-4">Departamento</th>
                            <th class="px-4 py-4" colspan="2">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="deparment in deparments" :key="deparment.id">
                            <td class="border border-gray-400 px-4 py-4">{{ deparment.id }}</td>
                            <td class="border border-gray-400 px-4 py-4">{{ deparment.name }}</td>
                            <td class="border border-gray-400 px-4 py-4 text-center">
                                <Link :href="route('departments.edit', deparment.id)" :class="'px-4 py-2 bg-yellow-400 text-white border rounded-md font-semibold text-xs'">
                                    <i class="fa-solid fa-edit"></i>
                                </Link>
                            </td>
                            <td class="border border-gray-400 px-4 py-4 text-center">
                                <DangerButton @click="deleteDeparments(deparment.id, deparment.name)">
                                    <i class="fa-solid fa-trash"></i>
                                </DangerButton>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

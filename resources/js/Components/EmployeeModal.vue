<script setup>
import { defineProps, defineEmits, ref, watch } from 'vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import SelectInput from '@/Components/SelectInput.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
    employee: { type: Object, default: null },
    departments: { type: Array, required: true },
})

const emit = defineEmits(['close', 'saved']);

const form = useForm({
    name: '',
    email: '',
    phone: '',
    deparments_id: '',
});

watch(() => props.employee, (newEmployee) => {
    if (newEmployee) {
        form.name = newEmployee.name;
        form.email = newEmployee.email;
        form.phone = newEmployee.phone;
        form.deparments_id = newEmployee.deparments_id;
    } else {
        form.reset();
    }
}, { immediate: true });

const save = () => {
    const method = props.employee ? 'put' : 'post';
    const routeName = props.employee ? 'employees.update' : 'employees.store';
    const routeParams = props.employee ? [props.employee.id] : [];

    form[method](route(routeName, ...routeParams), {
        onSuccess: () => {
            emit('saved');
            form.reset();
        }
    });
};
</script>

<template>
    <div class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white w-full max-w-lg p-6 rounded-lg shadow-lg">
            <h2 class="text-lg font-semibold mb-4">{{ props.employee ? 'Editar Empleado' : 'Crear Empleado' }}</h2>

            <form @submit.prevent="save" class="space-y-4">
                <div>
                    <InputLabel for="name" value="Nombre" />
                    <TextInput id="name" v-model="form.name" required class="block mt-1 w-full" />
                    <InputError :message="form.errors.name" class="mt-2" />
                </div>
                
                <div>
                    <InputLabel for="email" value="Email" />
                    <TextInput id="email" type="email" v-model="form.email" required class="block mt-1 w-full" />
                    <InputError :message="form.errors.email" class="mt-2" />
                </div>
                
                <div>
                    <InputLabel for="phone" value="Teléfono" />
                    <TextInput id="phone" v-model="form.phone" required class="block mt-1 w-full" />
                    <InputError :message="form.errors.phone" class="mt-2" />
                </div>
                
                <div>
                    <InputLabel for="deparments_id" value="Departamento" />
                    <SelectInput 
                        id="deparments_id" 
                        v-model="form.deparments_id" 
                        :options="departments.map(dept => ({ value: dept.id, label: dept.name }))" 
                        required 
                    />
                    <InputError :message="form.errors.deparments_id" class="mt-2" />
                </div>
                
                <div class="flex justify-end space-x-2 mt-4">
                    <SecondaryButton @click="emit('close')">Cancelar</SecondaryButton>
                    <PrimaryButton :disabled="form.processing"><i class="fa-solid fa-save mr-1"></i>Guardar</PrimaryButton>
                </div>
            </form>
        </div>
    </div>
</template>
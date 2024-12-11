<script setup>
import { onMounted, ref, defineProps, defineEmits } from 'vue';

const props = defineProps({
    modelValue: {
        type: [String, Number],
        required: true,
    },
    options: {
        type: Array,
        default: () => [],
        required: true,
    }
});

const emit = defineEmits(['update:modelValue']);

const input = ref(null);

onMounted(() => {
    if (input.value && input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
});

defineExpose({ focus: () => input.value.focus() });

const updateModel = (value) => {
    emit('update:modelValue', value);
};
</script>

<template>
    <select
        class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full"
        :value="props.modelValue"
        @change="updateModel($event.target.value)"
        ref="input"
    >
        <option value="" disabled>Seleccione una opción</option>
        <option v-for="(option, index) in props.options" :key="index" :value="option.value">
            {{ option.label }}
        </option>
    </select>
</template>

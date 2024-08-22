<script setup>
import RadioButton from 'primevue/radiobutton';
import { defineProps, defineEmits } from 'vue';

const props = defineProps({
    name: {
        type: String,
        required: true,
    },
    options: {
        type: Array,
        required: true,
    },
    modelValue: {
        type: [String, Number],
        required: true,
    },
    message: String
});

const emit = defineEmits(['update:modelValue']);

const updateValue = (value) => {
    emit('update:modelValue', value);
};
</script>

<template>
    <div class="mb-6">
        <label>{{ name }}</label>
        <div class="flex flex-wrap gap-2">
            <div v-for="option in options" :key="option.value" class="flex items-center">
                <RadioButton :inputId="`${name}-${option.value}`" :name="name" :value="option.value" :modelValue="modelValue" @update:modelValue="updateValue" />
                <label :for="`${name}-${option.value}`" class="ml-2">{{ option.label }}</label>
            </div>
        </div>
        <small class="error" v-if="message">{{ message }}</small>
    </div>
</template>

<script setup>
    import { onMounted, ref } from 'vue';

    defineProps({
        modelValue: {
            type: String,
            required: true,
        },
        required: {
            type: Boolean,
            default: false,
        },
        disabled: {
            type: Boolean,
            disabled: false,
        },
        label: {
            type: String,
            default: '',
        },
        nameOption: {
            type: String,
            required: true,
        },
        options: {
            type: Object,
            required: true,
        },
        error: {
            type: String,
            default: null,
        },
    });

    defineEmits(['update:modelValue']);

</script>

<template>
    <div>
        <label :for="label" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{label}}</label>
        <select :id="id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
        @change="$emit('update:modelValue', $event.target.value)"
        :required="required"
        :disabled="disabled"
        >
        <option value="">Seleccione</option>
        <option :selected="modelValue==option.id" :value="option.id" v-for="option in options"

        >{{option[nameOption]}}</option>
    </select>
    <p v-if="error" class="text-sm text-red-600 dark:text-red-400">{{ error }}
    </p>
</div>
</template>

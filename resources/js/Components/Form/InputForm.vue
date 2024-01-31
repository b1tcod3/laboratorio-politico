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
        type: {
            type: Boolean,
            default: 'text',
        },
        disabled: {
            type: Boolean,
            disabled: false,
        },
        label: {
            type: String,
            default: '',
        },
        error: {
            type: String,
            default: null,
        },
    });

    defineEmits(['update:modelValue']);

    const input = ref(null);

    onMounted(() => {
        if (input.value.hasAttribute('autofocus')) {
            input.value.focus();
        }
    });

    defineExpose({ focus: () => input.value.focus() });
</script>

<template>
    <div>
        <label :for="label" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{label}}</label>
        <input :type="type" id="first_name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"  
        :class="{
                    'cursor-not-allowed': disabled
                }"
        :value="modelValue"
        @input="$emit('update:modelValue', $event.target.value)"
        ref="input"
        :required="required"
        :disabled="disabled">
        <p v-if="error" class="text-sm text-red-600 dark:text-red-400">
            {{ error }}
        </p>
    </div>
</template>

<script setup>
import { computed, onMounted } from 'vue';

defineEmits(['update:modelValue']);

defineProps({
        modelValue: {
            type: String,
            required: true,
        },
        options: {
            type: Array,
            required: true,
        },
        nameElement: {
            type: String,
            required: true,
        },
        name: {
            type: String,
            required: true,
        },
    });

</script>

<template>
    <div>
        <button id="dropdownRadioButton" data-dropdown-toggle="dropdownRadio" class="inline-flex items-center text-gray-500 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-3 py-1.5 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700" type="button">
            {{modelValue}} {{nameElement}}
        </button>
        <!-- Dropdown menu -->
        <div id="dropdownRadio" class="z-10 hidden w-48 bg-white divide-y divide-gray-100 rounded-lg shadow dark:bg-gray-700 dark:divide-gray-600" data-popper-reference-hidden="" data-popper-escaped="" data-popper-placement="top" style="position: absolute; inset: auto auto 0px 0px; margin: 0px; transform: translate3d(522.5px, 3847.5px, 0px);">
            <ul class="p-3 space-y-1 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownRadioButton">
                <template v-for="option in options">
                <li>
                    <div class="flex items-center p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-600">
                        
                        
                            <input :id="option.id" type="radio" :name="name" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                            :value="option.value"
                            @input="$emit('update:modelValue', $event.target.value)"
                            ref="input"
                            >
                            <label for="filter-radio-example-1" class="w-full ms-2 text-sm font-medium text-gray-900 rounded dark:text-gray-300">{{option.value}} {{nameElement}}</label>
                        
                    </div>
                </li>
                </template>
            </ul>
        </div>
    </div>
</template>
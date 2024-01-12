<script setup>
	import Icon from '@/Components/Icon/Icon.vue';

	defineProps({
		color: {
			type: String,
		},
	});
</script>

<template>
    <button
        class="inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest dark:hover:bg-white  dark:focus:bg-white  focus:outline-none focus:ring-2 transition ease-in-out duration-150"

        :class="{
			'bg-blue-800 active:bg-blue-900 focus:bg-blue-700 dark:bg-blue-200 hover:bg-blue-700 dark:active:bg-blue-300 dark:active:bg-blue-300 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-blue-800': color=='blue',
		}"
    >
        <slot />
    </button>
</template>

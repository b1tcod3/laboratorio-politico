<script setup>
	import Icon from '@/Components/Icon/Icon.vue';

	defineProps({
		icon: {
			type: String,
		},
		data: {
			type: String,
		},
		title: {
			type: String,
		},
		color: {
			type: String,
		},
	});
</script>

<template>
	<div class="flex items-center p-4 bg-white rounded-lg shadow-xs">
		<div class="p-3 mr-4 rounded-full"
		:class="{
			'text-blue-500 bg-blue-100': color=='blue',
			'text-red-500 bg-red-100': color=='red',
			'text-yellow-500 bg-yellow-100': color=='yellow'
		}"
		>
			<Icon :name="icon" class="block w-6 h-6" :class="{
				'fill-red-400': color=='red',
				'fill-red-400': color=='red',
				'fill-yellow-400': color=='yellow' 
			}"/>
		</div>
		<div>
			<p class="mb-2 text-sm font-medium text-gray-600">
				{{title}}
			</p>
			<p class="text-lg font-semibold text-gray-700">
				{{data}}
			</p>
		</div>
	</div>
</template>

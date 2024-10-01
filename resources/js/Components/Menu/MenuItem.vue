<script setup>
	import Icon from '@/Components/Icon/Icon.vue'
	import { Link } from '@inertiajs/vue3';
	const props = defineProps({
	    url: {
	        type: [String],
	        default: '',
	    },
	    name: {
	        type: [String],
	        required: true,
	    },
	    icon: {
	        type: [String],
	        required: true,
	    },
	    active:{
	    	default:false
	    }
	});
</script>
<template>
	<Link class="group flex items-center py-3" :href="url" >
		<icon :name="icon" class="mr-2 w-4 h-4" :class="active ? 'fill-white' : 'fill-gray-200 group-hover:fill-white'" />
		<div :class="active ? 'text-red-200 font-bold' : 'text-gray-200 group-hover:text-white'">
			{{name}}
		</div>
	</Link>	
</template>


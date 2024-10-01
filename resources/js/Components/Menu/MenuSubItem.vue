<script setup>
	import Icon from '@/Components/Icon/Icon.vue'
	import { Link } from '@inertiajs/vue3';
	import { ref } from 'vue';
	
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
      items: {
          type: [Array],
          required: true,
      }
      ,
      active: {
          type: Boolean,
          required: true,
      }
	});

	const show = ref(false);

</script>
<template>
	<div class="relative">
            <!-- Dropdown toggle button -->
            <button
              @click="show = !show"
              class="
                flex
                items-center
                rounded-md
                focus:outline-none
                group flex items-center py-3
              "
              :class="active ? 'text-white' : 'text-gray-300 group-hover:text-white'"
            > 
            <icon name="resumen" class="mr-2 w-4 h-4" :class="active ? 'fill-white' : 'fill-gray-200 group-hover:fill-white'" />
              <span class="mr-4">{{name}}</span>
              <Icon name="arrow-down" />
            </button>

            <div
              v-show="show"
              class="
                mt-2
                ml-3
              "
            >
            <template v-for="item in items">
              <Link class="group flex items-center py-3" :href="item.url">
                <icon :name="icon" class="mr-2 w-4 h-4" :class="$page.url === item.name_route ? 'fill-white' : 'fill-gray-400 group-hover:fill-white'" />
                <div :class="$page.url === item.name_route ? 'text-white' : 'text-gray-300 group-hover:text-white'">{{item.name}}</div>
              </Link>
            </template>
              
            </div>
      </div>	
</template>


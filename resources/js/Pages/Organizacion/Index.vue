<script setup>
	import Layout from '@/Layouts/MainLayout.vue';
	import { Head, Link } from '@inertiajs/vue3';
    import SimpleTable from '@/Components/Table/SimpleTable.vue';

    defineOptions({ layout: Layout });

    const props = defineProps({
        organizaciones: {
            type: Array,
        }
    });

    const headers = ['ID','Logo','Nombre','Tipo'];
    const fields = ['logo','nombre','tipo'];
    const types_fields = ['image','string','string'];

</script>

<template>
	<Head title="Organizaciones" />
    <h2 class="mb-4 text-4xl tracking-tight font-bold text-gray-900 dark:text-white">Organizaciones</h2>
    <Link type="button" class="flex items-center justify-center px-4 py-2 text-sm font-medium text-white rounded-lg bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 focus:outline-none dark:focus:ring-primary-800"
         :href="route('organizaciones.create')"
         >
            <svg class="h-3.5 w-3.5 mr-2" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
              <path clip-rule="evenodd" fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" />
            </svg>
            Nueva
          </Link>
	<div class="p-4 w-full h-full">
        <simple-table name="organizaciones" :headers :data="organizaciones" :fields :types_fields route="/organizaciones" 
        @deleting="deleting"
        />
    </div>
</template>

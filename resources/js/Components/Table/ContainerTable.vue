<script setup>
    import Pagination from '@/Components/Pagination/Pagination.vue';
    const props = defineProps({
        name:{
            type: String,
            required: true
        },
        links:{
            type: Object,
            required: true
        },
        isEmpty:{
            type: Boolean,
            required: true
        }
    })
</script>
<template>
<h1 class="mb-8 text-3xl font-bold">{{name}}
</h1>



<div  class="relative overflow-x-auto shadow-md sm:rounded-lg">
    
    <!-- WIDGETS DE LA TABLA -->
    <div class="flex flex-column sm:flex-row flex-wrap space-y-4 sm:space-y-0 items-center justify-start pb-4">
        <slot name="widget"></slot>
    </div>

    <!-- INICIO TABLE -->
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400" v-show="!isEmpty">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <slot name="columns"/>
            </tr>
        </thead>
        <slot name="body" />
            
    </table>
    <div v-show="isEmpty">
        <div class="flex items-center p-4 text-sm text-gray-800 border border-gray-300 rounded-lg bg-gray-50 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600" role="alert">
          <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
          </svg>
          <span class="sr-only">Info</span>
          <div>
            <span class="font-medium">Sin registro!</span> Intente realizar otro filtro
          </div>
        </div>
    </div>
    <!-- FIN TABLE -->
    <pagination :links="links" />
</div>    
</template>

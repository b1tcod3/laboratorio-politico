<script setup>
    import Pagination from '@/Components/Pagination/Pagination.vue';
    const props = defineProps({
        name:{
            type: String,
            required: true
        }
    })
</script>
<template>
<h1 class="mb-8 text-3xl font-bold">{{name}}
</h1>



<div  class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <!-- INICIO TABLE -->
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400" >
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <slot name="columns"/>
            </tr>
        </thead>
        <slot name="body" />     
    </table>
</div>    
</template>

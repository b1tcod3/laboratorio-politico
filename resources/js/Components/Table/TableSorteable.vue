<script setup>
    const props = defineProps({
        fields: {
            type: Object,
            default: false,
        },
        rows:{
            type: Array,
            required: true
        }
    });
</script>

<template>

    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
          <thead class="text-xs text-gray-50 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-50">
            <tr class="bg-indigo-500">
              <th scope="col" class="px-6 py-3" v-for="field in fields" :key='field.id'>
               <div class="flex items-center uppercase">
                {{field.name_display}}
                <a href="#" :key="'link-'+field.id" @click="$emit('sort', field.name)">
                    <svg class="w-3 h-3 ml-1.5" 
                    :class="{
                        'fill-red-500': orderColumn==field.name
                    }"
                    aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M8.574 11.024h6.852a2.075 2.075 0 0 0 1.847-1.086 1.9 1.9 0 0 0-.11-1.986L13.736 2.9a2.122 2.122 0 0 0-3.472 0L6.837 7.952a1.9 1.9 0 0 0-.11 1.986 2.074 2.074 0 0 0 1.847 1.086Zm6.852 1.952H8.574a2.072 2.072 0 0 0-1.847 1.087 1.9 1.9 0 0 0 .11 1.985l3.426 5.05a2.123 2.123 0 0 0 3.472 0l3.427-5.05a1.9 1.9 0 0 0 .11-1.985 2.074 2.074 0 0 0-1.846-1.087Z"/>
                    </svg>
                </a>
            </div>
            </th>
            </tr>
    </thead>

<tbody>
    <tr class="bg-white border-b dark:bg-gray-900 dark:border-gray-700"
    v-for="row in rows" :key='row.id'
    >
    <td class="px-6 py-4" v-for="field in fields" :key='field.id' >
      {{row[field.name]}}
    </td>
</tr>
</tbody>
</table>
</div>
</template>

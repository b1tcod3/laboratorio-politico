<script setup>

    const props = defineProps({
        show: {
            type: Boolean,
            default: false,
        },
        maxWidth: {
            type: String,
            default: '2xl',
        },
        closeable: {
            type: Boolean,
            default: true,
        },
    });
</script>

<template>
    <div class="flex items-center justify-between mb-6">

      <FwbDropdown :text="form.rows+' rows'">
        <FwbListGroup>
          <FwbListGroupItem @click="updateRows(5)">
            <template #prefix >

            </template>
            5 rows
        </FwbListGroupItem>
        <FwbListGroupItem @click="updateRows(10)">
            <template #prefix>

            </template>
            10 rows
        </FwbListGroupItem>
        <FwbListGroupItem @click="updateRows(15)">
            <template #prefix >

            </template>
            15 rows
        </FwbListGroupItem>
        <FwbListGroupItem @click="updateRows(25)">
            <template #prefix >

            </template>
            25 rows
        </FwbListGroupItem>
    </FwbListGroup>
</FwbDropdown>

<search-filter v-model="form.search" class="mr-4 w-full max-w-md" @reset="reset">
</search-filter>

<a as="button" class="text-green-900 bg-green-200 hover:bg-green-100 border border-green-200 focus:ring-4 focus:outline-none focus:ring-green-100 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:focus:ring-green-600 dark:bg-green-800 dark:border-green-700 dark:text-white dark:hover:bg-green-700 mr-2 mb-2"
:href="route('api.municipios',{'search':form.search,'orderColumn':form.orderColumn,'orderType':form.orderType,
    'rows':form.rows
})"
target="_BLANK"
>
<svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
    <path d="M9 7V2.13a2.98 2.98 0 0 0-1.293.749L4.879 5.707A2.98 2.98 0 0 0 4.13 7H9Z"/>
    <path d="M18.066 2H11v5a2 2 0 0 1-2 2H4v11a1.97 1.97 0 0 0 1.934 2h12.132A1.97 1.97 0 0 0 20 20V4a1.97 1.97 0 0 0-1.934-2ZM10 18a1 1 0 1 1-2 0v-2a1 1 0 1 1 2 0v2Zm3 0a1 1 0 0 1-2 0v-6a1 1 0 1 1 2 0v6Zm3 0a1 1 0 0 1-2 0v-4a1 1 0 1 1 2 0v4Z"/>
</svg>
Export Excel
</a>

</div>

<div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
      <thead class="text-xs text-gray-50 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-50">
        <tr class="bg-indigo-500">
          <th scope="col" class="px-6 py-3" v-for="header in ['id','eje','nombre','circuito']">
             <div class="flex items-center uppercase">
                {{header}}
                <a href="#" :key="'link-'+header" @click="toggleOrder(header)"><svg class="w-3 h-3 ml-1.5" 
                  :class="{
                    'fill-red-500': form.orderColumn==header
                }"
                aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                <path d="M8.574 11.024h6.852a2.075 2.075 0 0 0 1.847-1.086 1.9 1.9 0 0 0-.11-1.986L13.736 2.9a2.122 2.122 0 0 0-3.472 0L6.837 7.952a1.9 1.9 0 0 0-.11 1.986 2.074 2.074 0 0 0 1.847 1.086Zm6.852 1.952H8.574a2.072 2.072 0 0 0-1.847 1.087 1.9 1.9 0 0 0 .11 1.985l3.426 5.05a2.123 2.123 0 0 0 3.472 0l3.427-5.05a1.9 1.9 0 0 0 .11-1.985 2.074 2.074 0 0 0-1.846-1.087Z"/>
            </svg></a>
        </div>
    </th>

    <th scope="col" class="px-6 py-3">
     <div class="flex items-center uppercase text-xs">
        Cantidad de Parroquias
        <a href="#" @click="toggleOrder('parroquias_count')"><svg class="w-3 h-3 ml-1.5" 
          :class="{
            'fill-red-500': form.orderColumn=='parroquias_count'
        }"
        aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
        <path d="M8.574 11.024h6.852a2.075 2.075 0 0 0 1.847-1.086 1.9 1.9 0 0 0-.11-1.986L13.736 2.9a2.122 2.122 0 0 0-3.472 0L6.837 7.952a1.9 1.9 0 0 0-.11 1.986 2.074 2.074 0 0 0 1.847 1.086Zm6.852 1.952H8.574a2.072 2.072 0 0 0-1.847 1.087 1.9 1.9 0 0 0 .11 1.985l3.426 5.05a2.123 2.123 0 0 0 3.472 0l3.427-5.05a1.9 1.9 0 0 0 .11-1.985 2.074 2.074 0 0 0-1.846-1.087Z"/>
    </svg></a>
</div>
</th>
<th scope="col" class="px-6 py-3">
 <div class="flex items-center uppercase text-xs">
    Cantidad de Centros Electorales
    <a href="#" @click="toggleOrder('centros_electorales_count')"><svg class="w-3 h-3 ml-1.5" 
      :class="{
        'fill-red-500': form.orderColumn=='centros_electorales_count'
    }"
    aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
    <path d="M8.574 11.024h6.852a2.075 2.075 0 0 0 1.847-1.086 1.9 1.9 0 0 0-.11-1.986L13.736 2.9a2.122 2.122 0 0 0-3.472 0L6.837 7.952a1.9 1.9 0 0 0-.11 1.986 2.074 2.074 0 0 0 1.847 1.086Zm6.852 1.952H8.574a2.072 2.072 0 0 0-1.847 1.087 1.9 1.9 0 0 0 .11 1.985l3.426 5.05a2.123 2.123 0 0 0 3.472 0l3.427-5.05a1.9 1.9 0 0 0 .11-1.985 2.074 2.074 0 0 0-1.846-1.087Z"/>
</svg></a>
</div>
</th>
<th scope="col" class="px-6 py-3">
 <div class="flex items-center uppercase text-xs">
    Cantidad de Electores
    <a href="#" @click="toggleOrder('sum_electores')"><svg class="w-3 h-3 ml-1.5" 
      :class="{
        'fill-red-500': form.orderColumn=='sum_electores'
    }"
    aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
    <path d="M8.574 11.024h6.852a2.075 2.075 0 0 0 1.847-1.086 1.9 1.9 0 0 0-.11-1.986L13.736 2.9a2.122 2.122 0 0 0-3.472 0L6.837 7.952a1.9 1.9 0 0 0-.11 1.986 2.074 2.074 0 0 0 1.847 1.086Zm6.852 1.952H8.574a2.072 2.072 0 0 0-1.847 1.087 1.9 1.9 0 0 0 .11 1.985l3.426 5.05a2.123 2.123 0 0 0 3.472 0l3.427-5.05a1.9 1.9 0 0 0 .11-1.985 2.074 2.074 0 0 0-1.846-1.087Z"/>
</svg></a>
</div>
</th>

</tr>
</thead>

<tbody v-show="loading">
  <div role="status">
      <icon name="loading"/>
      <span class="sr-only">Loading...</span>
  </div>
</tbody>

<tbody v-show="!loading">
  <tr class="bg-white border-b dark:bg-gray-900 dark:border-gray-700"
  v-for="municipio in municipios.data" :key="municipio.id"
  >
  <td class="px-6 py-4">
    {{municipio.id}}
</td>
<td class="px-6 py-4 uppercase">
    {{municipio.eje}}
</td>
<td class="px-6 py-4">
    {{municipio.nombre}}
</td>
<td class="px-6 py-4">
    {{municipio.circuito}}
</td>
<td class="px-6 py-4">
    {{municipio.parroquias_count}}
</td>
<td class="px-6 py-4">
    {{municipio.centros_electorales_count}}
</td>
<td class="px-6 py-4">
    {{municipio.sum_electores}}
</td>
</tr>
</tbody>
</table>
<pagination class="mt-6" :links="municipios.links" :total="municipios.total" :from="municipios.from" :to="municipios.to"/>
</div>
</template>

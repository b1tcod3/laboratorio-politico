<script setup>
  import Layout from '@/Layouts/MainLayout.vue';
  import { Head, Link } from '@inertiajs/vue3';
  import { columnsTable } from '@/Data/Table/columns-table';
  import ContainerTable from '@/Components/Table/ContainerDataTable.vue';
  import Icon from '@/Components/Icon/Icon.vue';


  defineOptions({ layout: Layout })

  const props = defineProps({
    municipio: {
        type: Object,
    },
    parroquias:{
      type: Object
    },
    data:{
      type: Array
    }
  });

  const centros_electorales_sum = props.parroquias.map(
                                  (parroquia) => parroquia.centros_electorales_count
                                  ).reduce((acc, curr) => acc + curr, 0);
</script>

<template>
  <Head :title="'Municipios: '+municipio.nombre" />

  <section class="bg-white dark:bg-gray-900">
    <div class="max-w-screen-xl px-4 py-8 mx-auto text-center lg:py-16 lg:px-6">
        <dl class="grid max-w-screen-md gap-8 mx-auto text-gray-900 sm:grid-cols-3 dark:text-white">
            <div class="flex flex-col items-center justify-center">
                <dt class="mb-2 text-3xl md:text-4xl font-extrabold">{{municipio.nombre}}</dt>
                <dd class="font-light text-gray-500 dark:text-gray-400">Nombre del municipio</dd>
            </div>
            <div class="flex flex-col items-center justify-center">
                <dt class="mb-2 text-3xl md:text-4xl font-extrabold">{{data.eje}}</dt>
                <dd class="font-light text-gray-500 dark:text-gray-400">
                  Eje
                </dd>
            </div>
            <div class="flex flex-col items-center justify-center">
                <dt class="mb-2 text-3xl md:text-4xl font-extrabold">{{parroquias.length}}</dt>
                <dd class="font-light text-gray-500 dark:text-gray-400">Cantidad de Parroquias</dd>
            </div>
            <div class="flex flex-col items-center justify-center">
                <dt class="mb-2 text-3xl md:text-4xl font-extrabold">{{centros_electorales_sum}}</dt>
                <dd class="font-light text-gray-500 dark:text-gray-400">Cantidad de Centros Electorales</dd>
            </div>
        </dl>
    </div>
  </section>

  <container-table name="Parroquias" 
  >

  <template #headings>
   <tr>
    <th v-for="column in columnsTable.columns_parroquia">
      <span class="flex items-center">
        {{column.name}}
      </span>
    </th>
  </tr>
</template>
  <template #rows>
    <tr v-for="parroquia in parroquias">
      <td class="font-medium text-gray-900 whitespace-nowrap dark:text-white">{{parroquia.id}}</td>
      <td>{{parroquia.eje}}</td>
      <td>{{parroquia.nombre}}</td>
      <td>{{parroquia.nombre}}</td>
      <td>{{parroquia.centros_electorales_count}}</td>
    </tr>
  </template>
</container-table>

<Link :href="route('municipios.index')" 
class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 mt-3"
>
  <icon name="arrow-left" class="text-white"/>
  Ir a Municipios
</Link>
</template>
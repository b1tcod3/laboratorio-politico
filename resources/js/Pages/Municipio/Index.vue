<script setup>
  import DropdownRadioButton from '@/Components/Dropdown/DropdownRadioButton.vue';
  import Layout from '@/Layouts/MainLayout.vue';
  import pickBy from 'lodash/pickBy'
  import SkeletonTable from '@/Components/Skeleton/SkeletonTable.vue'
  import ExcelIcon from '@/Components/Icon/ExcelIcon.vue'
  import sortedColumn from '@/Components/Table/SortedColumn.vue';
  import ContainerTable from '@/Components/Table/ContainerTable.vue';
  import throttle from 'lodash/throttle'
  import { Head, useForm, Link, router } from '@inertiajs/vue3';
  import { initDropdowns } from 'flowbite'
  import { ref, watch, onMounted } from 'vue';
  import { columnsTable } from '@/Data/Table/columns-table';
  import { optionsTable } from '@/Data/Table/options-table'

  defineOptions({ layout: Layout })

  const props = defineProps({
    municipios: {
        type: Object,
    },
    numberRows: {
      type: Number
    },
    dataSort: {
      type: String
    },
    filters: {
      type: Object
    },
    ejes: {
      type: Array
    }
  });

  const form = useForm({
      numberRows: props.numberRows,
      columnSort: props.dataSort.columnSort,
      typeSort: props.dataSort.typeSort,
      search: props.filters.search,
      eje: props.filters.eje??''
  });

  watch(
  () => form.search,
    throttle(function (search) {
          updateTable();
        }, 500),
  { deep: true }
);

  const loading = ref(false);

  const updateTable = () => {
      loading.value = true;
      form.get(route('municipios.index'), pickBy(form), { preserveState: true,
          onFinish: () => {
            loading.value=false;
          }
        })
      };

    const sortColumn = (column) => {

      var type = form.typeSort==='asc'?'desc':'asc';
      form.typeSort = column != form.columnSort ? 'asc' : type ;
      form.columnSort = column;

      updateTable();
      };

    onMounted(() => {
      initDropdowns();
    });

</script>

<template>
  <Head title="Municipios" />

  <container-table name="Municipios" :links="municipios" :isEmpty="municipios.data.length===0">
  <template #widget>
    <dropdown-radio-button 
        v-model="form.numberRows"
        :options="optionsTable.option_number_rows"
        name-element="rows"
        name="rows"
        @change="updateTable"
    />

    <div class="grid gap-4 sm:grid-cols-3 sm:gap-6 mx-4">
      <div>
                  <select id="eje" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" v-model="form.eje" @change="updateTable">
                      <option disabled value="">Selecciona Eje</option>
                      <option :value="id" v-for="(eje,id) in ejes">{{eje}}</option>
                  </select>
      </div>
      <div>
        <a 
        :href="route('exports.municipios.index', pickBy(form))"
        target="_BLANK">
          <ExcelIcon class="w-10"/>
        </a>
      </div>
    </div>

        <label for="table-search" class="sr-only">Search</label>
        <div class="relative">
            <div class="absolute inset-y-0 left-0 rtl:inset-r-0 rtl:right-0 flex items-center ps-3 pointer-events-none">
                <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path></svg>
            </div>
            <input type="text" id="table-search" class="block p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Filtrar Municipio" v-model="form.search">
        </div>
  </template>

  <template #columns>
    <th scope="col" class="px-6 py-3"
    v-for="column in columnsTable.columns_municipio"
    >
      <sorted-column @clickColumn="sortColumn" 
    :column="column" :active="form.columnSort==column.id"/>

    </th>
    <th scope="col" class="px-6 py-3">
      Opciones
    </th> 
  </template>

  <template #body>
    <tbody v-show="!loading">
            
            <tr v-for="municipio in municipios.data" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                <td class="px-6 py-4">
                    {{municipio.id}}
                </td>
                <td class="px-6 py-4">
                    {{municipio.nombre}}
                </td>
                <td class="px-6 py-4">
                    {{municipio.parroquias_count}}
                </td>
                <td class="px-6 py-4">
                    {{municipio.centros_electorales_count}}
                </td>
                <td class="px-6 py-4">
                    {{municipio.eje}}
                </td>
                <td class="px-6 py-4">
                    <Link :href="route('municipios.show',{municipio:municipio})" type="button" class="px-3 py-2 text-xs font-medium text-center text-white bg-purple-700 rounded-lg hover:bg-purple-800 focus:ring-4 focus:outline-none focus:ring-purple-300 dark:bg-purple-600 dark:hover:bg-purple-700 dark:focus:ring-purple-800">Ver</Link>

                </td>
            </tr>
      
        </tbody>
        <div v-show="loading">
          <skeleton-table />
        </div>
  </template>
</container-table>
</template>
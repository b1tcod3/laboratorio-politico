<script setup>

  import Icon from '@/Components/Icon/Icon.vue'
  import Layout from '@/Layouts/MainLayout.vue';
  import mapValues from 'lodash/mapValues'
  import Pagination from '@/Components/Pagination.vue'
  import pickBy from 'lodash/pickBy'
  import SearchFilter from '@/Components/SearchFilter.vue'
  import throttle from 'lodash/throttle'
  import { FwbDropdown, FwbListGroup, FwbListGroupItem } from 'flowbite-vue'
  import { Head, Link } from '@inertiajs/vue3'
  import { ref, watch } from 'vue'
  import { useForm } from '@inertiajs/vue3'


  defineOptions({ layout: Layout })

  const loading = ref(false);

  const props = defineProps({
    filters: Object,
    dataSort: Object,
    rows: Object,
    count_rows: Number,
    name: String,
    routeName: String,
    fields: Array,
    buttonsActions: Array
  });

  const form = useForm({
          search: props.filters.search,
          orderColumn: props.dataSort.orderColumn,
          orderType: props.dataSort.orderType,
          count_rows: props.count_rows
  });

  watch(
  () => form.search,
    throttle(function (search) {
          updateTable();
        }, 150),
  { deep: true }
);

  const updateTable = (column) => {
      loading.value = true;
      form.get(props.routeName, pickBy(form), { preserveState: true,
          onFinish: () => {
            loading.value=false;
          }
        })
      };

  const toggleOrder = (column) => {
      if(column!=form.orderColumn){
          form.orderColumn = column;
          form.orderType = 'asc';
        }else
        {
          if(form.orderType== 'asc'){
            form.orderType = 'desc';  
          }
          else{
            form.orderColumn = '';
            form.orderType = 'asc';
          }
        }
        updateTable();
      };

  const updateCountRows = (count_rows) => {
        form.count_rows = count_rows;  
        updateTable();
      };
  const reset = () => {
        form.search = null;
      };

</script>

<template>
  <div>
    <Head title="Municipios" />
    <h1 class="mb-8 text-3xl font-bold">{{name}}</h1>
    <div class="flex items-center justify-between mb-6">

      <FwbDropdown :text="form.count_rows+' Rows'">
        <FwbListGroup>
          <FwbListGroupItem v-for="i in [5,10,15,25,50,100]" key="i" @click="updateCountRows(i)">
            <template #prefix >

            </template>
            {{i}} Rows
          </FwbListGroupItem>
        </FwbListGroup>
      </FwbDropdown>

      <search-filter v-model="form.search" class="mr-4 w-full max-w-md" @reset="reset">
      </search-filter>

      <a as="button" class="text-green-900 bg-green-200 hover:bg-green-100 border border-green-200 focus:ring-4 focus:outline-none focus:ring-green-100 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:focus:ring-green-600 dark:bg-green-800 dark:border-green-700 dark:text-white dark:hover:bg-green-700 mr-2 mb-2"
      :href="route('api.municipios',{'search':form.search,'orderColumn':form.orderColumn,'orderType':form.orderType,
        'count_rows':form.count_rows
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


  </div>

  <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
      <thead class="text-xs text-gray-50 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-50">
        <tr class="bg-indigo-500">
              <th scope="col" class="px-6 py-3" v-for="field in fields" :key='field.id'>
               <div class="flex items-center uppercase">
                {{field.name_display}}
                <a href="#" :key="'link-'+field.id" @click="toggleOrder(field.name)">
                    <svg class="w-3 h-3 ml-1.5" 
                    :class="{
                        'fill-red-500': form.orderColumn==field.name
                    }"
                    aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M8.574 11.024h6.852a2.075 2.075 0 0 0 1.847-1.086 1.9 1.9 0 0 0-.11-1.986L13.736 2.9a2.122 2.122 0 0 0-3.472 0L6.837 7.952a1.9 1.9 0 0 0-.11 1.986 2.074 2.074 0 0 0 1.847 1.086Zm6.852 1.952H8.574a2.072 2.072 0 0 0-1.847 1.087 1.9 1.9 0 0 0 .11 1.985l3.426 5.05a2.123 2.123 0 0 0 3.472 0l3.427-5.05a1.9 1.9 0 0 0 .11-1.985 2.074 2.074 0 0 0-1.846-1.087Z"/>
                    </svg>
                </a>
            </div>
            </th>
            <th scope="col" class="px-6 py-3" v-if="buttonsActions">
              
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
      v-for="row in rows.data" :key='row.id'
      >
      <td class="px-6 py-4" v-for="field in fields" :key='field.id'>
        {{row[field.name]}}
      </td>
      <td class="px-6 py-4" v-if="buttonsActions">
        
        <Link v-if="buttonsActions.includes('show')" class="flex items-center px-4" :href="`${routeName}${row['id']}`" tabindex="-1">
              <icon name="eye" class="block w-6 h-6 fill-blue-400" />
        </Link>
      </td>
    </tr>
  </tbody>
</table>
<pagination class="mt-6" :links="rows.links" :total="rows.total" :from="rows.from" :to="rows.to"/>
</div>

</template>

<template>
  <div>
    <Head title="Personas" />
    <h1 class="mb-8 text-3xl font-bold">Buscar Personas</h1>
    <div class="flex items-center justify-between mb-6">

  <select id="municipios" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
  v-model="municipio" @change="form.centro_electoral=''"
  >
    <option value="">Todos los Municipio</option>
    <option :value="municipio" v-for="municipio in municipios">{{municipio}}</option>
  </select>

  <select id="parroquias" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
  v-model="form.parroquia" :disabled="form.municipio==''"
  @change="form.centro_electoral=''">
    <option value="">Todos las parroquias</option>
    <option :value="parroquia.id" v-for="parroquia in parroquias[municipio]">{{parroquia.parroquia_nombre}}</option>
  </select>

  <select id="sexo" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
  v-model="form.sexo"
  >
    <option value="">Seleccione</option>
    <option :value="sexo.id" v-for="sexo in sexos">{{sexo.name}}</option>
  </select>

<select id="centro-electoral" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
  v-model="form.centro_electoral"
  >
    <option value="">Seleccione</option>
    <option :value="centroElectoral.id" v-for="centroElectoral in centrosElectorales">{{centroElectoral.nombre}}</option>
  </select>

      <search-filter v-model="form.search" class="mr-4 w-full max-w-md" @reset="reset">
      </search-filter>

      <a as="button" class="text-green-900 bg-green-200 hover:bg-green-100 border border-green-200 focus:ring-4 focus:outline-none focus:ring-green-100 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:focus:ring-green-600 dark:bg-green-800 dark:border-green-700 dark:text-white dark:hover:bg-green-700 mr-2 mb-2"
      :href="route('api.personas',{'search':form.search,
        'rows':form.rows,'parroquia':form.parroquia,
        'sexo':form.sexo
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
        <th scope="col" class="px-6 py-3" v-for="header in ['id','nombres','apellidos','sexo','fecha nacimiento','edad','municipio','parroquia','centro electoral']">
         <div class="flex items-center uppercase">
          {{header}}
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
    v-for="persona in personas.data" :key="persona.id"
    >
    <td class="px-6 py-4">
      {{persona.id}}
    </td>
    <td class="px-6 py-4">
      {{persona.nombres}}
    </td>
    <td class="px-6 py-4">
      {{persona.apellidos}}
    </td>
    <td class="px-6 py-4">
      {{persona.sexo}}
    </td>
    <td class="px-6 py-4">
        {{persona.fecha_nacimiento}}
    </td>
    <td class="px-6 py-4">
        {{persona.edad}} años
    </td>
    <td class="px-6 py-4">
        {{persona.municipio}}
    </td>
    <td class="px-6 py-4">
        {{persona.parroquia}}
    </td>
    <td class="px-6 py-4">
        {{persona.centro_electoral}}
    </td>
  </tr>
</tbody>
</table>
<pagination class="mt-6" :links="personas.links" :total="personas.total" :from="personas.from" :to="personas.to"/>
</div>

</template>

<script>
  import { Head, Link } from '@inertiajs/vue3'
  import Icon from '@/Components/Icon/Icon.vue'
  import pickBy from 'lodash/pickBy'
  import Layout from '@/Layouts/MainLayout.vue'
  import throttle from 'lodash/throttle'
  import mapValues from 'lodash/mapValues'
  import Pagination from '@/Components/Pagination.vue'
  import SearchFilter from '@/Components/SearchFilter.vue'

  export default {
    components: {
      Head,
      Icon,
      Link,
      Pagination,
      SearchFilter
    },
    layout: Layout,
    props: {
      filters: Object,
      personas: Object,
      parroquias: Object,
      rows: Number,
      municipios: Object,
      centrosElectorales: Object
    },
    data() {
      return {
        form: {
          search: this.filters.search,
          parroquia: this.filters.parroquia?this.filters.parroquia:101,
          centro_electoral: this.filters.centro_electoral?this.filters.parroquia:'',
          rows: this.rows,
          sexo: this.filters.sexo,
        },
        loading: false,
        municipio: this.filters.municipio?this.filters.municipio:"ACOSTA",
        sexos : [{id:1,name:'F'},
                {id:2,name:'M'}]
      }
    },
    watch: {
      form: {
        deep: true,
        handler: throttle(function () {
          
          this.updateTable()
        }, 150),
      },
    },
    methods: {
      reset() {
        this.form = mapValues(this.form, () => null)
      },
      updateRows(rows) {
        this.form.rows = rows;  
        this.updateTable()
      },
      updateTable() {
        this.loading = true;
        this.$inertia.get('/personas', pickBy(this.form), { preserveState: true,
          onFinish: () => this.loading=false })
      },
    },
  }
</script>
<template>
  <div>
    <Head title="Buscar Persona" />
    <h1 class="mb-8 text-3xl font-bold">Buscar Personas</h1>
    <div class="flex items-center justify-between mb-6">
      <div>
        <label for="default-input" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Municipio</label>
        <select id="municipios" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
      v-model="form.municipio" @change="form.centro_electoral='';form.parroquia=''"
      >
      <option value="">Todos los Municipio</option>
      <option :value="municipio" v-for="municipio in municipios">{{municipio}}</option>
        </select>
      </div>
      
<div>
        <label for="default-input" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Parroquia</label>
    <select id="parroquias" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
    v-model="form.parroquia" :disabled="form.municipio==''"
    @change="form.centro_electoral=''">
    <option value="">Todos las parroquias</option>
    <option :value="parroquia.id" v-for="parroquia in parroquias[form.municipio]">{{parroquia.parroquia_nombre}}</option>
  </select>
</div>

<div>
        <label for="default-input" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Centro Electoral</label>
  <select id="centro-electoral" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
  v-model="form.centro_electoral"
  >
  <option value="">Seleccione</option>
  <option :value="centro_electoral.centro_electoral_id" v-for="centro_electoral in centrosElectorales[form.parroquia]">{{centro_electoral.nombre}}</option>
</select>
</div>

<div>
        <label for="default-input" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Sexo</label>
<select id="sexo" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
v-model="form.sexo"
>
<option value="">Seleccione</option>
<option :value="sexo.id" v-for="sexo in sexos">{{sexo.name}}</option>
</select>
</div>
</div>

<div class="flex items-center justify-between mb-6">
  <div class="mb-6">
    <label for="default-input" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Cédula</label>
    <input type="number" id="default-input" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
    v-model="form.cedula"
    >
  </div>
  <div class="mb-6">
    <label for="default-input" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nombres</label>
    <input type="text" id="default-input" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
    v-model="form.nombres"
    >
  </div>
  <div class="mb-6">
    <label for="default-input" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Apellidos</label>
    <input type="text" id="default-input" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
    v-model="form.apellidos"
    >
  </div>

  <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing" @click="updateTable">
                    Buscar
  </PrimaryButton>

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
  import Icon from '@/Components/Icon/Icon.vue'
  import InputError from '@/Components/InputError.vue';
  import InputLabel from '@/Components/InputLabel.vue';
  import Layout from '@/Layouts/MainLayout.vue'
  import mapValues from 'lodash/mapValues'
  import Pagination from '@/Components/Pagination.vue'
  import pickBy from 'lodash/pickBy'
  import PrimaryButton from '@/Components/PrimaryButton.vue';
  import SearchFilter from '@/Components/SearchFilter.vue'
  import throttle from 'lodash/throttle'
  import { Dropdown, ListGroup, ListGroupItem } from 'flowbite-vue'
  import { Head, Link } from '@inertiajs/vue3'

  export default {
    components: {
      Head,
      Icon,
      Link,
      Pagination,
      SearchFilter,
      Dropdown,
      ListGroup,
      ListGroupItem,
      InputError,
      InputLabel,
      PrimaryButton
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
          nombres: this.filters.nombres,
          apellidos: this.filters.apellidos,
          cedula: this.filters.cedula,
          municipio: this.filters.municipio?this.filters.municipio:'',
          parroquia: this.filters.parroquia?this.filters.parroquia:'',
          centro_electoral: this.filters.centro_electoral?this.filters.centro_electoral:'',
          rows: this.rows,
          sexo: this.filters.sexo,
        },
        loading: false,
        sexos : [{id:1,name:'F'},
        {id:2,name:'M'}]
      }
    },
    
    methods: {
      reset() {
        this.form = mapValues(this.form, () => null)
      },
      updateTable() {
        this.loading = true;
        this.$inertia.get('/buscar/persona', pickBy(this.form), { preserveState: true,
          onFinish: () => this.loading=false })
      },
    },
  }
</script>
<script setup>

  import ButtonSimple from '@/Components/Button/ButtonSimple.vue';
  import DangerButton from '@/Components/DangerButton.vue';
  import VotoCalleForm from '@/Pages/VotoCalle/Partials/VotoCalleForm.vue';
  import Icon from '@/Components/Icon/Icon.vue'
  import InputError from '@/Components/InputError.vue';
  import InputLabel from '@/Components/InputLabel.vue';
  import Layout from '@/Layouts/MainLayout.vue';
  import mapValues from 'lodash/mapValues'
  import Modal from '@/Components/Modal.vue';
  import Pagination from '@/Components/Pagination.vue'
  import pickBy from 'lodash/pickBy'
  import PrimaryButton from '@/Components/PrimaryButton.vue';
  import SearchFilter from '@/Components/SearchFilter.vue'
  import SecondaryButton from '@/Components/SecondaryButton.vue';
  import SelectForm from '@/Components/Form/SelectForm.vue';
  import Swal from 'sweetalert2'
  import TextInput from '@/Components/TextInput.vue';
  import throttle from 'lodash/throttle'
  import { FwbDropdown, FwbListGroup, FwbListGroupItem } from 'flowbite-vue'
  import { Head, Link } from '@inertiajs/vue3'
  import { ref, watch } from 'vue'
  import { useForm, router} from '@inertiajs/vue3';



  defineOptions({ layout: Layout })

  const loading = ref(false);
  const showModal = ref(false);
  const voto = ref(null);

  const props = defineProps({
    filters: Object,
    dataSort: Object,
    votos: Object,
    count_rows: Number,
    cargos: Object,
    tipo_voto: Object,
    municipios: Array,
    parroquias: Array,
    hora_voto: Object,
    centros_electorales: Array,
    comunidades: Array,
    calles: Array,
    info_calle: Array,
  });

  const showModalCreate = () => {
    voto.value = null;
    showModal.value = true;
};

const showModalEdit = (v) => {
    voto.value = v;
    showModal.value = true;
};

const closeModal = () => {
    showModal.value = false;
};


  const fields = [{'id':1,'name_display':'Télefono Jefe de Familia','name':'telefono_jefe_familia'},
        {'id':2,'name_display':'Tipo de Voto','name':'tipo_voto'},
        {'id':3,'name_display':'Cédula','name':'cedula'},
        {'id':4,'name_display':'Nombre','name':'nombres'},
        {'id':5,'name_display':'Apellido','name':'apellidos'},
        {'id':6,'name_display':'Sexo','name':'sexo'},
        {'id':7,'name_display':'Teléfono','name':'telefono_movil'},
        {'id':8,'name_display':'Vota en','name':'ubch'}
    ]

  const form = useForm({
          orderColumn: props.dataSort.orderColumn,
          orderType: props.dataSort.orderType,
          count_rows: props.count_rows,
          nombres: props.filters.nombres,
          apellidos: props.filters.apellidos,
          cedula: props.filters.cedula,
          sexo: props.filters.sexo,
          municipio: props.filters.municipio,
          parroquia: props.filters.parroquia,
          centro_electoral: props.filters.centro_electoral,
          comunidad: props.filters.comunidad,
          calle: props.filters.calle,
          info_calle: props.info_calle,
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
      form.get('/votos_calle', pickBy(form), { preserveState: true,
          onFinish: () => {
            loading.value=false;
          }
        })
      };

  const deleteVoto = (voto) => {
    
   const swalDelete = Swal.mixin({
  buttonsStyling: true
});

    swalDelete.fire({
  title: '¿Confirmar Eliminar Voto? '+voto.nombres+" "+voto.apellidos+"("+voto.id+")",
  text: "Esta acción no se puede revertir",
  icon: 'question',
  showCancelButton: true,
  confirmButtonText: 'Si. Estoy Seguro',
  cancelButtonText: 'No. Es un error',
  reverseButtons: true
}).then((result) => {
  if (result.isConfirmed) {
    swalDelete.fire(
      'Excelente!',
      'Voto Eliminado con éxito',
      'success'
    );
    router.delete(route('votos_calle.destroy',voto.id),{
      onSuccess: () => console.log('borrado:'+voto.id),
    });

  } else if (
    /* Read more about handling dismissals below */
    result.dismiss === Swal.DismissReason.cancel
  ) {
    swalDelete.fire(
      'Cancelled',
      'revisa bien la próxima vez',
      'error'
    )
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
        form.nombres= null;
        form.apellidos= null;
        form.cedula= null;
        form.sexo= null
      };

</script>

<template>
  <div>
    <Head title="Registro Voto Calle" />
    <h1 class="mb-8 text-3xl font-bold">Registro Voto Calle</h1>
    <div class="flex items-center justify-between mb-6">

      <!-- CANTIDAD DE REGISTROS -->
      <FwbDropdown :text="form.count_rows+' Filas'">
        <FwbListGroup>
          <FwbListGroupItem v-for="i in [5,10,15,25,50,100]" key="i" @click="updateCountRows(i)">
            <template #prefix >

            </template>
            {{i}} Rows
          </FwbListGroupItem>
        </FwbListGroup>
      </FwbDropdown>

      <!-- FILTROS -->

<div class="grid gap-6 mb-6 md:grid-cols-3">
  
  <SelectForm label="Municipio" v-model="form.municipio" :options="municipios" nameOption="nombre"
            :error="form.errors.municipio" @change="form.parroquia='';form.centro_electoral='';form.comunidad='';form.calle='';updateTable()"
            />
  <SelectForm label="Parroquia" v-model="form.parroquia" :options="parroquias[form.municipio]" nameOption="parroquia_nombre"
            :error="form.errors.parroquia" @change="form.centro_electoral='';form.comunidad='';updateTable();form.comunidad='';form.calle=''"
            :disabled="form.municipio==''"
            />
  <SelectForm label="UBCH" v-model="form.centro_electoral" :options="centros_electorales[form.parroquia]" nameOption="centro_electoral_nombre"
            :error="form.errors.centro_electoral" @change="form.comunidad='';form.calle='';updateTable()"
            :disabled="form.parroquia==''"
            />
  <SelectForm label="COMUNIDAD" v-model="form.comunidad" :options="comunidades[form.centro_electoral]" nameOption="comunidad_nombre"
            :error="form.errors.comunidad" @change="form.calle='';updateTable()"
            :disabled="form.centro_electoral==''"
            />
  <SelectForm label="CALLE" v-model="form.calle" :options="calles[form.comunidad]" nameOption="calle_nombre"
            :error="form.errors.calle" @change="updateTable"
            :disabled="form.comunidad==''"
            />
  <div >
    <label for="default-input" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Cédula</label>
    <input type="number" id="default-input" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
    v-model="form.cedula"
    >
  </div>
  <div >
    <label for="default-input" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nombres</label>
    <input type="text" id="default-input" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
    v-model="form.nombres"
    >
  </div>
  <div >
    <label for="default-input" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Apellidos</label>
    <input type="text" id="default-input" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
    v-model="form.apellidos"
    >
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

  <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing" @click="updateTable">
                    Buscar
  </PrimaryButton>

  <SecondaryButton @click="reset()"> reset </SecondaryButton>
</div>


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

  <div v-if="info_calle" class="relative overflow-x-auto shadow-md sm:rounded-lg" >
    <button-simple @click="showModalCreate" color="blue">
                    Nuevo Voto
    </button-simple>

    <section class="bg-white dark:bg-gray-900">
  <div class="max-w-screen-xl px-4 py-8 mx-auto text-center lg:py-16 lg:px-6">
      <dl class="grid max-w-screen-md gap-8 mx-auto text-gray-900 sm:grid-cols-3 dark:text-white">
          <div class="flex flex-col items-center justify-center">
              <dt class="mb-2 text-2xl md:text-2xl font-extrabold">{{info_calle.jefe_calle ?? 'SIN DEFINIR'}}</dt>
              <dd class="font-light text-gray-500 dark:text-gray-400">Jefe de Calle</dd>
          </div>
          <div class="flex flex-col items-center justify-center">
              <dt class="mb-2 text-2xl md:text-2xl font-extrabold">{{info_calle.telefono ?? 'SIN DEFINIR'}}</dt>
              <dd class="font-light text-gray-500 dark:text-gray-400">Teléfono</dd>
          </div>
          <div class="flex flex-col items-center justify-center">
              <dt class="mb-2 text-3xl md:text-4xl font-extrabold">{{info_calle.total_votos}}</dt>
              <dd class="font-light text-gray-500 dark:text-gray-400">Votos</dd>
          </div>
          <div class="flex flex-col items-center justify-center">
              <dt class="mb-2 text-3xl md:text-4xl font-extrabold">{{info_calle.count_votos_internos}}</dt>
              <dd class="font-light text-gray-500 dark:text-gray-400">Votos Internos</dd>
          </div>
          <div class="flex flex-col items-center justify-center">
              <dt class="mb-2 text-3xl md:text-4xl font-extrabold">{{info_calle.count_votos_externos}}</dt>
              <dd class="font-light text-gray-500 dark:text-gray-400">Votos Externos</dd>
          </div>
      </dl>
  </div>
</section>


    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
      <thead class="text-xs text-gray-50 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-50">
        <tr class="bg-indigo-500">
          <th scope="col" class="px-6 py-3" >
               <div class="flex items-center uppercase">
                ID
                <a href="#" :key="'link-id'" @click="toggleOrder('id')">
                    <svg class="w-3 h-3 ml-1.5" 
                    :class="{
                        'fill-red-500': form.orderColumn=='id'
                    }"
                    aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M8.574 11.024h6.852a2.075 2.075 0 0 0 1.847-1.086 1.9 1.9 0 0 0-.11-1.986L13.736 2.9a2.122 2.122 0 0 0-3.472 0L6.837 7.952a1.9 1.9 0 0 0-.11 1.986 2.074 2.074 0 0 0 1.847 1.086Zm6.852 1.952H8.574a2.072 2.072 0 0 0-1.847 1.087 1.9 1.9 0 0 0 .11 1.985l3.426 5.05a2.123 2.123 0 0 0 3.472 0l3.427-5.05a1.9 1.9 0 0 0 .11-1.985 2.074 2.074 0 0 0-1.846-1.087Z"/>
                    </svg>
                </a>
            </div>
            </th>
            <th scope="col" class="px-6 py-3" >
               <div class="flex items-center uppercase">
                Jefe de Familia
                <a href="#" :key="'link-id'" @click="toggleOrder('id')">
                    <svg class="w-3 h-3 ml-1.5" 
                    :class="{
                        'fill-red-500': form.orderColumn=='jefe_familia'
                    }"
                    aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M8.574 11.024h6.852a2.075 2.075 0 0 0 1.847-1.086 1.9 1.9 0 0 0-.11-1.986L13.736 2.9a2.122 2.122 0 0 0-3.472 0L6.837 7.952a1.9 1.9 0 0 0-.11 1.986 2.074 2.074 0 0 0 1.847 1.086Zm6.852 1.952H8.574a2.072 2.072 0 0 0-1.847 1.087 1.9 1.9 0 0 0 .11 1.985l3.426 5.05a2.123 2.123 0 0 0 3.472 0l3.427-5.05a1.9 1.9 0 0 0 .11-1.985 2.074 2.074 0 0 0-1.846-1.087Z"/>
                    </svg>
                </a>
            </div>
            </th>
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
            
            <th scope="col" class="px-6 py-3">
              Acciones
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
      v-for="voto in votos.data" :key='voto.id'
      >

      <td class="px-6 py-4">
        {{voto.id}}
      </td>
      <td class="px-6 py-4">
        {{voto.jefe_familia}}
      </td>

      <td class="px-6 py-4" v-for="field in fields" :key='field.id'>
        {{voto[field.name]}}
      </td>
      <td class="px-6 py-4 flex items-center ">
        
        <Link class="px-4" :href="`/votos_calle/${voto['id']}`" tabindex="-1">
              <icon name="eye" class="block w-6 h-6 fill-blue-400" />
        </Link>
        <a class="px-4" href="#" tabindex="-1"
        @click="showModalEdit(voto)"
        >
              <icon name="edit" class="block w-6 h-6 fill-green-400" />
        </a>
        <a class="px-4" href="#" tabindex="-1"
        @click="deleteVoto(voto)"
        >
              <icon name="trash" class="block w-6 h-6 fill-red-400" />
        </a>
      </td>
    </tr>
  </tbody>
</table>
<pagination :links="votos.links" :total="votos.total" :from="votos.from" :to="votos.to"/>
</div>
<div v-show="!info_calle">
  <div class="flex items-center p-4 mb-4 text-sm text-yellow-800 rounded-lg bg-yellow-50 dark:bg-gray-800 dark:text-yellow-300" role="alert">
  <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
  </svg>
  <span class="sr-only">Info</span>
  <div>
    <span class="font-medium">Atención!</span> Debes seleccionar una calle para continuar
  </div>
</div>
</div>

<Modal :show="showModal" @close="closeModal" >
       <VotoCalleForm @closeModal="closeModal" :miembro="miembro" :cargos="cargos" :municipios="municipios" :municipio="form.municipio" :parroquias="parroquias" :parroquia="form.parroquia" :centros_electorales="centros_electorales" :centro_electoral="form.centro_electoral" :comunidades="comunidades" :comunidad="form.comunidad"
       :calles="calles" :calle="form.calle" :voto="voto" :tipo_voto="tipo_voto" :hora_voto="hora_voto"/>
</Modal>


</template>

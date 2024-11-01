<script setup>
	import Layout from '@/Layouts/MainLayout.vue';
	import { Head, Link, useForm } from '@inertiajs/vue3';
  import { ref , provide, onMounted } from 'vue'
  import SimpleTable from '@/Components/Table/SimpleTable.vue';
  import Modal from '@/Components/Modal.vue';
  import Icon from '@/Components/Icon/Icon.vue';
  import FormCreate from '@/Pages/Estructura/Partials/FormCreate.vue';
  import FormEdit from '@/Pages/Estructura/Partials/FormEdit.vue';
  import Swal from 'sweetalert2';
  import { initTabs } from 'flowbite';
  

    defineOptions({ layout: Layout });

    const openModalCreateEstructura = ref(false);
    const openModalEditEstructura = ref(false);
    const estructura = ref(null);
    const nivelSelected = ref('REGIONAL');

    provide('openCreateModal',openModalCreateEstructura);
    provide('openEditModal',openModalEditEstructura);

    const props = defineProps({
        organizacion: {
            type: Object,
        },
        niveles_estructura:{
          type: Array
        },
        estructuras:{
          type: Array
        },

    });

    const form = useForm({
  organizacione: props.organizacion.id,
})

    const openFormEditEstructura = (e) => {
      estructura.value = e;
      openModalEditCargo.value = true;
    }

    const confirmDelete = () => {
      Swal.fire({
  title: "¿Estas seguro de eliminarlo?",
  text: "No puedes restaurarlo uno vez eliminado",
  icon: "warning",
  showCancelButton: true,
  confirmButtonColor: "#3085d6",
  cancelButtonColor: "#d33",
  confirmButtonText: "Si!"
}).then((result) => {
  if (result.isConfirmed) {
    Swal.fire({
      title: "Eliminado!",
      text: "Tu has borrado la organización.",
      icon: "success"
    });

    form.delete(route('organizaciones.destroy',{organizacione: props.organizacion.id}));

  }
});
    };

const headersEstructura = ['ID','Nombre','Nivel','Área','OPCS'];

onMounted(() => {
      initTabs();
    });

</script>

<template>
	<Head title="Organización" />
    <h2 class="mb-4 text-4xl tracking-tight font-bold text-gray-900 dark:text-white">Organización: {{organizacion.nombre}}</h2>
    
    <section class="bg-white py-8 antialiased dark:bg-gray-900 md:py-16">
        <div class="mx-auto max-w-3xl">
          <div class="mt-6 space-y-4 border-b border-t border-gray-200 py-8 dark:border-gray-700 sm:mt-8">
            <h4 class="text-lg font-semibold text-gray-900 dark:text-white">
            Tipo: {{organizacion.tipo_organizacion.replace('_',' ')}}</h4>

            <dl>
              <dt class="text-base font-medium text-gray-900 dark:text-white">
                  Acronimo: {{organizacion.acronimo}}
              </dt>
              <dd class="mt-1 text-base font-normal text-gray-500 dark:text-gray-400">
                  Logo: 
                  <img class="w-10 h-10 rounded-full" :src="`/${organizacion.logo}`" alt="image">
                  
              </dd>
            </dl>
           </div> 
            <Link class="inline-flex justify-center items-center py-3 px-5 text-base font-medium bg-blue-200 text-center text-gray-900 rounded-lg border border-gray-300 hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 dark:text-white dark:border-gray-700 dark:hover:bg-gray-700 dark:focus:ring-gray-800 mr-3"
            :href="route('organizaciones.edit',{organizacione:organizacion.id})"
            >Edit</Link>

            <Link :href="route('organizaciones.index')" class="inline-flex justify-center items-center py-3 px-5 text-base font-medium text-center text-gray-900 rounded-lg border border-gray-300 hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 dark:text-white dark:border-gray-700 dark:hover:bg-gray-700 dark:focus:ring-gray-800 ml-2">
                    <Icon name="arrow-left" />
                    Ver Organizaciones
            </Link>
            
            <button class="inline-flex bg-red-300 justify-center items-center py-3 px-5 text-base font-medium text-center text-gray-900 rounded-lg border border-red-300 hover:bg-red-100 focus:ring-4 focus:ring-red-100 dark:text-white dark:border-red-700 dark:hover:bg-red-700 dark:focus:ring-red-800 ml-2"
            @click="confirmDelete"
            >
                    <Icon name="trash" />    
                    Borrar
            </button>
          
        </div>
    </section>



<div class="sm:hidden">
    <label for="tabs" class="sr-only">Seleccione el Nivel</label>
    <select id="tabs" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
    v-for="(nivel,id) in niveles_estructura"
    >
        <option :selected="nivelSelected==nivel" :value="id">{{nivel}}</option>
    </select>
</div>
<ul class="hidden text-sm font-medium text-center text-gray-500 rounded-lg shadow sm:flex dark:divide-gray-700 dark:text-gray-400">
    <li class="w-full focus-within:z-10" v-for="nivel in niveles_estructura">
        <button class="inline-block w-full p-4 text-gray-900 bg-gray-100 border-r border-gray-200 dark:border-gray-700 rounded-s-lg focus:ring-4 focus:ring-blue-300 active focus:outline-none dark:bg-gray-700 dark:text-white" aria-current="page"
        v-show="nivel===nivelSelected"
        @click="nivelSelected=nivel"
        >{{nivel.replace('_',' ')}}</button>
        <button href="#" class="inline-block w-full p-4 bg-white border-r border-gray-200 dark:border-gray-700 hover:text-gray-700 hover:bg-gray-50 focus:ring-4 focus:ring-blue-300 focus:outline-none dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700"
        v-show="nivel!=nivelSelected"
        @click="nivelSelected=nivel"
        >{{nivel.replace('_',' ')}}</button>
    </li>
</ul>


    <section class="bg-white py-2 antialiased dark:bg-gray-900 md:py-2">
      <h1 class="mb-4 text-xl tracking-tight font-bold text-gray-900 dark:text-white">Estructuras {{nivelSelected.replace('_',' ')}}</h1>

      <button @click="openModalCreateEstructura=true">
        Agregar Estructura 
      </button>

      <SimpleTable name="estructuras" :headers="headersEstructura" >
        <template #rows>
        <tr class="hover:bg-gray-50 dark:hover:bg-gray-800 cursor-pointer" v-for="e in estructuras">
                        <td class="font-medium text-gray-900 whitespace-nowrap dark:text-white">
                          {{e.id}}
                        </td>
                        <td class="font-medium text-gray-900 whitespace-nowrap dark:text-white">
                          {{e.nombre}}
                        </td>  
                        <td class="font-medium text-gray-900 whitespace-nowrap dark:text-white">
                          {{e.area}}
                        </td>

                        <td class="font-medium text-gray-900 whitespace-nowrap dark:text-white">
                          {{e.municipio}}
                        </td>
                        <td class="font-medium text-gray-900 whitespace-nowrap dark:text-white">
                          <button @click="openModalEditCargoF(c)">
                            editar
                          </button>
                        </td>  
        </tr>          
        </template>
      </SimpleTable>  
    </section> 

    
     
    
    <Modal :show="openModalCreateEstructura" @close="openModalCreateEstructura=false">
      <FormCreate :isModal="true" :organizaciones="[organizacion]"
      :niveles_estructura="niveles_estructura" :redirect="`/organizaciones/${organizacion.id}`" :indexNivel="Object.values(niveles_estructura).indexOf(nivelSelected)"
      />
    </Modal>

    <Modal :show="openModalEditCargo" @close="openModalEditCargo=false">
      <FormEdit :isModal="true" :organizaciones="[organizacion]"
      :niveles_cargo="niveles_cargo" :cargo="cargo"
      :redirect="`/organizaciones/${organizacion.id}`"
      />
    </Modal>

</template>

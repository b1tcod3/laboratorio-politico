<script setup>
	import Layout from '@/Layouts/MainLayout.vue';
	import { Head, Link, useForm } from '@inertiajs/vue3';
  import SimpleTable from '@/Components/Table/SimpleTable.vue';
  import Swal from 'sweetalert2'

    defineOptions({ layout: Layout });

    const props = defineProps({
        organizacion: {
            type: Object,
        }
    });

    const form = useForm({
  organizacione: props.organizacion.id,
})

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

</script>

<template>
	<Head title="Organización" />
    <h2 class="mb-4 text-4xl tracking-tight font-bold text-gray-900 dark:text-white">Organización: {{organizacion.nombre}}</h2>
    
    <section class="bg-white py-8 antialiased dark:bg-gray-900 md:py-16">
        <div class="mx-auto max-w-3xl">
          <h2 class="text-xl font-semibold text-gray-900 dark:text-white sm:text-2xl">Nombre: {{organizacion.nombre}}</h2>

          <div class="mt-6 space-y-4 border-b border-t border-gray-200 py-8 dark:border-gray-700 sm:mt-8">
            <h4 class="text-lg font-semibold text-gray-900 dark:text-white">
            Tipo: {{organizacion.tipo_organizacion}}</h4>

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
                        <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12l4-4m-4 4 4 4"/>
                        </svg>
                    Ver Organizaciones
            </Link>
            <button class="inline-flex justify-center items-center py-3 px-5 text-base font-medium text-center text-gray-900 rounded-lg border border-gray-300 hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 dark:text-white dark:border-gray-700 dark:hover:bg-gray-700 dark:focus:ring-gray-800 ml-2"
            @click="confirmDelete"
            >
                        <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12l4-4m-4 4 4 4"/>
                        </svg>
                    Borrar
            </button>
          
        </div>
    </section>
</template>

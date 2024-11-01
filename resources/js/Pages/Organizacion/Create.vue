<script setup>
	import Layout from '@/Layouts/MainLayout.vue';
	import { Head , Link } from '@inertiajs/vue3';
	import { useForm } from 'laravel-precognition-vue-inertia';

	defineOptions({ layout: Layout })

	const form = useForm('post', route('organizaciones.store'), {
        nombre: '',
        acronimo: '',
        logo: '',
        tipo: ''
		});

	const props = defineProps({
		tipos:
        {
            type: Object
        }
	});

	form.setValidationTimeout(3000);

	const create = () => {
    	form.submit({
        preserveScroll: true
    })
	};

</script>

<template>
	<Head title="Create Organización" />
	<div class="p-4 w-full h-full">
        <div class="p-4 bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5">
            
            <!-- header -->
            <div class="flex justify-between items-center pb-4 mb-4 rounded-t border-b sm:mb-5 dark:border-gray-600">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    Nueva Organización
                </h3>
            </div>
            <!--Body -->
            <form @submit.prevent="create">
                <div class="grid gap-4 mb-4 sm:grid-cols-2">
                    
                    <!-- Nombre de la organización -->
                    <div>
                        <label for="nombre" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nombre</label>
                        <input type="text" name="nombre" id="nombre" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Escriba nombre" required=""
                        v-model="form.nombre"
            			@change="form.validate('nombre')"
                        >

                          <p class="mt-2 text-sm text-red-600 dark:text-red-500"
                          v-if="form.invalid('nombre')|| form.errors.nombre"
                          ><span class="font-medium">Error: </span> {{ form.errors.nombre }}</p>
                    </div>

                    <!-- acronimo -->
                    <div>
                        <label for="acronimo" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Acronimo</label>
                        <input type="text" name="nombre" id="nombre" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Escriba nombre" required=""
                        v-model="form.acronimo"
                        @change="form.validate('acronimo')"
                        >

                          <p class="mt-2 text-sm text-red-600 dark:text-red-500"
                          v-if="form.invalid('acronimo')|| form.errors.acronimo"
                          ><span class="font-medium">Error: </span> {{ form.errors.acronimo }}</p>
                    </div>

                    <!-- subir archivo del logo -->
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="file_input">Subir logo</label>
                        <input class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" aria-describedby="file_input_help" id="file_input" type="file"
                        @input="form.logo = $event.target.files[0]"
                        >
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="file_input_help"
                        >SVG, PNG, JPG o GIF (MAX. 800x400px).</p>
                        <progress v-if="form.progress" :value="form.progress.percentage" max="100">
                            {{ form.progress.percentage }}%
                        </progress>

                        <p class="mt-2 text-sm text-red-600 dark:text-red-500"
                          v-if="form.invalid('logo') || form.errors.logo"
                          ><span class="font-medium">Error: </span> {{ form.errors.logo }}</p>
                    </div>
                    
                    <div>
                        <label for="tipos" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Selecciona un tipo</label>
                        <select id="tipos" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        v-model="form.tipo"
                        >
                            <option selected>tipo</option>
                            <option :value="id" v-for="(tipo,id) in tipos">{{tipo.replace('_',' ')}}</option>
                        </select>
                        <p class="mt-2 text-sm text-red-600 dark:text-red-500"
                          v-if="form.invalid('tipo')|| form.errors.tipo"
                          ><span class="font-medium">Error: </span> {{ form.errors.tipo }}</p>
                    </div>    
                </div>

                <div class="flex flex-col mb-8 lg:mb-16 space-y-4 sm:flex-row sm:justify-center sm:space-y-0 sm:space-x-4">
                    <button class="text-white inline-flex items-center bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800"
                :disabled="form.processing"
                >
                    <svg class="mr-1 -ml-1 w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path></svg>
                    Registrar Organización
                </button>

                 <Link :href="route('organizaciones.index')" class="inline-flex justify-center items-center py-3 px-5 text-base font-medium text-center text-gray-900 rounded-lg border border-gray-300 hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 dark:text-white dark:border-gray-700 dark:hover:bg-gray-700 dark:focus:ring-gray-800">
                        <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12l4-4m-4 4 4 4"/>
                        </svg>
                    Volver
                </Link> 
                </div>

            </form>
        </div>
    </div>
</template>

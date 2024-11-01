<script setup>
	import { Head , Link } from '@inertiajs/vue3';
    import { inject, ref, watch } from 'vue'
	import { useForm } from 'laravel-precognition-vue-inertia';

    const openModal = inject('openEditModal');

	const props = defineProps({
        organizaciones:
        {
            type: Array
        },
        niveles_cargo:
        {
            type: Array
        },
        cargo:
        {
            type: Object
        },
        isModal:{
            default:false
        },
        redirect:{
            type: String
        }
	});

    const cargo = ref(props.cargo);

    watch(
        () => props.cargo,
        () => { cargo.value = props.cargo }
        );

    const form = useForm('put', route('cargos.update',{cargo: cargo.value.id}), {
        nombre: cargo.value.nombre,
        organizacion_id: cargo.value.organizacion_id,
        nivel: cargo.value.nivel,
        area: cargo.value.area,
        redirect: props.redirect
    });

	form.setValidationTimeout(3000);

	const update = () => {
    	form.submit({
        onSuccess: () => openModal.value=false,             
        preserveScroll: false
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
                    Actualizar Cargo
                </h3>
            </div>
            <!--Body -->
            <form @submit.prevent="update">
                <div class="grid gap-4 mb-4 sm:grid-cols-2">
                    
                    <div class="col-span-2">
                        <label for="organizaciones" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Selecciona organización</label>
                        <select id="organizaciones" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        v-model="form.organizacion_id"
                        >
                            <option selected value="">Seleccione Uno</option>
                            <option :value="organizacion.id" v-for="organizacion in organizaciones">{{organizacion.nombre}}</option>
                        </select>
                        <p class="mt-2 text-sm text-red-600 dark:text-red-500"
                          v-if="form.invalid('organizacion_id')|| form.errors.organizacion_id"
                          ><span class="font-medium">Error: </span> {{ form.errors.organizacion_id }}</p>
                    </div>    

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

                    <div>
                        <label for="tipos" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Selecciona un nivel</label>
                        <select id="tipos" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        v-model="form.nivel"
                        >
                            <option selected value="">seleccione nivel</option>
                            <option :value="id" v-for="(nivel,id) in niveles_cargo">{{nivel.replace('_',' ')}}</option>
                        </select>
                        <p class="mt-2 text-sm text-red-600 dark:text-red-500"
                          v-if="form.invalid('nivel')|| form.errors.tipo"
                          ><span class="font-medium">Error: </span> {{ form.errors.nivel }}</p>
                    </div>    

                    <!-- Nombre de la organización -->
                    <div>
                        <label for="area" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Área</label>
                        <input type="text" name="nombre" id="nombre" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Escriba área" required=""
                        v-model="form.area"
                        @change="form.validate('area')"
                        >

                          <p class="mt-2 text-sm text-red-600 dark:text-red-500"
                          v-if="form.invalid('area')|| form.errors.area"
                          ><span class="font-medium">Error: </span> {{ form.errors.area }}</p>
                    </div>

                </div>

                <div class="flex flex-col mb-8 lg:mb-16 space-y-4 sm:flex-row sm:justify-center sm:space-y-0 sm:space-x-4">
                    <button class="text-white inline-flex items-center bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800"
                :disabled="form.processing"
                >
                    <svg class="mr-1 -ml-1 w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path></svg>
                    Actualizar Cargo
                </button>


                <button type="button" v-show="isModal" class="inline-flex justify-center items-center py-3 px-5 text-base font-medium text-center text-gray-900 rounded-lg border border-gray-300 hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 dark:text-white dark:border-gray-700 dark:hover:bg-gray-700 dark:focus:ring-gray-800"
                @click="openModal=false"
                >
                        <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12l4-4m-4 4 4 4"/>
                        </svg>
                        Cerrar 
                  </button> 
                </div>

            </form>
        </div>
    </div>
</template>

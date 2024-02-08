<script setup>
    import PrimaryButton from '@/Components/PrimaryButton.vue';
    import InputError from '@/Components/InputError.vue';
    import InputLabel from '@/Components/InputLabel.vue';
    import Modal from '@/Components/Modal.vue';
    import SecondaryButton from '@/Components/SecondaryButton.vue';
    import TextInput from '@/Components/TextInput.vue';
    import { useForm } from '@inertiajs/vue3';
    import { nextTick, ref } from 'vue';
    import SearchIcon from '@/Components/Form/SearchIcon.vue';
    import InputForm from '@/Components/Form/InputForm.vue';
    import SelectForm from '@/Components/Form/SelectForm.vue';
    import SelectFormObject from '@/Components/Form/SelectFormObject.vue';
    import Loading from '@/Components/Misc/Loading.vue';
    import { onMounted } from 'vue';

    const cedulaInput = ref(null);
    const infoVoto = ref(null);
    const infoJefeFamilia = ref(null);
    const loading = ref(false);
    const error = ref(null);
    const error_jefe_familia = ref(null);

    const props = defineProps({
        voto: Object,
        tipo_voto: Object,
        hora_voto: Object,
        municipio: {
            default: null,
        },
        municipios: {
            default: null,
        },
        parroquia: {
            default: null,
        },
        parroquias: {
            default: null,
        },
        centro_electoral: {
            default: null,
        },
        centros_electorales: {
            default: null,
        },
        comunidad: {
            default: null,
        },
        comunidades: {
            default: null,
        },
        calle: {
            default: null,
        },
        calles: {
            default: null,
        },
    });

    const form = useForm({
        cedula: props.voto?props.voto.cedula:'',
        cedula_jefe_familia: props.voto?props.voto.cedula_jefe_familia:'',
        telefono_movil: '',
        telefono_movil_aux: '',
        email: '',
        municipio: props.municipio??'',
        parroquia: props.parroquia??'',
        municipio: props.municipio??'',
        parroquia: props.parroquia??'',
        centro_electoral: props.centro_electoral??'',
        comunidad: props.comunidad??'',
        calle: props.calle??'',
        tipo_voto: props.voto?props.voto.tipo:'',
        hora_voto: props.voto?props.voto.hora_voto:'',
        es_jefe_familia: props.voto?props.voto.es_jefe_familia:false,
        tiene_jefe_familia: false,
    });

    const emit = defineEmits(['closeModal'])

    const sexo = {1:'F',2:'M'};

    const create = () => {
        form.post(route('votos_calle.store'), {
            preserveScroll: true,
            onSuccess: () => emit('closeModal'),
            onError: () => console.log('error'),
            onFinish: () => console.log('finish'),
        });
    };

    const update = () => {
        form.put(route('votos_calle.update',{votos_calle:props.voto.id}), {
            preserveScroll: true,
            onSuccess: () => emit('closeModal'),
            onError: () => console.log('error'),
            onFinish: () => console.log('finish'),
        });
    };

    const fetchData = () => {
        loading.value = true;
        fetch('/api/get-data-persona/'+form.cedula)
  .then(response => response.json())    // one extra step
  .then(data => {

    if(data.status=='ok')
    {
        infoVoto.value= data.message;

        if(infoVoto.value.contacto){
            form.telefono_movil = infoVoto.value.contacto.telefono_movil;
            form.telefono_movil_aux = infoVoto.value.contacto.telefono_movil_aux;
            form.email = infoVoto.value.contacto.email;
        }

        error.value = null;
    }
    else{
        error.value = data.message;
    }
    loading.value = false;
})
  .catch(error => error.value = error);
};

const fetchDataJefeFamilia = () => {
    loading.value = true;
    fetch('/api/get-data-jefe-familia/'+form.cedula_jefe_familia)
  .then(response => response.json())    // one extra step
  .then(data => {

    if(data.status=='ok')
    {
        infoJefeFamilia.value= data.message.nombre;
    }
    else{
        error_jefe_familia.value = data.message;
    }
    loading.value = false;
})
  .catch(error => error_jefe_familia.value = error);
};

const reset = () => {
    form.cedula = null;
};

onMounted(() => {
    if (form.cedula) {
        fetchData();
    }
});

</script>

<template>
    <div class="p-6">
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100" v-if="voto">
            {{voto}}
            Actualizando los datos de {{voto.id}}:{{voto.nombres}} {{voto.apellidos}}
            }
        </h2>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100" v-else="voto">
            Ingresa los datos del Nuevo Voto
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400" v-if="!voto" >
            Ingresa la cédula para autocompletar los datos
        </p>

        <div class="mt-6">
            <InputLabel for="cedula" value="Ingrese Cédula"/>

            <search-icon v-model="form.cedula" @search="fetchData" :disabled="voto">
            </search-icon>

            <InputError :message="form.errors.cedula" class="mt-2" />
            <InputError :message="error" class="mt-2" />
        </div>

        <div v-show="loading">
            <Loading />
        </div>

        <div class="grid gap-6 mb-6 md:grid-cols-3" v-if="infoVoto">
            <InputForm label="Nombres" v-model="infoVoto.nombres" disabled/>
            <InputForm label="Apellidos" v-model="infoVoto.apellidos" disabled/>
            <InputForm label="Sexo" v-model="sexo[infoVoto.sexo]" disabled/>
            <InputForm label="Fecha Nacimiento" v-model="infoVoto.fecha_nacimiento" disabled/>
            <InputForm type="number" label="Telefono Móvil" v-model="form.telefono_movil" :error="form.errors.telefono_movil"/>
            <InputForm type="number" label="Telefono Móvil Auxiliar" v-model="form.telefono_movil_aux" :error="form.errors.telefono_movil_aux" />
            <InputForm type="email" label="Correo Electronico" v-model="form.email" class="col-span-2" :error="form.errors.email"/>
            
            <SelectForm v-if="municipios" label="Municipio" v-model="form.municipio" :options="municipios" nameOption="nombre" :error="form.errors.municipio" @change="form.parroquia='';form.centro_electoral=''" :disabled="calle"/>
            <SelectForm v-if="parroquias" label="Parroquia" v-model="form.parroquia" @change="form.centro_electoral='';form.comunidad=''" :options="parroquias[form.municipio]" nameOption="parroquia_nombre"
            :error="form.errors.parroquia" :disabled="calle" />
            
            <SelectForm label="UBCH" v-model="form.centro_electoral" :options="centros_electorales[form.parroquia]" nameOption="centro_electoral_nombre"
            :error="form.errors.centro_electoral"
            :disabled="form.parroquia==''||calle"
            class="col-span-2"
            />
            <SelectForm label="Comunidad" v-model="form.comunidad" :options="comunidades[form.centro_electoral]" nameOption="comunidad_nombre"
            :error="form.errors.comunidad"
            :disabled="form.centro_electoral==''||calle"
            />
            <SelectForm label="Calle" v-model="form.calle" :options="calles[form.comunidad]" nameOption="calle_nombre"
            :error="form.errors.calle"
            :disabled="form.comunidad==''||calle"
            />
            {{form.tipo_voto}}
            <SelectFormObject label="Tipo" v-model="form.tipo_voto"
            :options="tipo_voto"
            :error="form.errors.tipo_voto"
            />
            <SelectFormObject label="Hora del Voto" v-model="form.hora_voto" :options="hora_voto"
            :error="form.errors.hora_voto"
            />

            <div class="flex items-center ps-4 border border-gray-200 rounded dark:border-gray-700">
                <input id="es_jefe_familia" type="checkbox" value="" name="es_jefe_familia" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" v-model="form.es_jefe_familia">
                <label for="es_jefe_familia" class="w-full py-4 ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Es jefe de Familia</label>
            </div>
            <div class="flex items-center ps-4 border border-gray-200 rounded dark:border-gray-700">
                <input id="tiene_jefe_familia" type="checkbox" value="" v-model="form.tiene_jefe_familia" name="tiene_jefe_familia" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                <label for="tiene_jefe_familia" class="w-full py-4 ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Tiene jefe de Familia</label>
            </div>

            <div class="mt-6" v-show="!form.es_jefe_familia && form.tiene_jefe_familia">
                <InputLabel for="cedula_jefe_familia" value="Ingrese Cédula jefe de Familia"/>

                <search-icon v-model="form.cedula_jefe_familia" @search="fetchDataJefeFamilia" :disabled="voto">
                </search-icon>
                <InputError :message="form.errors.cedula_jefe_familia" class="mt-2" />
                <InputError :message="error_jefe_familia" class="mt-2" />
                <InputForm label="Nombres y Apellido" v-model="infoJefeFamilia" disabled/>
                
            </div>

            <div v-show="loading">
                <Loading />
            </div>

        </div>

        <div class="mt-6 flex justify-end">
            <SecondaryButton @click="$emit('closeModal')"> Cancel </SecondaryButton>

            <PrimaryButton
            class="ml-3"
            :class="{ 'opacity-25': form.processing }"
            :disabled="form.processing"
            @click="voto?update():create()"
            >
            {{voto?'Actualizar':'Crear Voto'}}
        </PrimaryButton>
    </div>
</div>
</template>

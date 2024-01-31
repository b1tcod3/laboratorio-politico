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
    import Loading from '@/Components/Misc/Loading.vue';
    import { onMounted } from 'vue';

    const cedulaInput = ref(null);
    const infoMiembro = ref(null);
    const loading = ref(false);
    const error = ref(null);

    const props = defineProps({
        miembro: Object,
        cargos: Object,
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
    });

    const form = useForm({
        cedula: props.miembro?props.miembro.cedula:'',
        telefono_movil: '',
        telefono_movil_aux: '',
        email: '',
        cargo: props.miembro?props.miembro.cargo_id:'',
        municipio: props.municipio??'',
        parroquia: props.parroquia??'',
        centro_electoral: props.centro_electoral??'',
        comunidad: props.comunidad??'',
    });

    const emit = defineEmits(['closeModal'])

    const sexo = {1:'F',2:'M'};

    const create = () => {
        form.post(route('estructuras_psuv.store'), {
        preserveScroll: true,
        onSuccess: () => emit('closeModal'),
        onError: () => form.cedula.focus(),
        onFinish: () => form.cedula.focus(),
    });
};

const update = () => {
    form.put(route('estructuras_psuv.update',{estructuras_psuv:props.miembro.id}), {
        preserveScroll: true,
        onSuccess: () => emit('closeModal'),
        onError: () => form.cedula.focus(),
        onFinish: () => form.cedula.focus(),
    });
};

const fetchData = () => {
    loading.value = true;
    fetch('/api/get-data-persona/'+form.cedula)
  .then(response => response.json())    // one extra step
  .then(data => {

    if(data.status=='ok')
    {
        infoMiembro.value= data.message;

        if(infoMiembro.value.contacto){
            form.telefono_movil = infoMiembro.value.contacto.telefono_movil;
            form.telefono_movil_aux = infoMiembro.value.contacto.telefono_movil_aux;
            form.email = infoMiembro.value.contacto.email;
        }
        form.municipio = props.miembro?props.miembro.municipio_id:props.municipio;
        form.parroquia = props.miembro?props.miembro.parroquia_id:props.parroquia;
        form.centro_electoral = props.miembro?props.miembro.centro_electoral_id:props.centro_electoral;
        form.comunidad = props.miembro?props.miembro.comunidad_id:props.comunidad;

        error.value = null;
    }
    else{
        error.value = data.message;
    }
    loading.value = false;
})
  .catch(error => error.value = error);
};

const reset = () => {
    form.cedula = null;
};

onMounted(() => {
    if (form.cedula) {
        fetchData()
    }
});

</script>

<template>
    <div class="p-6">
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100" v-if="miembro">

            Actualizando los datos de {{miembro.id}}:{{miembro.nombres}} {{miembro.apellidos}}
        </h2>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100" v-else="miembro">
            Ingresa los datos del Nuevo Miembro
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400" v-if="!miembro" >
            Ingresa la cédula para autocompletar los datos
        </p>

        <div class="mt-6">
            <InputLabel for="cedula" value="Ingrese Cédula"/>

            <search-icon v-model="form.cedula" @search="fetchData" :disabled="miembro">
            </search-icon>

            <InputError :message="form.errors.cedula" class="mt-2" />
            <InputError :message="error" class="mt-2" />
        </div>

        <div v-show="loading">
            <Loading />
        </div>

        <div class="grid gap-6 mb-6 md:grid-cols-3" v-if="infoMiembro">

            <InputForm label="Nombres" v-model="infoMiembro.nombres" disabled/>
            <InputForm label="Apellidos" v-model="infoMiembro.apellidos" disabled/>
            <InputForm label="Sexo" v-model="sexo[infoMiembro.sexo]" disabled/>
            <InputForm label="Fecha Nacimiento" v-model="infoMiembro.fecha_nacimiento" disabled/>
            <InputForm type="number" label="Telefono Móvil" v-model="form.telefono_movil" :error="form.errors.telefono_movil"/>
            <InputForm type="number" label="Telefono Móvil Auxiliar" v-model="form.telefono_movil_aux" :error="form.errors.telefono_movil_aux" />
            <InputForm type="email" label="Correo Electronico" v-model="form.email" class="col-span-2" :error="form.errors.email"/>
            <SelectForm v-if="municipios" label="Municipio" v-model="form.municipio" :options="municipios" nameOption="nombre"
            :error="form.errors.municipio" @change="form.parroquia='';form.centro_electoral=''" />
            <SelectForm v-if="parroquias" label="Municipio" v-model="form.parroquia" @change="form.centro_electoral='';form.comunidad=''" :options="parroquias[form.municipio]" nameOption="parroquia_nombre"
            :error="form.errors.parroquia" />
            <SelectForm label="UBCH" v-model="form.centro_electoral" :options="centros_electorales[form.parroquia]" nameOption="centro_electoral_nombre"
            :error="form.errors.centro_electoral"
            :disabled="form.parroquia==''"
            class="col-span-2"
            />
            <SelectForm label="Comunidad" v-model="form.comunidad" :options="comunidades[form.centro_electoral]" nameOption="comunidad_nombre"
            :error="form.errors.comunidad"
            :disabled="form.centro_electoral==''"
            />

            <SelectForm label="Cargo" v-model="form.cargo" class="col-span-2" :options="cargos" nameOption="nombre"
            :error="form.errors.cargo"
            />

        </div>

        <div class="mt-6 flex justify-end">
            <SecondaryButton @click="$emit('closeModal')"> Cancel </SecondaryButton>

            <PrimaryButton
            class="ml-3"
            :class="{ 'opacity-25': form.processing }"
            :disabled="form.processing"
            @click="miembro?update():create()"
            >
            {{miembro?'Actualizar':'Crear Cuenta'}}
        </PrimaryButton>
    </div>
</div>
</template>

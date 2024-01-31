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

    const loading = ref(false);
    const error = ref(null);

    const props = defineProps({
        comunidad: Object,
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
        comunidades: {
        default: null,
        },
    });

    const form = useForm({
        nombre: props.comunidad?props.comunidad.comunidad_nombre:'',
        municipio: props.municipio??'',
        parroquia: props.parroquia??'',
        centro_electoral: props.centro_electoral??'',
    });

    const emit = defineEmits(['closeModal'])

    const create = () => {
        form.post(route('comunidades.store'), {
        preserveScroll: true,
        onSuccess: () => emit('closeModal'),
        onError: () => form.cedula.focus(),
        onFinish: () => form.cedula.focus(),
    });
};

const update = () => {
    form.put(route('comunidades.update',{comunidade:props.comunidad.id}), {
        preserveScroll: true,
        onSuccess: () => emit('closeModal'),
        onError: () => form.nombre.focus(),
        onFinish: () => form.nombre.focus(),
    });
};

const reset = () => {
    form.nombre = null;
};

</script>

<template>
    <div class="p-6">
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100" v-if="comunidad">

            Actualizando los datos de {{comunidad.id}}:{{comunidad.nombres}} {{comunidad.apellidos}}
        </h2>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100" v-else>
            Ingresa los datos de la Comunidad
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400" v-if="!comunidad" >
            Ingresa los datos de la comunidad
        </p>

        <div class="grid gap-6 mb-6 md:grid-cols-3">
            
            <SelectForm v-if="municipios" label="Municipio" v-model="form.municipio" :options="municipios" nameOption="nombre"
            :error="form.errors.municipio" @change="form.parroquia='';form.centro_electoral=''" />
            <SelectForm v-if="parroquias" label="Municipio" v-model="form.parroquia" @change="form.centro_electoral='';form.comunidad=''" :options="parroquias[form.municipio]" nameOption="parroquia_nombre"
            :error="form.errors.parroquia" />
            <SelectForm label="UBCH" v-model="form.centro_electoral" :options="centros_electorales[form.parroquia]" nameOption="centro_electoral_nombre"
            :error="form.errors.centro_electoral"
            :disabled="form.parroquia==''"
            class="col-span-2"
            />

            <InputForm label="Nombre de la Comunidad" v-model="form.nombre"/>

        </div>

        <div class="mt-6 flex justify-end">
            <SecondaryButton @click="$emit('closeModal')"> Cancel </SecondaryButton>

            <PrimaryButton
            class="ml-3"
            :class="{ 'opacity-25': form.processing }"
            :disabled="form.processing"
            @click="comunidad?update():create()"
            >
            {{comunidad?'Actualizar':'Crear Cuenta'}}
        </PrimaryButton>
    </div>
</div>
</template>

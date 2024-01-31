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
        calle: Object,
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
        comunidad: {
        default: null,
        },
    });

    const form = useForm({
        nombre: props.calle?props.calle.calle_nombre:'',
        municipio: props.municipio??'',
        comunidad: props.comunidad??'',
        parroquia: props.parroquia??'',
        centro_electoral: props.centro_electoral??'',
    });

    const emit = defineEmits(['closeModal'])

    const create = () => {
        form.post(route('calles.store'), {
        preserveScroll: true,
        onSuccess: () => emit('closeModal'),
        onError: () => form.cedula.focus(),
        onFinish: () => form.cedula.focus(),
    });
};

const update = () => {
    form.put(route('calles.update',{calle:props.calle.id}), {
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
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100" v-if="calle">
            Actualizando los datos de {{calle.id}}:{{calle.nombres}} {{calle.apellidos}}
        </h2>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100" v-else>
            Ingresa los datos de la Calle
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400" v-if="!calle" >
            Ingresa los datos de la calle
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
            <SelectForm label="Comunidad" v-model="form.comunidad" :options="comunidades[form.centro_electoral]" nameOption="comunidad_nombre"
            :error="form.errors.comunidad"
            :disabled="form.comunidad==''"
            class="col-span-2"
            />

            <InputForm label="Nombre de la Calle" v-model="form.nombre"/>

        </div>

        <div class="mt-6 flex justify-end">
            <SecondaryButton @click="$emit('closeModal')"> Cancel </SecondaryButton>

            <PrimaryButton
            class="ml-3"
            :class="{ 'opacity-25': form.processing }"
            :disabled="form.processing"
            @click="calle?update():create()"
            >
            {{calle?'Actualizar':'Crear Cuenta'}}
        </PrimaryButton>
    </div>
</div>
</template>

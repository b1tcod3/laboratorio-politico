<script setup>
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm } from '@inertiajs/vue3';
import { nextTick, ref } from 'vue';
import SearchIcon from '@/Components/Form/SearchIcon.vue'

const confirmingUserDeletion = ref(false);
const cedulaInput = ref(null);
const infoMiembro = ref(null);
const error = ref(null);

const form = useForm({
    cedula: '',
});

const confirmUserDeletion = () => {
    confirmingUserDeletion.value = true;

    nextTick(() => cedulaInput.value.focus());
};

const deleteUser = () => {
    // form.delete(route('profile.destroy'), {
    //     preserveScroll: true,
    //     onSuccess: () => closeModal(),
    //     onError: () => cedulaInput.value.focus(),
    //     onFinish: () => form.reset(),
    // });
    
    console.log(form.cedula)
};

const fetchData = () => {
    fetch('/api/get-data-persona/'+form.cedula)
  .then(response => response.json())    // one extra step
  .then(data => {
    infoMiembro.value=data;
  })
  .catch(error => console.error(error));
};

const reset = () => {
        form.cedula = null;
      };

</script>

<template>
    <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                    Ingresa los datos del Nuevo Miembro
                </h2>

                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    Ingresa la cédula para autocompletar los datos
                </p>

                <div class="mt-6">
                    <InputLabel for="cedula" value="Ingrese Cédula"/>
                
                    <search-icon v-model="form.cedula" @search="fetchData">
                    </search-icon>

                    <InputError :message="form.errors.cedula" class="mt-2" />
                    <InputError :message="error" class="mt-2" />
                </div>

                <div class="mt-6" v-if="infoMiembro">
                    {{infoMiembro}}
                </div>

                <div class="mt-6 flex justify-end">
                    <SecondaryButton @click="$emit('closeModal')"> Cancel </SecondaryButton>

                    <PrimaryButton
                        class="ml-3"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                        @click="deleteUser"
                    >
                        Crear Cuenta
                    </PrimaryButton>
                </div>
            </div>
</template>

0<script setup>
    import { onMounted } from 'vue';
    import { Link } from '@inertiajs/vue3';
    import Icon from '@/Components/Icon/Icon.vue'

    const props = defineProps({
        name: {
            type: String,
        },
        headers: {
            type: Array,
        }
    });

    onMounted( () => {
        if (document.getElementById(props.name) && typeof simpleDatatables.DataTable !== 'undefined') {

    const table = new simpleDatatables.DataTable('#'+props.name, {

        labels: {
            placeholder: "Buscar ...",
            perPage: "entradas por página",
            noRows: "No existe registros",
            noResults: "No hay registros de lo que estas buscando",

        },
    });
}
});

</script>

<template>
	<div class="p-4 w-full h-full">
        
        <table :id="name">
            <thead>
                <tr>
                    <th v-for="header in headers">
                        <span class="flex items-center" >
                            {{header}} <coin name="sorting" />
                        </span>
                    </th>
                </tr>
            </thead>
            <tbody>
                <slot name="rows"></slot>
            </tbody>
        </table>
    </div>
</template>

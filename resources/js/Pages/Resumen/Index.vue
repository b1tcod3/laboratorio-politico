<script setup>
	import Layout from '@/Layouts/MainLayout.vue';
	import Heading from '@/Components/Typography/Heading.vue';
  import TableSorteable from '@/Components/Table/TableSorteable.vue';
	import CardIcon from '@/Components/Card/CardIcon.vue';
  import { orderBy } from 'lodash';
	import { Head, useForm} from '@inertiajs/vue3';
	import { ref } from 'vue';

  const orderColumn = ref(false);
  const orderType = ref(false);


	defineOptions({ layout: Layout })

	const props = defineProps({
		resumen: {
			type: Object,
			required: true
		},
    municipios: Object
	});

  const fields=[{id:1,name_display:'ID',name:'id'},
  {id:1,name_display:'Nombre',name:'nombre'},
  {id:2,name_display:'Parroquias',name:'parroquias_count'},
  {id:3,name_display:'Centros Electorales',name:'centros_electorales_count'},
  {id:4,name_display:'Comunidades',name:'sum_comunidades'},
  ];

  const rows = ref(props.municipios.data);
  // a function to sort the table
  const sortTable = (column) => {


    if(column!=orderColumn.value){
          orderColumn.value = column;
          orderType.value = 'asc';
        }else
        {
          if(orderType.value== 'asc'){
            orderType.value = 'desc';  
          }
          else{
            orderColumn.value = false;
            orderType.value = 'asc';
          }
        }
        console.log(orderType.value);
    // Use of _.sortBy() method
    
    if(orderColumn)
    {
      rows.value = orderBy(props.municipios.data,orderColumn.value,orderType.value);
    }
  }


</script>


<template>
	<Head title="Resumen General" />

	<div>
		<div class="max-w-7xl">
			<div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
				<Heading title="Resumen General"/>
				<div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-4">
				<card-icon icon="centro_electoral" :data="resumen.centros_electorales_count" title="Total Centros Electorales" color="red"/>
        <card-icon icon="electores" :data="resumen.sum_electores" title="Total Electores" color="blue"/>
        <card-icon icon="comunidades" :data="resumen.sum_comunidades" title="Total Comunidades" color="yellow"/>
				</div>

        <TableSorteable :fields="fields" :rows="rows"
        @sort="sortTable" 
        />

			</div> 


		</div>
	</div>
</template>

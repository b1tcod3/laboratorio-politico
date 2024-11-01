import { ref } from 'vue';

export default function useMunicipios(){

	const municipios = ref([]);
	const getMunicipios = async () => {
		axios.get('/api/municipios')
		.then( 
			response => {
			municipios.value  = response.data
		})
	}

	return {municipios, getMunicipios}
}
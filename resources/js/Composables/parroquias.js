import { ref } from 'vue';

export default function useParroquias(){

	const parroquias = ref([]);
	const getParroquias = async (municipio) => {
		axios.get('/api/parroquias/'+municipio)
		.then( 
			response => {
			parroquias.value  = response.data
		})
	}

	return {parroquias, getParroquias}
}
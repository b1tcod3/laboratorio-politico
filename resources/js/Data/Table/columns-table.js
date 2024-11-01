export const columnsTable = {
	columns_municipio:[
		{
			id: 'id',
			name: 'ID'
		},{
			id: 'nombre',
			name: 'Nombre'
		}
		,{
			id: 'parroquias_count',
			name: 'Cantidad de Parroquias'
		},
		{
			id: 'centros_electorales_count',
			name: 'Cantidad de C.E.'
		},
		{
			id: 'eje',
			name: 'EJE'
		}
	],
	columns_parroquia:[
		{
			id: 'id',
			name: 'ID'
		},
		{
			id: 'eje',
			name: 'Eje'
		},
		{
			id: 'nombre_municipio',
			name: 'Municipio'
		},
		{
			id: 'nombre',
			name: 'Nombre de Parroquia'
		},
		{
			id: 'centros_electorales_count',
			name: 'Cantidad de C.E.'
		}
	],
	columns_centro_electoral:[
		{
			id: 'id',
			name: 'ID'
		},
		{
			id: 'nombre',
			name: 'Nombre'
		},
		{
			id: 'cantidad_electores',
			name: 'Cantidad de Electores'
		}
	],
	columns_comunidades:[
		{
			id: 'id',
			name: 'ID'
		},
		{
			id: 'eje',
			name: 'Eje'
		}
		,
		{
			id: 'municipio',
			name: 'Municipio'
		},
		{
			id: 'parroquia',
			name: 'Parroquia'
		}
		,
		{
			id: 'nombre',
			name: 'Nombre'
		},
		{
			id: 'cantidad_calles',
			name: 'Cantidad de Calles'
		}
	],
	columns_calles:[
		{
			id: 'id',
			name: 'ID'
		},
		{
			id: 'eje',
			name: 'Eje'
		}
		,
		{
			id: 'municipio',
			name: 'Municipio'
		},
		{
			id: 'parroquia',
			name: 'Parroquia'
		}
		,{
			id: 'comunidad',
			name: 'Comunidad'
		}
		,
		{
			id: 'calle_nombre',
			name: 'Nombre'
		}
	]
};
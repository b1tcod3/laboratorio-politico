export const items = [
	{
	is_sub_menu: false,
	name: 'Dashboard',
	name_route: 'dashboard' ,
	icon: 'resumen' ,
	url: route('dashboard')
	},
	{
	is_sub_menu: true,
	name: 'Resumen',
	name_route: 'test' ,
	icon: 'arrow-left' ,
	items: [
		{
			name: 'Municipios',
			name_route: '/municipios',
			url: route('municipios.index')
		},
		{
			name: 'Parroquias',
			name_route: '/parroquias',
			url: route('parroquias.index')
		}
		]
	},

];
<script setup>
	import Layout from '@/Layouts/MainLayout.vue';
	import { Head, useForm } from '@inertiajs/vue3';
	import { ref, onMounted, computed, watch } from 'vue';
	import ApexCharts from 'apexcharts'
    import pickBy from 'lodash/pickBy'
    import throttle from 'lodash/throttle'

	defineOptions({ layout: Layout });

    const props = defineProps({
        data_votos: {
            type: Object
        },
        filters: {
          type: Object
        },
        ejes: {
          type: Array
        },
        municipios: {
          type: Array
        },
        centros_electorales: {
          type: Array
        },
        parroquias: {
            type: Array,
        }
  });

  const form = useForm({
      municipio_eje: props.filters.municipio_eje??'',
      municipio: props.filters.municipio,
      parroquia: props.filters.parroquia,
      centro_electoral: props.filters.centro_electoral,
  });

   const loading = ref(false);

    const updateGraph = () => {
      loading.value = true;
      form.get(route('resultados-electorales.index'), pickBy(form), { preserveState: true,
          onFinish: () => {
            loading.value=false;
          }
        })
      };

	onMounted(() => {
		const options = {

			series: [{
				name: 'Participación',
				data: props.data_votos.map(
                                  (data) => data
                                  )
			},
			{
				name: 'Votos PSUV',
				data: [50, 100, 322, 120],
			}]
			,
			chart: {
				height: "300",
				width: "100%",
				type: 'area',

				toolbar: {
					show: false
				}
			},
                        dataLabels: {
                            enabled: true
                        },
                        stroke: {
                            show: true,
                            curve: 'smooth',
                            width: 2,
                            lineCap: 'square'
                        },
                        dropShadow: {
                            enabled: true,
                            opacity: 0.2,
                            blur: 10,
                            left: -7,
                            top: 22
                        },
                        colors: ['#1b55e2', '#e7515a'],
                        markers: {
                            discrete: [{
                                    seriesIndex: 0,
                                    dataPointIndex: 6,
                                    fillColor: '#1b55e2',
                                    strokeColor: 'transparent',
                                    size: 4
                                },
                                {
                                    seriesIndex: 1,
                                    dataPointIndex: 5,
                                    fillColor: '#e7515a',
                                    strokeColor: 'transparent',
                                    size: 4
                                },
                            ],
                        },
                        labels: ['AN 2015', 'REG 2017', 'PRES 2018', 'REG 2021'
                        ],
                        xaxis: {
                            axisBorder: {
                                show: false
                            },
                            axisTicks: {
                                show: false
                            },
                            crosshairs: {
                                show: true
                            },
                            labels: {
                                offsetX: 0,
                                offsetY: 5,
                                style: {
                                    fontSize: '20px',
                                    cssClass: 'apexcharts-xaxis-title'
                                }
                            },
                        },
                        yaxis: {
                            tickAmount: 7,
                            labels: {
                                style: {
                                    fontSize: '14px',
                                    cssClass: 'apexcharts-yaxis-title'
                                },
                            }
                        },
                        grid: {
                            borderColor: '#e0e6ed',
                            strokeDashArray: 5,
                            xaxis: {
                                lines: {
                                    show: true
                                }
                            },
                            yaxis: {
                                lines: {
                                    show: false
                                }
                            },
                            padding: {
                                top: 0,
                                right: 0,
                                bottom: 0,
                                left: 0
                            }
                        },
                        legend: {
                            position: 'top',
                            horizontalAlign: 'right',
                            fontSize: '16px',
                            markers: {
                                width: 10,
                                height: 10,
                                offsetX: -2,
                            },
                            itemMargin: {
                                horizontal: 10,
                                vertical: 5
                            },
                        },
                        tooltip: {
                            marker: {
                                show: true
                            },
                            x: {
                                show: false
                            }
                        },
                        fill: {
                            type: 'gradient',
                            gradient: {
                                shadeIntensity: 1,
                                inverseColors: !1,
                                opacityFrom: 0.28,
                                opacityTo: 0.05,
                                stops: [45, 100],
                            },
                        },

		}	
		const chart = new ApexCharts(document.querySelector("#chart"), options);

		chart.render();
	});

const getMunicipios = computed(() => {
      const municipios = form.municipio_eje ? props.municipios.filter((municipio) =>municipio.eje_id == form.municipio_eje ) : props.municipios;

      return municipios;
  });

    const getParroquias = computed(() => {
      const parroquias_eje = form.municipio_eje ? props.parroquias.filter((parroquia) =>parroquia.eje_id == form.municipio_eje ) : props.parroquias;

      const parroquias = form.municipio ? parroquias_eje.filter((parroquia) =>parroquia.municipio_id == form.municipio ) : parroquias_eje;

      return parroquias;
  });

    const getCentrosElectorales = computed(() => {

      const centros_electorales_eje = form.municipio_eje ? props.centros_electorales.filter((centro_electoral) => centro_electoral.eje_id == form.municipio_eje ) : props.centros_electorales;

      const centros_electorales_municipios = form.municipio ? centros_electorales_eje.filter((centro_electoral) =>centro_electoral.municipio_id == form.municipio ) : centros_electorales_eje;

      const centros_electorales = form.parroquia ? centros_electorales_municipios.filter((centro_electoral) =>centro_electoral.parroquia_id == form.parroquia ) : centros_electorales_municipios;

      return centros_electorales;
  });




</script>

<template>
	<Head title="Dashboard" />

    <div class="grid gap-4 sm:grid-cols-3 sm:gap-6 mx-4">

      <div>
                  <select id="eje" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" v-model="form.municipio_eje" @change="form.municipio='';updateGraph()">
                      <option value="">Selecciona Eje</option>
                      <option :value="id" v-for="(eje,id) in ejes">{{eje}}</option>
                  </select>
      </div>

      <select id="municipios" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
      v-model="form.municipio"
      @change="updateGraph()"
      >
        <option value="">Todos los Municipio</option>
        <option :value="municipio.id" v-for="municipio in getMunicipios">{{municipio.nombre}}</option>
      </select>

      <select id="parroquias" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
      v-model="form.parroquia"
      @change="updateGraph()"
      >
        <option value="">Todos las parroquias</option>
        <option :value="parroquia.id" v-for="parroquia in getParroquias">{{parroquia.nombre}}</option>
      </select>

      <select id="centros_electorales" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
      v-model="form.centro_electoral"
      @change="updateGraph()"
      >
        <option value="">Todos los centros electorales</option>
        <option :value="centro_electoral.id" v-for="centro_electoral in getCentrosElectorales">{{centro_electoral.nombre}}</option>
      </select> 


    </div>

	<div class="mt-4 w-full p-20" v-show="!loading">
		<div class="rounded-lg" id="chart"></div>
	</div>


<div role="status" class="mt-4 w-full p-20 space-y-8 animate-pulse md:space-y-0 md:space-x-8 rtl:space-x-reverse md:flex md:items-center" 
v-show="loading">
    <div class="flex items-center justify-center w-full h-48 bg-gray-300 rounded sm:w-96 dark:bg-gray-700">
        <svg class="w-10 h-10 text-gray-200 dark:text-gray-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 18">
            <path d="M18 0H2a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2Zm-5.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Zm4.376 10.481A1 1 0 0 1 16 15H4a1 1 0 0 1-.895-1.447l3.5-7A1 1 0 0 1 7.468 6a.965.965 0 0 1 .9.5l2.775 4.757 1.546-1.887a1 1 0 0 1 1.618.1l2.541 4a1 1 0 0 1 .028 1.011Z"/>
        </svg>
    </div>
    <div class="w-full">
        <div class="h-2.5 bg-gray-200 rounded-full dark:bg-gray-700 w-48 mb-4"></div>
        <div class="h-2 bg-gray-200 rounded-full dark:bg-gray-700 max-w-[480px] mb-2.5"></div>
        <div class="h-2 bg-gray-200 rounded-full dark:bg-gray-700 mb-2.5"></div>
        <div class="h-2 bg-gray-200 rounded-full dark:bg-gray-700 max-w-[440px] mb-2.5"></div>
        <div class="h-2 bg-gray-200 rounded-full dark:bg-gray-700 max-w-[460px] mb-2.5"></div>
        <div class="h-2 bg-gray-200 rounded-full dark:bg-gray-700 max-w-[360px]"></div>
    </div>
    <span class="sr-only">Loading...</span>
</div>


</template>

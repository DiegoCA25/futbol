<template>
	<Head title="Dashboard" />
	
	<AuthenticatedLayout>
	  <template #header>
		Dashboard
	  </template>
	
	  <div class="p-4 bg-white rounded-lg shadow-xs">
		<div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-4">
		  <!-- Tarjeta Total Jugadores -->
		  <div class="flex border items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
			<div class="p-3 mr-4 text-orange-500 bg-orange-100 rounded-full dark:text-orange-100 dark:bg-orange-500">
			  <!-- Icono de Jugadores -->
			  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
				<path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772" />
			  </svg>
			</div>
			<div>
			  <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
				Total Jugadores
			  </p>
			  <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
				{{ jugadores ? jugadores.length : 0 }}
			  </p>
			</div>
		  </div>
	
		  <!-- Tarjeta Total Equipos -->
		  <div class="flex border items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
			<div class="p-3 mr-4 text-green-500 bg-green-100 rounded-full dark:text-green-100 dark:bg-green-500">
			  <!-- Icono de Equipos -->
			  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
				<path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702  0 0 1 7.74-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443" />
			  </svg>
			</div>
			<div>
			  <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
				Total Equipos
			  </p>
			  <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
				{{ equipos ? Object.keys(equipos).length : 0 }}
			  </p>
			</div>
		  </div>
	
		  <!-- Tarjeta Total Países -->
		  <div class="flex border items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
			<div class="p-3 mr-4 text-blue-500 bg-blue-100 rounded-full dark:text-blue-100 dark:bg-blue-500">
			  <!-- Icono de Países -->
			  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
				<path stroke-linecap="round" stroke-linejoin="round" d="M3 3v1.5M3 21v-6m0 0 2.77-.693a9 9 0 0 1 6.208.682l.108.054a9 9 0 0 0 6.086.71l3.114-.732a48.524 48.524 0 0 1-.005-10.499l-3.11.732a9 9 0 0 1-6.085-.711l-.108-.054a9 9 0 0 0-6.208-.682L3 4.5M3 15V4.5" />
			  </svg>
			</div>
			<div>
			  <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
				Total Países
			  </p>
			  <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
				{{ paises ? Object.keys(paises).length : 0 }}
			  </p>
			</div>
		  </div>
		</div>
	
		<div class="grid gap-6 bg-white mb-8 md:grid-cols-2 border rounded-lg">
		  <div class="win-w-0 p-4 rounded-lg shadow-xs border">
			<span class="text-lg p-4">Equipos por país</span>
			<div class="flex items-center">
			  <Pie :data="chartData1" :options="charOptions1" />
			</div>
		  </div>
	
		  <div class="win-w-0 p-4 rounded-lg shadow-xs border">
			<span class="text-lg p-4">Jugadores por equipo</span>
			<div class="flex items-center">
			  <Bar :data="chartData2" :options="charOptions2" />
			</div>
		  </div>
		</div>
	  </div>
	</AuthenticatedLayout>
  </template>
  
  <script>
  export default {
	props: {
	  jugadores: {
		type: Array,
		default: () => []
	  },
	  equipos: {
		type: Object,
		default: () => ({})
	  },
	  paises: {
		type: Object,
		default: () => ({})
	  },
	  chartData1: {
		type: Object,
		required: true
	  },
	  chartData2: {
		type: Object,
		required: true
	  },
	  charOptions1: {
		type: Object,
		required: true
	  },
	  charOptions2: {
		type: Object,
		required: true
	  }
	}
  }
  </script>
  
  <style scoped>
  /* Estilos personalizados aquí */
  </style>
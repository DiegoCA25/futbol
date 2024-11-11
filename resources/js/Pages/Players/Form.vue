<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';

const props = defineProps({
    teams: { type: Array, required: true }, // Equipos disponibles
    countries: { type: Array, required: true }, // Nacionalidades disponibles
    player: { type: Object, default: null }, // Jugador (si se está editando)
});

const form = useForm({
    id: props.player?.id || '',
    first_name: props.player?.first_name || '',
    last_name: props.player?.last_name || '',
    age: props.player?.age || '',
    position: props.player?.position || '',
    description: props.player?.description || '',
    nationality: props.player?.nationality || '', // 'nationality' en lugar de 'country_id'
    team_id: props.player?.team_id || '',
    image: null, 
});

const title_form = props.player ? 'Edit Player' : 'Create Player';

// Función para guardar los datos
const save = () => {
    const formData = new FormData();
    formData.append('first_name', form.first_name);
    formData.append('last_name', form.last_name);
    formData.append('age', form.age);
    formData.append('position', form.position);
    formData.append('description', form.description);
    formData.append('nationality', form.nationality); // Usamos 'nationality'
    formData.append('team_id', form.team_id);

    // Si hay una imagen, agregarla al FormData
    if (form.image) {
        formData.append('image', form.image);
    }

    // Si estamos editando un jugador
    if (props.player) {
        formData.append('_method', 'PUT'); // Para la actualización de un recurso
        form.post(route('players.update', props.player.id), {
            data: formData,
            onSuccess: () => {
                alert('Player updated successfully');
            },
        });
    } else {
        // Si estamos creando un jugador
        form.post(route('players.store'), {
            data: formData,
            onSuccess: () => {
                alert('Player created successfully');
            },
        });
    }
};
</script>

<template>
    <AuthenticatedLayout>
        <Head :title="title_form" />

        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ title_form }}
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-4xl mx-auto bg-white shadow-md rounded-md p-6">
                <form @submit.prevent="save">
                    <!-- Nombre -->
                    <div class="mb-4">
                        <label for="first_name" class="block text-gray-700 font-medium">First Name</label>
                        <input
                            type="text"
                            id="first_name"
                            v-model="form.first_name"
                            class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Enter first name"
                            required
                        />
                        <span v-if="form.errors.first_name" class="text-red-600 text-sm">{{ form.errors.first_name }}</span>
                    </div>

                    <!-- Apellidos -->
                    <div class="mb-4">
                        <label for="last_name" class="block text-gray-700 font-medium">Last Name</label>
                        <input
                            type="text"
                            id="last_name"
                            v-model="form.last_name"
                            class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Enter last name"
                            required
                        />
                        <span v-if="form.errors.last_name" class="text-red-600 text-sm">{{ form.errors.last_name }}</span>
                    </div>

                    <!-- Edad -->
                    <div class="mb-4">
                        <label for="age" class="block text-gray-700 font-medium">Age</label>
                        <input
                            type="number"
                            id="age"
                            v-model="form.age"
                            class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Enter age"
                            required
                        />
                        <span v-if="form.errors.age" class="text-red-600 text-sm">{{ form.errors.age }}</span>
                    </div>

                    <!-- Posición -->
                    <div class="mb-4">
                        <label for="position" class="block text-gray-700 font-medium">Position</label>
                        <input
                            type="text"
                            id="position"
                            v-model="form.position"
                            class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Enter position"
                            required
                        />
                        <span v-if="form.errors.position" class="text-red-600 text-sm">{{ form.errors.position }}</span>
                    </div>

                    <!-- Nacionalidad -->
                    <div class="mb-4">
                        <label for="nationality" class="block text-gray-700 font-medium">Nationality</label>
                        <select
                            id="nationality"
                            v-model="form.nationality"
                            class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            required
                        >
                            <option value="" disabled>Select a nationality</option>
                            <option v-for="country in props.countries" :key="country.id" :value="country.id">
                                {{ country.name }}
                            </option>
                        </select>
                        <span v-if="form.errors.nationality" class="text-red-600 text-sm">{{ form.errors.nationality }}</span>
                    </div>

                    <!-- Equipos -->
                    <div class="mb-4">
                        <label for="team_id" class="block text-gray-700 font-medium">Team</label>
                        <select
                            id="team_id"
                            v-model="form.team_id"
                            class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            required
                        >
                            <option value="" disabled>Select a team</option>
                            <option v-for="team in props.teams" :key="team.id" :value="team.id">
                                {{ team.name }}
                            </option>
                        </select>
                        <span v-if="form.errors.team_id" class="text-red-600 text-sm">{{ form.errors.team_id }}</span>
                    </div>

                    <!-- Imagen -->
                    <div class="mb-4">
                        <label for="image" class="block text-gray-700 font-medium">Player Image</label>
                        <input
                            type="file"
                            id="image"
                            @change="event => form.image = event.target.files[0]"
                            class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        />
                        <span v-if="form.errors.image" class="text-red-600 text-sm">{{ form.errors.image }}</span>
                    </div>

                    <!-- Botón de envío -->
                    <div class="mt-6 text-right">
                        <button
                            type="submit"
                            class="px-4 py-2 bg-blue-600 text-white font-semibold rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        >
                            {{ title_form }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

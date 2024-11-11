<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head,} from '@inertiajs/vue3';
import NavLink from '@/Components/NavLink.vue';
import DangerButton from '@/Components/DangerButton.vue';
import DarkButton from '@/Components/DarkButton.vue';

const props = defineProps({
    player: { type: Object },
    teams: { type: Object }
});
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Player" />
        <template #header>
            <div class="inline-flex overflow-hidden mb-4 w-full">
                {{ player.first_name }} {{ player.last_name }}
            <NavLink :href="route('players.index')">
                <DarkButton>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="m3.75 13.5 10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75Z" />
</svg>

                </DarkButton>
            </NavLink>
            </div>
        </template>
        <div class="grid grap-6 bg-white mb-8:grid-cols-2 border rounded-lg">
            <div class="win-w-0 p-4 rounded-lg shadow-xs">
                <p>Nombre: <span class="text-gray-900 font-semibold">{{ player.first_name }}</span></p> 
                <p>Apellido: <span class="text-gray-900 font-semibold">{{ player.last_name }}</span></p>
                 <p>Edad: <span class="text-gray-900 font-semibold">{{ player.age }}</span></p>
                  <p>Posición: <span class="text-gray-900 font-semibold">{{ player.position }}</span></p> 
                  <p>Descripción: <span class="text-gray-900 font-semibold">{{ player.description }}</span></p> 
                  <p>Nacionalidad: <span class="text-gray-900 font-semibold">{{ player.nationality }}</span></p>
                  <p>Teams: <span v-for="teams,i in teams" class="text-gray-900 font-semibold">
                    {{ teams.name+''+teams.league+',' }}</span></p>
                </div>
            <div class="win-w-0 p-4 rounded-lg shadow-xs">
<img :src="'../Storage'+player.image" :alt="player.image">
</div>
        </div>
    </AuthenticatedLayout>
</template>

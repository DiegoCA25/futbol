<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import DangerButton from '@/Components/DangerButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import WarningButton from '@/Components/WarningButton.vue';
import DarkButton from '@/Components/DarkButton.vue';
import Modal from '@/Components/Modal.vue';
import Pagination from '@/Components/Pagination.vue';
import { ref } from 'vue';
import NavLink from '@/Components/NavLink.vue';

const props = defineProps({
    players: { type: Object },
    flash: { type: Object },
});

const form = useForm({ id: '', first_name: '' });
const showModalDel = ref(false);
const msj = ref(props.flash.success ?? '');
const classmsj = ref(props.flash.success ? '' : 'hidden');

// Abrir el modal de eliminación
const openModalDel = (player) => {
    form.id = player.id;
    form.first_name = player.first_name;
    showModalDel.value = true;
};

// Cerrar el modal de eliminación
const closeModalDel = () => {
    showModalDel.value = false;
};

// Eliminar jugador
const deletePlayer = () => {
    form.delete(route('players.destroy', form.id), {
        onSuccess: () => {
            closeModalDel();
            msj.value = 'Jugador eliminado con éxito.';
            classmsj.value = '';
            // Ocultar mensaje después de 8 segundos
            setTimeout(() => {
                classmsj.value = 'hidden';
                msj.value = '';
            }, 8000);
        },
    });
};

// Ocultar el mensaje después de 5 segundos
if (props.flash.success) {
    setTimeout(() => {
        classmsj.value = 'hidden';
        msj.value = '';
    }, 5000);
}
</script>

<template>
    <Head title="Jugadores" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-lg font-bold">Jugadores</h2>
            <DarkButton :href="route('players.create')">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Agregar Jugador
            </DarkButton>
        </template>

        <!-- Notificación de éxito -->
        <div :class="['overflow-hidden mb-4 w-full bg-white rounded-lg shadow-md', classmsj]">
            <div class="flex">
                <div class="flex items-center justify-center w-12 bg-green-500">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-white">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                    </svg>
                </div>
                <div class="px-4 py-2 -mx-3">
                    <div class="mx-3">
                        <span class="font-semibold text-green-500">Éxito</span>
                        <p class="text-sm text-gray-600">{{ msj }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabla de jugadores -->
        <div class="w-full overflow-hidden rounded-lg border shadow-md">
            <table class="w-full text-left border-collapse whitespace-no-wrap">
                <thead>
                    <tr class="text-xs font-semibold tracking-wide text-gray-500 uppercase bg-gray-100 border-b">
                        <th class="px-4 py-3">#</th>
                        <th class="px-4 py-3">Nombre</th>
                        <th class="px-4 py-3">Apellido</th>
                        <th class="px-4 py-3">Edad</th>
                        <th class="px-4 py-3">Posición</th>
                        <th class="px-4 py-3">Descripción</th>
                        <th class="px-4 py-3">Nacionalidad</th>
                        <th class="px-4 py-3">Imagen</th>
                        <th class="px-4 py-3">Ver</th>
                        <th class="px-4 py-3">Editar</th>
                        <th class="px-4 py-3">Eliminar</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(player, i) in players.data" :key="player.id" class="text-gray-700">
                        <td class="px-4 py-3">{{ i + 1 }}</td>
                        <td class="px-4 py-3">{{ player.first_name }}</td>
                        <td class="px-4 py-3">{{ player.last_name }}</td>
                        <td class="px-4 py-3">{{ player.age }}</td>
                        <td class="px-4 py-3">{{ player.position }}</td>
                        <td class="px-4 py-3">{{ player.description }}</td>
                        <td class="px-4 py-3">{{ player.nationality }}</td>
                        <td class="px-4 py-3">
                            <img :src="'/storage/' + player.image" alt="Player Image" class="w-16 h-16 object-cover rounded-full">
                        </td>
                        <td class="px-4 py-3">
                            <NavLink :href="route('players.show', player.id)">
                                <SecondaryButton>Ver</SecondaryButton>
                            </NavLink>
                        </td>
                        <td class="px-4 py-3">
                            <NavLink :href="route('players.edit', player.id)">
                            <WarningButton :href="route('players.edit', player.id)">Editar</WarningButton>
                        </NavLink>
                        </td>
                        <td class="px-4 py-3">
                            <DangerButton @click="openModalDel(player)">Eliminar</DangerButton>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Modal de confirmación para eliminar -->
        <Modal :show="showModalDel" @close="closeModalDel">
            <div class="p-6">
                <h3 class="text-lg font-semibold text-gray-800">
                    ¿Seguro que deseas eliminar el jugador "{{ form.first_name }}"?
                </h3>
                <div class="mt-4 flex justify-end">
                    <DangerButton @click="deletePlayer">Eliminar</DangerButton>
                    <SecondaryButton @click="closeModalDel" class="ml-2">Cancelar</SecondaryButton>
                </div>
            </div>
        </Modal>

        <!-- Paginación -->
        <Pagination :links="players.links" />
    </AuthenticatedLayout>
</template>

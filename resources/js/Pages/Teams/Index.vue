<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import DangerButton from '@/Components/DangerButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import WarningButton from '@/Components/WarningButton.vue';
import DarkButton from '@/Components/DarkButton.vue';
import Modal from '@/Components/Modal.vue';
import { ref } from 'vue';

const props = defineProps({
    teams: { type: Array, required: true },
    countries: { type: Array, required: true },
});

const form = useForm({
    id: null,
    name: '',
    league: '',
    country_id: null,
});

const v = ref({ id: '', name: '', league: '', country: '' });
const showModalView = ref(false);
const showModalForm = ref(false);
const showModalDel = ref(false);

const openModalView = (team) => {
    v.value = {
        id: team.id,
        name: team.name,
        league: team.league || 'Sin liga',
        country: team.country?.country || 'Desconocido',
    };
    showModalView.value = true;
};

const openModalForm = (team = { id: null, name: '', league: '', country_id: null }) => {
    form.id = team.id;
    form.name = team.name;
    form.league = team.league;
    form.country_id = team.country_id;
    showModalForm.value = true;
};

const openModalDel = (team) => {
    v.value = team;
    showModalDel.value = true;
};

const closeModalView = () => (showModalView.value = false);
const closeModalForm = () => {
    form.reset();
    showModalForm.value = false;
};
const closeModalDel = () => (showModalDel.value = false);

const save = () => {
    const routeName = form.id ? 'teams.update' : 'teams.store';
    if (form.id) {
        form.put(route(routeName, form.id), {
            onSuccess: () => {
                form.reset();
                closeModalForm();
                showNotification('Equipo actualizado');
            },
        });
    } else {
        form.post(route(routeName), {
            onSuccess: () => {
                form.reset();
                closeModalForm();
                showNotification('Equipo creado');
            },
        });
    }
};

const deleteTeam = () => {
    form.delete(route('teams.destroy', v.value.id), {
        onSuccess: () => {
            closeModalDel();
            showNotification('Equipo eliminado');
        },
    });
};

const notificationMessage = ref('');
const notificationClass = ref('hidden');

const showNotification = (message) => {
    notificationMessage.value = message;
    notificationClass.value = 'inline-flex';
    setTimeout(() => {
        notificationClass.value = 'hidden';
        notificationMessage.value = '';
    }, 8000);
};
</script>

<template>
    <Head title="Equipos" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-lg font-bold">Equipos</h2>
            <DarkButton @click="openModalForm">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M15.042 21.672 13.684 16.6m0 0-2.51 2.225.569-9.47 5.227 7.917-3.286-.672ZM12 2.25V4.5m5.834.166-1.591 1.591M20.25 10.5H18M7.757 14.743l-1.59 1.59M6 10.5H3.75m4.007-4.243-1.59-1.59" />
</svg>

            </DarkButton>
        </template>
        
        <div :class="['overflow-hidden mb-4 w-full bg-white rounded-lg shadow-md', notificationClass]">
            <div class="flex justify-center items-center w-12 bg-green-500">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-white">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                </svg>
            </div>
            <div class="px-4 py-2 -mx-3">
                <div class="mx-3">
                    <span class="font-semibold text-green-500">Éxito</span>
                    <p class="text-sm text-gray-600">{{ notificationMessage }}</p>
                </div>
            </div>
        </div>

        <div class="w-full overflow-hidden rounded-lg border shadow-md">
            <table class="w-full text-left border-collapse whitespace-no-wrap">
                <thead>
                    <tr class="text-xs font-semibold tracking-wide text-gray-500 uppercase bg-gray-100 border-b">
                        <th class="px-4 py-3">#</th>
                        <th class="px-4 py-3">Nombre</th>
                        <th class="px-4 py-3">Liga</th>
                        <th class="px-4 py-3">País</th>
                        <th class="px-4 py-3">Ver</th>
                        <th class="px-4 py-3">Editar</th>
                        <th class="px-4 py-3">Eliminar</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(team, index) in teams" :key="team.id" class="text-gray-700">
                        <td class="px-4 py-3">{{ index + 1 }}</td>
                        <td class="px-4 py-3">{{ team.name }}</td>
                        <td class="px-4 py-3">{{ team.league }}</td>
                        <td class="px-4 py-3">{{ team.country?.country || 'Desconocido' }}</td>
                        <td class="px-4 py-3">
                            <SecondaryButton @click="openModalView(team)">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z" />
</svg>

                            </SecondaryButton>
                        </td>
                        <td class="px-4 py-3">
                            <WarningButton @click="openModalForm(team)">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17 17.25 21A2.652 2.652 0 0 0 21 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 1 1-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.14a4.5 4.5 0 0 0 4.486-6.336l-3.276 3.277a3.004 3.004 0 0 1-2.25-2.25l3.276-3.276a4.5 4.5 0 0 0-6.336 4.486c.091 1.076-.071 2.264-.904 2.95l-.102.085m-1.745 1.437L5.909 7.5H4.5L2.25 3.75l1.5-1.5L7.5 4.5v1.409l4.26 4.26m-1.745 1.437 1.745-1.437m6.615 8.206L15.75 15.75M4.867 19.125h.008v.008h-.008v-.008Z" />
</svg>

                            </WarningButton>
                        </td>
                        <td class="px-4 py-3">
                            <DangerButton @click="openModalDel(team)">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
</svg>

                            </DangerButton>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <Modal :show="showModalView" @close="closeModalView">
            <div class="p-6">
                <p class="text-lg font-bold">Nombre: {{ v.name }}</p>
                <p>Liga: {{ v.league }}</p>
                <p>País: {{ v.country }}</p>
            </div>
        </Modal>

        <Modal :show="showModalForm" @close="closeModalForm">
            <div class="p-6">
                <h2 class="text-xl font-semibold mb-4 text-gray-800">{{ form.id ? 'Editar' : 'Crear' }} Equipo</h2>
                <form @submit.prevent="save">
                    <div class="mt-4 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Z" />
</svg>

                        <input id="name" v-model="form.name" class="form-input block w-full text-sm" type="text" placeholder="Nombre del equipo" />
                    </div>
                    <div class="mt-4 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M3 3v1.5M3 21v-6m0 0 2.77-.693a9 9 0 0 1 6.208.682l.108.054a9 9 0 0 0 6.086.71l3.114-.732a48.524 48.524 0 0 1-.005-10.499l-3.11.732a9 9 0 0 1-6.085-.711l-.108-.054a9 9 0 0 0-6.208-.682L3 4.5M3 15V4.5" />
</svg>

                        <input id="league" v-model="form.league" class="form-input block w-full text-sm" type="text" placeholder="Liga" />
                    </div>
                    <div class="mt-4 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="m6.115 5.19.319 1.913A6 6 0 0 0 8.11 10.36L9.75 12l-.387.775c-.217.433-.132.956.21 1.298l1.348 1.348c.21.21.329.497.329.795v1.089c0 .426.24.815.622 1.006l.153.076c.433.217.956.132 1.298-.21l.723-.723a8.7 8.7 0 0 0 2.288-4.042 1.087 1.087 0 0 0-.358-1.099l-1.33-1.108c-.251-.21-.582-.299-.905-.245l-1.17.195a1.125 1.125 0 0 1-.98-.314l-.295-.295a1.125 1.125 0 0 1 0-1.591l.13-.132a1.125 1.125 0 0 1 1.3-.21l.603.302a.809.809 0 0 0 1.086-1.086L14.25 7.5l1.256-.837a4.5 4.5 0 0 0 1.528-1.732l.146-.292M6.115 5.19A9 9 0 1 0 17.18 4.64M6.115 5.19A8.965 8.965 0 0 1 12 3c1.929 0 3.716.607 5.18 1.64" />
</svg>

    <select v-model="form.country_id" class="form-select w-full">
        <option value="" disabled>Seleccione un país</option>
        <option v-for="country in countries" :key="country.id" :value="country.id">{{ country.country }}</option>
    </select>
</div>

                    <div class="mt-6 flex justify-end space-x-4">
                        <SecondaryButton @click="closeModalForm">Cancelar</SecondaryButton>
                        <DarkButton type="submit">Guardar</DarkButton>
                    </div>
                </form>
            </div>
        </Modal>

        <Modal :show="showModalDel" @close="closeModalDel">
            <div class="p-6">
                <p>¿Estás seguro de eliminar el equipo {{ v.name }}?</p>
                <div class="mt-6 flex justify-end space-x-4">
                    <SecondaryButton @click="closeModalDel">Cancelar</SecondaryButton>
                    <DangerButton @click="deleteTeam">Eliminar</DangerButton>
                </div>
            </div>
        </Modal>
    </AuthenticatedLayout>
</template>

<style scoped>
/* Estilo adicional para iconos y botones */
</style>

<template>
    <CardBox v-if="requests.data.length > 0" hasTable>
        <table>
            <thead>
                <tr>
                    <SortableHeader column="name" label="Nombre" />
                    <SortableHeader column="email" label="Correo electrónico" />
                    <SortableHeader column="organization_type" label="Tipo" />
                    <SortableHeader column="state" label="Estado" />
                    <SortableHeader column="municipality" label="Municipio" />
                    <SortableHeader column="created_at" label="Fecha de solicitud" />
                    <SortableHeader column="status" label="Estatus" />
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>
                <tr v-for="item in requests.data" :key="item.id">
                    <td data-label="Nombre">
                        {{ item.name }}
                    </td>

                    <td data-label="Correo electrónico">
                        {{ item.email }}
                    </td>

                    <td data-label="Tipo">
                        {{ item.organization_type }}
                    </td>

                    <td data-label="Estado">
                        <span v-if="item.state">
                            {{ item.state.name }}
                        </span>
                        <Badge v-else variant="soft">
                            N/A
                        </Badge>
                    </td>

                    <td data-label="Municipio">
                        <span v-if="item.municipality">
                            {{ item.municipality.name }}
                        </span>
                        <Badge v-else variant="soft">
                            N/A
                        </Badge>
                    </td>

                    <td data-label="Fecha de solicitud">
                        {{ item.created_at?.formatted || 'N/A' }}
                    </td>

                    <td data-label="Estatus">
                        <Badge v-if="item.status?.name" :color="getStatusColor(item.status.name)" showDot variant="soft">
                            {{ item.status.name }}
                        </Badge>
                    </td>

                    <td data-label="Acciones">
                        <BaseButtons>
                            <BaseButton :icon="mdiMagnify" color="info" small @click="openModal(item)" title="Revisar solicitud" />
                        </BaseButtons>
                    </td>
                </tr>
            </tbody>
        </table>
    </CardBox>

    <CardBoxComponentEmpty v-else />

    <Pagination :links="requests.meta.links" :total="requests.meta.total" :to="requests.meta.to"
        :from="requests.meta.from" />
</template>

<script setup>
import Badge from '@/Components/Badge.vue';
import BaseButton from '@/Components/BaseButton.vue';
import BaseButtons from '@/Components/BaseButtons.vue';
import CardBox from '@/Components/CardBox.vue';
import CardBoxComponentEmpty from '@/Components/CardBoxComponentEmpty.vue';
import Pagination from '@/Components/Pagination.vue';
import SortableHeader from '@/Components/Table/SortableHeader.vue';
import { mdiMagnify } from '@mdi/js';

defineProps({
    requests: Object,
});

const emit = defineEmits(['openModal']);

const openModal = (item) => emit('openModal', item);

const getStatusColor = (status) => {
    const colors = {
        'Pendiente': 'yellow',
        'Aceptada': 'green',
        'Rechazada': 'red',
    };
    return colors[status] || 'gray';
};
</script>

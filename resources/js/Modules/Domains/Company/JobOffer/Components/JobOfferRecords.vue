<template>
    <CardBox v-if="jobOffers.data && jobOffers.data.length > 0">
        <table>
            <thead>
                <tr>
                    <th v-if="canEnable"></th>
                    <SortableHeader column="position" label="Puesto" />
                    <SortableHeader column="job_offer_type_id" label="Tipo de Oferta" />
                    <SortableHeader column="start_date" label="Fecha Inicio" />
                    <SortableHeader column="end_date" label="Fecha Cierre" />
                    <SortableHeader column="academic_degree_id" label="Grado académico" />
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="item in jobOffers.data" :key="item.id">
                    <TableCheckboxCell v-if="canEnable" @confirm="enableJobOffer(item.id)" type="switch"
                        v-model="item.is_active" confirm />
                    <td data-label="Puesto">
                        {{ item.position }}
                    </td>
                    <td data-label="Tipo de Oferta">
                        <span v-if="item.job_offer_type">
                            {{ item.job_offer_type.name }}
                        </span>
                        <Badge v-else variant="soft">
                            No asignado
                        </Badge>
                    </td>
                    <td data-label="Fecha Inicio">
                        {{ item.start_date ?? 'No definida' }}
                    </td>
                    <td data-label="Fecha Cierre">
                        <span v-if="item.end_date">
                            {{ item.end_date }}
                        </span>
                        <Badge v-else variant="soft">
                            No asignada
                        </Badge>
                    </td>
                    <td data-label="Grado académico">
                        <span v-if="item.academic_degree">
                            {{ item.academic_degree.name }}
                        </span>
                        <Badge v-else variant="soft">
                            No asignado
                        </Badge>
                    </td>
                    <td data-label="Acciones">
                        <BaseButtons>
                            <BaseButton color="info" :icon="mdiPencil" small :routeName="`${routeName}edit`"
                                :parameter="item.id" title="Editar oferta" />
                            <BaseButton @click="deleteJobOffer(item.id)" color="danger" :icon="mdiTrashCan" small
                                title="Eliminar oferta" />
                        </BaseButtons>
                    </td>
                </tr>
            </tbody>
        </table>
    </CardBox>

    <CardBoxComponentEmpty v-else />

    <Pagination :links="jobOffers.meta.links" :total="jobOffers.meta.total" :to="jobOffers.meta.to"
        :from="jobOffers.meta.from" />
</template>

<script setup>
import Badge from '@/Components/Badge.vue';
import BaseButton from '@/Components/BaseButton.vue';
import BaseButtons from '@/Components/BaseButtons.vue';
import CardBox from '@/Components/CardBox.vue';
import CardBoxComponentEmpty from '@/Components/CardBoxComponentEmpty.vue';
import Pagination from '@/Components/Pagination.vue';
import { mdiPencil, mdiTrashCan } from '@mdi/js';
import { deleteJobOffer, enableJobOffer } from '../Composables/useJobOffer';
import SortableHeader from '@/Components/Table/SortableHeader.vue';
import { verifyPermission } from '@/Hooks/usePermissions';
import TableCheckboxCell from '@/Components/TableCheckboxCell.vue';

const props = defineProps({
    jobOffers: Object,
    routeName: String,
});

const canEnable = verifyPermission('jobOffers.enable');

</script>
<template>
    <CardBox v-if="certifications.data.length > 0">
        <table>
            <thead>
                <tr>
                    <th v-if="canEnable"></th>
                    <SortableHeader @sort="sortByColumn" :filters="filters" column="name" label="Nombre"/>
                    <SortableHeader @sort="sortByColumn" :filters="filters" column="certification_level" label="Nivel de certificación"/>
                    <SortableHeader @sort="sortByColumn" :filters="filters" column="certifying_entity" label="Entidad certificadora"/>
                    <SortableHeader @sort="sortByColumn" :filters="filters" column="is_active" label="Estado"/>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>
                <tr v-for="item in certifications.data" :key="item.id">
                    <TableCheckboxCell v-if="canEnable" @confirm="enable(item.id)" type="switch"
                            v-model="item.is_active" confirm />
                    <td data-label="Nombre">
                        {{ item.name }}
                    </td>
                    <td data-label="Nivel de certificación">
                        {{ item.certification_level.name }}
                    </td>
                    <td data-label="certifying_entity">
                        {{ item.certifying_entity }}
                    </td>
                    <td data-label="Habilitado">

                        <Badge v-if="item.is_active" color="green" variant="soft">
                            Habilitado
                        </Badge>

                        <Badge v-else color="gray" variant="soft">
                            Deshabilitado
                        </Badge>
                    </td>
                    <td data-label="Acciones">
                        <BaseButtons>
                            <BaseButton color="info" :icon="mdiPencil" small :routeName="`${routeName}edit`" :parameter="item.id"
                                title="Editar certificación" />
                            <BaseButton color="danger" :icon="mdiTrashCan" small title="Eliminar certificación" @click="deleteCertification(item)" />
                        </BaseButtons>
                    </td>
                </tr>
            </tbody>
        </table>

        <Pagination :links="certifications.meta.links" :total="certifications.meta.total" :to="certifications.meta.to"
            :from="certifications.meta.from" />
    </CardBox>

    <CardBoxComponentEmpty v-else />
</template>

<script setup>
import Badge from '@/Components/Badge.vue';
import BaseButton from '@/Components/BaseButton.vue';
import BaseButtons from '@/Components/BaseButtons.vue';
import CardBox from '@/Components/CardBox.vue';
import CardBoxComponentEmpty from '@/Components/CardBoxComponentEmpty.vue';
import Pagination from '@/Components/Pagination.vue';
import { mdiPencil, mdiTrashCan } from '@mdi/js';
import { useCertification } from '../Composables/useCertification';
import SortableHeader from '@/Components/Table/SortableHeader.vue';
import TableCheckboxCell from "@/Components/TableCheckboxCell.vue";

const props = defineProps({
    certifications: Object,
    routeName: String,
    sortByColumn: Function,
    filters: Object
});

const { deleteForm, enable } = useCertification(props);
const canEnable = () => verifyPermission(`${props.routeName}enable`);

const deleteCertification = (certification) => {
    deleteForm(certification);
}
</script>
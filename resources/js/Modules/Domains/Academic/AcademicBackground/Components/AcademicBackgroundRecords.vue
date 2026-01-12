<template>
    <CardBox v-if="academicDegreeRecords.data.length > 0">
        <table>
            <thead>
                <tr>
                    <th>Grado</th>
                    <th>Título</th>
                    <th>Area de conocimiento</th>
                    <th>Fecha finalización</th>
                    <th>No. de cédula</th>
                </tr>
            </thead>

            <tbody>
                <tr v-for="item in academicDegreeRecords.data" :key="item.id">
                    <td data-label="Grado">
                        {{ item.academic_degree }}
                    </td>
                    <td data-label="Título">
                        {{ item.academic_title }}
                    </td>
                    <td data-label="Área de conocimiento">
                        {{ item.knowledge_area }}
                    </td>
                    <td data-label="Fecha finalización">
                        {{ item.end_date }}
                    </td>
                    <td data-label="No. de cédula">
                        {{ item.certificate_number }}
                    </td>
                    <td data-label="Acciones">
                        <BaseButtons>
                            <BaseButton color="info" :icon="mdiPencil" small :routeName="`${routeName}create`"
                                title="Editar oferta" />
                            <BaseButton color="danger" :icon="mdiTrashCan" small title="Eliminar grado" />
                        </BaseButtons>
                    </td>
                </tr>
            </tbody>
        </table>


        <Pagination :links="academicDegreeRecords.meta.links" :total="academicDegreeRecords.meta.total" :to="academicDegreeRecords.meta.to"
            :from="academicDegreeRecords.meta.from" />
    </CardBox>

    <CardBoxComponentEmpty v-else />
</template>

<script setup>
import BaseButton from '@/Components/BaseButton.vue';
import BaseButtons from '@/Components/BaseButtons.vue';
import CardBox from '@/Components/CardBox.vue';
import CardBoxComponentEmpty from '@/Components/CardBoxComponentEmpty.vue';
import Pagination from '@/Components/Pagination.vue';
import { mdiPencil, mdiTrashCan } from '@mdi/js';

const props = defineProps({
    academicDegreeRecords: { type: Object, default: () => ({ data: [] }) },
    routeName: { type: String, default: "academics.academicBackgrounds." }
});
</script>
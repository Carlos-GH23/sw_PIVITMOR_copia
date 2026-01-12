<template>
    <CardBox v-if="notices?.data && notices.data.length > 0" class="mt-2">
        <table>
            <thead>
                <tr>
                    <SortableHeader @sort="sortByColumn" :filters="filters" column="title" label="Titulo" />
                    <SortableHeader @sort="sortByColumn" :filters="filters" column="category" label="Categoría" />
                    <SortableHeader @sort="sortByColumn" :filters="filters" column="publication_date" label="Fecha de publicación" />
                    <SortableHeader @sort="sortByColumn" :filters="filters" column="status" label="Estatus" />
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>
                <tr v-for="item in notices.data" :key="item.id">
                    <td data-label="Título">
                        {{ item.title }}
                    </td>
                    <td data-label="Categoría">
                        <span v-if="item.category">{{ item.category?.name }}</span>
                        <span v-else class="text-gray-400">Sin categoría</span>
                    </td>
                    <td data-label="Publicación">
                        <span v-if="item.publication_date">{{ item.formatted_date?.human }}</span>
                        <span v-else class="text-gray-400">No programada</span>
                    </td>
                    <td data-label="Estatus">
                        <span>
                            <Badge  :color="item.status?.color" :text="item.status?.name">
                            {{ item.status?.name }}
                            </Badge>
                        </span>
                    </td>
                    <td data-label="Acciones">
                        <div class="flex gap-4">
                        <BaseButtons>
                            <BaseButton  color="info" :icon="mdiPencil" small :routeName="`${routeName}edit`" :parameter="item.id"
                                 title="Editar noticia" />
                        </BaseButtons>
                        <BaseButton color="danger" :icon="mdiTrashCan" small @click="deleteNotice(item)"
                                        title="Eliminar instalación" />
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </CardBox>

    <CardBoxComponentEmpty v-else />

    <pagination v-if="notices?.meta" :links="notices.meta.links" :total="notices.meta.total" :to="notices.meta.to" :from="notices.meta.from" />
</template>

<script setup>
import Badge from '@/Components/Badge.vue';
import BaseButton from '@/Components/BaseButton.vue';
import BaseButtons from '@/Components/BaseButtons.vue';
import CardBox from '@/Components/CardBox.vue';
import CardBoxComponentEmpty from '@/Components/CardBoxComponentEmpty.vue';
import Pagination from '@/Components/Pagination.vue';
import { mdiPencil, mdiTrashCan } from '@mdi/js';
import { useNotice } from '../Composables/useNotice';
import SortableHeader from "@/Components/Table/SortableHeader.vue";

const props = defineProps({
    notices: {
        type: Object,
        required: true,
    },
    routeName: {
        type: String,
        required: true,
    },
    filters: {
        type: Object,
        required: true,
    },
    sortByColumn: {
        type: Function,
        required: true,
    },
});

const { deleteForm } = useNotice(props);

const deleteNotice = (notice) => {
    deleteForm(notice);
}


</script>
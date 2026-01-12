<template>
    <CardBox v-if="technologyServices.data.length > 0">
        <table>
            <thead>
                <tr>
                    <SortableHeader label="Título" column="title" />
                    <SortableHeader label="Departamento Académico" column="department" />
                    <SortableHeader label="Fecha Inicio" column="start_date" />
                    <SortableHeader label="Fecha Cierre" column="end_date" />
                    <th>Estatus</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="item in technologyServices.data" :key="item.id">
                    <td data-label="Titulo">
                        <div class="leading-relaxed line-clamp-2">
                            {{ item.title }}
                        </div>
                    </td>
                    <td data-label="Departamento">
                        {{ item.department?.name || 'Sin departamento' }}
                    </td>
                    <td data-label="Fecha Inicio">
                        {{ item.start_date.human }}
                    </td>
                    <td data-label="Fecha Fin">
                        {{ item.end_date.human || 'Sin fecha' }}
                    </td>
                    <td data-label="Estatus">
                        <Badge size="md" color="yellow" showDot>
                            {{ item.status?.name || 'Sin estado' }}
                        </Badge>
                    </td>
                    <td data-label="acciones">
                        <BaseButtons>
                            <BaseButton color="success" :icon="mdiCheckDecagram" small :routeName="`${routeName}create`"
                                :parameter="item.id" title="Evaluar" />
                        </BaseButtons>
                    </td>
                </tr>
            </tbody>
        </table>
    </CardBox>

    <CardBoxComponentEmpty v-else />

    <Pagination :links="technologyServices.meta.links" :total="technologyServices.meta.total"
        :to="technologyServices.meta.to" :from="technologyServices.meta.from" />
</template>

<script setup>
import Badge from "@/Components/Badge.vue";
import BaseButton from "@/Components/BaseButton.vue";
import BaseButtons from "@/Components/BaseButtons.vue";
import CardBox from "@/Components/CardBox.vue";
import CardBoxComponentEmpty from "@/Components/CardBoxComponentEmpty.vue";
import Pagination from "@/Components/Pagination.vue";
import SortableHeader from "@/Components/Table/SortableHeader.vue";

import {
    mdiCheckDecagram,
} from "@mdi/js";

defineProps({
    technologyServices: Object,
    routeName: String,
});
</script>

<template>
    <CardBox v-if="capabilities.data.length > 0">
        <table>
            <thead>
                <tr>
                    <SortableHeader column="title" label="Título" />
                    <SortableHeader column="department" label="Departamento Académico" />
                    <SortableHeader column="start_date" label="Fecha inicio" />
                    <SortableHeader column="end_date" label="Fecha fin" />
                    <th>Estatus</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="item in capabilities.data" :key="item.id">
                    <td data-label="Titulo">
                        <div class="leading-relaxed line-clamp-2">
                            {{ item.title }}
                        </div>
                    </td>
                    <td data-label="Departamento">
                        <span v-if="item.department">
                            {{ item.department.name }}
                        </span>

                        <Badge v-else variant="soft">
                            No asignado
                        </Badge>
                    </td>
                    <td data-label="Fecha Inicio">
                        <span v-if="item.start_date?.human">
                            {{ item.start_date?.human }}
                        </span>

                        <Badge v-else variant="soft">
                            No especificado
                        </Badge>
                    </td>
                    <td data-label="Fecha Fin">
                        <span v-if="item.end_date?.human">
                            {{ item.end_date?.human }}
                        </span>

                        <Badge v-else variant="soft">
                            No especificado
                        </Badge>
                    </td>
                    <td data-label="Estatus">
                        <Badge v-if="item.status?.name" :color="item.status.color" showDot variant="soft">
                            {{ item.status.name }}
                        </Badge>
                    </td>
                    <td data-label="acciones">
                        <BaseButtons>
                            <BaseButton color="success" :icon="mdiCheckDecagram" small :routeName="`${routeName}create`"
                                :parameter="item.id" title="Editar" />
                        </BaseButtons>
                    </td>
                </tr>
            </tbody>
        </table>
    </CardBox>

    <CardBoxComponentEmpty v-else />

    <Pagination :links="capabilities.meta.links" :total="capabilities.meta.total" :to="capabilities.meta.to"
        :from="capabilities.meta.from" />
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
    capabilities: Object,
    routeName: String,
});
</script>
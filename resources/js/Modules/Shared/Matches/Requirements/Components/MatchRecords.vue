<template>
    <CardBox v-if="matches.data.length > 0">
        <table>
            <thead>
                <tr>
                    <SortableHeader column="requirement" label="Necesidad" />
                    <SortableHeader column="capability" label="Capacidad" />
                    <th>Institución</th>
                    <SortableHeader column="compatibility_score" label="Similitud" />
                    <SortableHeader column="status" label="Estatus" />
                    <th>Evaluación</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="item in matches.data" :key="item.id">
                    <td data-label="Necesidad">
                        <div class="leading-relaxed line-clamp-2">
                            {{ item.requirement.title }}
                        </div>
                    </td>
                    <td data-label="Capacidad">
                        <div class="leading-relaxed line-clamp-2">
                            {{ item.capability.title }}
                        </div>
                    </td>
                    <td data-label="Institución"> <!-- institucion de la capacidad -->
                        {{ item.capability.user.academic.department.institution.name }}
                    </td>
                    <td data-label="Similitud">
                        {{ decimalToPercentage(item.compatibility_score) }}
                    </td>
                    <td data-label="Estatus">
                        <Badge :color="item.match_status.color" size="md" show-dot
                            :title="item.match_status.description">
                            {{ item.match_status.name }}
                        </Badge>
                    </td>
                    <td data-label="Evaluación">
                        <BaseIcon v-bind="iconStatus(item)" />
                    </td>
                    <td data-label="acciones">
                        <BaseButtons>
                            <BaseButton color="success" :icon="mdiCheckDecagram" title="Aceptar o rechazar"
                                @click="openForm(item)" />
                            <BaseButton :disabled="actionButtons(item).disabled" color="info" :icon="mdiHelp"
                                title="Formulario de evualuación" :href="actionButtons(item).route" />
                        </BaseButtons>
                    </td>
                </tr>
            </tbody>
        </table>
    </CardBox>
    <CardBoxComponentEmpty v-else />
    <pagination :links="matches.meta.links" :total="matches.meta.total" :to="matches.meta.to"
        :from="matches.meta.from" />
</template>
<script setup>
import CardBox from "@/Components/CardBox.vue";
import CardBoxComponentEmpty from "@/Components/CardBoxComponentEmpty.vue";
import Pagination from "@/Components/Pagination.vue";
import Badge from "@/Components/Badge.vue";
import { decimalToPercentage } from "@/Hooks/useFormat";
import { mdiCheckDecagram, mdiHelp } from "@mdi/js";
import BaseButton from "@/Components/BaseButton.vue";
import BaseButtons from "@/Components/BaseButtons.vue";
import BaseIcon from "@/Components/BaseIcon.vue";
import { useConfigEvaluation } from "@/Hooks/useMatchEvaluation";
import SortableHeader from "@/Components/Table/SortableHeader.vue";

const props = defineProps({
    matches: Object,
    routeName: String,
});

const emit = defineEmits(['open-form']);
const { iconStatus, actionButtons } = useConfigEvaluation(props.routeName, 'applicant_evaluation');

const openForm = (item) => {
    emit('open-form', item);
}
</script>
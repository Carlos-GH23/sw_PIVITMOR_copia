<template>
    <HeadLogo :title="title" />
    <loading v-model:active="isLoading" :can-cancel="false" :is-full-page="true" loader="dots" color="#283C2A" />
    <LayoutMain>
        <SectionTitleLineWithButton :icon="mdiHandCoin" :title="title" main />

        <SearchBar @apply-filters="applyFilters" @clear-filters="clearFilters" v-model:search="filters.search"
            v-model:rows="filters.rows" :routeName="routeName" :total="matchEvaluations.meta.total" />

        <CardBox v-if="matchEvaluations.data.length > 0">
            <table>
                <thead>
                    <tr>
                        <th />
                        <SortableHeader column="title" label="Titulo" />
                        <SortableHeader column="capability" label="Capacidad" />
                        <SortableHeader column="requirement" label="Necesidad" />
                        <SortableHeader column="compatibility_score" label="Similitud" />
                        <th>Estatus</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="item in matchEvaluations.data" :key="item.id">
                        <td>
                            <div class="flex lg:gap-11 items-center">
                                <TableCheckboxCell @confirm="updateSuccessStory(item.id)" type="switch"
                                    v-model="item.is_success_story" confirm />
                                <BaseIcon :path="item.is_success_story ? mdiEye : mdiEyeOff" size="18" h="h-auto"
                                    w="w-auto" :class="item.is_success_story ? 'text-success-400' : 'text-gray-500'" />
                            </div>
                        </td>
                        <td data-label="Titulo">
                            <div class="leading-relaxed line-clamp-2">
                                {{ item.title }}
                            </div>
                        </td>
                        <td data-label="Capacidad">
                            {{ item.match.capability.title }}
                        </td>
                        <td data-label="Necesidad">
                            {{ item.match.requirement.title }}
                        </td>
                        <td data-label="Similitud">
                            {{ decimalToPercentage(item.match.compatibility_score) }}
                        </td>
                        <td data-label="Estatus">
                            <Badge :color="item.status.color" size="md" showDot :title="item.status.description">
                                {{ item.status.name }}
                            </Badge>
                        </td>
                        <td data-label="acciones">
                            <BaseButtons>
                                <BaseButton color="info" :icon="mdiEye" small title="Ver evaluación"
                                    :routeName="`${routeName}show`" :parameter="item.id" />
                            </BaseButtons>
                        </td>
                    </tr>
                </tbody>
            </table>
        </CardBox>
        <CardBoxComponentEmpty v-else />
        <pagination :links="matchEvaluations.meta.links" :total="matchEvaluations.meta.total"
            :to="matchEvaluations.meta.to" :from="matchEvaluations.meta.from" />
    </LayoutMain>
</template>
<script setup>
import LayoutMain from "@/Layouts/LayoutMain.vue";
import SectionTitleLineWithButton from "@/Components/SectionTitleLineWithButton.vue";
import {
    mdiHandCoin,
    mdiEye,
    mdiEyeOff,
} from "@mdi/js";
import HeadLogo from "@/Components/HeadLogo.vue";
import { useFilters } from "@/Hooks/useFilters";
import SearchBar from "@/Components/SearchBar.vue";
import pagination from "@/Components/Pagination.vue";
import CardBoxComponentEmpty from "@/Components/CardBoxComponentEmpty.vue";
import CardBox from "@/Components/CardBox.vue";
import TableCheckboxCell from "@/Components/TableCheckboxCell.vue";
import BaseButtons from "@/Components/BaseButtons.vue";
import BaseButton from "@/Components/BaseButton.vue";
import Badge from "@/Components/Badge.vue";
import SortableHeader from "@/Components/Table/SortableHeader.vue";
import { provide } from "vue";
import { decimalToPercentage } from "@/Hooks/useFormat";
import BaseIcon from "@/Components/BaseIcon.vue";
import { updateSuccessStory } from "../Composables/useMatchEvaluation";

const props = defineProps({
    title: {
        type: String,
        required: true,
    },
    matchEvaluations: {
        type: Object,
        default: () => ({}),
        required: true,
    },
    routeName: {
        type: String,
        required: true,
    },
    filters: {
        type: Object,
        required: true
    },
});

const { filters, clearFilters, applyFilters, isLoading, sortByColumn } = useFilters(props.filters, props.routeName);

provide('filters', filters);
provide('sortByColumn', sortByColumn);
</script>
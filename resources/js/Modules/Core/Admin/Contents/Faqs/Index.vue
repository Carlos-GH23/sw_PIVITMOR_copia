
<template>
    <HeadLogo :title="title" />
    <loading v-model:active="isLoading" :can-cancel="false" :is-full-page="true" loader="dots" color="#283C2A" />
    <LayoutMain>
        <SectionTitleLineWithButton :icon="mdiChatQuestion" :title="title" main />

        <SearchBar @apply-filters="applyFilters" @clear-filters="clearFilters" v-model:search="filters.search"
            v-model:rows="filters.rows" :routeName="routeName" title="pregunta" :total="faqs.meta.total" />

        <CardBox v-if="faqs.data.length > 0">
            <table>
                <thead>
                    <tr>
                        <SortableHeader @sort="sortByColumn" :filters="filters" column="question" label="Pregunta" />
                        <SortableHeader @sort="sortByColumn" :filters="filters" column="answer" label="Respuesta" />
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="item in faqs.data" :key="item.id">
                        <td data-label="Pregunta">
                            {{ item.question }}
                        </td>
                        <td data-label="Respuesta">
                            {{ truncateText(item.answer, 100) }}
                        </td>
                        <td data-label="Acciones">
                            <BaseButtons>
                                <BaseButton color="info" :icon="mdiPencil" small :routeName="`${routeName}edit`"
                                    :parameter="item.id" title="Editar pregunta" />
                                <BaseButton color="danger" :icon="mdiTrashCan" @click="deleteForm(item)" title="Eliminar pregunta"/>
                            </BaseButtons>
                        </td>
                    </tr>
                </tbody>
            </table>
        </CardBox>
        <CardBoxComponentEmpty v-else />
        <pagination :links="faqs.meta.links" :total="faqs.meta.total" :to="faqs.meta.to" :from="faqs.meta.from" />
    </LayoutMain>
</template>

<script setup>
import { router } from '@inertiajs/vue3';
import CardBox from "@/Components/CardBox.vue";
import LayoutMain from "@/Layouts/LayoutMain.vue";
import SectionTitleLineWithButton from "@/Components/SectionTitleLineWithButton.vue";
import {
    mdiChatQuestion,
    mdiPencil,
    mdiTrashCan,
} from "@mdi/js";
import BaseButton from "@/Components/BaseButton.vue";
import BaseButtons from "@/Components/BaseButtons.vue";
import CardBoxComponentEmpty from "@/Components/CardBoxComponentEmpty.vue";
import Pagination from "@/Components/Pagination.vue";
import HeadLogo from "@/Components/HeadLogo.vue";
import { useFilters } from "@/Hooks/useFilters";
import SearchBar from "@/Components/SearchBar.vue";
import SortableHeader from "@/Components/Table/SortableHeader.vue";
import { messageConfirm } from "@/Hooks/useErrorsForm";

const props = defineProps({
    title: {
        type: String,
        required: true,
    },
    faqs: {
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

function truncateText(text, maxLength = 100) {
    if (!text) return '';
    return text.length > maxLength ? text.slice(0, maxLength) + '...' : text;
}

async function deleteForm(item) {
    const result = await messageConfirm();
    if (!result.isConfirmed) return;
    router.delete(route(`${props.routeName}destroy`, item.id), {
        preserveScroll: true,
    });
}
</script>

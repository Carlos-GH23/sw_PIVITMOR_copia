<template>
    <HeadLogo :title="title" />
    <loading v-model:active="isLoading" :can-cancel="false" :is-full-page="true" loader="dots" color="#283C2A" />
    <LayoutMain>
        <SectionTitleLineWithButton :icon="mdiViewModule" :title="title" main />

        <SearchBar @apply-filters="applyFilters" @clear-filters="clearFilters" v-model:search="filters.search"
            v-model:rows="filters.rows" :routeName="routeName" title="sector" :total="economic_sectors.meta.total">
            <template #filters>
                <FormField class="order-2 sm:order-1 min-w-[200px]" label="Nivel">
                    <FormControl v-model="filters.level" @change="applyFilters(true)" placeholder="Seleccione un nivel"
                        :options="levelOptions" valueSelect="value" valueOption="label" />
                </FormField>
            </template>
        </SearchBar>

        <CardBox v-if="economic_sectors.data.length > 0">
            <table>
                <thead>
                    <tr>
                        <SortableHeader @sort="sortByColumn" :filters="filters" column="name" label="Nombre" />
                        <SortableHeader @sort="sortByColumn" :filters="filters" column="level" label="Nivel" />
                        <SortableHeader @sort="sortByColumn" :filters="filters" column="economic_social_sector_id"
                            label="Sector Económico-Social" />
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="item in economic_sectors.data" :key="item.id">
                        <td data-label="Nombre">
                            {{ item.name }}
                        </td>
                        <td data-label="Nivel">
                            {{ getLevelLabel(item.level) }}
                        </td>
                        <td data-label="Sector Social Económico">
                            {{ item.economic_social_sector?.name ?? 'N/A' }}
                        </td>
                        <td data-label="acciones">
                            <BaseButtons>
                                <BaseButton color="info" :icon="mdiPencil" small :routeName="`${routeName}edit`"
                                    :parameter="item.id" title="Editar sector" />
                                <BaseButton color="danger" :icon="mdiTrashCan" small @click="deleteForm(item)"
                                    title="Eliminar instalación" />
                            </BaseButtons>
                        </td>
                    </tr>
                </tbody>
            </table>
        </CardBox>
        <CardBoxComponentEmpty v-else />
        <pagination :links="economic_sectors.meta.links" :total="economic_sectors.meta.total"
            :to="economic_sectors.meta.to" :from="economic_sectors.meta.from" />
    </LayoutMain>
</template>
<script setup>
import CardBox from "@/Components/CardBox.vue";
import LayoutMain from "@/Layouts/LayoutMain.vue";
import SectionTitleLineWithButton from "@/Components/SectionTitleLineWithButton.vue";
import {
    mdiViewModule,
    mdiPencil,
    mdiTrashCan
} from "@mdi/js";
import BaseButton from "@/Components/BaseButton.vue";
import BaseButtons from "@/Components/BaseButtons.vue";
import CardBoxComponentEmpty from "@/Components/CardBoxComponentEmpty.vue";
import Pagination from "@/Components/Pagination.vue";
import HeadLogo from "@/Components/HeadLogo.vue";
import { useFilters } from "@/Hooks/useFilters";
import SearchBar from "@/Components/SearchBar.vue";
import SortableHeader from "@/Components/Table/SortableHeader.vue";
import FormField from "@/Components/FormField.vue";
import FormControl from "@/Components/FormControl.vue";
import { messageConfirm } from "@/Hooks/useErrorsForm";
import { router } from "@inertiajs/vue3";

const props = defineProps({
    title: {
        type: String,
        required: true,
    },
    economic_sectors: {
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
    levelOptions: {
        type: Array,
        default: () => [],
    },
});

const { filters, clearFilters, applyFilters, isLoading, sortByColumn } = useFilters(props.filters, props.routeName);

const getLevelLabel = (levelValue) => {
    if (!props.levelOptions) return levelValue;
    if (Array.isArray(props.levelOptions)) {
        const found = props.levelOptions.find(opt => opt.value == levelValue);
        return found ? found.label : levelValue;
    }
    return props.levelOptions[levelValue] || levelValue;
};

const deleteForm = (economicSector) => {
    messageConfirm().then((res) => {
        if (res.isConfirmed) {
            router.delete(route(`${props.routeName}destroy`, economicSector));
        }
    });
};
</script>
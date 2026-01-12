<template>
    <HeadLogo :title="title" />
    <loading v-model:active="isLoading" :can-cancel="false" :is-full-page="true" loader="dots" color="#283C2A" />
    <LayoutMain>
        <SectionTitleLineWithButton :icon="mdiSchoolOutline" :title="title" main />

        <SearchBar @apply-filters="applyFilters" @clear-filters="clearFilters" v-model:search="filters.search"
            v-model:rows="filters.rows" :routeName="routeName" title="disciplina" :total="oecdData?.meta?.total || 0">
            <template #filters>
                <FormField class="order-2 sm:order-1 min-w-[200px]" label="Nivel">
                    <FormControl v-model="filters.level" @change="applyFilters(true)" placeholder="Seleccione un nivel"
                        :options="levelOptions" valueSelect="value" valueOption="label" />
                </FormField>
            </template>
        </SearchBar>

        <CardBox v-if="oecdData?.data && oecdData.data.length > 0">
            <table>
                <thead>
                    <tr>
                        <SortableHeader @sort="sortByColumn" :filters="filters" column="name" label="Nombre" />
                        <SortableHeader @sort="sortByColumn" :filters="filters" column="level" label="Categoría" />
                        <SortableHeader @sort="sortByColumn" :filters="filters" column="economic_social_sector_id"
                            label="Sector Económico-Social" />
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="item in oecdData.data" :key="item.id">
                        <td data-label="Nombre">
                            {{ item.name }}
                        </td>
                        <td data-label="Nivel">
                            {{ getLevelLabel(item.level) }}
                        </td>
                        <td data-label="Sector Económico-Social">
                            {{ item.economic_social_sector?.name ?? 'N/A' }}
                        </td>
                        <td data-label="Acciones">
                            <BaseButtons>
                                <BaseButton color="info" :icon="mdiPencil" small :routeName="`${routeName}edit`"
                                    :parameter="item.id" title="Editar disciplina" />
                                <BaseButton color="danger" :icon="mdiTrashCan" small @click="deleteItem(item)"
                                    title="Eliminar disciplina" />
                            </BaseButtons>
                        </td>
                    </tr>
                </tbody>
            </table>
        </CardBox>
        <CardBoxComponentEmpty v-else />
        <Pagination v-if="oecdData?.meta" :links="oecdData.meta.links" :total="oecdData.meta.total"
            :to="oecdData.meta.to" :from="oecdData.meta.from" />
    </LayoutMain>
</template>

<script setup>
import { router } from '@inertiajs/vue3';
import { mdiSchoolOutline, mdiPencil, mdiTrashCan } from '@mdi/js';
import HeadLogo from '@/Components/HeadLogo.vue';
import LayoutMain from '@/Layouts/LayoutMain.vue';
import SectionTitleLineWithButton from '@/Components/SectionTitleLineWithButton.vue';
import BaseButtons from '@/Components/BaseButtons.vue';
import BaseButton from '@/Components/BaseButton.vue';
import CardBox from '@/Components/CardBox.vue';
import SearchBar from '@/Components/SearchBar.vue';
import SortableHeader from '@/Components/Table/SortableHeader.vue';
import FormField from '@/Components/FormField.vue';
import FormControl from '@/Components/FormControl.vue';
import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/css/index.css';
import { useFilters } from "@/Hooks/useFilters";
import Pagination from "@/Components/Pagination.vue";
import CardBoxComponentEmpty from "@/Components/CardBoxComponentEmpty.vue";
import { messageConfirm } from "@/Hooks/useErrorsForm";

const props = defineProps({
    title: {
        type: String,
        required: true,
    },
    oecdData: {
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
        type: Object,
        default: () => ({}),
    }
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

const deleteItem = (item) => {
    messageConfirm(`¿Está seguro de querer eliminar el registro "${item.name}"?`).then((res) => {
        if (res.isConfirmed) {
            router.delete(route(`${props.routeName}destroy`, item.id));
        }
    });
};
</script>

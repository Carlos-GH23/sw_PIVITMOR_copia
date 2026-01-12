<template>
    <HeadLogo :title="title" />
    <loading v-model:active="isLoading" :can-cancel="false" :is-full-page="true" loader="dots" color="#283C2A" />
    <LayoutMain>
        <SectionTitleLineWithButton :icon="mdiShapeOutline" :title="title" main />

        <SearchBar @apply-filters="applyFilters" @clear-filters="clearFilters" v-model:search="filters.search"
            v-model:rows="filters.rows" :routeName="routeName" :total="categories.meta.total" />

        <CardBox v-if="categories.data.length > 0">
            <table>
                <thead>
                    <tr>
                        <SortableHeader @sort="sortByColumn" :filters="filters" column="name" label="Categoría" />
                        <SortableHeader @sort="sortByColumn" :filters="filters" column="name" label="Subcategoría" />
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="item in categories.data" :key="item.id">
                        <td data-label="Categoría">
                            {{ item.name }}
                        </td>
                        <td data-label="Subcategoría">
                            <ul class="max-w-md space-y-1 text-gray-800 list-disc list-inside dark:text-gray-400">
                                <li v-for="child in showAll ? item.children : item.children.slice(0, 3)"
                                    :key="child.id">
                                    <Link class="hover:text-forest-100" :href="route(`${routeName}edit`, child.id)">
                                    {{ child.name }}
                                    </Link>
                                </li>

                                <li v-if="item.children.length > 3">
                                    <button class="hover:text-forest-100 cursor-pointer" @click="showAll = !showAll">
                                        {{ showAll ? 'Ver menos...' : 'Ver más...' }}
                                    </button>
                                </li>
                            </ul>
                        </td>
                        <td data-label="acciones">
                            <BaseButtons>
                                <BaseButton color="info" :icon="mdiPencil" small :routeName="`${routeName}edit`"
                                    :parameter="item.id" title="Editar categoría" />
                                <BaseButton color="danger" :icon="mdiTrashCan" small @click="deleteForm(item)"
                                    title="Eliminar instalación" />
                            </BaseButtons>
                        </td>
                    </tr>
                </tbody>
            </table>
        </CardBox>
        <CardBoxComponentEmpty v-else />
        <pagination :links="categories.meta.links" :total="categories.meta.total" :to="categories.meta.to"
            :from="categories.meta.from" />
    </LayoutMain>
</template>
<script setup>
import CardBox from "@/Components/CardBox.vue";
import LayoutMain from "@/Layouts/LayoutMain.vue";
import SectionTitleLineWithButton from "@/Components/SectionTitleLineWithButton.vue";
import {
    mdiShapeOutline,
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
import { Link } from "@inertiajs/vue3";
import { ref } from "vue";
import SortableHeader from "@/Components/Table/SortableHeader.vue";
import { messageConfirm } from "@/Hooks/useErrorsForm";
import { router } from "@inertiajs/vue3";

const props = defineProps({
    title: {
        type: String,
        required: true,
    },
    categories: {
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

const deleteForm = (item) => {
    messageConfirm().then((res) => {
        if (res.isConfirmed) {
            router.delete(route(`${props.routeName}destroy`, item));
        }
    });
};

const showAll = ref(false)
</script>
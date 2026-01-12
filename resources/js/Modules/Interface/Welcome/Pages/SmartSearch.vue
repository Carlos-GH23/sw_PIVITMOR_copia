<template>
    <HeadLogo title="Buscador inteligente" />
    <loading v-model:active="isLoading" :can-cancel="false" :is-full-page="true" loader="dots" color="#283C2A" />
    <LayoutWelcome>
        <SectionWrapper :hasLayer="false">
            <div>
                <TitleLineWithIcon class="mx-auto mb-6">
                    Buscador <span class="font-extrabold">inteligente</span>
                </TitleLineWithIcon>
                <div class="w-24 h-1 mb-5 bg-wine-50 mx-auto rounded-full" />

                <p class="text-center text-lg leading-relaxed ">
                    Explora, desde un solo lugar, la riqueza del ecosistema de innovación de Morelos. El Buscador
                    Inteligente de PIVITMor te permite localizar instituciones de educación superior (IES), centros de
                    investigación (CI), oferta educativa, capacidades y servicios tecnológicos, así como necesidades del
                    sector productivo, instalaciones especializadas, infraestructura tecnológica y conferencias
                    impartidas por académicos. Basta con escribir una palabra clave o seleccionar un sector para
                    descubrir oportunidades reales de vinculación, colaboración e innovación. Aquí, la información se
                    convierte en conexiones que sí generan valor.
                </p>

                <div class="mt-8 max-w-4xl mx-auto">
                    <SmartSearchBar v-model="filters.search"
                        :placeholder="'Busca capacidades, necesidades, servicios o empleos...'" @search="onSearchInput"
                        @apply="applyFilters" />
                </div>

                <div class="max-w-6xl">
                    <SectorCategories @search="applySectorFilter" :selectedSector="filters.social_sector" />
                </div>
            </div>

            <div v-if="capabilities?.data?.length > 0"
                class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-10">
                <OfferCard @click="openModal(item)" v-for="item in (capabilities.data || capabilities)"
                    :key="`${item.id}_${item.resource_type}`" :title="item.title"
                    :sector="item.social_sector?.name || 'Sin sector'"
                    :cover="item.photos?.[0]?.path || IMAGES.image.src" :icon="getSectorIcon(item.social_sector?.name)"
                    :institution="getInstitutionDisplay(item)" :description="item.technical_description"
                    :matches="item.matches || []" :resourceType="item.resource_type"
                    :institutionCategory="item.resource_type === 'institution' ? item.institution_category : ''" />
            </div>

            <div v-else class="text-center py-12">
                <p class="text-gray-500">No se encontraron resultados.</p>
            </div>

            <div v-if="capabilities?.links || capabilities?.meta" class="mt-8">
                <Pagination :links="capabilities.meta.links" :total="capabilities.meta.total" :to="capabilities.meta.to"
                    :from="capabilities.meta.from" />
            </div>
        </SectionWrapper>
    </LayoutWelcome>

    <OfferModal @close="handleModal(false)" :showModal="showModal" :offer="offer" />
</template>

<script setup>
import SmartSearchBar from '../Components/SmartSearchBar.vue';
import HeadLogo from '@/Components/HeadLogo.vue';
import LayoutWelcome from '@/Layouts/LayoutWelcome.vue';
import OfferCard from '../Components/OfferCard.vue';
import OfferModal from '../Components/OfferModal.vue';
import SectorCategories from '../Components/SectorCategories.vue';
import { ref } from 'vue';
import { IMAGES } from '@/Utils/Image';
import TitleLineWithIcon from '@/Components/TitleLineWithIcon.vue';
import SectionWrapper from '../Components/SectionWrapper.vue';
import Pagination from '@/Components/Pagination.vue';
import { useSmartSearch } from '../Composables/useSmartSearch';

const props = defineProps({
    capabilities: {
        type: Object,
        default: () => ({})
    },
    filters: {
        type: Object,
        default: () => ({})
    },
    routeName: {
        type: String,
        default: 'welcome.smartSearch'
    }
});

const showModal = ref(false);
const offer = ref({});

const handleModal = (value) => {
    showModal.value = value;
};

const openModal = (value) => {
    offer.value = value;
    handleModal(true);
};

const {
    isLoading,
    applyFilters,
    applySectorFilter,
    onSearchInput,
    getSectorIcon
} = useSmartSearch(props);

const getInstitutionDisplay = (item) => {
    if (item.resource_type === 'requirement' && item.institution_category === 'Empresa de Base Tecnológica') {
        return 'Empresa de base tecnológica';
    }

    return item.institution_name || item.department?.institution?.name || 'Sin institución';
};

</script>

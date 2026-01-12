<template>
    <CardSection :title="resource.title" :description="resource.description" :hasDivider="false">
        <AcademicList v-if="resource.component === 'academic-list'" :academics="resource.data" />
        <ItemList v-else-if="resource.component === 'item-list'" :items="resource.data" />
        <ImageSwiper v-else-if="resource.component === 'image-swiper'" :photos="resource.data" showEmpty :slides="2" />
        <FilesTable v-else-if="resource.component === 'files-table'" :files="resource.data" />
        <BadgeList v-else-if="resource.component === 'badge-list'" :items="resource.data" />
    </CardSection>
</template>

<script setup>
import CardSection from '@/Components/CardSection.vue';
import AcademicList from './AcademicList.vue';
import ItemList from './ItemList.vue';
import ImageSwiper from '@/Components/ImageSwiper.vue';
import FilesTable from '@/Components/FilesTable.vue';
import BadgeList from './BadgeList.vue';

defineProps({
    resource: {
        type: Object,
        required: true
    }
});
</script>
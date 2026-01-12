<template>
    <HeadLogo :title="title" />

    <LayoutMain>
        <SectionTitleLineWithButton :icon="mdiPlus" :title="title" main />

        <ProfileForm>
            <BaseButton @click="updateForm" :icon="mdiContentSave" color="success" label="Actualizar" />
        </ProfileForm>
        <loading v-model:active="processing" :can-cancel="false" :is-full-page="true" loader="dots" color="#283C2A" />
    </LayoutMain>
</template>

<script setup>
import HeadLogo from '@/Components/HeadLogo.vue';
import LayoutMain from '@/Layouts/LayoutMain.vue';
import SectionTitleLineWithButton from '@/Components/SectionTitleLineWithButton.vue';
import BaseButton from '@/Components/BaseButton.vue';
import { mdiContentSave, mdiPlus } from '@mdi/js';
import ProfileForm from '../Components/ProfileForm.vue';
import { useProfile } from '../Composables/useProfile';

const props = defineProps({
    title: {
        type: String,
        required: true,
    },
    academic: {
        type: Object,
        required: true,
    },
    routeName: {
        type: String,
        required: true,
    },
    departments: {
        type: Array,
        required: true,
    },
    researchAreas: {
        type: Array,
        required: true,
    },
    oecdSectors: {
        type: Array,
        required: true,
    },
    economicSectors: {
        type: Array,
        required: true,
    },
    sniiLevels: {
        type: Array,
        required: true,
    },
    genders: {
        type: Array,
        required: true,
    },
    errors: {
        type: Object,
        required: true,
    },
});

const { updateForm, processing } = useProfile(props);

</script>

<template>
    <HeadLogo :title="props.title" />
    <LayoutMain>
        <SectionTitleLineWithButton :icon="mdiDomain" :title="props.title" main />

        <ProfileForm>
            <BaseButtons>
                <BaseButton @click="resetForm" label="Limpiar formulario" color="lightDark" :icon="mdiBroom" />
                <BaseButton @click="updateForm" label="Guardar" color="success" :icon="mdiSend" />
            </BaseButtons>
        </ProfileForm>
        <loading v-model:active="processing" :can-cancel="false" :is-full-page="true" loader="dots" color="#283C2A" />
    </LayoutMain>
</template>

<script setup>
import { mdiBroom, mdiDomain, mdiSend } from '@mdi/js';
import LayoutMain from '@/Layouts/LayoutMain.vue';
import HeadLogo from '@/Components/HeadLogo.vue';
import SectionTitleLineWithButton from '@/Components/SectionTitleLineWithButton.vue';
import ProfileForm from '../Components/ProfileForm.vue';
import BaseButton from '@/Components/BaseButton.vue';
import BaseButtons from '@/Components/BaseButtons.vue';
import { useProfile } from '../Composables/useProfile';

const props = defineProps({
    institution: {
        type: Object,
        required: true,
    },
    title: {
        type: String,
        required: true,
    },
    routeName: {
        type: String,
        required: true,
    },
    errors: {
        type: Object,
        required: true,
    },
    categories: {
        type: Array,
        required: true,
    },
    types: {
        type: Array,
        required: true,
    },
    knowledges: {
        type: Object,
        required: true,
    },
    oecdSectors: {
        type: Object,
        required: true,
    },
    economicSectors: {
        type: Object,
        required: true,
    }
});

const { resetForm, updateForm, processing } = useProfile(props);
</script>
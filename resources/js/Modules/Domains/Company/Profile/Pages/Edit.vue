<template>
    <HeadLogo title="Perfil" />
    <LayoutMain>
        <SectionTitleLineWithButton main :icon="mdiAccount" :title="title" :his-bread-crumb="false"
            description="Aquí puedes revisar y actualizar los datos clave de tu empresa de forma rápida y sencilla">
            <div class="md:block hidden">
                <BaseButton :icon="mdiClose" color="lightDark" route-name="dashboard" />
            </div>
        </SectionTitleLineWithButton>
        <ProfileForm>
            <div class="flex justify-end gap-2">
                <BaseButton @click="resetForm" label="Limpiar formulario" color="lightDark" :icon="mdiBroom" />
                <BaseButton @click="updateForm" label="Guardar" color="success" :icon="mdiSend" />
            </div>
        </ProfileForm>
        <loading v-model:active="processing" :can-cancel="false" :is-full-page="true" loader="dots" color="#283C2A" />
    </LayoutMain>
</template>
<script setup>
import BaseButton from '@/Components/BaseButton.vue';
import HeadLogo from '@/Components/HeadLogo.vue';
import SectionTitleLineWithButton from '@/Components/SectionTitleLineWithButton.vue';
import LayoutMain from '@/Layouts/LayoutMain.vue';
import { mdiAccount, mdiBroom, mdiClose, mdiSend } from '@mdi/js';
import ProfileForm from '../Components/ProfileForm.vue';
import { useProfile } from '../Composables/useProfile';

const props = defineProps({
    company: {
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
    origens: {
        type: Array,
        required: true,
    },
    innovationTypes: {
        type: Array,
        required: true,
    },
    marketReaches: {
        type: Array,
        required: true,
    },
    companySizes: {
        type: Array,
        required: true,
    },
    technologyLevels: {
        type: Array,
        required: true,
    },
    economicSectors: {
        type: Array,
        required: true,
    },
    oecdSectors: {
        type: Array,
        required: true,
    }
});

const { resetForm, updateForm, processing } = useProfile(props);
</script>
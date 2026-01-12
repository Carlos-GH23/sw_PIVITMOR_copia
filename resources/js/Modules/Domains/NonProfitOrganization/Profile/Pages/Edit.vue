<template>
    <HeadLogo :title="title" />
    <LayoutMain>
        <SectionTitleLineWithButton :icon="mdiHandHeart" :title="title" main />

        <DataForm>
            <div class="flex justify-end space-x-3">
                <!-- <BaseButton :icon="mdiContentSave" color="lightDark" label="Actualizar Perfil" /> -->
                <BaseButton @click="updateForm" :icon="mdiContentSave" color="success" label="Guardar" />
            </div>
        </DataForm>
        <loading v-model:active="processing" :can-cancel="false" :is-full-page="true" loader="dots" color="#283C2A" />
    </LayoutMain>
</template>

<script setup>
import BaseButton from '@/Components/BaseButton.vue';
import DataForm from '../Components/DataForm.vue';
import HeadLogo from '@/Components/HeadLogo.vue';
import LayoutMain from '@/Layouts/LayoutMain.vue';
import SectionTitleLineWithButton from '@/Components/SectionTitleLineWithButton.vue';
import { mdiHandHeart, mdiContentSave } from '@mdi/js';
import { useNonProfitOrganization } from '../Composables/useNonProfitOrganization';

const props = defineProps({
    title: { type: String, required: true },
    routeName: { type: String, required: true },
    nonProfitOrganization: { type: Object, required: true },
    marketReaches: { type: Array, required: true },
    economicSectors: { type: Array, required: true },
    legalEntityTypes: { type: Array, required: true },
});

const { updateForm, processing } = useNonProfitOrganization(props);

</script>

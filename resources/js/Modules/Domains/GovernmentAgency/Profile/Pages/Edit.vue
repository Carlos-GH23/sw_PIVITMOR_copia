<template>
    <HeadLogo :title="title" />
    <LayoutMain>
        <SectionTitleLineWithButton :icon="mdiAccountGroupOutline" :title="title" main>
        </SectionTitleLineWithButton>
        <Dataform>
            <BaseButtons>
                <BaseButton @click="updateForm" :icon="mdiContentSave" :processing="form.processing" color="success"
                    label="Actualizar Perfil" />
            </BaseButtons>
        </Dataform>
    </LayoutMain>
</template>

<script setup>
import LayoutMain from '@/Layouts/LayoutMain.vue';
import SectionTitleLineWithButton from '@/Components/SectionTitleLineWithButton.vue';
import BaseButton from '@/Components/BaseButton.vue';
import HeadLogo from '@/Components/HeadLogo.vue';
import Dataform from '../Components/DataForm.vue';
import { mdiAccountGroupOutline, mdiContentSave, } from '@mdi/js';
import { useProfile } from '../Composables/useProfile';
import BaseButtons from '@/Components/BaseButtons.vue';

const props = defineProps({
    title: { type: String, required: true },
    routeName: { type: String, required: true },
    governmentAgency: { type: Object, required: false},
    levels: { type: Object, required: true },
    governmentSectors: { type: Object, required: true },
});

const { form, isEditMode, storeForm, updateForm } = useProfile(props);
</script>

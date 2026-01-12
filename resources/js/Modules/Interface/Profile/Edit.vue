<script setup>
import { provide, reactive } from "vue";
import { useMainStore } from "@/stores/main";
import {
    mdiAccount,
} from "@mdi/js";
import CardBox from "@/Components/CardBox.vue";
import LayoutMain from "@/Layouts/LayoutMain.vue";
import SectionTitleLineWithButton from "@/Components/SectionTitleLineWithButton.vue";
import DeleteUserForm from './Partials/DeleteUserForm.vue';
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';
import HeadLogo from "@/Components/HeadLogo.vue";

defineProps({
    name: 'Edit',
    user: {
        type: Object,
        required: true
    }
});
</script>

<template>
    <LayoutMain>
        <HeadLogo title="Perfil" />
        <SectionTitleLineWithButton :icon="mdiAccount" title="Perfil" main />

        <div class="space-y-10">
            <UpdateProfileInformationForm :user="user.data" />
            <UpdatePasswordForm />
            <DeleteUserForm />
        </div>
    </LayoutMain>
</template>

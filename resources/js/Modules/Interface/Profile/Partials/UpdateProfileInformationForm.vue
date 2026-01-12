<script setup>
import {
    mdiAccount,
    mdiEmail,
    mdiAccountStar,
    mdiTrashCan,
    mdiCheck,
    mdiFile,
} from "@mdi/js";
import { useForm } from '@inertiajs/vue3';
import FormField from "@/Components/FormField.vue";
import FormControl from "@/Components/FormControl.vue";
import { computed, inject } from "vue";
import InputError from "@/Components/InputError.vue";
import BaseButton from "@/Components/BaseButton.vue";
import CardForm from "@/Components/CardForm.vue";
import SectionTitleLineWithButton from "@/Components/SectionTitleLineWithButton.vue";
import { IMAGES } from "@/Utils/Image";

const { user } = defineProps({
    user: Object
});

const roles = user.roles.map(role => role.name)

const form = useForm({
    _method: 'patch',
    id: user.id,
    name: user.name,
    email: user.email,
    photo: null,
})

const getImage = computed(() => {
    if (form.photo !== null) {
        return URL.createObjectURL(form.photo)
    }
    if (user.photo) {
        return user.photo.path
    }
    return IMAGES.user.src
});

const handleFileInput = (event) => {
    form.photo = event.target.files[0];
};

const saveForm = () => {
    form.post(route('profile.update'), {
        onError: (error) => {
            console.log('error: ', error)
        },
    });
}

const deletePhoto = () => {
    form.delete(route('profile.destroyPhoto'), {
        onError: (error) => {
            console.log('error: ', error)
        },
    });
}

</script>

<template>
    <CardForm>
         <template #header>
            <SectionTitleLineWithButton :icon="mdiAccount" title="Información personal"
                description="Actualice la información del perfil y la dirección de correo electrónico de cuenta"
                :hisBreadCrumb="false" />
        </template>
        <form>
            <div class="md:flex md:space-x-4 mb-5">
                <div class="md:w-1/4 max-lg:mb-5">
                    <img id="photo" :src="getImage" class="rounded w-full h-60 object-cover" loading="lazy">
                    <div class="mt-2 flex space-x-2">
                        <FormControl @input="handleFileInput" type="file" :icon="mdiFile" />
                        <BaseButton class="w-1/4" :icon="mdiTrashCan" color="danger" @click="deletePhoto" outline />
                    </div>
                    <InputError :message="form.errors.photo" />
                </div>
                <div class="md:w-3/4">
                    <FormField label="Nombre completo:" :error="form.errors.name">
                        <FormControl :icon="mdiAccount" v-model="form.name" placeholder="Nombre completo" />
                    </FormField>
                    <FormField label="Correo Electrónico:" :error="form.errors.email">
                        <FormControl v-model="form.email" :icon="mdiEmail" placeholder="Correo Electrónico" />
                    </FormField>
                    <FormField class="w-full" label="Rol en el sistema:">
                        <FormControl disabled v-model="roles" :icon="mdiAccountStar" />
                    </FormField>
                </div>
            </div>
            <div class="flex items-center gap-4">
                <BaseButton @click="saveForm" :icon="mdiCheck" color="success" label="Actualizar"
                    :processing="form.processing" outline />
                <Transition enter-active-class="transition ease-in-out" enter-from-class="opacity-0"
                    leave-active-class="transition ease-in-out" leave-to-class="opacity-0">
                    <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">Guardado.</p>
                </Transition>
            </div>
        </form>
    </CardForm>
</template>

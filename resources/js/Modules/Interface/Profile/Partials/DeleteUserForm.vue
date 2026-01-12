<script setup>
import { mdiLock, mdiTrashCan } from '@mdi/js';
import Modal from '@/Components/Modal.vue';
import { useForm } from '@inertiajs/vue3';
import { nextTick, ref } from 'vue';
import BaseButton from '@/Components/BaseButton.vue';
import CardForm from '@/Components/CardForm.vue';
import FormField from '@/Components/FormField.vue';
import FormControl from '@/Components/FormControl.vue';
import SectionTitleLineWithButton from '@/Components/SectionTitleLineWithButton.vue';

const confirmingUserDeletion = ref(false);
const passwordInput = ref(null);

const form = useForm({
    password: null,
});

const confirmUserDeletion = () => {
    confirmingUserDeletion.value = true;
    nextTick(() => passwordInput.value.focus());
};

const deleteUser = () => {
    form.delete(route('profile.destroy'), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onError: () => passwordInput.value.focus(),
        onFinish: () => form.reset(),
    });
};

const closeModal = () => {
    confirmingUserDeletion.value = false;

    form.reset();
};
</script>

<template>
    <CardForm>
        <template #header>
            <SectionTitleLineWithButton :icon="mdiTrashCan" title="Borrar cuenta"
                description="Una vez que se elimine su cuenta, todos sus recursos y datos se eliminarán permanentemente. Antes de eliminar su cuenta, descargue cualquier dato o información que desee conservar"
                :hisBreadCrumb="false" />
        </template>

        <BaseButton title="Eliminar" @click="confirmUserDeletion" :icon="mdiTrashCan" color="danger"
            label="Eliminar cuenta" />
    </CardForm>
    <Modal :show="confirmingUserDeletion" @close="closeModal" closeable>
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900">
                ¿Estás seguro/a de que quieres eliminar tu cuenta?
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                Una vez que se elimine su cuenta, todos sus recursos y datos se eliminarán permanentemente. Ingrese
                su contraseña para confirmar que desea eliminar permanentemente su cuenta.
            </p>

            <FormField label="Contraseña:" :error="form.errors.password">
                <FormControl v-model="form.password" ref="passwordInput" autofocus :icon="mdiLock" type="password"
                    required placeholder="Contraseña" />
            </FormField>

            <div class="mt-6 flex justify-end gap-2">
                <BaseButton label="Cancelar" color="lightDark" @click="closeModal" />
                <BaseButton label="Eliminar" color="danger" :processing="form.processing" @click="deleteUser" />
            </div>
        </div>
    </Modal>
</template>

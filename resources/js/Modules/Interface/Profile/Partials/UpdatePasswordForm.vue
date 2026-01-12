<script setup>
import {
    mdiLock,
    mdiCheck,
    mdiLightbulbOnOutline,
} from "@mdi/js";
import { useForm } from '@inertiajs/vue3';
import { computed } from "vue";
import FormField from "@/Components/FormField.vue";
import FormControl from "@/Components/FormControl.vue";
import BaseButton from "@/Components/BaseButton.vue";
import CardForm from "@/Components/CardForm.vue";
import BaseIcon from "@/Components/BaseIcon.vue";
import SectionTitleLineWithButton from "@/Components/SectionTitleLineWithButton.vue";

const form = useForm({
    current_password: null,
    password: null,
    password_confirmation: null,
});

const updatePassword = () => {
    form.put(route('password.update'), {
        preserveScroll: true,
        onSuccess: () => form.reset(),
        onError: () => {
            if (form.errors.password) {
                form.reset('password', 'password_confirmation');
            }
            if (form.errors.current_password) {
                form.reset('current_password');
            }
        },
    });
};

const passwordRating = computed(() => {
    const password = String(form.password);
    const containsUpperCase = /[A-Z]/.test(password);
    const containsLowerCase = /[a-z]/.test(password);
    const containsNumbers = /[0-9]/.test(password);
    const containsSpecialChars = /[!@#$%^&*(),.?":{}|<>]/.test(password);

    if (!form.password) return;
    if (password.length < 8) return 'La contraseña debe tener al menos 8 caracteres.';
    if (!containsUpperCase) return 'Debe incluir al menos una letra mayúscula.';
    if (!containsLowerCase) return 'Debe incluir al menos una letra minúscula.';
    if (!containsNumbers) return 'Debe incluir al menos un número.';
    if (!containsSpecialChars) return 'Debe incluir al menos un carácter especial.';
});
</script>

<template>
    <CardForm>
        <template #header>
            <SectionTitleLineWithButton :icon="mdiLock" title="Actualizar contraseña"
                description="Asegúrese de que su cuenta utilice una contraseña larga y aleatoria para mantenerse segura."
                :hisBreadCrumb="false" />
        </template>

        <form>
            <FormField label="Contraseña Antigüa:" :error="form.errors.current_password">
                <FormControl v-model="form.current_password" :icon="mdiLock" type="password" required
                    placeholder="Contraseña Antigüa" />
            </FormField>

            <FormField label="Contraseña Nueva:" :error="form.errors.password">
                <FormControl v-model="form.password" :icon="mdiLock" placeholder="Contraseña Nueva" type="password" />
            </FormField>
            <div v-if="passwordRating" class="w-auto flex items-center mb-5 text-gray-800/90">
                <BaseIcon :path="mdiLightbulbOnOutline" />
                <span class="text-sm">
                    {{ passwordRating }}
                </span>
            </div>

            <FormField label="Contraseña Confirmación:" :error="form.errors.password_confirmation">
                <FormControl v-model="form.password_confirmation" :icon="mdiLock" type="password"
                    placeholder="Contraseña Confirmación" required />
            </FormField>

            <div class="flex items-center gap-4">
                <BaseButton @click="updatePassword" :icon="mdiCheck" color="success" label="Actualizar"
                    :processing="form.processing" outline />

                <Transition enter-active-class="transition ease-in-out" enter-from-class="opacity-0"
                    leave-active-class="transition ease-in-out" leave-to-class="opacity-0">
                    <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">Guardado.</p>
                </Transition>
            </div>
        </form>
    </CardForm>
</template>

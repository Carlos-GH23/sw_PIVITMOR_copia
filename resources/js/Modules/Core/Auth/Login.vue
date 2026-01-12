<script setup>
import FormField from '@/Components/FormField.vue'
import FormValidationErrors from '@/Components/FormValidationErrors.vue'
import HeadLogo from '@/Components/HeadLogo.vue'
import LayoutWelcome from '@/Layouts/LayoutWelcome.vue'
import NotificationBarInCard from '@/Components/NotificationBarInCard.vue'
import SectionFullScreen from '@/Components/SectionFullScreen.vue'
import { useForm, Link } from '@inertiajs/vue3'
import FormControl from '@/Components/FormControl.vue'
import { mdiAsterisk, mdiEmail } from '@mdi/js'
import BaseButton from '@/Components/BaseButton.vue'

const props = defineProps({
    status: {
        type: String,
        default: null
    },
    canResetPassword: Boolean,
})

const form = useForm({
    email: null,
    password: null,
    remember: []
})

const submit = () => {
    form
        .transform(data => ({
            ...data,
            remember: form.remember && form.remember.length ? 'on' : ''
        }))
        .post(route('login.store'), {
            onFinish: () => form.reset('password'),
        })
}
</script>

<template>
    <HeadLogo title="Iniciar sesión" />

    <LayoutWelcome>
        <SectionFullScreen bg="white">
            <div class="grid space-y-4 md:space-y-0 md:space-x-4 md:max-w-4xl md:grid-cols-3">
                <div
                    class="flex flex-col justify-center items-center col-span-2 p-6 border-3 rounded-lg border-forest-100">

                    <h2 class="my-4 text-center text-5xl md:text-[56px] text-earth-100">
                        Bienvenido
                    </h2>

                    <FormValidationErrors />

                    <NotificationBarInCard v-if="status" color="info">
                        {{ status }}
                    </NotificationBarInCard>

                    <FormField label="Correo electrónico:" help="Por favor, introduce tu correo electrónico"
                        class="w-full">
                        <FormControl @keyup.enter="submit" v-model="form.email" :icon="mdiEmail" type="email"
                            placeholder="Ej: usuario@mail.com" required />
                    </FormField>

                    <FormField label="Contraseña:" help="Por favor, introduce tu contraseña" class="w-full">
                        <FormControl @keyup.enter="submit" v-model="form.password" :icon="mdiAsterisk" type="password"
                            placeholder="Contraseña" required />
                    </FormField>

                    <div class="mb-4 text-center">
                        <Link v-if="canResetPassword" :href="route('password.request')"
                            class="text-center font-bold text-sm text-wine-400  hover:text-md hover:opacity-90 rounded-md hover:underline underline-offset-4 transition-all">
                        ¿Olvidaste tu contraseña?
                        </Link>
                    </div>

                    <BaseButton class="w-full" :small="false" :processing="form.processing" @click="submit" color="info"
                        label="Iniciar sesión" />
                </div>

                <div class="bg-pantone-400 text-sand-50 rounded-lg">
                    <div class="p-4 text-center flex items-center justify-center h-full">
                        <div class="block px-2">
                            <h2 class="font-bold text-xl lg:text-2xl mb-4">
                                ¿Aún no te registras?</h2>
                            <p class="text-lg xl:text-xl">
                                <span class="font-bold">
                                    Conecta tu empresa con
                                    oportunidades tecnológicas.
                                </span>
                                Solicita tu registro hoy y
                                forma parte de la red de
                                innovación de Morelos.
                            </p>

                            <Link as="button" href="/#registerView"
                                class="w-full mt-10 p-2 rounded-sm cursor-pointer hover:opacity-90 bg-sand-100 text-wine-400 transition-opacity">
                            Conecta tu empresa ahora
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </SectionFullScreen>
    </LayoutWelcome>
</template>

<template>
    <CardForm>
        <template #header>
            <div class="flex gap-2 items-center py-4">
                <BaseIcon class="bg-forest-400 text-mono-100 rounded-lg" :path="mdiAccount" size="24" h="h-10"
                    w="w-10" />
                <div>
                    <p class="text-forest-400 text-xl font-bold">
                        Información
                    </p>
                    <p class=" text-sm font-light text-slate-800 dark:text-slate-300">
                        Datos básicos del académico
                    </p>
                </div>
            </div>
        </template>

        <div class="flex flex-col md:items-center md:flex-row gap-4">
            <ImageFrame :src="data.photo?.path" alt="Foto Académico" type="user" />

            <div class="flex flex-col col-span-2 space-y-4">
                <h3 class="text-lg font-semibold text-foreground mb-2">{{ data.name }}</h3>

                <div class="flex items-center space-x-2">
                    <label class="text-md font-medium text-forest-400">Departamento:
                        <span class="text-foreground font-light">
                            {{ data.department?.name || 'Sin datos' }}
                        </span>
                    </label>
                </div>

                <div class="flex items-center space-x-2">
                    <label class="text-md font-medium text-forest-400">Posición académica:
                        <span class="text-foreground font-light">
                            {{ data.academic_position?.name || 'Sin datos' }}
                        </span>
                    </label>
                </div>

                <div class="flex items-center space-x-2">
                    <label class="text-md font-medium text-forest-400">Nivel educativo:
                        <span class="text-foreground font-light">
                            {{ data.academic_degree?.name || 'Sin datos' }}
                        </span>
                    </label>
                </div>

                <div class="flex items-center space-x-2">
                    <label class="text-md font-medium text-forest-400">Género:
                        <span class="text-foreground font-light">
                            {{ data.gender || 'Sin datos' }}
                        </span>
                    </label>
                </div>
            </div>
        </div>

        <LabelText label="Biografía" :text="data.biography" />

        <CardSection title="Contacto" description="Información de contacto del académico">
            <ContactFields :contact="data.contact" :phoneNumbers="data.phoneNumbers" :socialLinks="data.socialLinks"
                :hasName="false" />
        </CardSection>
    </CardForm>
</template>

<script setup>
import BaseIcon from '@/Components/BaseIcon.vue';
import CardForm from '@/Components/CardForm.vue';
import CardSection from '@/Components/CardSection.vue';
import ContactFields from '@/Components/ContactFields.vue';
import ImageFrame from '@/Components/ImageFrame.vue';
import LabelText from '@/Components/LabelText.vue';
import { mdiAccount } from '@mdi/js';

const props = defineProps({
    hasBorder: {
        type: Boolean,
        default: false,
    },
    data: {
        type: Object,
        required: false,
    },
});
</script>
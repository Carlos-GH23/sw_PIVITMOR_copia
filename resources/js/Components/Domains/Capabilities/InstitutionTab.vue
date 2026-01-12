<template>
    <CardForm>
        <template #header>
            <div class="flex gap-2 items-center py-4">
                <BaseIcon class="bg-forest-400 text-mono-100 rounded-lg" :path="mdiImageMultiple" size="24" h="h-10"
                    w="w-10" />

                <div>
                    <p class="text-forest-400 text-xl font-bold">
                        Institución
                    </p>
                    <p class="text-sm font-light text-slate-800 dark:text-slate-300">
                        Información de la IES/CI propietaria de la capacidad tecnológica.
                    </p>
                </div>
            </div>
        </template>
        <div class="py-4 px-3 sm:px-4 md:px-6">
            <div class="grid gap-6 md:grid-cols-2">
                <div class="flex flex-col sm:flex-row items-start gap-4">
                    <div
                        class="w-24 h-20 sm:w-28 sm:h-24 md:w-32 md:h-28 bg-muted rounded-lg flex items-center justify-center border-2 border-dashed border-border shrink-0">
                        <img :src="institution.logo?.path" alt="Logo Institución"
                            class="object-contain w-full h-full rounded-lg" />
                    </div>

                    <div class="flex-1 min-w-0">
                        <h3
                            class="text-base sm:text-lg md:text-xl font-semibold text-foreground mb-2 break-words leading-snug">
                            {{ institution.name }}
                        </h3>


                        <div class="space-y-2 text-sm sm:text-base">
                            <div class="flex flex-wrap items-center gap-x-2">
                                <span class="font-medium text-muted-foreground">RENIIECYT:</span>
                                <span class="text-foreground truncate">{{ institution.reniecyt?.register_number
                                }}</span>
                            </div>

                            <div class="flex flex-wrap items-center gap-x-2">
                                <span class="font-medium text-muted-foreground">Localización:</span>
                                <span v-if="institution.location" class="text-foreground break-words">
                                    {{ institution.location?.neighborhood?.name }},
                                    {{ institution.location?.neighborhood?.municipality?.name }},
                                    {{ institution.location?.neighborhood?.municipality?.state?.name }}
                                </span>
                            </div>

                            <div class="flex flex-wrap items-center gap-x-2">
                                <span class="font-medium text-muted-foreground">Página Web:</span>
                                <a :href="institution.contact?.website"
                                    class="text-primary hover:text-forest-50 transition-colors break-all">
                                    {{ institution.contact?.website }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Columna derecha -->
                <div>
                    <h4 class="font-semibold text-foreground mb-3 text-base sm:text-lg">Reseña</h4>
                    <div v-html="institution.description"
                        class="ql-content leading-relaxed text-muted-foreground text-justify text-sm sm:text-base" />
                </div>
            </div>
        </div>
        <CardSection title="Información de contacto" description="Medios de contacto de la institución"
            :hasDivider="true">
            <div class="md:flex gap-4">
                <FormField class="w-full" label="Nombre del contacto">
                    <LabelControl :value="institution.contact?.name" />
                </FormField>
                <FormField class="w-full" label="E-mail">
                    <LabelControl :value="institution.contact?.email" />
                </FormField>
            </div>
            <FormField label="Números de contacto">
                <div>
                    <table v-if="institution.phone_numbers.length > 0">
                        <thead class="text-gray-700 bg-gray-100">
                            <tr>
                                <th>Teléfono</th>
                                <th>Extensión</th>
                                <th>Tipo</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(contact, index) in institution.phone_numbers" :key="index">
                                <td>
                                    {{ contact.number }}
                                </td>
                                <td>
                                    {{ contact.dial_code }}
                                </td>
                                <td>
                                    <Badge color="gray" size="md" variant="soft">
                                        {{ contact.type }}
                                    </Badge>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <CardBoxComponentEmpty v-else />
                </div>
            </FormField>
        </CardSection>
    </CardForm>
</template>
<script setup>
import Badge from '@/Components/Badge.vue';
import BaseIcon from '@/Components/BaseIcon.vue';
import CardBoxComponentEmpty from '@/Components/CardBoxComponentEmpty.vue';
import CardForm from '@/Components/CardForm.vue';
import CardSection from '@/Components/CardSection.vue';
import FormField from '@/Components/FormField.vue';
import LabelControl from '@/Components/LabelControl.vue';
import { mdiImageMultiple, mdiPhone } from '@mdi/js';

defineProps({
    institution: {
        type: Object,
        required: true,
    }
})
</script>
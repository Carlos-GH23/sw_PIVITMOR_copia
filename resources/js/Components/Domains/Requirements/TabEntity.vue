<template>
    <CardForm>
        <template #header>
            <div class="flex gap-2 items-center py-4">
                <BaseIcon class="bg-forest-400 text-mono-100 rounded-lg" :path="mdiImageMultiple" size="24" h="h-10"
                    w="w-10" />

                <div>
                    <p class="text-forest-400 text-xl font-bold">
                        Entidad
                    </p>
                    <p class="text-sm font-light text-slate-800 dark:text-slate-300">
                        Información de la entidad propietaria de la necesidad tecnológica.
                    </p>
                </div>
            </div>
        </template>

        <div class="py-4 space-y-4">
            <div class="grid md:grid-cols-3 gap-4">
                <div class="flex justify-center items-center">
                    <img :src="entity?.logo?.path" class="max-h-60 rounded-lg" alt="Logo entidad" />
                </div>

                <div class="flex flex-col col-span-2 space-y-2">
                    <h3 class="text-lg font-semibold text-foreground mb-2">{{ entity.name }}</h3>
                    <div v-html="entity.description" class="ql-content text-foreground leading-relaxed text-justify" />

                    <div v-if="entity?.reniecyt" class="flex items-center space-x-2">
                        <label class="font-medium text-muted-foreground">RENIIECYT:</label>
                        <span class="text-foreground">{{ entity.reniecyt?.register_number }}</span>
                    </div>

                    <div v-if="entity?.location" class="flex items-center space-x-2">
                        <label class="font-medium text-muted-foreground">Ubicación:</label>
                        <span class="text-foreground">
                            {{ entity.location }},
                        </span>
                    </div>

                    <div v-if="entity?.contact">
                        <div class="flex gap-2">
                            <label class="font-medium text-muted-foreground">Nombre del contacto:</label>
                            <span class="text-foreground">{{ entity.contact.name }}</span>
                        </div>

                        <div class="flex gap-2">
                            <label class="font-medium text-muted-foreground">Correo de contacto:</label>
                            <span class="text-foreground">{{ entity.contact.email }}</span>
                        </div>

                        <div v-if="entity.contact?.website" class="flex items-center space-x-2">
                            <label class="font-medium text-muted-foreground">Página Web:</label>
                            <a :href="entity.contact?.website"
                                class="text-primary hover:text-forest-50 transition-colors">
                                {{ entity.contact?.website }}
                            </a>
                        </div>
                    </div>

                    <span class="text-muted-foreground" v-else>Sin información de contacto</span>
                </div>
            </div>
        </div>

        <FormField v-if="entity.phone_numbers?.length > 0" label="Números de contacto">
            <table>
                <thead class="text-gray-700 bg-gray-100">
                    <tr>
                        <th>Teléfono</th>
                        <th>Extensión</th>
                        <th>Tipo</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(contact, index) in entity.phone_numbers" :key="index">
                        <td data-label="Teléfono">
                            {{ contact.number }}
                        </td>
                        <td data-label="Extensión">
                            {{ contact.dial_code }}
                        </td>
                        <td data-label="Tipo">
                            <Badge color="gray" size="md" variant="soft">
                                {{ contact.type }}
                            </Badge>
                        </td>
                    </tr>
                </tbody>
            </table>
        </FormField>
    </CardForm>
</template>

<script setup>
import Badge from '@/Components/Badge.vue';
import BaseIcon from '@/Components/BaseIcon.vue';
import CardForm from '@/Components/CardForm.vue';
import FormField from '@/Components/FormField.vue';
import { mdiImageMultiple } from '@mdi/js';

defineProps({
    entity: {
        type: Object,
        required: true,
    }
})
</script>
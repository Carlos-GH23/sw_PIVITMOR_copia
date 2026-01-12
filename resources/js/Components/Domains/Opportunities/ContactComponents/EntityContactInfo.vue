<template>
    <div v-if="entity.is_anonymous">
        <AnonymousAlert />
    </div>

    <div v-else class="pt-4 space-y-6">

        <div class="flex flex-col sm:flex-row items-start gap-4">

            <div v-if="entity.logo?.url || entity.logo?.path"
                class="w-32 h-28 sm:w-40 sm:h-36 bg-muted rounded-lg flex items-center justify-center border-2 border-dashed border-border shrink-0">
                <img :src="entity.logo.url || entity.logo.path" :alt="`Logo ${entity.name}`"
                    class="object-contain w-full h-full rounded-lg" />
            </div>
            <div v-else
                class="w-32 h-28 sm:w-40 sm:h-36 bg-gray-100 rounded-lg flex items-center justify-center border-2 border-dashed shrink-0">
                <CardBoxComponentEmpty />
            </div>

            <div class="flex-1 min-w-0">
                <h3 class="text-base sm:text-lg md:text-xl font-semibold text-foreground mb-2 break-words leading-snug">
                    {{ entity.name }}
                </h3>

                <div class="space-y-2 text-sm sm:text-base">
                    <div v-if="entity.reniecyt" class="flex flex-wrap items-center gap-x-2">
                        <span class="font-medium text-muted-foreground">RENIECYT:</span>
                        <span class="text-foreground truncate">{{ entity.reniecyt }}</span>
                    </div>

                    <div v-if="entity.location" class="flex flex-wrap items-center gap-x-2">
                        <span class="font-medium text-muted-foreground">Localización:</span>
                        <span class="text-foreground break-words">
                            {{ entity.location }}
                        </span>
                    </div>

                    <div v-if="entity.contact?.website" class="flex flex-wrap items-center gap-x-2">
                        <span class="font-medium text-muted-foreground">{{ websiteLabel }}:</span>
                        <a :href="entity.contact.website" target="_blank"
                            class="text-primary hover:text-forest-50 transition-colors break-all">
                            {{ entity.contact.website }}
                        </a>
                    </div>

                    <div v-if="entity.economic_sector" class="flex flex-wrap items-center gap-x-2">
                        <span class="font-medium text-muted-foreground">Sector Económico:</span>
                        <span class="text-foreground break-words">
                            {{ getSectorName(entity.economic_sector) }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div v-if="entity.description">
            <h4 class="font-semibold text-foreground mb-3 text-base sm:text-lg">{{ descriptionTitle }}</h4>
            <div v-html="entity.description"
                class="ql-content leading-relaxed text-muted-foreground text-justify text-sm sm:text-base" />
        </div>

        <CardSection v-if="hasContactInfo" title="Información de contacto" :description="contactDescription"
            :hasDivider="true">
            <ContactFields :contact="entity.contact" :phone-numbers="entity.phone_numbers" />
        </CardSection>
    </div>
</template>

<script setup>
import CardSection from '@/Components/CardSection.vue';
import CardBoxComponentEmpty from '@/Components/CardBoxComponentEmpty.vue';
import AnonymousAlert from './AnonymousAlert.vue';
import ContactFields from './ContactFields.vue';
import { computed } from 'vue';

const props = defineProps({
    entity: {
        type: Object,
        required: true
    }
});

const entityLabels = {
    company: {
        description: 'Acerca de la empresa',
        website: 'Sitio Web',
        contact: 'Medios de contacto de la empresa'
    },
    institution: {
        description: 'Reseña',
        website: 'Página Web',
        contact: 'Medios de contacto de la institución'
    },
    government_agency: {
        description: 'Acerca de la agencia',
        website: 'Sitio Web',
        contact: 'Medios de contacto de la agencia'
    },
    non_profit: {
        description: 'Acerca de la organización',
        website: 'Sitio Web',
        contact: 'Medios de contacto de la organización'
    }
};

const entityType = computed(() => props.entity.type || 'institution');

const descriptionTitle = computed(() => {
    return entityLabels[entityType.value]?.description || 'Descripción';
});

const websiteLabel = computed(() => {
    return entityLabels[entityType.value]?.website || 'Sitio Web';
});

const contactDescription = computed(() => {
    return entityLabels[entityType.value]?.contact || 'Medios de contacto';
});

const hasContactInfo = computed(() => {
    return props.entity.contact?.name ||
        props.entity.contact?.email ||
        props.entity.phone_numbers?.length > 0;
});

const getSectorName = (sector) => {
    if (!sector) return '';
    return typeof sector === 'object' ? sector.name : sector;
};
</script>
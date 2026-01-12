<template>
    <div class="pt-4 space-y-6">
        <div class="flex flex-col sm:flex-row items-start gap-4">
            <div v-if="institution.logo"
                class="w-32 h-28 sm:w-40 sm:h-36 bg-muted rounded-lg flex items-center justify-center border-2 border-dashed border-border shrink-0">
                <img :src="institution.logo.path || institution.logo.url" alt="Logo Institución"
                    class="object-contain w-full h-full rounded-lg" />
            </div>
            <div v-else
                class="w-32 h-28 sm:w-40 sm:h-36 bg-gray-100 rounded-lg flex items-center justify-center border-2 border-dashed shrink-0">
                <CardBoxComponentEmpty />
            </div>

            <div class="flex-1 min-w-0">
                <h3 class="text-base sm:text-lg md:text-xl font-semibold text-foreground mb-2 break-words leading-snug">
                    {{ institution.name }}
                </h3>

                <div class="space-y-2 text-sm sm:text-base">
                    <div v-if="reniecyt" class="flex flex-wrap items-center gap-x-2">
                        <span class="font-medium text-muted-foreground">RENIECYT:</span>
                        <span class="text-foreground truncate">
                            {{ reniecyt }}
                        </span>
                    </div>

                    <div v-if="locationText" class="flex flex-wrap items-center gap-x-2">
                        <span class="font-medium text-muted-foreground">Localización:</span>
                        <span class="text-foreground break-words">
                            {{ locationText }}
                        </span>
                    </div>

                    <div v-if="website" class="flex flex-wrap items-center gap-x-2">
                        <span class="font-medium text-muted-foreground">Página Web:</span>
                        <a :href="website" target="_blank"
                            class="text-primary hover:text-forest-50 transition-colors break-all">
                            {{ website }}
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div v-if="institution.description">
            <h4 class="font-semibold text-foreground mb-3 text-base sm:text-lg">Reseña</h4>
            <div v-html="institution.description"
                class="ql-content leading-relaxed text-muted-foreground text-justify text-sm sm:text-base" />
        </div>

        <CardSection v-if="hasContactInfo" title="Información de contacto"
            description="Medios de contacto de la institución" :hasDivider="true">
            <ContactFields :contact="contact" :phone-numbers="phoneNumbers" />
        </CardSection>
    </div>
</template>

<script setup>
import CardSection from '@/Components/CardSection.vue';
import CardBoxComponentEmpty from '@/Components/CardBoxComponentEmpty.vue';
import ContactFields from './ContactFields.vue';
import { computed } from 'vue';
import { getInstitutionContactData } from '@/Configs/opportunityContactConfig';

const props = defineProps({
    opportunity: {
        type: Object,
        required: true
    }
});

const contactData = computed(() => {
    return getInstitutionContactData(props.opportunity);
});

const institution = computed(() => contactData.value.institution);
const contact = computed(() => contactData.value.contact);
const phoneNumbers = computed(() => contactData.value.phoneNumbers);

const reniecyt = computed(() => {
    return institution.value?.reniecyt?.register_number ||
        institution.value?.reniecyt;
});

const locationText = computed(() => {
    const location = institution.value?.location;
    if (!location) return null;

    return `${location?.neighborhood?.name}, ${location?.neighborhood?.municipality?.name}, ${location?.neighborhood?.municipality?.state?.name}`;
});

const website = computed(() => {
    return institution.value?.contact?.website;
});

const hasContactInfo = computed(() => {
    return contact.value?.name ||
        contact.value?.email ||
        phoneNumbers.value?.length > 0;
});
</script>
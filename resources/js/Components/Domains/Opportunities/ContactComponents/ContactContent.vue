<template>
    <AnonymousAlert v-if="contactType === 'anonymous'" />

    <EntityContactInfo v-else-if="contactType === 'company'" :entity="opportunity.owner_entity" />

    <AcademicContactInfo v-else-if="contactType === 'academic' && opportunity.academic"
        :academic="opportunity.academic" />

    <EntityContactInfo v-else-if="contactType === 'entity' && opportunity.owner_entity"
        :entity="opportunity.owner_entity" />

    <InstitutionContactInfo v-else-if="contactType === 'institution'" :opportunity="opportunity" />

    <template v-if="type === 'academic' && opportunity.contact">
        <CardSection title="Contacto del académico" description="Información de contacto directo">
            <ContactFields :contact="opportunity.contact" :phone-numbers="opportunity.phone_numbers" />
        </CardSection>
    </template>
</template>

<script setup>
import CardSection from '@/Components/CardSection.vue';
import AnonymousAlert from './AnonymousAlert.vue';
import EntityContactInfo from './EntityContactInfo.vue';
import AcademicContactInfo from './AcademicContactInfo.vue';
import InstitutionContactInfo from './InstitutionContactInfo.vue';
import ContactFields from './ContactFields.vue';

defineProps({
    opportunity: {
        type: Object,
        required: true
    },
    type: {
        type: String,
        required: true
    },
    contactType: {
        type: String,
        default: null
    }
});
</script>
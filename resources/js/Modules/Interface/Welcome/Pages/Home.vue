<template>
    <HeadLogo title="Bienvenido" />
    <LayoutWelcome>
        <HeroSection />
        <CompanyRegister :states="states" :municipalities="municipalities" :organizationTypes="organizationTypes" id="registerView" />
        <SectionWrapper>
            <PivitMor />
        </SectionWrapper>
        <SectionWrapper>
            <SectorSwiper />
        </SectionWrapper>
        <SectionWrapper>
            <SearchAndMapSection :ecosystem-resources="ecosystemResources" :ecosystem-stats="ecosystemStats" />
        </SectionWrapper>
        <SectionWrapper>
            <SuccessStories :success-stories="successStories?.data" />
        </SectionWrapper>
        <SectionWrapper>
            <FAQSection />
        </SectionWrapper>
        <SectionWrapper :has-layer="false">
            <RegistrationSection />
        </SectionWrapper>
    </LayoutWelcome>
</template>
<script setup>
import HeadLogo from '@/Components/HeadLogo.vue';
import LayoutWelcome from '@/Layouts/LayoutWelcome.vue';
import PivitMor from '../Components/PivitMor.vue';
import SectorSwiper from '../Components/SectorSwiper.vue';
import SearchAndMapSection from '../Components/SearchAndMapSection.vue';
import SuccessStories from '../Components/SuccessStories.vue';
import FAQSection from '../Components/FAQSection.vue';
import HeroSection from '../Components/HeroSection.vue';
import RegistrationSection from '../Components/RegistrationSection.vue';
import SectionWrapper from '../Components/SectionWrapper.vue';
import CompanyRegister from '../Components/CompanyRegister.vue';

defineProps({
    states: Array,
    municipalities: Array,
    organizationTypes: Array,
    ecosystemResources: Array,
    ecosystemStats: Object,
    successStories: Object,
});
</script>
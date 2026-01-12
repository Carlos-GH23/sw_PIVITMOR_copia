<template>
    <HeadLogo title="Bienvenido" />
    <LayoutWelcome src-logo="/img/header/LOGOTIPO-PIVITMOR-CONVIVENCIAFONDOOSCURO-JUNIO2025.png">
        <HeroSection @scroll="scrollAndFocus" />
        <SectionWrapper ref="initialContent">
            <PivitMor />
        </SectionWrapper>
        <SectionWrapper>
            <FAQSection />
        </SectionWrapper>
        <SectionWrapper>
            <SearchAndOfferSection />
        </SectionWrapper>
        <SectionWrapper>
            <MapSection />
        </SectionWrapper>
        <SectionWrapper>
            <SuccessStories />
        </SectionWrapper>
        <SectionWrapper :has-layer="false">
            <RegistrationSection />
        </SectionWrapper>
    </LayoutWelcome>
</template>
<script setup>
import HeadLogo from '@/Components/HeadLogo.vue';
import LayoutWelcome from '@/Layouts/LayoutWelcome.vue';
import SectionWrapper from '../Components/SectionWrapper.vue';
import PivitMor from '../Components/Alternative/PivitMor.vue';
import FAQSection from '../Components/Alternative/FAQSection.vue';
import SearchAndOfferSection from '../Components/Alternative/SearchAndOfferSection.vue';
import MapSection from '../Components/Alternative/MapSection.vue';
import SuccessStories from '../Components/SuccessStories.vue';
import RegistrationSection from '../Components/RegistrationSection.vue';
import HeroSection from '../Components/Alternative/HeroSection.vue';
import { ref } from 'vue';

const initialContent = ref(null);

const scrollAndFocus = () => {
    if (initialContent.value) {
        initialContent.value.$el.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
};
</script>
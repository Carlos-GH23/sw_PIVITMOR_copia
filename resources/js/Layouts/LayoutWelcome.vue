<script setup>
import Container from './Components/Container.vue';
import Navbar from "./Components/LayoutWelcomeNavBar.vue";

</script>

<template>
  <Navbar />

  <Container bg="white">
    <slot />
  </Container>

</template>

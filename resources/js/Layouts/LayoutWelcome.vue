<script setup>
import ChatBot from './Components/ChatBot.vue';
import Container from './Components/Container.vue';
import Footer from "./Components/LayoutWelcomeFooter.vue";
import Navbar from "./Components/LayoutWelcomeNavBar.vue";
import { provide, ref } from 'vue';

const showChat = ref(false);

const openChat = () => {
  showChat.value = true;
};

const closeChat = () => {
  showChat.value = false;
};

provide('openChat', openChat);

</script>

<template>
  <Navbar />

  <Container bg="white">
    <slot />
    <ChatBot @open-chat="openChat" @close-chat="closeChat" :showChat="showChat" />
  </Container>

  <Footer />

</template>
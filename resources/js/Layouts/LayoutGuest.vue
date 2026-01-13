<script setup>
import { computed } from "vue";
import { useStyleStore } from "@/stores/style.js";
import { usePage } from "@inertiajs/vue3";
import NavBar from "@/Components/NavBar.vue";
import NavBarItem from "@/Components/NavBarItem.vue";
import { navbarMenu } from "./Composables/navbarMenu.js";

const styleStore = useStyleStore();
const page = usePage();

const logoItem = computed(() => ({
  label: page.props.auth.user?.name || 'Invitado',
  href: '/',
}));
</script>

<template>
  <div :class="{ dark: styleStore.darkMode }">
    <NavBar :menu="navbarMenu">
      <NavBarItem :item="logoItem" />
    </NavBar>

    <div class="w-screen min-h-screen pt-14">
      <slot />
    </div>
  </div>
</template>

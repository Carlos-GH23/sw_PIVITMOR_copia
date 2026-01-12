<template>
  <header class="relative h-20">
    <nav id="navbar" class="fixed min-w-screen z-50 bg-forest-400">
      <div class="mx-auto flex flex-col xl:flex-row xl:justify-between xl:items-center xl:py-4 xl:px-8 2xl:container">
        <div class="flex p-4 xl:p-0 items-center justify-between bg-forest-400">
          <Link href="/" class="flex items-center cursor-pointer">
          <img :src="IMAGES.pivitmorLogoDarkHorizontal.src" :alt="IMAGES.pivitmorLogoDarkHorizontal.alt"
            class="h-14 md:h-20">
          </Link>

          <button @click="toggleMobileMenu"
            class="flex items-center xl:hidden px-3 py-2 border rounded bg-sand-100 hover:cursor-pointer hover:opacity-80 transition-all">
            <BaseIcon class="text-forest-300 hover:text-forest-100" :path="mdiMenu" />
          </button>
        </div>

        <transition enter-active-class="transition-all duration-300 ease-out"
          leave-active-class="transition-all duration-300 ease-in"
          enter-from-class="opacity-0 -translate-y-10 xl:-translate-y-5" enter-to-class="opacity-100 translate-y-0"
          leave-from-class="opacity-100 translate-y-0" leave-to-class="opacity-0 -translate-y-10 xl:-translate-y-5">
          <ul v-if="isMobileMenuOpen || width >= 1024"
            class="mt-4 gap-2 flex flex-col xl:flex-row xl:mt-0 xl:gap-6 xl:bg-transparent" :class="[
              isMobileMenuOpen ? 'flex bg-sand-50 p-4 shadow-xl' : 'hidden',
              'xl:flex xl:bg-transparent xl:p-0 xl:shadow-none xl:rounded-none'
            ]">
            <li v-for="item in navbarMenu" :key="item.routeName">
              <!-- <Dropdown v-if="item.menu" :label="item.label" :childRoutes="item.menu">
                <DropdownLink v-for="subItem in item.menu" :routeName="subItem.routeName" :label="subItem.label" />
              </Dropdown> -->

              <NavLink :routeName="item.routeName" :label="item.label" />
            </li>

            <li>
              <Link :href="route('login')"
                class="transition-all duration-200 ease-in-out block p-2 group rounded-lg bg-white relative hover:bg-gray-200 text-forest-100 cursor-pointer w-auto"
                as="button">
              Iniciar sesión
              </Link>
            </li>
          </ul>
        </transition>
      </div>
    </nav>
  </header>
</template>

<script setup>
import BaseIcon from '@/Components/BaseIcon.vue';
import NavLink from '@/Layouts/Components/NavLink.vue';
import { ref } from 'vue'
import { Link } from '@inertiajs/vue3';
import { mdiMenu } from '@mdi/js';
import { useWindowSize } from '@vueuse/core';
import navbarMenu from '../Composables/navbarMenu';
import { IMAGES } from '@/Utils/Image';

const isMobileMenuOpen = ref(false);

const { width } = useWindowSize();

const toggleMobileMenu = () => {
  isMobileMenuOpen.value = !isMobileMenuOpen.value
};
</script>
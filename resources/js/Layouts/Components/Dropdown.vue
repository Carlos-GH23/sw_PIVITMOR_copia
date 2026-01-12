<template>
    <div class="relative w-full xl:w-auto dropdown-container" @mouseenter="openWithDelay" @mouseleave="closeWithDelay">
        <button @click="toggleDropdown" :class="classes"> <span> {{ label }} </span>
            <BaseIcon class="transition-transform xl:hidden" :class="{ 'rotate-90': isDropdownOpen }"
                :path="mdiChevronRight" />
        </button>

        <Transition enter-active-class="transition ease-out duration-200" enter-from-class="opacity-0 scale-95"
            enter-to-class="opacity-100 scale-100" leave-active-class="transition ease-in duration-75"
            leave-from-class="opacity-100 scale-100" leave-to-class="opacity-0 scale-95">
            <div v-show="isDropdownOpen" class="dropdown-menu" :class="[isDropdownOpen ? 'block' : 'hidden']">
                <slot />
            </div>
        </Transition>
    </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import BaseIcon from '@/Components/BaseIcon.vue';
import { mdiChevronRight } from '@mdi/js';

const props = defineProps({
    label: String,
    href: String,
    active: Boolean,
    childRoutes: {
        type: Array,
        default: () => []
    }
});

const isDropdownOpen = ref(false);
let hoverTimeout = null;

const isDropdownActive = computed(() => {
    if (props.active) return true;

    const currentRoute = route().current();
    return props.childRoutes.some(childRoute =>
        currentRoute === childRoute.routeName
    );
});

const classes = computed(() => {
    const base = ['transition-all duration-200 ease-in-out flex justify-between items-center w-full text-left p-2 group rounded-lg relative hover:cursor-pointer hover:text-earth-50 xl:hover:bg-transparent'];

    if (props.active || isDropdownActive.value) {
        base.push('font-bold text-earth-100 xl:underline xl:decoration-2 xl:underline-offset-8 xl:decoration-earth-200');
    } else {
        base.push('text-forest-100 hover:bg-forest-300 xl:text-sand-100 xl:hover:decoration-2 xl:hover:underline xl:hover:underline-offset-8 xl:rounded-lg xl:hover:text-earth-100');
    }

    return base;
});

const toggleDropdown = () => {
    if (window.innerWidth < 1280) {
        isDropdownOpen.value = !isDropdownOpen.value;
    }
};

const openWithDelay = () => {
    clearTimeout(hoverTimeout);
    if (window.innerWidth >= 1280) {
        isDropdownOpen.value = true
    }
};

const closeWithDelay = () => {
    if (window.innerWidth >= 1280) {
        hoverTimeout = setTimeout(() => {
            isDropdownOpen.value = false
        }, 100)
    }
};
</script>

<style scoped>
.dropdown-menu {
    padding: 4px;
}

@media (min-width: 1280px) {
    .dropdown-menu {
        position: absolute;
        max-width: calc(100vw - 100);
        right: 0;
        left: auto;
        transform: translateX(0);
    }

    .dropdown-container:nth-last-child(-n+2) .dropdown-menu,
    .dropdown-container[data-position="left"] .dropdown-menu {
        right: 0;
        left: auto;
        transform: translateX(0);
    }

    .dropdown-container:nth-child(-n+2) .dropdown-menu,
    .dropdown-container[data-position="right"] .dropdown-menu {
        left: 0;
        right: auto;
        transform: translateX(0);
    }
}
</style>

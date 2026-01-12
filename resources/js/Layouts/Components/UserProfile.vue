<template>
    <Avatar class="h-8 w-8 rounded-lg">
        <AvatarImage :src="avatar" :alt="user.name" />
        <AvatarFallback class="rounded-lg"> CN </AvatarFallback>
    </Avatar>
    <div class="grid flex-1 text-left text-sm leading-tight">
        <span class="truncate font-medium">{{ user.name }}</span>
        <span class="truncate text-xs">{{ user.email }}</span>
    </div>
</template>

<script setup>
import Avatar from "@/Components/ui/avatar/Avatar.vue";
import AvatarImage from "@/Components/ui/avatar/AvatarImage.vue";
import AvatarFallback from "@/Components/ui/avatar/AvatarFallback.vue";

import { computed } from "vue";
import { usePage } from "@inertiajs/vue3";
import { IMAGES } from "@/Utils/Image";

const user = usePage().props.auth.user.data;

const avatar = computed(() => {
    if (user.photo) {
        return user.photo.path
    }
    return IMAGES.user.src
});
</script>
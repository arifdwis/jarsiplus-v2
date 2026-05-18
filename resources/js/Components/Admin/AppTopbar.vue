<script setup>
import { Link } from '@inertiajs/vue3';
import AppSearch from './AppSearch.vue';
import AppBreadcrumb from './AppBreadcrumb.vue';
import AppNotifications from './AppNotifications.vue';
import AppUserMenu from './AppUserMenu.vue';
import AppThemeToggle from './AppThemeToggle.vue';

defineProps({
    sidebarOpen: { type: Boolean, default: true },
    sidebarMini: { type: Boolean, default: false },
});

defineEmits(['toggle-sidebar', 'toggle-mini']);
</script>

<template>
    <header
        :class="[
            'fixed top-0 right-0 z-20 h-14 bg-white dark:bg-zinc-900 border-b border-zinc-200 dark:border-zinc-800 flex items-center px-3 transition-all',
            sidebarOpen ? (sidebarMini ? 'left-16' : 'left-60') : 'left-0',
        ]"
    >
        <button
            @click="$emit('toggle-sidebar')"
            class="p-1.5 rounded hover:bg-zinc-100 dark:hover:bg-zinc-800 text-zinc-700 dark:text-zinc-300"
            aria-label="Toggle sidebar"
        >
            <i class="pi pi-bars text-sm"></i>
        </button>

        <button
            v-if="sidebarOpen"
            @click="$emit('toggle-mini')"
            class="hidden md:inline-flex p-1.5 rounded hover:bg-zinc-100 dark:hover:bg-zinc-800 text-zinc-700 dark:text-zinc-300 ml-1"
            :aria-label="sidebarMini ? 'Expand sidebar' : 'Collapse sidebar'"
        >
            <i :class="['text-sm', sidebarMini ? 'pi pi-angle-double-right' : 'pi pi-angle-double-left']"></i>
        </button>

        <div class="hidden md:block ml-3 flex-1 min-w-0 truncate">
            <AppBreadcrumb />
        </div>
        <div class="flex-1 md:hidden"></div>

        <div class="flex items-center gap-1">
            <AppSearch />
            <AppThemeToggle />
            <AppNotifications />
            <div class="w-px h-6 bg-zinc-200 dark:bg-zinc-700 mx-1"></div>
            <AppUserMenu />
        </div>
    </header>
</template>

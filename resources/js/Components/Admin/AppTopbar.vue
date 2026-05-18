<script setup>
import { Link } from '@inertiajs/vue3';
import AppUserMenu from './AppUserMenu.vue';
import AppThemeToggle from './AppThemeToggle.vue';

defineProps({ sidebarOpen: { type: Boolean, default: true } });
defineEmits(['toggle-sidebar']);
</script>

<template>
    <header
        class="fixed top-0 left-0 right-0 z-30 h-12 bg-white dark:bg-zinc-900 border-b border-zinc-200 dark:border-zinc-800 flex items-center px-3"
    >
        <button
            @click="$emit('toggle-sidebar')"
            class="p-1.5 rounded hover:bg-zinc-100 dark:hover:bg-zinc-800 text-zinc-700 dark:text-zinc-300"
            aria-label="Toggle sidebar"
        >
            <i class="pi pi-bars text-sm"></i>
        </button>

        <Link href="/dashboard" class="ml-3 flex items-center gap-2">
            <span class="text-sm font-semibold tracking-tight">JARSIPLUS</span>
        </Link>

        <div class="flex-1"></div>

        <AppThemeToggle class="mr-1" />
        <AppUserMenu />
    </header>
</template>

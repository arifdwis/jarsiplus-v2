<script setup>
import { ref } from 'vue';
import Toast from 'primevue/toast';
import ConfirmDialog from 'primevue/confirmdialog';
import AppTopbar from '@/Components/Admin/AppTopbar.vue';
import AppSidebar from '@/Components/Admin/AppSidebar.vue';
import { useFlash } from '@/Composables/useFlash';

useFlash();

const sidebarOpen = ref(true);
const toggleSidebar = () => { sidebarOpen.value = !sidebarOpen.value; };
</script>

<template>
    <div class="min-h-screen bg-zinc-50 text-zinc-900 dark:bg-zinc-950 dark:text-zinc-100">
        <Toast position="top-right" />
        <ConfirmDialog />

        <AppTopbar :sidebar-open="sidebarOpen" @toggle-sidebar="toggleSidebar" />
        <AppSidebar :open="sidebarOpen" />

        <main
            :class="[
                'pt-12 transition-all duration-200 min-h-screen',
                sidebarOpen ? 'md:ml-56' : 'ml-0',
            ]"
        >
            <div class="p-4 max-w-screen-2xl">
                <slot />
            </div>
        </main>
    </div>
</template>

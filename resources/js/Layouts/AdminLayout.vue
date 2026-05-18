<script setup>
import { ref } from 'vue';
import Toast from 'primevue/toast';
import ConfirmDialog from 'primevue/confirmdialog';
import AppTopbar from '@/Components/Admin/AppTopbar.vue';
import AppSidebar from '@/Components/Admin/AppSidebar.vue';
import { useFlash } from '@/Composables/useFlash';

useFlash();

const sidebarOpen = ref(true);
const sidebarMini = ref(false);

const toggleSidebar = () => { sidebarOpen.value = !sidebarOpen.value; };
const toggleMini = () => { sidebarMini.value = !sidebarMini.value; };
</script>

<template>
    <div class="min-h-screen bg-zinc-50 text-zinc-900 dark:bg-zinc-950 dark:text-zinc-100">
        <Toast position="top-right" />
        <ConfirmDialog />

        <AppSidebar :open="sidebarOpen" :mini="sidebarMini" />
        <AppTopbar
            :sidebar-open="sidebarOpen"
            :sidebar-mini="sidebarMini"
            @toggle-sidebar="toggleSidebar"
            @toggle-mini="toggleMini"
        />

        <main
            :class="[
                'pt-14 transition-all duration-200 min-h-screen',
                sidebarOpen ? (sidebarMini ? 'md:ml-16' : 'md:ml-60') : 'ml-0',
            ]"
        >
            <div class="p-4 max-w-screen-2xl">
                <slot />
            </div>
        </main>
    </div>
</template>

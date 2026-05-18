<script setup>
import PanelMenu from 'primevue/panelmenu';
import { useMenu } from '@/Composables/useMenu';
import { useAuth } from '@/Composables/useAuth';

defineProps({ open: { type: Boolean, default: true } });

const { menuItems } = useMenu();
const { roles } = useAuth();
</script>

<template>
    <aside
        :class="[
            'fixed top-12 left-0 bottom-0 z-20 bg-white dark:bg-zinc-900 border-r border-zinc-200 dark:border-zinc-800 transition-all duration-200 overflow-hidden',
            open ? 'w-56' : 'w-0',
        ]"
    >
        <nav class="p-2 overflow-y-auto h-full" v-show="open">
            <PanelMenu :model="menuItems" class="!bg-transparent mono-menu" />

            <div v-if="!menuItems.length" class="text-zinc-500 text-xs p-3">
                Tidak ada menu untuk role Anda.
            </div>

            <div v-if="roles.length" class="mt-4 pt-3 border-t border-zinc-100 dark:border-zinc-800">
                <p class="text-[10px] text-zinc-400 uppercase tracking-wider mb-1.5 px-2 font-medium">Roles</p>
                <div class="flex flex-wrap gap-1 px-2">
                    <span
                        v-for="role in roles"
                        :key="role"
                        class="text-[10px] bg-zinc-900 dark:bg-zinc-100 text-white dark:text-zinc-900 px-1.5 py-0.5 rounded font-medium"
                    >
                        {{ role }}
                    </span>
                </div>
            </div>
        </nav>
    </aside>
</template>

<style>
.mono-menu .p-panelmenu-panel,
.mono-menu .p-panelmenu-header,
.mono-menu .p-panelmenu-content {
    background: transparent !important;
    border: none !important;
}
.mono-menu .p-panelmenu-header-link,
.mono-menu .p-menuitem-link {
    padding: 0.4rem 0.6rem !important;
    font-size: 0.8rem !important;
    color: #3f3f46 !important;
    border-radius: 0.25rem !important;
    border: none !important;
    background: transparent !important;
}
.mono-menu .p-panelmenu-header-link:hover,
.mono-menu .p-menuitem-link:hover {
    background: #f4f4f5 !important;
    color: #18181b !important;
}
.app-dark .mono-menu .p-panelmenu-header-link,
.app-dark .mono-menu .p-menuitem-link {
    color: #d4d4d8 !important;
}
.app-dark .mono-menu .p-panelmenu-header-link:hover,
.app-dark .mono-menu .p-menuitem-link:hover {
    background: #27272a !important;
    color: #fafafa !important;
}
.mono-menu .p-icon,
.mono-menu .p-menuitem-icon,
.mono-menu .pi {
    font-size: 0.85rem !important;
}
.mono-menu .p-panelmenu-content .p-menuitem-link {
    padding-left: 1.6rem !important;
}
</style>

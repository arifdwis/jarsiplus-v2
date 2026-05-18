<script setup>
import { ref } from 'vue';
import { Link, router } from '@inertiajs/vue3';
import Menu from 'primevue/menu';
import PanelMenu from 'primevue/panelmenu';
import Avatar from 'primevue/avatar';
import Toast from 'primevue/toast';
import ConfirmDialog from 'primevue/confirmdialog';
import { useAuth } from '@/Composables/useAuth';
import { useMenu } from '@/Composables/useMenu';
import { useFlash } from '@/Composables/useFlash';
import { useTheme } from '@/Composables/useTheme';

const { user, roles } = useAuth();
const { menuItems } = useMenu();
const { dark, toggle: toggleTheme } = useTheme();
useFlash();

const sidebarOpen = ref(true);
const userMenuRef = ref();

const userMenuItems = ref([
    { label: 'Profil', icon: 'pi pi-user', command: () => router.visit('/profil') },
    { label: 'Notifikasi', icon: 'pi pi-bell', command: () => router.visit('/notifikasi') },
    { separator: true },
    { label: 'Logout', icon: 'pi pi-sign-out', command: () => router.visit('/logout') },
]);

const toggleUserMenu = (e) => userMenuRef.value.toggle(e);
const toggleSidebar = () => { sidebarOpen.value = !sidebarOpen.value; };
</script>

<template>
    <div class="min-h-screen bg-zinc-50 text-zinc-900 dark:bg-zinc-950 dark:text-zinc-100">
        <Toast position="top-right" />
        <ConfirmDialog />

        <!-- Topbar -->
        <header
            class="fixed top-0 left-0 right-0 z-30 h-12 bg-white dark:bg-zinc-900 border-b border-zinc-200 dark:border-zinc-800 flex items-center px-3"
        >
            <button
                @click="toggleSidebar"
                class="p-1.5 rounded hover:bg-zinc-100 dark:hover:bg-zinc-800 text-zinc-700 dark:text-zinc-300"
                aria-label="Toggle sidebar"
            >
                <i class="pi pi-bars text-sm"></i>
            </button>

            <Link href="/dashboard" class="ml-3 flex items-center gap-2">
                <span class="text-sm font-semibold tracking-tight">JARSIPLUS</span>
            </Link>

            <div class="flex-1"></div>

            <button
                @click="toggleTheme"
                class="p-1.5 rounded hover:bg-zinc-100 dark:hover:bg-zinc-800 text-zinc-700 dark:text-zinc-300 mr-1"
                :aria-label="dark ? 'Light mode' : 'Dark mode'"
            >
                <i :class="['text-sm', dark ? 'pi pi-sun' : 'pi pi-moon']"></i>
            </button>

            <button
                v-if="user"
                @click="toggleUserMenu"
                class="flex items-center gap-2 px-2 py-1 rounded hover:bg-zinc-100 dark:hover:bg-zinc-800"
            >
                <Avatar
                    v-if="user.photo"
                    :image="user.photo"
                    shape="circle"
                    style="width: 1.5rem; height: 1.5rem"
                />
                <Avatar
                    v-else
                    :label="user.name?.charAt(0).toUpperCase() ?? '?'"
                    shape="circle"
                    style="width: 1.5rem; height: 1.5rem; background: #18181b; color: #fff; font-size: 0.75rem"
                />
                <span class="hidden md:inline text-xs">{{ user.name }}</span>
                <i class="pi pi-chevron-down text-[10px] text-zinc-500"></i>
            </button>
            <Menu ref="userMenuRef" :model="userMenuItems" popup />
        </header>

        <!-- Sidebar -->
        <aside
            :class="[
                'fixed top-12 left-0 bottom-0 z-20 bg-white dark:bg-zinc-900 border-r border-zinc-200 dark:border-zinc-800 transition-all duration-200 overflow-hidden',
                sidebarOpen ? 'w-56' : 'w-0',
            ]"
        >
            <nav class="p-2 overflow-y-auto h-full" v-show="sidebarOpen">
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

        <!-- Main -->
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

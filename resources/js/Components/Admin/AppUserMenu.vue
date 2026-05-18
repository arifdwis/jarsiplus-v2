<script setup>
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';
import OverlayPanel from 'primevue/overlaypanel';
import Avatar from 'primevue/avatar';
import { useAuth } from '@/Composables/useAuth';

const { user, roles } = useAuth();
const panelRef = ref();

const toggle = (e) => panelRef.value.toggle(e);
const go = (path) => {
    panelRef.value.hide();
    router.visit(path);
};

const menu = [
    { label: 'Profil Saya', icon: 'pi pi-user', path: '/profil' },
    { label: 'Notifikasi', icon: 'pi pi-bell', path: '/notifikasi' },
    { label: 'Pengaturan', icon: 'pi pi-cog', path: '/pengaturan' },
];
</script>

<template>
    <div v-if="user">
        <button
            @click="toggle"
            class="flex items-center gap-2 pl-1 pr-2 py-1 rounded hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors"
            aria-haspopup="true"
            aria-controls="user-menu-panel"
        >
            <Avatar
                v-if="user.photo"
                :image="user.photo"
                shape="circle"
                style="width: 1.75rem; height: 1.75rem"
            />
            <Avatar
                v-else
                :label="user.name?.charAt(0).toUpperCase() ?? '?'"
                shape="circle"
                style="width: 1.75rem; height: 1.75rem; background: #18181b; color: #fff; font-size: 0.8rem"
            />
            <span class="hidden md:inline text-xs font-medium text-zinc-700 dark:text-zinc-200">{{ user.name }}</span>
            <i class="pi pi-chevron-down text-[10px] text-zinc-400"></i>
        </button>

        <OverlayPanel ref="panelRef" id="user-menu-panel" class="!w-72" :pt="{ root: { class: '!p-0' }, content: { class: '!p-0' } }">
            <!-- Profile header -->
            <div class="bg-gradient-to-br from-zinc-900 to-zinc-700 dark:from-zinc-800 dark:to-zinc-700 p-4 text-white">
                <div class="flex items-center gap-3">
                    <Avatar
                        v-if="user.photo"
                        :image="user.photo"
                        shape="circle"
                        size="large"
                    />
                    <Avatar
                        v-else
                        :label="user.name?.charAt(0).toUpperCase() ?? '?'"
                        shape="circle"
                        size="large"
                        style="background: #00ADB5; color: #222831; font-weight: 600"
                    />
                    <div class="min-w-0 flex-1">
                        <p class="text-sm font-semibold truncate">{{ user.name }}</p>
                        <p class="text-[11px] text-white/70 truncate">{{ user.email }}</p>
                    </div>
                </div>
                <div v-if="roles.length" class="flex flex-wrap gap-1 mt-3">
                    <span
                        v-for="role in roles"
                        :key="role"
                        class="text-[10px] bg-white/20 text-white px-1.5 py-0.5 rounded font-medium uppercase tracking-wide"
                    >
                        {{ role }}
                    </span>
                </div>
            </div>

            <!-- Menu list -->
            <ul class="py-1">
                <li v-for="item in menu" :key="item.path">
                    <button
                        @click="go(item.path)"
                        class="w-full flex items-center gap-2.5 px-4 py-2 text-left text-xs text-zinc-700 dark:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors"
                    >
                        <i :class="[item.icon, 'text-sm text-zinc-500']"></i>
                        <span>{{ item.label }}</span>
                    </button>
                </li>
            </ul>

            <!-- Logout -->
            <div class="border-t border-zinc-200 dark:border-zinc-700 p-2">
                <button
                    @click="go('/logout')"
                    class="w-full flex items-center gap-2.5 px-2 py-2 text-left text-xs font-medium text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 rounded transition-colors"
                >
                    <i class="pi pi-sign-out text-sm"></i>
                    <span>Logout</span>
                </button>
            </div>
        </OverlayPanel>
    </div>
</template>

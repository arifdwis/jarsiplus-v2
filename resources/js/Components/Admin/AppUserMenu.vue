<script setup>
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';
import Menu from 'primevue/menu';
import Avatar from 'primevue/avatar';
import { useAuth } from '@/Composables/useAuth';

const { user } = useAuth();

const menuRef = ref();

const items = ref([
    { label: 'Profil', icon: 'pi pi-user', command: () => router.visit('/profil') },
    { label: 'Notifikasi', icon: 'pi pi-bell', command: () => router.visit('/notifikasi') },
    { separator: true },
    { label: 'Logout', icon: 'pi pi-sign-out', command: () => router.visit('/logout') },
]);

const toggle = (e) => menuRef.value.toggle(e);
</script>

<template>
    <div v-if="user">
        <button
            @click="toggle"
            class="flex items-center gap-2 px-2 py-1 rounded hover:bg-zinc-100 dark:hover:bg-zinc-800"
            aria-haspopup="true"
            aria-controls="user-menu"
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
        <Menu ref="menuRef" id="user-menu" :model="items" popup />
    </div>
</template>

<script setup>
import { ref, onMounted, onBeforeUnmount } from 'vue';
import { router } from '@inertiajs/vue3';
import OverlayPanel from 'primevue/overlaypanel';
import Badge from 'primevue/badge';
import { usePage } from '@inertiajs/vue3';

const page = usePage();
const panelRef = ref();

// Stub data — to be wired to /api/notifications later
const notifications = ref([]);
const unread = ref(0);

function toggle(e) {
    panelRef.value.toggle(e);
}

function viewAll() {
    panelRef.value.hide();
    router.visit('/notifikasi');
}
</script>

<template>
    <button
        @click="toggle"
        class="relative p-1.5 rounded hover:bg-zinc-100 dark:hover:bg-zinc-800 text-zinc-700 dark:text-zinc-300"
        aria-label="Notifikasi"
    >
        <i class="pi pi-bell text-sm"></i>
        <Badge
            v-if="unread > 0"
            :value="unread"
            severity="danger"
            class="!absolute !-top-0.5 !-right-0.5 !text-[9px] !min-w-[1rem] !h-4"
        />
    </button>

    <OverlayPanel ref="panelRef" class="!w-80">
        <div class="p-3 border-b border-zinc-100 dark:border-zinc-800 flex items-center justify-between">
            <h3 class="text-sm font-semibold text-zinc-900 dark:text-zinc-100">Notifikasi</h3>
            <button
                v-if="notifications.length"
                class="text-[11px] text-zinc-500 hover:text-zinc-900 dark:hover:text-zinc-100"
            >
                Tandai semua dibaca
            </button>
        </div>

        <ul v-if="notifications.length" class="max-h-80 overflow-y-auto">
            <li
                v-for="n in notifications"
                :key="n.id"
                class="p-3 border-b border-zinc-100 dark:border-zinc-800 hover:bg-zinc-50 dark:hover:bg-zinc-800 cursor-pointer"
            >
                <p class="text-xs font-medium text-zinc-900 dark:text-zinc-100">{{ n.title }}</p>
                <p class="text-[11px] text-zinc-500 mt-0.5">{{ n.message }}</p>
                <p class="text-[10px] text-zinc-400 mt-1">{{ n.time }}</p>
            </li>
        </ul>

        <div v-else class="p-8 text-center">
            <i class="pi pi-bell-slash text-zinc-300 text-2xl"></i>
            <p class="text-xs text-zinc-500 mt-2">Belum ada notifikasi</p>
        </div>

        <div class="p-2 border-t border-zinc-100 dark:border-zinc-800">
            <button
                @click="viewAll"
                class="w-full text-[11px] font-medium text-zinc-700 dark:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-800 py-1.5 rounded"
            >
                Lihat semua
            </button>
        </div>
    </OverlayPanel>
</template>

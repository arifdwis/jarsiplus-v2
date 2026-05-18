<script setup>
import { ref, computed } from 'vue';
import { router } from '@inertiajs/vue3';
import OverlayPanel from 'primevue/overlaypanel';
import Badge from 'primevue/badge';

const panelRef = ref();
const activeTab = ref('semua');

// Stub data — wire to NotificationLog API later
const notifications = ref([]);

const tabs = [
    { key: 'semua', label: 'Semua' },
    { key: 'belum-dibaca', label: 'Belum Dibaca' },
];

const filtered = computed(() => {
    if (activeTab.value === 'belum-dibaca') {
        return notifications.value.filter((n) => !n.read_at);
    }
    return notifications.value;
});

const unread = computed(() => notifications.value.filter((n) => !n.read_at).length);

const toggle = (e) => panelRef.value.toggle(e);

function viewAll() {
    panelRef.value.hide();
    router.visit('/notifikasi');
}

function markAllRead() {
    notifications.value.forEach((n) => { n.read_at = new Date().toISOString(); });
}
</script>

<template>
    <div>
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

        <OverlayPanel ref="panelRef" class="!w-80" :pt="{ root: { class: '!p-0' }, content: { class: '!p-0' } }">
            <!-- Header -->
            <div class="px-4 py-3 border-b border-zinc-100 dark:border-zinc-800 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <h3 class="text-sm font-semibold text-zinc-900 dark:text-zinc-100">Notifikasi</h3>
                    <Badge v-if="unread" :value="unread" severity="danger" class="!text-[10px]" />
                </div>
                <button
                    v-if="unread > 0"
                    @click="markAllRead"
                    class="text-[11px] text-zinc-500 hover:text-zinc-900 dark:hover:text-zinc-100"
                >
                    Tandai semua
                </button>
            </div>

            <!-- Tabs -->
            <div class="border-b border-zinc-100 dark:border-zinc-800 flex">
                <button
                    v-for="tab in tabs"
                    :key="tab.key"
                    @click="activeTab = tab.key"
                    :class="[
                        'flex-1 text-[11px] font-medium py-2.5 transition-colors',
                        activeTab === tab.key
                            ? 'text-zinc-900 dark:text-zinc-100 border-b-2 border-zinc-900 dark:border-zinc-100'
                            : 'text-zinc-500 hover:text-zinc-700 dark:hover:text-zinc-300',
                    ]"
                >
                    {{ tab.label }}
                </button>
            </div>

            <!-- List -->
            <ul v-if="filtered.length" class="max-h-80 overflow-y-auto">
                <li
                    v-for="n in filtered"
                    :key="n.id"
                    :class="[
                        'px-4 py-3 border-b border-zinc-100 dark:border-zinc-800 hover:bg-zinc-50 dark:hover:bg-zinc-800 cursor-pointer flex gap-3',
                        !n.read_at ? 'bg-zinc-50/50 dark:bg-zinc-800/30' : '',
                    ]"
                >
                    <div class="w-8 h-8 rounded-full bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center flex-shrink-0">
                        <i class="pi pi-info-circle text-sm text-zinc-500"></i>
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="text-xs font-medium text-zinc-900 dark:text-zinc-100">{{ n.title }}</p>
                        <p class="text-[11px] text-zinc-500 mt-0.5 line-clamp-2">{{ n.message }}</p>
                        <p class="text-[10px] text-zinc-400 mt-1">{{ n.time }}</p>
                    </div>
                    <span v-if="!n.read_at" class="w-1.5 h-1.5 rounded-full bg-blue-500 flex-shrink-0 mt-1.5"></span>
                </li>
            </ul>

            <!-- Empty state -->
            <div v-else class="p-10 text-center">
                <i class="pi pi-bell-slash text-zinc-300 dark:text-zinc-600 text-3xl"></i>
                <p class="text-xs text-zinc-500 mt-2">Belum ada notifikasi</p>
            </div>

            <!-- Footer -->
            <div class="border-t border-zinc-100 dark:border-zinc-800 p-2">
                <button
                    @click="viewAll"
                    class="w-full text-[11px] font-medium text-zinc-700 dark:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-800 py-2 rounded transition-colors"
                >
                    Lihat semua notifikasi
                </button>
            </div>
        </OverlayPanel>
    </div>
</template>

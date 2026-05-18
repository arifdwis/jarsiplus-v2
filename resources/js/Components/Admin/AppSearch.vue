<script setup>
import { ref, computed, onMounted, onBeforeUnmount } from 'vue';
import { router, usePage } from '@inertiajs/vue3';
import Dialog from 'primevue/dialog';

const visible = ref(false);
const query = ref('');
const activeIndex = ref(0);
const page = usePage();

const RECENT_KEY = 'jarsiplus-search-recent';

function getRecent() {
    if (typeof localStorage === 'undefined') return [];
    try {
        return JSON.parse(localStorage.getItem(RECENT_KEY) ?? '[]');
    } catch {
        return [];
    }
}

function pushRecent(item) {
    const recent = getRecent().filter((r) => r.uri !== item.uri);
    recent.unshift(item);
    localStorage.setItem(RECENT_KEY, JSON.stringify(recent.slice(0, 5)));
}

function open() {
    visible.value = true;
    activeIndex.value = 0;
    setTimeout(() => document.querySelector('#admin-search-input')?.focus(), 50);
}

function close() {
    visible.value = false;
    query.value = '';
    activeIndex.value = 0;
}

function navigate(item) {
    pushRecent(item);
    close();
    router.visit('/' + String(item.uri).replace(/^\//, ''));
}

function flatMenu(items, parent = '', results = []) {
    items?.forEach((item) => {
        if (item.uri && item.uri !== '#') {
            results.push({
                title: item.title,
                uri: item.uri,
                icon: item.icon ?? 'pi pi-arrow-right',
                section: parent || 'Menu',
            });
        }
        if (item.items?.length) flatMenu(item.items, item.title, results);
    });
    return results;
}

const allItems = computed(() => flatMenu(page.props.menu ?? []));

const groupedResults = computed(() => {
    const q = query.value.trim().toLowerCase();
    let items = allItems.value;
    if (q) items = items.filter((m) => m.title?.toLowerCase().includes(q));
    items = items.slice(0, 20);

    // Group by section
    const groups = new Map();
    items.forEach((it) => {
        if (!groups.has(it.section)) groups.set(it.section, []);
        groups.get(it.section).push(it);
    });
    return Array.from(groups.entries()).map(([title, items]) => ({ title, items }));
});

const flatResults = computed(() => groupedResults.value.flatMap((g) => g.items));

const recent = computed(() => getRecent());
const showRecent = computed(() => !query.value.trim() && recent.value.length > 0);

function handleKeydown(e) {
    if ((e.metaKey || e.ctrlKey) && e.key === 'k') {
        e.preventDefault();
        open();
        return;
    }
    if (!visible.value) return;
    if (e.key === 'Escape') close();
    if (e.key === 'ArrowDown') {
        e.preventDefault();
        activeIndex.value = Math.min(activeIndex.value + 1, flatResults.value.length - 1);
    }
    if (e.key === 'ArrowUp') {
        e.preventDefault();
        activeIndex.value = Math.max(activeIndex.value - 1, 0);
    }
    if (e.key === 'Enter' && flatResults.value[activeIndex.value]) {
        e.preventDefault();
        navigate(flatResults.value[activeIndex.value]);
    }
}

onMounted(() => window.addEventListener('keydown', handleKeydown));
onBeforeUnmount(() => window.removeEventListener('keydown', handleKeydown));

function clearRecent() {
    localStorage.removeItem(RECENT_KEY);
}
</script>

<template>
    <!-- Trigger (desktop) -->
    <button
        @click="open"
        class="hidden md:inline-flex items-center gap-2 text-xs text-zinc-500 dark:text-zinc-400 bg-zinc-100 dark:bg-zinc-800 hover:bg-zinc-200 dark:hover:bg-zinc-700 pl-2.5 pr-2 py-1.5 rounded-md transition-colors min-w-[14rem]"
        aria-label="Cari (Cmd+K)"
    >
        <i class="pi pi-search text-xs"></i>
        <span class="flex-1 text-left">Cari menu, halaman...</span>
        <kbd class="text-[10px] bg-white dark:bg-zinc-700 border border-zinc-200 dark:border-zinc-600 rounded px-1 py-0.5 font-mono text-zinc-600 dark:text-zinc-300">⌘K</kbd>
    </button>

    <!-- Trigger (mobile) -->
    <button
        @click="open"
        class="md:hidden p-1.5 rounded hover:bg-zinc-100 dark:hover:bg-zinc-800 text-zinc-700 dark:text-zinc-300"
        aria-label="Cari"
    >
        <i class="pi pi-search text-sm"></i>
    </button>

    <Dialog
        v-model:visible="visible"
        modal
        :showHeader="false"
        :draggable="false"
        :dismissable-mask="true"
        position="top"
        class="!w-full !max-w-2xl !mt-20"
        :pt="{
            mask: { class: '!bg-zinc-900/50 dark:!bg-black/70 backdrop-blur-sm' },
            root: { class: '!shadow-xl !border !border-zinc-200 dark:!border-zinc-700' },
            content: { class: '!p-0 !rounded-md !overflow-hidden !bg-white dark:!bg-zinc-900' },
        }"
    >
        <!-- Search input -->
        <div class="flex items-center px-4 py-1 border-b border-zinc-100 dark:border-zinc-800">
            <i class="pi pi-search text-zinc-400 text-sm"></i>
            <input
                id="admin-search-input"
                v-model="query"
                type="text"
                placeholder="Cari menu, halaman, fitur..."
                class="flex-1 px-3 py-3 bg-transparent text-sm text-zinc-900 dark:text-zinc-100 outline-none placeholder:text-zinc-400 dark:placeholder:text-zinc-500"
                autocomplete="off"
                @input="activeIndex = 0"
            />
            <button
                v-if="query"
                @click="query = ''"
                class="text-zinc-400 hover:text-zinc-700 dark:hover:text-zinc-200 mr-2 p-0.5"
            >
                <i class="pi pi-times-circle text-sm"></i>
            </button>
            <kbd class="text-[10px] text-zinc-500 dark:text-zinc-400 border border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800 rounded px-1.5 py-0.5 font-mono">esc</kbd>
        </div>

        <!-- Recent (when no query) -->
        <div v-if="showRecent" class="px-4 py-3">
            <div class="flex items-center justify-between mb-2">
                <p class="text-[10px] font-semibold text-zinc-400 uppercase tracking-wider">Terakhir dikunjungi</p>
                <button
                    @click="clearRecent"
                    class="text-[10px] text-zinc-400 hover:text-zinc-700 dark:hover:text-zinc-200"
                >
                    Bersihkan
                </button>
            </div>
            <ul class="space-y-0.5">
                <li v-for="(item, i) in recent" :key="`recent-${item.uri}`">
                    <button
                        @click="navigate(item)"
                        class="w-full flex items-center gap-2.5 px-2 py-2 text-left text-xs text-zinc-700 dark:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-800 rounded transition-colors"
                    >
                        <i class="pi pi-history text-[11px] text-zinc-400"></i>
                        <span class="flex-1 truncate">{{ item.title }}</span>
                        <span class="text-[10px] text-zinc-400 font-mono">/{{ item.uri }}</span>
                    </button>
                </li>
            </ul>
        </div>

        <!-- Results grouped -->
        <div v-if="!showRecent" class="max-h-96 overflow-y-auto py-2">
            <template v-if="groupedResults.length">
                <div v-for="(group, gi) in groupedResults" :key="`g-${gi}`" class="mb-2">
                    <p class="text-[10px] font-semibold text-zinc-400 uppercase tracking-wider px-4 py-1.5">
                        {{ group.title }}
                    </p>
                    <ul>
                        <li v-for="(item, i) in group.items" :key="item.uri">
                            <button
                                @click="navigate(item)"
                                @mouseenter="activeIndex = flatResults.findIndex((r) => r.uri === item.uri)"
                                :class="[
                                    'w-full flex items-center gap-2.5 px-4 py-2 text-left text-xs transition-colors',
                                    flatResults[activeIndex]?.uri === item.uri
                                        ? 'bg-zinc-100 dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100'
                                        : 'text-zinc-700 dark:text-zinc-300 hover:bg-zinc-50 dark:hover:bg-zinc-800/50',
                                ]"
                            >
                                <i :class="[item.icon, 'text-[11px] text-zinc-400 w-4']"></i>
                                <span class="flex-1 truncate">{{ item.title }}</span>
                                <span class="text-[10px] text-zinc-400 font-mono">/{{ item.uri }}</span>
                                <i
                                    v-if="flatResults[activeIndex]?.uri === item.uri"
                                    class="pi pi-arrow-right text-[10px] text-zinc-500"
                                ></i>
                            </button>
                        </li>
                    </ul>
                </div>
            </template>

            <div v-else class="px-4 py-12 text-center">
                <i class="pi pi-search text-zinc-300 dark:text-zinc-600 text-2xl"></i>
                <p class="text-xs text-zinc-500 mt-2">Tidak ada hasil untuk "{{ query }}"</p>
            </div>
        </div>

        <!-- Footer with keyboard hints -->
        <div class="border-t border-zinc-100 dark:border-zinc-800 px-4 py-2 flex items-center gap-3 text-[10px] text-zinc-500 bg-zinc-50/50 dark:bg-zinc-900/50">
            <span class="flex items-center gap-1">
                <kbd class="bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded px-1 font-mono">↵</kbd>
                buka
            </span>
            <span class="flex items-center gap-1">
                <kbd class="bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded px-1 font-mono">↑↓</kbd>
                navigasi
            </span>
            <span class="flex items-center gap-1">
                <kbd class="bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded px-1 font-mono">esc</kbd>
                tutup
            </span>
            <span class="flex-1"></span>
            <span class="text-zinc-400">JARSIPLUS Search</span>
        </div>
    </Dialog>
</template>

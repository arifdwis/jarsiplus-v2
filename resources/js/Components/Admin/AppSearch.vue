<script setup>
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';
import Dialog from 'primevue/dialog';
import InputText from 'primevue/inputtext';
import { onMounted, onBeforeUnmount } from 'vue';
import { usePage } from '@inertiajs/vue3';

const visible = ref(false);
const query = ref('');
const page = usePage();

function open() {
    visible.value = true;
    setTimeout(() => {
        document.querySelector('#admin-search-input')?.focus();
    }, 100);
}

function close() {
    visible.value = false;
    query.value = '';
}

function navigate(uri) {
    close();
    router.visit('/' + String(uri).replace(/^\//, ''));
}

function handleKeydown(e) {
    if ((e.metaKey || e.ctrlKey) && e.key === 'k') {
        e.preventDefault();
        open();
    } else if (e.key === 'Escape') {
        close();
    }
}

onMounted(() => window.addEventListener('keydown', handleKeydown));
onBeforeUnmount(() => window.removeEventListener('keydown', handleKeydown));

function flatMenu(items, results = []) {
    items?.forEach((item) => {
        if (item.uri && item.uri !== '#') {
            results.push({ title: item.title, uri: item.uri });
        }
        if (item.items?.length) flatMenu(item.items, results);
    });
    return results;
}

const filtered = () => {
    const all = flatMenu(page.props.menu ?? []);
    const q = query.value.trim().toLowerCase();
    if (!q) return all.slice(0, 8);
    return all.filter((m) => m.title?.toLowerCase().includes(q)).slice(0, 12);
};
</script>

<template>
    <button
        @click="open"
        class="hidden md:inline-flex items-center gap-2 text-xs text-zinc-500 dark:text-zinc-400 bg-zinc-100 dark:bg-zinc-800 hover:bg-zinc-200 dark:hover:bg-zinc-700 px-2.5 py-1.5 rounded transition-colors"
        aria-label="Cari (Ctrl+K)"
    >
        <i class="pi pi-search text-xs"></i>
        <span>Cari menu...</span>
        <kbd class="hidden lg:inline ml-2 text-[10px] bg-white dark:bg-zinc-700 border border-zinc-200 dark:border-zinc-600 rounded px-1 font-mono">⌘K</kbd>
    </button>

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
        class="!w-full !max-w-lg"
        contentClass="!p-0"
    >
        <div class="border-b border-zinc-100 dark:border-zinc-800 flex items-center px-3">
            <i class="pi pi-search text-zinc-400 text-sm"></i>
            <InputText
                id="admin-search-input"
                v-model="query"
                placeholder="Cari menu, halaman, fitur..."
                class="!flex-1 !border-0 !shadow-none !text-sm"
                fluid
                unstyled
                inputClass="w-full px-3 py-3 bg-transparent text-sm text-zinc-900 dark:text-zinc-100 outline-none"
            />
            <kbd class="text-[10px] text-zinc-400 border border-zinc-200 dark:border-zinc-700 rounded px-1 font-mono">esc</kbd>
        </div>

        <ul class="max-h-80 overflow-y-auto py-2">
            <li v-for="item in filtered()" :key="item.uri">
                <button
                    @click="navigate(item.uri)"
                    class="w-full flex items-center gap-2 px-4 py-2 text-left hover:bg-zinc-100 dark:hover:bg-zinc-800 text-xs text-zinc-700 dark:text-zinc-300"
                >
                    <i class="pi pi-arrow-right text-[10px] text-zinc-400"></i>
                    <span>{{ item.title }}</span>
                    <span class="ml-auto text-[10px] text-zinc-400 font-mono">/{{ item.uri }}</span>
                </button>
            </li>
            <li v-if="!filtered().length" class="px-4 py-8 text-center text-xs text-zinc-500">
                Tidak ada hasil
            </li>
        </ul>
    </Dialog>
</template>

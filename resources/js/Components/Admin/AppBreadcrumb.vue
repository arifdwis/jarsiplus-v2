<script setup>
import { computed } from 'vue';
import { usePage, Link } from '@inertiajs/vue3';

const page = usePage();

const breadcrumb = computed(() => {
    // Use prop `breadcrumb` from page if explicitly passed, else build from URL
    const explicit = page.props.breadcrumb;
    if (Array.isArray(explicit) && explicit.length) return explicit;

    const path = page.url.split('?')[0].replace(/^\/|\/$/g, '');
    if (!path) return [];

    const parts = path.split('/');
    let acc = '';
    return parts.map((p) => {
        acc += '/' + p;
        return {
            label: humanize(p),
            url: acc,
        };
    });
});

function humanize(slug) {
    return slug
        .replace(/[-_]/g, ' ')
        .replace(/\b\w/g, (m) => m.toUpperCase());
}
</script>

<template>
    <nav v-if="breadcrumb.length" class="hidden md:flex items-center gap-1.5 text-[11px] text-zinc-500 dark:text-zinc-400">
        <Link href="/dashboard" class="hover:text-zinc-900 dark:hover:text-zinc-100">
            <i class="pi pi-home text-[10px]"></i>
        </Link>
        <template v-for="(b, i) in breadcrumb" :key="i">
            <i class="pi pi-angle-right text-[9px]"></i>
            <Link
                v-if="i < breadcrumb.length - 1 && b.url"
                :href="b.url"
                class="hover:text-zinc-900 dark:hover:text-zinc-100"
            >
                {{ b.label }}
            </Link>
            <span v-else class="text-zinc-700 dark:text-zinc-300 font-medium">{{ b.label }}</span>
        </template>
    </nav>
</template>

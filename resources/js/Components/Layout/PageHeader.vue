<script setup>
defineProps({
    title: { type: String, required: true },
    description: { type: String, default: '' },
    breadcrumb: { type: Array, default: () => [] },
});
</script>

<template>
    <div class="mb-4 flex flex-col md:flex-row md:items-center md:justify-between gap-2">
        <div class="min-w-0">
            <nav v-if="breadcrumb.length" class="flex items-center gap-1.5 text-[11px] text-zinc-500 mb-1">
                <template v-for="(b, i) in breadcrumb" :key="i">
                    <a v-if="b.url" :href="b.url" class="hover:text-zinc-900">{{ b.label }}</a>
                    <span v-else class="text-zinc-700">{{ b.label }}</span>
                    <i v-if="i < breadcrumb.length - 1" class="pi pi-angle-right text-[9px]"></i>
                </template>
            </nav>
            <h1 class="text-lg font-semibold text-zinc-900 truncate">{{ title }}</h1>
            <p v-if="description" class="text-xs text-zinc-500 mt-0.5">{{ description }}</p>
        </div>
        <div v-if="$slots.actions" class="flex items-center gap-2 flex-shrink-0">
            <slot name="actions" />
        </div>
    </div>
</template>

<script setup>
defineProps({
    icon: { type: String, default: 'pi pi-inbox' },
    title: { type: String, default: 'Belum ada data' },
    description: { type: String, default: '' },
});
</script>

<template>
    <div class="text-center py-12 px-4">
        <i :class="[icon, 'text-2xl text-zinc-300']"></i>
        <p class="text-sm font-medium text-zinc-700 mt-3">{{ title }}</p>
        <p v-if="description" class="text-xs text-zinc-500 mt-1">{{ description }}</p>
        <div v-if="$slots.action" class="mt-4">
            <slot name="action" />
        </div>
    </div>
</template>

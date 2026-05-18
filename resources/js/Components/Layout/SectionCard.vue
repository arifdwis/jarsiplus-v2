<script setup>
defineProps({
    title: { type: String, default: '' },
    bordered: { type: Boolean, default: true },
    padded: { type: Boolean, default: true },
});
</script>

<template>
    <section
        :class="[
            'bg-white rounded',
            bordered ? 'border border-zinc-200' : '',
        ]"
    >
        <header v-if="title || $slots.header" class="px-4 py-3 border-b border-zinc-100 flex items-center justify-between">
            <h2 class="text-sm font-medium text-zinc-900">
                <slot name="header">{{ title }}</slot>
            </h2>
            <slot name="header-actions" />
        </header>
        <div :class="padded ? 'p-4' : ''">
            <slot />
        </div>
        <footer v-if="$slots.footer" class="px-4 py-3 border-t border-zinc-100">
            <slot name="footer" />
        </footer>
    </section>
</template>

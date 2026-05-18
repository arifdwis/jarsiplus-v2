<script setup>
import { useTheme } from '@/Composables/useTheme';

const { dark, toggle } = useTheme();
</script>

<template>
    <button
        @click="toggle"
        class="p-1.5 rounded hover:bg-zinc-100 dark:hover:bg-zinc-800 text-zinc-700 dark:text-zinc-300"
        :aria-label="dark ? 'Light mode' : 'Dark mode'"
    >
        <i :class="['text-sm', dark ? 'pi pi-sun' : 'pi pi-moon']"></i>
    </button>
</template>

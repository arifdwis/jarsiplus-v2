<script setup>
import Tag from 'primevue/tag';
import { usePermohonanStatus } from '@/Composables/usePermohonanStatus';

defineProps({
    status: { type: [String, Number], required: true },
});

const { statusLabel, statusSeverity } = usePermohonanStatus();
</script>

<template>
    <Tag
        :value="statusLabel(status)"
        :severity="statusSeverity(status)"
        class="!text-[10px] !py-0.5 !px-2"
    />
</template>

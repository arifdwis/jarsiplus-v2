<script setup>
defineProps({
    label: { type: String, required: true },
    value: { type: [String, Number], required: true },
    icon: { type: String, default: 'pi pi-circle-fill' },
    trend: { type: String, default: '' },
    trendType: { type: String, default: 'neutral' }, // up | down | neutral
});
</script>

<template>
    <div class="bg-white border border-zinc-200 rounded p-3 flex items-center justify-between">
        <div class="min-w-0">
            <p class="text-[11px] text-zinc-500 uppercase tracking-wide truncate">{{ label }}</p>
            <p class="text-2xl font-semibold text-zinc-900 mt-1 tabular-nums">{{ value }}</p>
            <p
                v-if="trend"
                :class="[
                    'text-[11px] mt-0.5',
                    trendType === 'up' ? 'text-emerald-600' : '',
                    trendType === 'down' ? 'text-red-600' : '',
                    trendType === 'neutral' ? 'text-zinc-500' : '',
                ]"
            >
                <i
                    :class="[
                        'text-[9px] mr-1',
                        trendType === 'up' ? 'pi pi-arrow-up' : '',
                        trendType === 'down' ? 'pi pi-arrow-down' : '',
                    ]"
                ></i>
                {{ trend }}
            </p>
        </div>
        <i :class="[icon, 'text-zinc-400 text-lg flex-shrink-0']"></i>
    </div>
</template>

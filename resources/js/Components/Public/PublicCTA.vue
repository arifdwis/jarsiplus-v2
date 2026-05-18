<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    title: { type: String, required: true },
    subtitle: { type: String, default: '' },
    primaryCta: { type: Object, required: true },
    secondaryCta: { type: Object, default: () => null },
});
</script>

<template>
    <section class="relative overflow-hidden bg-[#222831] text-[#EEEEEE]">
        <div class="absolute inset-0 bg-gradient-to-r from-[#00ADB5]/10 to-transparent"></div>

        <div class="relative max-w-7xl mx-auto px-4 lg:px-8 py-20">
            <div class="max-w-3xl">
                <h2 class="text-3xl md:text-4xl font-bold tracking-tight">{{ title }}</h2>
                <p v-if="subtitle" class="text-base text-[#EEEEEE]/80 mt-4 leading-relaxed">{{ subtitle }}</p>

                <div class="mt-8 flex flex-wrap items-center gap-3">
                    <Link
                        :href="primaryCta.href"
                        class="inline-flex items-center gap-2 text-sm font-semibold text-[#222831] bg-[#00ADB5] hover:bg-[#00ADB5]/90 px-6 py-3 rounded transition-colors"
                    >
                        {{ primaryCta.label }}
                        <i class="pi pi-arrow-right text-xs"></i>
                    </Link>
                    <Link
                        v-if="secondaryCta"
                        :href="secondaryCta.href"
                        class="inline-flex items-center gap-2 text-sm font-semibold border border-[#EEEEEE]/30 hover:border-[#00ADB5] hover:text-[#00ADB5] px-6 py-3 rounded transition-colors"
                    >
                        {{ secondaryCta.label }}
                    </Link>
                </div>
            </div>
        </div>
    </section>
</template>

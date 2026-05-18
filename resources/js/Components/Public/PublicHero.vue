<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    eyebrow: { type: String, default: '' },
    title: { type: String, required: true },
    subtitle: { type: String, default: '' },
    primaryCta: { type: Object, default: () => ({ label: 'Ajukan Inovasi', href: '/login' }) },
    secondaryCta: { type: Object, default: () => null },
});
</script>

<template>
    <section class="relative overflow-hidden bg-gradient-to-br from-[#222831] via-[#222831] to-[#393E46] text-[#EEEEEE]">
        <!-- Decorative blur -->
        <div class="absolute -top-32 -right-32 w-96 h-96 bg-[#00ADB5]/20 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-[#00ADB5]/10 rounded-full blur-3xl"></div>

        <div class="relative max-w-7xl mx-auto px-4 lg:px-8 pt-32 pb-24 lg:pt-40 lg:pb-32">
            <div class="max-w-3xl">
                <p
                    v-if="eyebrow"
                    class="inline-block text-xs font-semibold tracking-widest text-[#00ADB5] bg-[#00ADB5]/10 px-3 py-1 rounded-full mb-5 uppercase"
                >
                    {{ eyebrow }}
                </p>
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold tracking-tight leading-[1.1]">
                    <slot name="title">{{ title }}</slot>
                </h1>
                <p v-if="subtitle" class="text-lg md:text-xl text-[#EEEEEE]/80 mt-6 leading-relaxed">
                    {{ subtitle }}
                </p>

                <div v-if="primaryCta || secondaryCta" class="mt-10 flex flex-wrap items-center gap-3">
                    <Link
                        v-if="primaryCta"
                        :href="primaryCta.href"
                        class="inline-flex items-center gap-2 text-sm font-semibold text-[#222831] bg-[#00ADB5] hover:bg-[#00ADB5]/90 px-6 py-3 rounded transition-colors"
                    >
                        {{ primaryCta.label }}
                        <i class="pi pi-arrow-right text-xs"></i>
                    </Link>
                    <Link
                        v-if="secondaryCta"
                        :href="secondaryCta.href"
                        class="inline-flex items-center gap-2 text-sm font-semibold text-[#EEEEEE] border border-[#EEEEEE]/30 hover:border-[#00ADB5] hover:text-[#00ADB5] px-6 py-3 rounded transition-colors"
                    >
                        {{ secondaryCta.label }}
                    </Link>
                </div>

                <slot name="meta" />
            </div>

            <slot name="figure" />
        </div>
    </section>
</template>

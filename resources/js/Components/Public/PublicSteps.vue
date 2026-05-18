<script setup>
defineProps({
    eyebrow: { type: String, default: '' },
    title: { type: String, required: true },
    subtitle: { type: String, default: '' },
    steps: { type: Array, required: true }, // [{number, title, description}]
});
</script>

<template>
    <section class="bg-white py-20">
        <div class="max-w-7xl mx-auto px-4 lg:px-8">
            <div class="max-w-2xl mb-14">
                <p
                    v-if="eyebrow"
                    class="text-xs font-semibold tracking-widest text-[#00ADB5] uppercase mb-3"
                >
                    {{ eyebrow }}
                </p>
                <h2 class="text-3xl md:text-4xl font-bold text-[#222831] tracking-tight">{{ title }}</h2>
                <p v-if="subtitle" class="text-base text-[#393E46] mt-4 leading-relaxed">{{ subtitle }}</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div
                    v-for="(step, i) in steps"
                    :key="i"
                    class="relative"
                >
                    <div class="flex items-baseline gap-3 mb-3">
                        <span class="text-5xl font-bold text-[#00ADB5] tabular-nums leading-none">
                            {{ String(step.number ?? i + 1).padStart(2, '0') }}
                        </span>
                        <div v-if="i < steps.length - 1" class="hidden lg:block flex-1 h-px bg-[#393E46]/20 ml-3 mb-3"></div>
                    </div>
                    <h3 class="text-base font-semibold text-[#222831]">{{ step.title }}</h3>
                    <p class="text-sm text-[#393E46] mt-2 leading-relaxed">{{ step.description }}</p>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
defineProps({
    eyebrow: { type: String, default: '' },
    title: { type: String, required: true },
    subtitle: { type: String, default: '' },
    items: { type: Array, required: true }, // [{icon, title, description}]
});
</script>

<template>
    <section class="bg-[#EEEEEE] py-20">
        <div class="max-w-7xl mx-auto px-4 lg:px-8">
            <div class="max-w-2xl mb-12">
                <p
                    v-if="eyebrow"
                    class="text-xs font-semibold tracking-widest text-[#00ADB5] uppercase mb-3"
                >
                    {{ eyebrow }}
                </p>
                <h2 class="text-3xl md:text-4xl font-bold text-[#222831] tracking-tight">{{ title }}</h2>
                <p v-if="subtitle" class="text-base text-[#393E46] mt-4 leading-relaxed">{{ subtitle }}</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <div
                    v-for="(item, i) in items"
                    :key="i"
                    class="bg-white rounded-lg p-6 border border-[#393E46]/10 hover:border-[#00ADB5] transition-colors group"
                >
                    <div class="w-12 h-12 bg-[#00ADB5]/10 group-hover:bg-[#00ADB5] rounded-lg flex items-center justify-center text-[#00ADB5] group-hover:text-[#222831] transition-colors mb-4">
                        <i :class="[item.icon, 'text-xl']"></i>
                    </div>
                    <h3 class="text-base font-semibold text-[#222831]">{{ item.title }}</h3>
                    <p class="text-sm text-[#393E46] mt-2 leading-relaxed">{{ item.description }}</p>
                </div>
            </div>
        </div>
    </section>
</template>

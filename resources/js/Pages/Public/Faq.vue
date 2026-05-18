<script setup>
import { ref } from 'vue';
import PublicLayout from '@/Layouts/PublicLayout.vue';
import PublicHero from '@/Components/Public/PublicHero.vue';

defineProps({ faq: { type: Array, default: () => [] } });

const opened = ref([]);
const toggle = (id) => {
    const i = opened.value.indexOf(id);
    if (i > -1) opened.value.splice(i, 1);
    else opened.value.push(id);
};
</script>

<template>
    <PublicLayout>
        <PublicHero
            eyebrow="Pertanyaan Umum"
            title="Pertanyaan yang sering diajukan."
            subtitle="Tidak menemukan jawaban? Hubungi tim kami lewat halaman Kontak."
        />

        <section class="py-20 bg-white">
            <div class="max-w-3xl mx-auto px-4 lg:px-8">
                <div v-if="faq.length" class="space-y-3">
                    <article
                        v-for="item in faq"
                        :key="item.id"
                        class="bg-white border border-[#393E46]/10 rounded-lg overflow-hidden"
                    >
                        <button
                            @click="toggle(item.id)"
                            class="w-full flex items-center justify-between p-5 text-left hover:bg-[#EEEEEE] transition-colors"
                        >
                            <h3 class="text-base font-semibold text-[#222831] pr-4">{{ item.label }}</h3>
                            <i
                                :class="[
                                    'pi pi-chevron-down text-[#00ADB5] transition-transform',
                                    opened.includes(item.id) ? 'rotate-180' : '',
                                ]"
                            ></i>
                        </button>
                        <div
                            v-if="opened.includes(item.id)"
                            class="px-5 pb-5 text-sm text-[#393E46] leading-relaxed prose prose-sm max-w-none"
                            v-html="item.jawaban"
                        ></div>
                    </article>
                </div>

                <div v-else class="text-center py-12">
                    <i class="pi pi-info-circle text-3xl text-[#393E46]/40"></i>
                    <p class="text-sm text-[#393E46] mt-3">Belum ada FAQ tersedia.</p>
                </div>
            </div>
        </section>
    </PublicLayout>
</template>

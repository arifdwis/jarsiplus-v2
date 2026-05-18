<script setup>
import PublicLayout from '@/Layouts/PublicLayout.vue';
import PublicHero from '@/Components/Public/PublicHero.vue';

defineProps({
    laman: { type: Object, required: true },
});
</script>

<template>
    <PublicLayout>
        <PublicHero
            eyebrow="Informasi"
            :title="laman.label"
        />

        <article class="py-20 bg-white">
            <div
                class="max-w-3xl mx-auto px-4 lg:px-8 prose prose-zinc prose-base prose-a:text-[#00ADB5] prose-a:no-underline hover:prose-a:underline"
                v-html="laman.content"
            ></div>
        </article>
    </PublicLayout>
</template>

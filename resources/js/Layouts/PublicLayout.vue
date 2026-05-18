<script setup>
import { computed, onMounted, onBeforeUnmount, ref } from 'vue';
import PublicNavbar from '@/Components/Public/PublicNavbar.vue';
import PublicFooter from '@/Components/Public/PublicFooter.vue';

defineProps({
    transparentNav: { type: Boolean, default: true },
});

const scrolled = ref(false);

function onScroll() {
    scrolled.value = window.scrollY > 20;
}

onMounted(() => {
    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll();
});

onBeforeUnmount(() => {
    window.removeEventListener('scroll', onScroll);
});
</script>

<template>
    <div class="min-h-screen bg-white text-[#222831] flex flex-col">
        <PublicNavbar :transparent="transparentNav && !scrolled" />

        <main class="flex-1">
            <slot />
        </main>

        <PublicFooter />
    </div>
</template>

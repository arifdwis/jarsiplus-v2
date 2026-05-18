<script setup>
import PublicLayout from '@/Layouts/PublicLayout.vue';
import PublicHero from '@/Components/Public/PublicHero.vue';

const contacts = [
    {
        icon: 'pi pi-building',
        label: 'Diskominfo Kota Samarinda',
        value: 'Jl. Basuki Rahmat No. 76, Samarinda',
    },
    {
        icon: 'pi pi-envelope',
        label: 'Email',
        value: 'diskominfo@samarindakota.go.id',
        href: 'mailto:diskominfo@samarindakota.go.id',
    },
    {
        icon: 'pi pi-phone',
        label: 'Telepon',
        value: '(0541) 123-4567',
    },
    {
        icon: 'pi pi-globe',
        label: 'Website',
        value: 'samarindakota.go.id',
        href: 'https://samarindakota.go.id',
    },
];
</script>

<template>
    <PublicLayout>
        <PublicHero
            eyebrow="Hubungi Kami"
            title="Tim Pemkot siap membantu."
            subtitle="Hubungi Diskominfo Kota Samarinda untuk pertanyaan terkait JARSIPLUS, integrasi, atau dukungan teknis."
        />

        <section class="py-20 bg-white">
            <div class="max-w-4xl mx-auto px-4 lg:px-8 grid grid-cols-1 md:grid-cols-2 gap-4">
                <a
                    v-for="c in contacts"
                    :key="c.label"
                    :href="c.href ?? '#'"
                    :target="c.href?.startsWith('http') ? '_blank' : undefined"
                    rel="noopener"
                    class="bg-white border border-[#393E46]/10 rounded-lg p-6 hover:border-[#00ADB5] transition-colors group"
                >
                    <div class="w-10 h-10 bg-[#00ADB5]/10 group-hover:bg-[#00ADB5] rounded flex items-center justify-center text-[#00ADB5] group-hover:text-[#222831] transition-colors mb-4">
                        <i :class="[c.icon, 'text-base']"></i>
                    </div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-[#393E46]/70">{{ c.label }}</p>
                    <p class="text-base text-[#222831] mt-1 font-medium">{{ c.value }}</p>
                </a>
            </div>
        </section>
    </PublicLayout>
</template>

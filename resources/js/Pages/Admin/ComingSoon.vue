<script setup>
import { Link } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import PageHeader from '@/Components/Layout/PageHeader.vue';
import EmptyState from '@/Components/Layout/EmptyState.vue';

defineProps({
    title: { type: String, default: 'Halaman ini sedang dibangun' },
    description: { type: String, default: '' },
    icon: { type: String, default: 'pi pi-hammer' },
});
</script>

<template>
    <AdminLayout>
        <PageHeader :title="title" :description="description" />

        <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded">
            <EmptyState
                :icon="icon"
                title="Halaman dalam pengembangan"
                description="Fitur ini sedang dibangun. Pantau update di repositori GitHub."
            >
                <template #action>
                    <Link
                        href="/dashboard"
                        class="inline-flex items-center gap-1.5 text-xs font-medium text-zinc-700 dark:text-zinc-300 bg-zinc-100 dark:bg-zinc-800 hover:bg-zinc-200 dark:hover:bg-zinc-700 px-3 py-1.5 rounded transition-colors"
                    >
                        <i class="pi pi-arrow-left text-[10px]"></i>
                        Kembali ke Dashboard
                    </Link>
                </template>
            </EmptyState>
        </div>
    </AdminLayout>
</template>

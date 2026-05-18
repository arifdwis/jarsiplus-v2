<script setup>
import { Link } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import PageHeader from '@/Components/Layout/PageHeader.vue';
import SectionCard from '@/Components/Layout/SectionCard.vue';
import EmptyState from '@/Components/Layout/EmptyState.vue';
import StatCard from '@/Components/Data/StatCard.vue';
import { useAuth } from '@/Composables/useAuth';

const { user } = useAuth();

const stats = [
    { label: 'Permohonan Aktif', value: 0, icon: 'pi pi-clock' },
    { label: 'Disetujui', value: 0, icon: 'pi pi-check' },
    { label: 'Ditolak', value: 0, icon: 'pi pi-times' },
    { label: 'Total', value: 0, icon: 'pi pi-file' },
];
</script>

<template>
    <AdminLayout>
        <PageHeader title="Dashboard" :description="`Selamat datang, ${user?.name ?? '—'}`" />

        <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 mb-4">
            <StatCard
                v-for="s in stats"
                :key="s.label"
                :label="s.label"
                :value="s.value"
                :icon="s.icon"
            />
        </div>

        <SectionCard title="Permohonan Terbaru">
            <template #header-actions>
                <Link
                    href="/permohonan/create"
                    class="inline-flex items-center gap-1.5 text-xs font-medium text-zinc-900 bg-zinc-100 hover:bg-zinc-200 px-2.5 py-1.5 rounded"
                >
                    <i class="pi pi-plus text-[10px]"></i>
                    Buat Permohonan
                </Link>
            </template>

            <EmptyState
                title="Belum ada permohonan"
                description="Mulai ajukan inovasi pertama Anda"
            >
                <template #action>
                    <Link
                        href="/permohonan/create"
                        class="inline-flex items-center gap-1.5 text-xs font-medium text-white bg-zinc-900 hover:bg-zinc-800 px-3 py-1.5 rounded"
                    >
                        <i class="pi pi-plus text-[10px]"></i>
                        Buat Permohonan
                    </Link>
                </template>
            </EmptyState>
        </SectionCard>
    </AdminLayout>
</template>

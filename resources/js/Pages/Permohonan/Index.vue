<script setup>
import { Link, router } from '@inertiajs/vue3';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import PageHeader from '@/Components/Layout/PageHeader.vue';
import StatusTag from '@/Components/Data/StatusTag.vue';
import { useDataTable } from '@/Composables/useDataTable';
import { useFormatter } from '@/Composables/useFormatter';

const props = defineProps({
    permohonan: Object,
    isAdmin: Boolean,
});

const { onPage } = useDataTable('/permohonan');
const { formatDate } = useFormatter();

const viewRow = (row) => router.visit(`/permohonan/${row.id}`);
</script>

<template>
    <AdminLayout>
        <PageHeader
            :title="isAdmin ? 'Semua Permohonan' : 'Permohonan Saya'"
            :description="`${permohonan.total} record`"
        >
            <template #actions>
                <Link
                    href="/permohonan/create"
                    class="inline-flex items-center gap-1.5 text-xs font-medium text-white bg-zinc-900 hover:bg-zinc-800 px-3 py-1.5 rounded"
                >
                    <i class="pi pi-plus text-[10px]"></i>
                    Buat Permohonan
                </Link>
            </template>
        </PageHeader>

        <div class="bg-white border border-zinc-200 rounded overflow-hidden">
            <DataTable
                :value="permohonan.data"
                paginator
                lazy
                :rows="permohonan.per_page"
                :totalRecords="permohonan.total"
                :first="(permohonan.current_page - 1) * permohonan.per_page"
                @page="onPage"
                @rowClick="(e) => viewRow(e.data)"
                dataKey="id"
                :rowHover="true"
                stripedRows
                size="small"
                class="cursor-pointer mono-table"
                emptyMessage="Belum ada permohonan"
            >
                <Column field="kode" header="Kode" style="width: 7rem">
                    <template #body="{ data }">
                        <span class="text-xs font-mono text-zinc-600">{{ data.kode || '-' }}</span>
                    </template>
                </Column>
                <Column field="label" header="Judul Inovasi" sortable>
                    <template #body="{ data }">
                        <div class="text-xs">
                            <p class="font-medium text-zinc-900 line-clamp-1">{{ data.label || '(tanpa judul)' }}</p>
                            <p v-if="data.pemohon" class="text-zinc-500 mt-0.5">{{ data.pemohon.name }}</p>
                        </div>
                    </template>
                </Column>
                <Column header="Urusan">
                    <template #body="{ data }">
                        <span class="text-xs text-zinc-700">{{ data.urusan?.label ?? '-' }}</span>
                    </template>
                </Column>
                <Column field="status" header="Status" sortable style="width: 8rem">
                    <template #body="{ data }">
                        <StatusTag :status="data.status" />
                    </template>
                </Column>
                <Column field="created_at" header="Dibuat" sortable style="width: 8rem">
                    <template #body="{ data }">
                        <span class="text-xs text-zinc-600">{{ formatDate(data.created_at) }}</span>
                    </template>
                </Column>
            </DataTable>
        </div>
    </AdminLayout>
</template>

<style>
.mono-table .p-datatable-thead > tr > th {
    background: #fafafa !important;
    color: #3f3f46 !important;
    font-size: 0.7rem !important;
    text-transform: uppercase;
    letter-spacing: 0.03em;
    font-weight: 600 !important;
    padding: 0.5rem 0.75rem !important;
    border-bottom: 1px solid #e4e4e7 !important;
}
.mono-table .p-datatable-tbody > tr > td {
    padding: 0.6rem 0.75rem !important;
    border-bottom: 1px solid #f4f4f5 !important;
}
.mono-table .p-datatable-tbody > tr:hover {
    background: #fafafa !important;
}
</style>

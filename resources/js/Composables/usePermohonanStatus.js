/**
 * Permohonan status helpers — labels, severity, action permissions.
 */
export function usePermohonanStatus() {
    const labels = {
        draft: 'Draft',
        submitted: 'Disubmit',
        reviewed: 'Ditinjau',
        approved: 'Disetujui',
        rejected: 'Ditolak',
        // Legacy numeric statuses from dump
        '0': 'Diajukan',
        '1': 'Disetujui',
        '2': 'Menunggu Review',
        '4': 'Selesai',
        '9': 'Ditolak',
    };

    const severities = {
        draft: 'secondary',
        submitted: 'info',
        reviewed: 'warn',
        approved: 'success',
        rejected: 'danger',
        '0': 'secondary',
        '1': 'info',
        '2': 'warn',
        '4': 'success',
        '9': 'danger',
    };

    const statusLabel = (status) => labels[String(status)] ?? (status || '-');
    const statusSeverity = (status) => severities[String(status)] ?? 'secondary';

    const isDraft = (p) => p?.status === 'draft' || p?.status === 0 || p?.status === '0';
    const isSubmitted = (p) => p?.status === 'submitted' || p?.status === 2 || p?.status === '2';
    const isApproved = (p) => p?.status === 'approved' || p?.status === 4 || p?.status === '4';
    const isRejected = (p) => p?.status === 'rejected' || p?.status === 9 || p?.status === '9';

    const canEdit = (p) => isDraft(p);
    const canSubmit = (p) => isDraft(p);
    const canDelete = (p) => isDraft(p);

    return {
        labels,
        severities,
        statusLabel,
        statusSeverity,
        isDraft,
        isSubmitted,
        isApproved,
        isRejected,
        canEdit,
        canSubmit,
        canDelete,
    };
}

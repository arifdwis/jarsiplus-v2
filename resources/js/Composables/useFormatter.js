/**
 * Formatter helpers — Indonesian-localized date, currency, number, text.
 */
export function useFormatter() {
    const formatDate = (date, opts = { day: '2-digit', month: 'short', year: 'numeric' }) => {
        if (!date) return '-';
        try {
            return new Date(date).toLocaleDateString('id-ID', opts);
        } catch {
            return '-';
        }
    };

    const formatDateTime = (date) =>
        formatDate(date, { day: '2-digit', month: 'short', year: 'numeric', hour: '2-digit', minute: '2-digit' });

    const formatRupiah = (n) => {
        if (n === null || n === undefined || n === '') return '-';
        const num = typeof n === 'number' ? n : parseInt(String(n).replace(/[^\d-]/g, ''), 10);
        if (Number.isNaN(num)) return '-';
        return num.toLocaleString('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 });
    };

    const formatNumber = (n) => {
        if (n === null || n === undefined || n === '') return '-';
        const num = typeof n === 'number' ? n : Number(n);
        return Number.isNaN(num) ? '-' : num.toLocaleString('id-ID');
    };

    const truncate = (text, max = 80) => {
        if (!text) return '';
        return text.length > max ? text.slice(0, max).trim() + '…' : text;
    };

    const formatBytes = (bytes) => {
        if (!bytes) return '0 B';
        const units = ['B', 'KB', 'MB', 'GB', 'TB'];
        const i = Math.floor(Math.log(bytes) / Math.log(1024));
        return (bytes / Math.pow(1024, i)).toFixed(i === 0 ? 0 : 1) + ' ' + units[i];
    };

    return { formatDate, formatDateTime, formatRupiah, formatNumber, truncate, formatBytes };
}

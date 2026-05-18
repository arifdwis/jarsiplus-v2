import { computed } from 'vue';
import { usePage } from '@inertiajs/vue3';

/**
 * Transform server-side menu tree (from HandleInertiaRequests) into
 * PrimeVue PanelMenu-compatible items, mapping iconify icons to PrimeIcons.
 */
export function useMenu() {
    const page = usePage();

    const iconMap = {
        'icon-park-twotone:dashboard-one': 'pi pi-home',
        'icon-park-twotone:list-success': 'pi pi-cog',
        'icon-park-twotone:peoples-two': 'pi pi-users',
        'icon-park-twotone:id-card-h': 'pi pi-id-card',
        'icon-park-twotone:harm': 'pi pi-shield',
        'icon-park-twotone:tree-diagram': 'pi pi-sitemap',
        'icon-park-twotone:history-query': 'pi pi-history',
        'ic:baseline-work-history': 'pi pi-briefcase',
        'humbleicons:user-asking': 'pi pi-user-plus',
        'akar-icons:people-group': 'pi pi-users',
        'wpf:faq': 'pi pi-question-circle',
        'mdi:database-clock-outline': 'pi pi-database',
        'zondicons:information-outline': 'pi pi-info-circle',
        'fluent:megaphone-loud-20-filled': 'pi pi-megaphone',
        'material-symbols:slide-library': 'pi pi-images',
        'healthicons:i-exam-multiple-choice': 'pi pi-list',
        'healthicons:i-exam-multiple-choice-outline': 'pi pi-list',
        'carbon:parent-child': 'pi pi-folder',
        'clarity:map-solid-alerted': 'pi pi-map',
        'clarity:building-solid-alerted': 'pi pi-building',
        'clarity:building-solid-badged': 'pi pi-building',
        'material-symbols:archive-outline': 'pi pi-inbox',
    };

    const mapIcon = (icon) => iconMap[icon] ?? 'pi pi-circle-fill';

    const transform = (item) => {
        const node = {
            key: String(item.id),
            label: item.title,
            icon: mapIcon(item.icon),
        };

        if (item.items?.length) {
            node.items = item.items.map(transform);
        } else if (item.uri && item.uri !== '#') {
            const url = '/' + item.uri.replace(/^\//, '');
            node.url = url;
            node.command = (e) => {
                e.originalEvent.preventDefault();
                import('@inertiajs/vue3').then(({ router }) => router.visit(url));
            };
        }

        return node;
    };

    const menuItems = computed(() => (page.props.menu ?? []).map(transform));

    return { menuItems, mapIcon };
}

<script setup>
import { Link } from '@inertiajs/vue3';
import { useAuth } from '@/Composables/useAuth';
import { useMenu } from '@/Composables/useMenu';

defineProps({
    open: { type: Boolean, default: true },
    mini: { type: Boolean, default: false },
});

const { roles } = useAuth();
const { menuItems } = useMenu();

// Group menu items by parent category for Diamond-style section header
function groupItems(items) {
    // Top-level items become section headers; their children become menu items.
    // Flat items (no children) go into a default "Umum" section.
    const sections = [];
    const flat = [];

    items.forEach((item) => {
        if (item.items?.length) {
            sections.push({ title: item.label, items: item.items, icon: item.icon });
        } else {
            flat.push(item);
        }
    });

    if (flat.length) {
        sections.unshift({ title: 'Umum', items: flat, icon: 'pi pi-home' });
    }

    return sections;
}
</script>

<template>
    <aside
        :class="[
            'fixed top-0 left-0 bottom-0 z-30 bg-white dark:bg-zinc-900 border-r border-zinc-200 dark:border-zinc-800 transition-all duration-200 flex flex-col',
            open ? (mini ? 'w-16' : 'w-60') : 'w-0 overflow-hidden',
        ]"
    >
        <!-- Brand -->
        <div class="h-14 flex items-center border-b border-zinc-200 dark:border-zinc-800 flex-shrink-0" :class="mini ? 'justify-center' : 'px-4'">
            <Link href="/dashboard" class="flex items-center gap-2.5">
                <div class="w-8 h-8 bg-zinc-900 dark:bg-white rounded flex items-center justify-center text-white dark:text-zinc-900 font-bold text-xs flex-shrink-0">
                    J+
                </div>
                <span v-if="!mini" class="text-sm font-semibold tracking-tight text-zinc-900 dark:text-zinc-100">JARSIPLUS</span>
            </Link>
        </div>

        <!-- Menu sections -->
        <nav class="flex-1 overflow-y-auto py-3" :class="mini ? 'px-1.5' : 'px-3'">
            <template v-for="(section, idx) in groupItems(menuItems)" :key="idx">
                <div :class="['mb-4', idx > 0 ? 'mt-2' : '']">
                    <p
                        v-if="!mini"
                        class="text-[10px] font-semibold text-zinc-400 dark:text-zinc-500 uppercase tracking-wider px-2 mb-1.5"
                    >
                        {{ section.title }}
                    </p>
                    <ul class="space-y-0.5">
                        <li v-for="item in section.items" :key="item.key">
                            <a
                                :href="item.url ?? '#'"
                                @click.prevent="item.command?.($event)"
                                v-tooltip.right="mini ? item.label : null"
                                :class="[
                                    'flex items-center gap-2.5 px-2 py-1.5 rounded text-xs text-zinc-700 dark:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-800 hover:text-zinc-900 dark:hover:text-zinc-100 transition-colors',
                                    mini ? 'justify-center' : '',
                                ]"
                            >
                                <i :class="[item.icon, 'text-sm flex-shrink-0']"></i>
                                <span v-if="!mini" class="truncate">{{ item.label }}</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </template>

            <div v-if="!menuItems.length && !mini" class="text-zinc-500 text-xs p-3">
                Tidak ada menu untuk role Anda.
            </div>
        </nav>

        <!-- Footer with role badges -->
        <div
            v-if="roles.length && !mini"
            class="border-t border-zinc-200 dark:border-zinc-800 px-3 py-3 flex-shrink-0"
        >
            <p class="text-[10px] text-zinc-400 dark:text-zinc-500 uppercase tracking-wider mb-1.5 font-semibold">Role</p>
            <div class="flex flex-wrap gap-1">
                <span
                    v-for="role in roles"
                    :key="role"
                    class="text-[10px] bg-zinc-900 dark:bg-zinc-100 text-white dark:text-zinc-900 px-1.5 py-0.5 rounded font-medium"
                >
                    {{ role }}
                </span>
            </div>
        </div>
    </aside>
</template>

<template>
    <Head title="Links - Admin" />

    <AdminLayout>
        <div class="space-y-6">
            <!-- Header -->
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-foreground">Links</h1>
                    <p class="text-muted-foreground">Manage all links on your platform</p>
                </div>
            </div>

            <!-- Filters -->
            <div class="rounded-lg border border-border bg-card p-6">
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                    <div>
                        <label class="text-sm font-medium text-card-foreground">Search</label>
                        <input
                            v-model="filters.search"
                            type="text"
                            placeholder="Search links..."
                            class="mt-1 block w-full rounded-md border border-border bg-background px-3 py-2 text-sm text-foreground placeholder:text-muted-foreground focus:border-primary focus:ring-1 focus:ring-primary focus:outline-none"
                        />
                    </div>
                    <div>
                        <label class="text-sm font-medium text-card-foreground">User</label>
                        <input
                            v-model="filters.user"
                            type="text"
                            placeholder="Search by user..."
                            class="mt-1 block w-full rounded-md border border-border bg-background px-3 py-2 text-sm text-foreground placeholder:text-muted-foreground focus:border-primary focus:ring-1 focus:ring-primary focus:outline-none"
                        />
                    </div>
                    <div>
                        <label class="text-sm font-medium text-card-foreground">Status</label>
                        <select
                            v-model="filters.is_active"
                            class="mt-1 block w-full rounded-md border border-border bg-background px-3 py-2 text-sm text-foreground focus:border-primary focus:ring-1 focus:ring-primary focus:outline-none"
                        >
                            <option value="">All Links</option>
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-card-foreground">Sort By</label>
                        <select
                            v-model="filters.sort"
                            class="mt-1 block w-full rounded-md border border-border bg-background px-3 py-2 text-sm text-foreground focus:border-primary focus:ring-1 focus:ring-primary focus:outline-none"
                        >
                            <option value="created_at">Created Date</option>
                            <option value="clicks">Total Clicks</option>
                            <option value="title">Title</option>
                        </select>
                    </div>
                </div>
                <div class="mt-4 flex items-center justify-between">
                    <button
                        @click="applyFilters"
                        class="inline-flex items-center gap-2 rounded-lg bg-primary px-4 py-2 text-sm font-medium text-primary-foreground transition-colors hover:bg-primary/90"
                    >
                        Apply Filters
                    </button>
                    <button @click="clearFilters" class="text-sm text-muted-foreground transition-colors hover:text-foreground">Clear Filters</button>
                </div>
            </div>

            <!-- Links Table -->
            <div class="overflow-hidden rounded-lg border border-border bg-card">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="border-b border-border bg-muted/50">
                            <tr>
                                <th class="px-4 py-3 text-left text-sm font-medium text-muted-foreground">Link</th>
                                <th class="px-4 py-3 text-left text-sm font-medium text-muted-foreground">User</th>
                                <th class="px-4 py-3 text-left text-sm font-medium text-muted-foreground">Clicks</th>
                                <th class="px-4 py-3 text-left text-sm font-medium text-muted-foreground">Status</th>
                                <th class="px-4 py-3 text-left text-sm font-medium text-muted-foreground">Created</th>
                                <th class="px-4 py-3 text-right text-sm font-medium text-muted-foreground">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-border">
                            <tr v-for="link in links.data" :key="link.id" class="transition-colors hover:bg-muted/50">
                                <td class="px-4 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-primary/10">
                                            <img v-if="link.icon" :src="link.icon" :alt="link.title" class="h-6 w-6 rounded object-cover" />
                                            <svg v-else class="h-5 w-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"
                                                />
                                            </svg>
                                        </div>
                                        <div class="min-w-0 flex-1">
                                            <p class="truncate text-sm font-medium text-card-foreground">{{ link.title }}</p>
                                            <p class="truncate text-sm text-muted-foreground">{{ link.url }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-4">
                                    <div class="flex items-center gap-2">
                                        <div class="flex h-8 w-8 items-center justify-center rounded-full bg-primary/10">
                                            <img
                                                v-if="link.user.avatar"
                                                :src="link.user.avatar"
                                                :alt="link.user.name"
                                                class="h-full w-full rounded-full object-cover"
                                            />
                                            <span v-else class="text-xs font-medium text-primary">
                                                {{ link.user.name.charAt(0).toUpperCase() }}
                                            </span>
                                        </div>
                                        <span class="text-sm text-card-foreground">{{ link.user.name }}</span>
                                    </div>
                                </td>
                                <td class="px-4 py-4">
                                    <span class="text-sm text-card-foreground">{{ link.analytics_sum_clicks || 0 }}</span>
                                </td>
                                <td class="px-4 py-4">
                                    <span
                                        :class="[
                                            'inline-flex items-center rounded-full px-2 py-1 text-xs font-medium',
                                            link.is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700',
                                        ]"
                                    >
                                        {{ link.is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td class="px-4 py-4">
                                    <span class="text-sm text-muted-foreground">
                                        {{ formatDate(link.created_at) }}
                                    </span>
                                </td>
                                <td class="px-4 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a
                                            :href="link.url"
                                            target="_blank"
                                            class="inline-flex items-center gap-1 rounded-md bg-blue-100 px-2 py-1 text-xs font-medium text-blue-700 transition-colors hover:bg-blue-200"
                                        >
                                            Visit
                                        </a>
                                        <button
                                            @click="toggleLinkStatus(link)"
                                            :class="[
                                                'inline-flex items-center gap-1 rounded-md px-2 py-1 text-xs font-medium transition-colors',
                                                link.is_active
                                                    ? 'bg-red-100 text-red-700 hover:bg-red-200'
                                                    : 'bg-green-100 text-green-700 hover:bg-green-200',
                                            ]"
                                        >
                                            {{ link.is_active ? 'Disable' : 'Enable' }}
                                        </button>
                                        <button
                                            @click="deleteLink(link.id)"
                                            class="inline-flex items-center gap-1 rounded-md bg-red-100 px-2 py-1 text-xs font-medium text-red-700 transition-colors hover:bg-red-200"
                                        >
                                            Delete
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div v-if="links.links.length > 3" class="border-t border-border px-6 py-4">
                    <div class="flex items-center justify-between">
                        <p class="text-sm text-muted-foreground">Showing {{ links.from }} to {{ links.to }} of {{ links.total }} results</p>
                        <div class="flex items-center gap-2">
                            <Link
                                v-for="link in links.links"
                                :key="link.label"
                                :href="link.url"
                                v-html="link.label"
                                :class="[
                                    'rounded-md px-3 py-2 text-sm font-medium transition-colors',
                                    link.active
                                        ? 'bg-primary text-primary-foreground'
                                        : link.url
                                          ? 'text-muted-foreground hover:bg-muted hover:text-foreground'
                                          : 'cursor-not-allowed text-muted-foreground/50',
                                ]"
                                :tabindex="link.url ? 0 : -1"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup lang="ts">
import AdminLayout from '@/layouts/AdminLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { ref, watch } from 'vue';

interface LinkItem {
    id: number;
    title: string;
    url: string;
    icon?: string;
    is_active: boolean;
    analytics_sum_clicks: number;
    created_at: string;
    user: {
        name: string;
        avatar?: string;
    };
}

interface PaginatedLinks {
    data: LinkItem[];
    links: Array<{
        url: string | null;
        label: string;
        active: boolean;
    }>;
    from: number;
    to: number;
    total: number;
}

interface Props {
    links: PaginatedLinks;
    filters: {
        search: string;
        user: string;
        is_active: string;
        sort: string;
    };
}

const props = defineProps<Props>();

const filters = ref({ ...props.filters });

const formatDate = (dateString: string): string => {
    return new Date(dateString).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric',
    });
};

const applyFilters = () => {
    router.get(route('admin.links.index'), filters.value, {
        preserveState: true,
        preserveScroll: true,
    });
};

const clearFilters = () => {
    filters.value = {
        search: '',
        user: '',
        is_active: '',
        sort: 'created_at',
    };
    applyFilters();
};

const toggleLinkStatus = (link: LinkItem) => {
    const action = link.is_active ? 'disable' : 'enable';
    if (confirm(`Are you sure you want to ${action} this link?`)) {
        router.patch(route('admin.links.toggle-status', link.id));
    }
};

const deleteLink = (linkId: number) => {
    if (confirm('Are you sure you want to delete this link? This action cannot be undone.')) {
        router.delete(route('admin.links.destroy', linkId));
    }
};

// Auto-apply filters on change with debounce
let filterTimeout: ReturnType<typeof setTimeout>;
watch(
    filters,
    () => {
        clearTimeout(filterTimeout);
        filterTimeout = setTimeout(() => {
            applyFilters();
        }, 500);
    },
    { deep: true },
);
</script>

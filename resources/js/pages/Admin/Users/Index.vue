<template>
    <Head title="Users - Admin" />

    <AdminLayout>
        <div class="space-y-6">
            <!-- Header -->
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-foreground">Users</h1>
                    <p class="text-muted-foreground">Manage all users on your platform</p>
                </div>
                <div class="flex items-center gap-3">
                    <button
                        v-if="selectedUsers.length > 0"
                        @click="showBulkActions = !showBulkActions"
                        class="inline-flex items-center gap-2 rounded-lg border border-border bg-card px-4 py-2 text-sm font-medium text-card-foreground transition-colors hover:bg-muted"
                    >
                        Bulk Actions ({{ selectedUsers.length }})
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Bulk Actions -->
            <div v-if="showBulkActions && selectedUsers.length > 0" class="rounded-lg border border-border bg-card p-4">
                <div class="flex items-center gap-3">
                    <span class="text-sm font-medium text-card-foreground">
                        {{ selectedUsers.length }} user{{ selectedUsers.length === 1 ? '' : 's' }} selected:
                    </span>
                    <button
                        @click="bulkVerifyUsers"
                        class="inline-flex items-center gap-1 rounded-md bg-green-100 px-3 py-1 text-sm font-medium text-green-700 transition-colors hover:bg-green-200"
                    >
                        Verify
                    </button>
                    <button
                        @click="bulkUnverifyUsers"
                        class="inline-flex items-center gap-1 rounded-md bg-yellow-100 px-3 py-1 text-sm font-medium text-yellow-700 transition-colors hover:bg-yellow-200"
                    >
                        Unverify
                    </button>
                    <button
                        @click="bulkDeleteUsers"
                        class="inline-flex items-center gap-1 rounded-md bg-red-100 px-3 py-1 text-sm font-medium text-red-700 transition-colors hover:bg-red-200"
                    >
                        Delete
                    </button>
                    <button
                        @click="clearSelection"
                        class="inline-flex items-center gap-1 rounded-md bg-muted px-3 py-1 text-sm font-medium text-muted-foreground transition-colors hover:bg-muted/80"
                    >
                        Clear
                    </button>
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
                            placeholder="Search users..."
                            class="mt-1 block w-full rounded-md border border-border bg-background px-3 py-2 text-sm text-foreground placeholder:text-muted-foreground focus:border-primary focus:ring-1 focus:ring-primary focus:outline-none"
                        />
                    </div>
                    <div>
                        <label class="text-sm font-medium text-card-foreground">Role</label>
                        <select
                            v-model="filters.role"
                            class="mt-1 block w-full rounded-md border border-border bg-background px-3 py-2 text-sm text-foreground focus:border-primary focus:ring-1 focus:ring-primary focus:outline-none"
                        >
                            <option value="">All Roles</option>
                            <option value="free">Free</option>
                            <option value="pro">Pro</option>
                        </select>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-card-foreground">Status</label>
                        <select
                            v-model="filters.verified"
                            class="mt-1 block w-full rounded-md border border-border bg-background px-3 py-2 text-sm text-foreground focus:border-primary focus:ring-1 focus:ring-primary focus:outline-none"
                        >
                            <option value="">All Users</option>
                            <option value="1">Verified</option>
                            <option value="0">Unverified</option>
                        </select>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-card-foreground">Admin</label>
                        <select
                            v-model="filters.is_admin"
                            class="mt-1 block w-full rounded-md border border-border bg-background px-3 py-2 text-sm text-foreground focus:border-primary focus:ring-1 focus:ring-primary focus:outline-none"
                        >
                            <option value="">All Users</option>
                            <option value="1">Admins</option>
                            <option value="0">Regular Users</option>
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

            <!-- Users Table -->
            <div class="overflow-hidden rounded-lg border border-border bg-card">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="border-b border-border bg-muted/50">
                            <tr>
                                <th class="w-12 px-4 py-3 text-left">
                                    <input
                                        type="checkbox"
                                        :checked="allUsersSelected"
                                        @change="toggleAllUsers"
                                        class="rounded border-border text-primary focus:ring-primary"
                                    />
                                </th>
                                <th class="px-4 py-3 text-left text-sm font-medium text-muted-foreground">User</th>
                                <th class="px-4 py-3 text-left text-sm font-medium text-muted-foreground">Role</th>
                                <th class="px-4 py-3 text-left text-sm font-medium text-muted-foreground">Status</th>
                                <th class="px-4 py-3 text-left text-sm font-medium text-muted-foreground">Links</th>
                                <th class="px-4 py-3 text-left text-sm font-medium text-muted-foreground">Joined</th>
                                <th class="px-4 py-3 text-right text-sm font-medium text-muted-foreground">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-border">
                            <tr v-for="user in users.data" :key="user.id" class="transition-colors hover:bg-muted/50">
                                <td class="px-4 py-4">
                                    <input
                                        type="checkbox"
                                        :value="user.id"
                                        v-model="selectedUsers"
                                        class="rounded border-border text-primary focus:ring-primary"
                                    />
                                </td>
                                <td class="px-4 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="flex h-10 w-10 items-center justify-center rounded-full bg-primary/10">
                                            <img
                                                v-if="user.avatar"
                                                :src="user.avatar"
                                                :alt="user.name"
                                                class="h-full w-full rounded-full object-cover"
                                            />
                                            <span v-else class="font-medium text-primary">
                                                {{ user.name.charAt(0).toUpperCase() }}
                                            </span>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-card-foreground">{{ user.name }}</p>
                                            <p class="text-sm text-muted-foreground">{{ user.email }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-4">
                                    <div class="flex items-center gap-2">
                                        <span
                                            v-if="user.is_admin"
                                            class="inline-flex items-center rounded-full bg-red-100 px-2 py-1 text-xs font-medium text-red-700"
                                        >
                                            Admin
                                        </span>
                                        <span
                                            :class="[
                                                'inline-flex items-center rounded-full px-2 py-1 text-xs font-medium',
                                                user.role === 'pro' ? 'bg-yellow-100 text-yellow-700' : 'bg-gray-100 text-gray-700',
                                            ]"
                                        >
                                            {{ user.role === 'pro' ? 'Pro' : 'Free' }}
                                        </span>
                                    </div>
                                </td>
                                <td class="px-4 py-4">
                                    <span
                                        :class="[
                                            'inline-flex items-center rounded-full px-2 py-1 text-xs font-medium',
                                            user.email_verified_at ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700',
                                        ]"
                                    >
                                        {{ user.email_verified_at ? 'Verified' : 'Unverified' }}
                                    </span>
                                </td>
                                <td class="px-4 py-4">
                                    <span class="text-sm text-card-foreground">{{ user.links_count || 0 }}</span>
                                </td>
                                <td class="px-4 py-4">
                                    <span class="text-sm text-muted-foreground">
                                        {{ formatDate(user.created_at) }}
                                    </span>
                                </td>
                                <td class="px-4 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <button
                                            @click="impersonateUser(user.id)"
                                            class="inline-flex items-center gap-1 rounded-md bg-blue-100 px-2 py-1 text-xs font-medium text-blue-700 transition-colors hover:bg-blue-200"
                                        >
                                            Impersonate
                                        </button>
                                        <button
                                            @click="toggleUserAdmin(user)"
                                            :class="[
                                                'inline-flex items-center gap-1 rounded-md px-2 py-1 text-xs font-medium transition-colors',
                                                user.is_admin
                                                    ? 'bg-red-100 text-red-700 hover:bg-red-200'
                                                    : 'bg-green-100 text-green-700 hover:bg-green-200',
                                            ]"
                                        >
                                            {{ user.is_admin ? 'Remove Admin' : 'Make Admin' }}
                                        </button>
                                        <button
                                            @click="deleteUser(user.id)"
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
                <div v-if="users.links.length > 3" class="border-t border-border px-6 py-4">
                    <div class="flex items-center justify-between">
                        <p class="text-sm text-muted-foreground">Showing {{ users.from }} to {{ users.to }} of {{ users.total }} results</p>
                        <div class="flex items-center gap-2">
                            <Link
                                v-for="link in users.links"
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
import { computed, ref, watch } from 'vue';

interface User {
    id: number;
    name: string;
    email: string;
    avatar?: string;
    is_admin: boolean;
    role: string;
    email_verified_at: string | null;
    links_count: number;
    created_at: string;
}

interface PaginatedUsers {
    data: User[];
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
    users: PaginatedUsers;
    filters: {
        search: string;
        role: string;
        verified: string;
        is_admin: string;
    };
}

const props = defineProps<Props>();

const selectedUsers = ref<number[]>([]);
const showBulkActions = ref(false);
const filters = ref({ ...props.filters });

const allUsersSelected = computed(() => {
    return props.users.data.length > 0 && selectedUsers.value.length === props.users.data.length;
});

const formatDate = (dateString: string): string => {
    return new Date(dateString).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric',
    });
};

const toggleAllUsers = () => {
    if (allUsersSelected.value) {
        selectedUsers.value = [];
    } else {
        selectedUsers.value = props.users.data.map((user) => user.id);
    }
};

const clearSelection = () => {
    selectedUsers.value = [];
    showBulkActions.value = false;
};

const applyFilters = () => {
    router.get(route('admin.users.index'), filters.value, {
        preserveState: true,
        preserveScroll: true,
    });
};

const clearFilters = () => {
    filters.value = {
        search: '',
        role: '',
        verified: '',
        is_admin: '',
    };
    applyFilters();
};

const impersonateUser = (userId: number) => {
    if (confirm('Are you sure you want to impersonate this user?')) {
        router.post(route('admin.users.impersonate', userId));
    }
};

const toggleUserAdmin = (user: User) => {
    const action = user.is_admin ? 'remove admin privileges from' : 'grant admin privileges to';
    if (confirm(`Are you sure you want to ${action} ${user.name}?`)) {
        router.patch(route('admin.users.toggle-admin', user.id));
    }
};

const deleteUser = (userId: number) => {
    if (confirm('Are you sure you want to delete this user? This action cannot be undone.')) {
        router.delete(route('admin.users.destroy', userId));
    }
};

const bulkVerifyUsers = () => {
    if (confirm(`Are you sure you want to verify ${selectedUsers.value.length} user(s)?`)) {
        router.patch(
            route('admin.users.bulk-verify'),
            {
                user_ids: selectedUsers.value,
            },
            {
                onSuccess: () => clearSelection(),
            },
        );
    }
};

const bulkUnverifyUsers = () => {
    if (confirm(`Are you sure you want to unverify ${selectedUsers.value.length} user(s)?`)) {
        router.patch(
            route('admin.users.bulk-unverify'),
            {
                user_ids: selectedUsers.value,
            },
            {
                onSuccess: () => clearSelection(),
            },
        );
    }
};

const bulkDeleteUsers = () => {
    if (confirm(`Are you sure you want to delete ${selectedUsers.value.length} user(s)? This action cannot be undone.`)) {
        router.delete(route('admin.users.bulk-destroy'), {
            data: { user_ids: selectedUsers.value },
            onSuccess: () => clearSelection(),
        });
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

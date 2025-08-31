<template>
    <Head title="Admin Dashboard" />

    <AdminLayout>
        <div class="space-y-6">
            <!-- Header -->
            <div class="border-b border-border pb-4">
                <h1 class="text-3xl font-bold text-foreground">Admin Dashboard</h1>
                <p class="text-muted-foreground">Manage your biolink platform</p>
            </div>

            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
                <StatsCard
                    title="Total Users"
                    :value="statistics.total_users"
                    :trend="statistics.new_users_this_month"
                    trend-label="new this month"
                    icon="users"
                    color="blue"
                />
                <StatsCard
                    title="Total Links"
                    :value="statistics.total_links"
                    :trend="statistics.new_links_this_month"
                    trend-label="new this month"
                    icon="link"
                    color="green"
                />
                <StatsCard title="Total Portfolios" :value="statistics.total_portfolios" icon="portfolio" color="purple" />
                <StatsCard
                    title="Total Clicks"
                    :value="statistics.total_clicks"
                    :trend="statistics.clicks_this_month"
                    trend-label="this month"
                    icon="click"
                    color="orange"
                />
            </div>

            <!-- Charts Row -->
            <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
                <!-- Daily Analytics Chart -->
                <div class="rounded-lg border border-border bg-card p-6">
                    <h3 class="mb-4 text-lg font-semibold text-card-foreground">Daily Analytics (Last 30 Days)</h3>
                    <div class="h-64">
                        <canvas ref="analyticsChart"></canvas>
                    </div>
                </div>

                <!-- User Growth Chart -->
                <div class="rounded-lg border border-border bg-card p-6">
                    <h3 class="mb-4 text-lg font-semibold text-card-foreground">User Growth (Last 30 Days)</h3>
                    <div class="h-64">
                        <canvas ref="userGrowthChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Tables Row -->
            <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
                <!-- Recent Users -->
                <div class="rounded-lg border border-border bg-card p-6">
                    <div class="mb-4 flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-card-foreground">Recent Users</h3>
                        <Link :href="route('admin.users.index')" class="text-sm text-primary hover:text-primary/80"> View all </Link>
                    </div>
                    <div class="space-y-4">
                        <div v-for="user in recent_users" :key="user.id" class="flex items-center gap-3 rounded-lg bg-muted/50 p-3">
                            <div class="flex h-10 w-10 items-center justify-center rounded-full bg-primary/10">
                                <img v-if="user.avatar" :src="user.avatar" :alt="user.name" class="h-full w-full rounded-full object-cover" />
                                <span v-else class="font-medium text-primary">
                                    {{ user.name.charAt(0).toUpperCase() }}
                                </span>
                            </div>
                            <div class="min-w-0 flex-1">
                                <p class="truncate text-sm font-medium text-card-foreground">{{ user.name }}</p>
                                <p class="truncate text-sm text-muted-foreground">{{ user.email }}</p>
                            </div>
                            <div class="flex items-center gap-2">
                                <span
                                    v-if="user.is_admin"
                                    class="inline-flex items-center rounded-full bg-red-100 px-2 py-1 text-xs font-medium text-red-700"
                                >
                                    Admin
                                </span>
                                <span
                                    v-if="user.role === 'pro'"
                                    class="inline-flex items-center rounded-full bg-yellow-100 px-2 py-1 text-xs font-medium text-yellow-700"
                                >
                                    Pro
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Top Links -->
                <div class="rounded-lg border border-border bg-card p-6">
                    <div class="mb-4 flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-card-foreground">Top Performing Links</h3>
                        <Link :href="route('admin.links.index')" class="text-sm text-primary hover:text-primary/80"> View all </Link>
                    </div>
                    <div class="space-y-4">
                        <div v-for="link in top_links" :key="link.id" class="flex items-center justify-between rounded-lg bg-muted/50 p-3">
                            <div class="min-w-0 flex-1">
                                <p class="truncate text-sm font-medium text-card-foreground">{{ link.title }}</p>
                                <p class="truncate text-sm text-muted-foreground">{{ link.user.name }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-medium text-card-foreground">{{ formatNumber(link.analytics_sum_clicks || 0) }} clicks</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup lang="ts">
import StatsCard from '@/components/Admin/StatsCard.vue';
import AdminLayout from '@/layouts/AdminLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import Chart from 'chart.js/auto';
import { onMounted, ref } from 'vue';

interface Statistics {
    total_users: number;
    total_links: number;
    total_portfolios: number;
    total_clicks: number;
    new_users_this_month: number;
    new_links_this_month: number;
    clicks_this_month: number;
}

interface User {
    id: number;
    name: string;
    email: string;
    avatar?: string;
    is_admin: boolean;
    role: string;
}

interface TopLink {
    id: number;
    title: string;
    analytics_sum_clicks: number;
    user: {
        name: string;
    };
}

interface DailyAnalytic {
    date: string;
    total_clicks: number;
}

interface UserGrowth {
    date: string;
    total_users: number;
}

interface Props {
    statistics: Statistics;
    recent_users: User[];
    top_links: TopLink[];
    daily_analytics: DailyAnalytic[];
    user_growth: UserGrowth[];
}

const props = defineProps<Props>();

const analyticsChart = ref<HTMLCanvasElement>();
const userGrowthChart = ref<HTMLCanvasElement>();

const formatNumber = (num: number): string => {
    if (num >= 1000000) {
        return (num / 1000000).toFixed(1).replace(/\.0$/, '') + 'M';
    }
    if (num >= 1000) {
        return (num / 1000).toFixed(1).replace(/\.0$/, '') + 'K';
    }
    return num.toString();
};

onMounted(() => {
    // Create analytics chart
    if (analyticsChart.value) {
        new Chart(analyticsChart.value, {
            type: 'line',
            data: {
                labels: props.daily_analytics.map((item) => new Date(item.date).toLocaleDateString('en-US', { month: 'short', day: 'numeric' })),
                datasets: [
                    {
                        label: 'Clicks',
                        data: props.daily_analytics.map((item) => item.total_clicks),
                        borderColor: 'rgb(59, 130, 246)',
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        fill: true,
                        tension: 0.4,
                    },
                ],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false,
                    },
                },
                scales: {
                    y: {
                        beginAtZero: true,
                    },
                },
            },
        });
    }

    // Create user growth chart
    if (userGrowthChart.value) {
        new Chart(userGrowthChart.value, {
            type: 'bar',
            data: {
                labels: props.user_growth.map((item) => new Date(item.date).toLocaleDateString('en-US', { month: 'short', day: 'numeric' })),
                datasets: [
                    {
                        label: 'New Users',
                        data: props.user_growth.map((item) => item.total_users),
                        backgroundColor: 'rgba(34, 197, 94, 0.8)',
                        borderColor: 'rgb(34, 197, 94)',
                        borderWidth: 1,
                    },
                ],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false,
                    },
                },
                scales: {
                    y: {
                        beginAtZero: true,
                    },
                },
            },
        });
    }
});
</script>

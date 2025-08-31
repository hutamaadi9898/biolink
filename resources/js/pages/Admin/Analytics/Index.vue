<template>
    <Head title="Analytics - Admin" />

    <AdminLayout>
        <div class="space-y-6">
            <!-- Header -->
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-foreground">Analytics</h1>
                    <p class="text-muted-foreground">Platform analytics and insights</p>
                </div>
                <div class="flex items-center gap-3">
                    <button
                        @click="exportData('csv')"
                        class="inline-flex items-center gap-2 rounded-lg border border-border bg-card px-4 py-2 text-sm font-medium text-card-foreground transition-colors hover:bg-muted"
                    >
                        Export CSV
                    </button>
                    <button
                        @click="exportData('json')"
                        class="inline-flex items-center gap-2 rounded-lg border border-border bg-card px-4 py-2 text-sm font-medium text-card-foreground transition-colors hover:bg-muted"
                    >
                        Export JSON
                    </button>
                </div>
            </div>

            <!-- Date Range Filter -->
            <div class="rounded-lg border border-border bg-card p-6">
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                    <div>
                        <label class="text-sm font-medium text-card-foreground">From Date</label>
                        <input
                            v-model="filters.from_date"
                            type="date"
                            class="mt-1 block w-full rounded-md border border-border bg-background px-3 py-2 text-sm text-foreground focus:border-primary focus:ring-1 focus:ring-primary focus:outline-none"
                        />
                    </div>
                    <div>
                        <label class="text-sm font-medium text-card-foreground">To Date</label>
                        <input
                            v-model="filters.to_date"
                            type="date"
                            class="mt-1 block w-full rounded-md border border-border bg-background px-3 py-2 text-sm text-foreground focus:border-primary focus:ring-1 focus:ring-primary focus:outline-none"
                        />
                    </div>
                    <div class="flex items-end">
                        <button
                            @click="applyFilters"
                            class="w-full rounded-lg bg-primary px-4 py-2 text-sm font-medium text-primary-foreground transition-colors hover:bg-primary/90"
                        >
                            Apply Filters
                        </button>
                    </div>
                </div>
            </div>

            <!-- Overview Cards -->
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
                <div class="rounded-lg border border-border bg-card p-6">
                    <div class="flex items-center gap-4">
                        <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-blue-100 text-blue-600">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122"
                                />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-muted-foreground">Total Clicks</p>
                            <p class="text-2xl font-bold text-card-foreground">{{ formatNumber(overview.total_clicks) }}</p>
                        </div>
                    </div>
                </div>

                <div class="rounded-lg border border-border bg-card p-6">
                    <div class="flex items-center gap-4">
                        <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-green-100 text-green-600">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"
                                />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-muted-foreground">Unique Visitors</p>
                            <p class="text-2xl font-bold text-card-foreground">{{ formatNumber(overview.unique_visitors) }}</p>
                        </div>
                    </div>
                </div>

                <div class="rounded-lg border border-border bg-card p-6">
                    <div class="flex items-center gap-4">
                        <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-purple-100 text-purple-600">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"
                                />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-muted-foreground">Top Links</p>
                            <p class="text-2xl font-bold text-card-foreground">{{ overview.top_links_count }}</p>
                        </div>
                    </div>
                </div>

                <div class="rounded-lg border border-border bg-card p-6">
                    <div class="flex items-center gap-4">
                        <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-orange-100 text-orange-600">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"
                                />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-muted-foreground">Avg. Daily Clicks</p>
                            <p class="text-2xl font-bold text-card-foreground">{{ formatNumber(overview.average_daily_clicks) }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts -->
            <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
                <!-- Daily Analytics Chart -->
                <div class="rounded-lg border border-border bg-card p-6">
                    <h3 class="mb-4 text-lg font-semibold text-card-foreground">Daily Analytics</h3>
                    <div class="h-64">
                        <canvas ref="dailyChart"></canvas>
                    </div>
                </div>

                <!-- Top Performing Links -->
                <div class="rounded-lg border border-border bg-card p-6">
                    <h3 class="mb-4 text-lg font-semibold text-card-foreground">Top Performing Links</h3>
                    <div class="space-y-4">
                        <div v-for="link in top_links" :key="link.id" class="flex items-center justify-between rounded-lg bg-muted/50 p-3">
                            <div class="min-w-0 flex-1">
                                <p class="truncate text-sm font-medium text-card-foreground">{{ link.title }}</p>
                                <p class="truncate text-sm text-muted-foreground">{{ link.user_name }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-medium text-card-foreground">{{ formatNumber(link.total_clicks) }} clicks</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Browser & Device Stats -->
            <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
                <!-- Browser Statistics -->
                <div class="rounded-lg border border-border bg-card p-6">
                    <h3 class="mb-4 text-lg font-semibold text-card-foreground">Browser Statistics</h3>
                    <div class="space-y-3">
                        <div v-for="browser in browser_stats" :key="browser.browser" class="flex items-center justify-between">
                            <span class="text-sm text-card-foreground">{{ browser.browser || 'Unknown' }}</span>
                            <div class="flex items-center gap-2">
                                <div class="h-2 w-24 rounded-full bg-muted">
                                    <div class="h-2 rounded-full bg-primary" :style="{ width: browser.percentage + '%' }"></div>
                                </div>
                                <span class="w-12 text-right text-sm text-muted-foreground"> {{ browser.percentage.toFixed(1) }}% </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Device Statistics -->
                <div class="rounded-lg border border-border bg-card p-6">
                    <h3 class="mb-4 text-lg font-semibold text-card-foreground">Device Statistics</h3>
                    <div class="space-y-3">
                        <div v-for="device in device_stats" :key="device.device" class="flex items-center justify-between">
                            <span class="text-sm text-card-foreground">{{ device.device || 'Unknown' }}</span>
                            <div class="flex items-center gap-2">
                                <div class="h-2 w-24 rounded-full bg-muted">
                                    <div class="h-2 rounded-full bg-green-500" :style="{ width: device.percentage + '%' }"></div>
                                </div>
                                <span class="w-12 text-right text-sm text-muted-foreground"> {{ device.percentage.toFixed(1) }}% </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup lang="ts">
import AdminLayout from '@/layouts/AdminLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import Chart from 'chart.js/auto';
import { onMounted, ref } from 'vue';

interface AnalyticsOverview {
    total_clicks: number;
    unique_visitors: number;
    top_links_count: number;
    average_daily_clicks: number;
}

interface TopLink {
    id: number;
    title: string;
    user_name: string;
    total_clicks: number;
}

interface DailyAnalytic {
    date: string;
    total_clicks: number;
}

interface BrowserStat {
    browser: string;
    total_clicks: number;
    percentage: number;
}

interface DeviceStat {
    device: string;
    total_clicks: number;
    percentage: number;
}

interface Props {
    overview: AnalyticsOverview;
    top_links: TopLink[];
    daily_analytics: DailyAnalytic[];
    browser_stats: BrowserStat[];
    device_stats: DeviceStat[];
    filters: {
        from_date: string;
        to_date: string;
    };
}

const props = defineProps<Props>();

const dailyChart = ref<HTMLCanvasElement>();
const filters = ref({ ...props.filters });

const formatNumber = (num: number): string => {
    if (num >= 1000000) {
        return (num / 1000000).toFixed(1).replace(/\.0$/, '') + 'M';
    }
    if (num >= 1000) {
        return (num / 1000).toFixed(1).replace(/\.0$/, '') + 'K';
    }
    return num.toLocaleString();
};

const applyFilters = () => {
    router.get(route('admin.analytics.index'), filters.value, {
        preserveState: true,
        preserveScroll: true,
    });
};

const exportData = (format: 'csv' | 'json') => {
    router.get(route('admin.analytics.export'), {
        ...filters.value,
        format,
    });
};

onMounted(() => {
    // Create daily analytics chart
    if (dailyChart.value) {
        new Chart(dailyChart.value, {
            type: 'line',
            data: {
                labels: props.daily_analytics.map((item) => new Date(item.date).toLocaleDateString('en-US', { month: 'short', day: 'numeric' })),
                datasets: [
                    {
                        label: 'Daily Clicks',
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
});
</script>

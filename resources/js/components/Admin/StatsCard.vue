<template>
    <div class="rounded-lg border border-border bg-card p-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <!-- Icon -->
                <div :class="['flex h-12 w-12 items-center justify-center rounded-lg', iconColorClasses]">
                    <component :is="iconComponent" class="h-6 w-6" />
                </div>

                <!-- Content -->
                <div>
                    <p class="text-sm font-medium text-muted-foreground">{{ title }}</p>
                    <p class="text-2xl font-bold text-card-foreground">{{ formattedValue }}</p>
                    <p v-if="trend !== undefined" class="text-sm text-muted-foreground">
                        <span :class="trendColorClass">{{ formattedTrend }}</span>
                        {{ trendLabel }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { computed } from 'vue';

interface Props {
    title: string;
    value: number;
    trend?: number;
    trendLabel?: string;
    icon: string;
    color: 'blue' | 'green' | 'purple' | 'orange' | 'red';
}

const props = defineProps<Props>();

const formatNumber = (num: number): string => {
    if (num >= 1000000) {
        return (num / 1000000).toFixed(1).replace(/\.0$/, '') + 'M';
    }
    if (num >= 1000) {
        return (num / 1000).toFixed(1).replace(/\.0$/, '') + 'K';
    }
    return num.toLocaleString();
};

const formattedValue = computed(() => formatNumber(props.value));

const formattedTrend = computed(() => {
    if (props.trend === undefined) return '';
    const sign = props.trend > 0 ? '+' : '';
    return `${sign}${formatNumber(props.trend)}`;
});

const trendColorClass = computed(() => {
    if (props.trend === undefined) return '';
    return props.trend > 0 ? 'text-green-600' : props.trend < 0 ? 'text-red-600' : 'text-muted-foreground';
});

const iconColorClasses = computed(() => {
    const colorMap = {
        blue: 'bg-blue-100 text-blue-600',
        green: 'bg-green-100 text-green-600',
        purple: 'bg-purple-100 text-purple-600',
        orange: 'bg-orange-100 text-orange-600',
        red: 'bg-red-100 text-red-600',
    };
    return colorMap[props.color];
});

const iconComponent = computed(() => {
    const iconMap = {
        users: UsersIcon,
        link: LinkIcon,
        portfolio: PortfolioIcon,
        click: ClickIcon,
    };
    return iconMap[props.icon as keyof typeof iconMap] || UsersIcon;
});

// Icon Components
const UsersIcon = {
    template: `
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a4 4 0 11-8 0 4 4 0 018 0z" />
        </svg>
    `,
};

const LinkIcon = {
    template: `
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
        </svg>
    `,
};

const PortfolioIcon = {
    template: `
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
        </svg>
    `,
};

const ClickIcon = {
    template: `
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122" />
        </svg>
    `,
};
</script>

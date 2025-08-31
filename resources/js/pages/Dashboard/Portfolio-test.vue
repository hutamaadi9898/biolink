<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <Head title="Portfolio" />
        <div class="test">
            <h1>Test Portfolio Page</h1>
        </div>
    </AppLayout>
</template>

<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import type { BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';

defineProps<{
    portfolios: any[];
}>();

const breadcrumbs: BreadcrumbItem[] = [
    { label: 'Dashboard', href: '/dashboard' },
    { label: 'Portfolio', href: '/dashboard/portfolio' },
];
</script>

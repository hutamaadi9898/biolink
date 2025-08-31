<script setup lang="ts">
import { SidebarGroup, SidebarGroupLabel, SidebarMenu, SidebarMenuButton, SidebarMenuItem } from '@/components/ui/sidebar';
import { type NavItem } from '@/types';
import { Link, usePage } from '@inertiajs/vue3';

defineProps<{
    items: NavItem[];
}>();

const page = usePage();
</script>

<template>
    <SidebarGroup class="px-2 py-0">
        <SidebarGroupLabel class="text-xs font-medium tracking-wider text-muted-foreground uppercase">Menu</SidebarGroupLabel>
        <SidebarMenu>
            <SidebarMenuItem v-for="item in items" :key="item.title">
                <SidebarMenuButton
                    as-child
                    :is-active="item.href === page.url || page.url.startsWith(item.href)"
                    :tooltip="item.title"
                    class="transition-all duration-200 hover:bg-accent/50"
                >
                    <Link :href="item.href" class="flex items-center gap-3 rounded-lg px-3 py-2">
                        <component :is="item.icon" class="h-4 w-4" />
                        <span class="font-medium">{{ item.title }}</span>
                    </Link>
                </SidebarMenuButton>
            </SidebarMenuItem>
        </SidebarMenu>
    </SidebarGroup>
</template>

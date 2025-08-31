<script setup lang="ts">
import { SidebarGroup, SidebarGroupContent, SidebarMenu, SidebarMenuButton, SidebarMenuItem } from '@/components/ui/sidebar';
import { usePage } from '@inertiajs/vue3';

interface Props {
    class?: string;
}

defineProps<Props>();

const page = usePage();
const user = page.props.auth?.user;
</script>

<template>
    <SidebarGroup :class="`group-data-[collapsible=icon]:p-0 ${$props.class || ''}`">
        <SidebarGroupContent>
            <SidebarMenu v-if="user?.slug">
                <SidebarMenuItem>
                    <SidebarMenuButton class="text-muted-foreground transition-colors hover:text-foreground" as-child>
                        <a :href="`/${user.slug}`" target="_blank" rel="noopener noreferrer" class="flex items-center gap-3">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"
                                />
                            </svg>
                            <span class="text-sm">View Your Biolink</span>
                        </a>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarGroupContent>
    </SidebarGroup>
</template>

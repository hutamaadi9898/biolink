<template>
    <div class="min-h-screen bg-background">
        <!-- Header -->
        <header class="border-b border-border bg-card">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex h-16 items-center justify-between">
                    <!-- Logo and Navigation -->
                    <div class="flex items-center gap-8">
                        <Link :href="route('admin.dashboard')" class="flex items-center gap-2">
                            <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-primary">
                                <span class="text-sm font-bold text-primary-foreground">B</span>
                            </div>
                            <span class="text-lg font-semibold text-foreground">BioLink Admin</span>
                        </Link>

                        <nav class="hidden items-center gap-6 md:flex">
                            <Link
                                :href="route('admin.dashboard')"
                                :class="[
                                    'text-sm font-medium transition-colors',
                                    route().current('admin.dashboard') ? 'text-primary' : 'text-muted-foreground hover:text-foreground',
                                ]"
                            >
                                Dashboard
                            </Link>
                            <Link
                                :href="route('admin.users.index')"
                                :class="[
                                    'text-sm font-medium transition-colors',
                                    route().current('admin.users.*') ? 'text-primary' : 'text-muted-foreground hover:text-foreground',
                                ]"
                            >
                                Users
                            </Link>
                            <Link
                                :href="route('admin.links.index')"
                                :class="[
                                    'text-sm font-medium transition-colors',
                                    route().current('admin.links.*') ? 'text-primary' : 'text-muted-foreground hover:text-foreground',
                                ]"
                            >
                                Links
                            </Link>
                            <Link
                                :href="route('admin.analytics.index')"
                                :class="[
                                    'text-sm font-medium transition-colors',
                                    route().current('admin.analytics.*') ? 'text-primary' : 'text-muted-foreground hover:text-foreground',
                                ]"
                            >
                                Analytics
                            </Link>
                        </nav>
                    </div>

                    <!-- User Menu -->
                    <div class="flex items-center gap-4">
                        <!-- Back to Site -->
                        <Link :href="route('dashboard')" class="text-sm text-muted-foreground transition-colors hover:text-foreground">
                            ← Back to Site
                        </Link>

                        <!-- User Dropdown -->
                        <div class="relative" v-click-outside="closeUserMenu">
                            <button @click="toggleUserMenu" class="flex items-center gap-2 rounded-lg p-2 transition-colors hover:bg-muted">
                                <div class="flex h-8 w-8 items-center justify-center rounded-full bg-primary/10">
                                    <img v-if="user.avatar" :src="user.avatar" :alt="user.name" class="h-full w-full rounded-full object-cover" />
                                    <span v-else class="text-sm font-medium text-primary">
                                        {{ user.name.charAt(0).toUpperCase() }}
                                    </span>
                                </div>
                                <span class="text-sm font-medium text-foreground">{{ user.name }}</span>
                                <svg class="h-4 w-4 text-muted-foreground" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>

                            <Transition
                                enter-active-class="transition ease-out duration-200"
                                enter-from-class="transform opacity-0 scale-95"
                                enter-to-class="transform opacity-100 scale-100"
                                leave-active-class="transition ease-in duration-75"
                                leave-from-class="transform opacity-100 scale-100"
                                leave-to-class="transform opacity-0 scale-95"
                            >
                                <div v-show="showUserMenu" class="absolute right-0 z-50 mt-2 w-48 rounded-lg border border-border bg-card shadow-lg">
                                    <div class="p-2">
                                        <Link
                                            :href="route('profile.edit')"
                                            class="flex w-full items-center gap-2 rounded-md px-3 py-2 text-sm text-card-foreground transition-colors hover:bg-muted"
                                        >
                                            Profile Settings
                                        </Link>
                                        <Link
                                            :href="route('logout')"
                                            method="post"
                                            as="button"
                                            class="flex w-full items-center gap-2 rounded-md px-3 py-2 text-sm text-destructive transition-colors hover:bg-destructive/10"
                                        >
                                            Sign Out
                                        </Link>
                                    </div>
                                </div>
                            </Transition>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Mobile Navigation -->
        <div v-if="showMobileMenu" class="border-b border-border bg-card md:hidden">
            <div class="space-y-1 px-4 py-2">
                <Link
                    :href="route('admin.dashboard')"
                    :class="[
                        'block rounded-md px-3 py-2 text-sm font-medium transition-colors',
                        route().current('admin.dashboard')
                            ? 'bg-primary text-primary-foreground'
                            : 'text-muted-foreground hover:bg-muted hover:text-foreground',
                    ]"
                >
                    Dashboard
                </Link>
                <Link
                    :href="route('admin.users.index')"
                    :class="[
                        'block rounded-md px-3 py-2 text-sm font-medium transition-colors',
                        route().current('admin.users.*')
                            ? 'bg-primary text-primary-foreground'
                            : 'text-muted-foreground hover:bg-muted hover:text-foreground',
                    ]"
                >
                    Users
                </Link>
                <Link
                    :href="route('admin.links.index')"
                    :class="[
                        'block rounded-md px-3 py-2 text-sm font-medium transition-colors',
                        route().current('admin.links.*')
                            ? 'bg-primary text-primary-foreground'
                            : 'text-muted-foreground hover:bg-muted hover:text-foreground',
                    ]"
                >
                    Links
                </Link>
                <Link
                    :href="route('admin.analytics.index')"
                    :class="[
                        'block rounded-md px-3 py-2 text-sm font-medium transition-colors',
                        route().current('admin.analytics.*')
                            ? 'bg-primary text-primary-foreground'
                            : 'text-muted-foreground hover:bg-muted hover:text-foreground',
                    ]"
                >
                    Analytics
                </Link>
            </div>
        </div>

        <!-- Main Content -->
        <main class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
            <slot />
        </main>
    </div>
</template>

<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { ref } from 'vue';
import { route } from 'ziggy-js';

interface User {
    id: number;
    name: string;
    email: string;
    avatar?: string;
}

interface Props {
    user: User;
}

defineProps<Props>();

const showUserMenu = ref(false);
const showMobileMenu = ref(false);

const toggleUserMenu = () => {
    showUserMenu.value = !showUserMenu.value;
};

const closeUserMenu = () => {
    showUserMenu.value = false;
};

// const toggleMobileMenu = () => {
//     showMobileMenu.value = !showMobileMenu.value;
// };

// Click outside directive
const vClickOutside = {
    mounted(el: HTMLElement, binding: any) {
        el.clickOutsideEvent = (event: Event) => {
            if (!(el === event.target || el.contains(event.target as Node))) {
                binding.value();
            }
        };
        document.addEventListener('click', el.clickOutsideEvent);
    },
    unmounted(el: HTMLElement) {
        document.removeEventListener('click', el.clickOutsideEvent);
    },
};
</script>

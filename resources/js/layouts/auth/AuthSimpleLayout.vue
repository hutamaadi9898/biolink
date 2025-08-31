<script setup lang="ts">
import AppLogoIcon from '@/components/AppLogoIcon.vue';
import { home } from '@/routes';
import { Link } from '@inertiajs/vue3';
import { onMounted, ref } from 'vue';

defineProps<{
    title?: string;
    description?: string;
}>();

const isLoaded = ref(false);

onMounted(() => {
    setTimeout(() => {
        isLoaded.value = true;
    }, 100);
});
</script>

<template>
    <div class="min-h-svh overflow-hidden bg-gradient-to-br from-background via-background to-muted/20">
        <!-- Animated Background -->
        <div class="absolute inset-0">
            <!-- Floating orbs for visual interest -->
            <div class="absolute -top-40 -left-40 h-80 w-80 animate-pulse rounded-full bg-primary/5 blur-3xl"></div>
            <div class="absolute top-1/2 -right-40 h-60 w-60 animate-pulse rounded-full bg-purple-500/5 blur-3xl delay-1000"></div>
            <div class="absolute bottom-0 left-1/4 h-40 w-40 animate-pulse rounded-full bg-blue-500/5 blur-3xl delay-500"></div>

            <!-- Subtle grid pattern -->
            <div
                class="absolute inset-0 bg-[radial-gradient(circle_at_1px_1px,rgba(0,0,0,.15)_1px,transparent_0)] [background-size:24px_24px] opacity-[0.02] dark:bg-[radial-gradient(circle_at_1px_1px,rgba(255,255,255,.15)_1px,transparent_0)]"
            ></div>
        </div>

        <!-- Content -->
        <div class="relative flex min-h-svh">
            <!-- Left Side - Branding/Info (Desktop) -->
            <div class="hidden w-1/2 flex-col justify-between p-8 lg:flex xl:p-12" :class="{ 'animate-slideInLeft': isLoaded }">
                <!-- Logo & Nav -->
                <div class="space-y-8">
                    <Link :href="home()" class="group flex items-center gap-3 font-medium transition-transform hover:scale-105">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-primary/10 transition-colors group-hover:bg-primary/20">
                            <AppLogoIcon class="size-6 fill-current text-primary" />
                        </div>
                        <span class="text-xl font-bold text-foreground">BiolinkID</span>
                    </Link>
                </div>

                <!-- Main Content -->
                <div class="max-w-lg space-y-8">
                    <div class="space-y-4">
                        <h2 class="text-4xl leading-tight font-bold text-foreground">
                            Biolink Platform
                            <span class="bg-gradient-to-r from-primary to-purple-600 bg-clip-text text-transparent"> Terdepan </span>
                        </h2>
                        <p class="text-xl leading-relaxed text-muted-foreground">
                            Buat landing page profesional yang menggabungkan portfolio, social media, dan bisnis dalam satu link yang powerful.
                        </p>
                    </div>

                    <!-- Animated Feature List -->
                    <div class="space-y-4">
                        <div
                            v-for="(feature, index) in [
                                { text: 'Mobile-First Design', icon: 'M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z' },
                                {
                                    text: 'Real-time Analytics',
                                    icon: 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z',
                                },
                                { text: 'Lightning Fast', icon: 'M13 10V3L4 14h7v7l9-11h-7z' },
                            ]"
                            :key="index"
                            class="group flex items-center gap-4 transition-all duration-500 hover:translate-x-2"
                            :style="{ animationDelay: `${index * 200}ms` }"
                            :class="{ 'animate-slideInLeft': isLoaded }"
                        >
                            <div
                                class="flex h-10 w-10 items-center justify-center rounded-xl bg-primary/10 transition-all duration-300 group-hover:scale-110 group-hover:bg-primary/20"
                            >
                                <svg class="h-5 w-5 text-primary" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" :d="feature.icon" />
                                </svg>
                            </div>
                            <span class="font-medium text-foreground transition-colors group-hover:text-primary">{{ feature.text }}</span>
                        </div>
                    </div>

                    <!-- Social Proof -->
                    <div class="rounded-2xl border border-border/50 bg-card/50 p-6 backdrop-blur-sm">
                        <div class="mb-3 flex items-center gap-3">
                            <div class="flex -space-x-2">
                                <div class="h-8 w-8 rounded-full border-2 border-background bg-gradient-to-br from-blue-400 to-blue-600"></div>
                                <div class="h-8 w-8 rounded-full border-2 border-background bg-gradient-to-br from-green-400 to-green-600"></div>
                                <div class="h-8 w-8 rounded-full border-2 border-background bg-gradient-to-br from-purple-400 to-purple-600"></div>
                            </div>
                            <div class="text-sm text-muted-foreground">1000+ users sudah bergabung</div>
                        </div>
                        <div class="text-sm text-muted-foreground">"Platform terbaik untuk membangun personal brand di era digital"</div>
                    </div>
                </div>

                <!-- Demo Preview -->
                <div class="grid grid-cols-2 gap-4">
                    <div
                        class="group relative aspect-[4/3] overflow-hidden rounded-2xl border border-border/50 bg-gradient-to-br from-card to-muted/50 transition-all duration-500 hover:scale-105 hover:shadow-xl"
                        :class="{ 'animate-slideInUp': isLoaded }"
                        style="animation-delay: 400ms"
                    >
                        <div
                            class="absolute inset-0 bg-gradient-to-br from-primary/20 to-purple-500/20 opacity-0 transition-opacity duration-300 group-hover:opacity-100"
                        ></div>
                        <div class="relative flex h-full flex-col items-center justify-center p-4 text-center">
                            <div class="mb-2 h-8 w-8 rounded-lg bg-primary/20"></div>
                            <div class="text-xs text-muted-foreground">Portfolio</div>
                        </div>
                    </div>
                    <div
                        class="group relative aspect-[4/3] overflow-hidden rounded-2xl border border-border/50 bg-gradient-to-br from-card to-muted/50 transition-all duration-500 hover:scale-105 hover:shadow-xl"
                        :class="{ 'animate-slideInUp': isLoaded }"
                        style="animation-delay: 600ms"
                    >
                        <div
                            class="absolute inset-0 bg-gradient-to-br from-green-500/20 to-blue-500/20 opacity-0 transition-opacity duration-300 group-hover:opacity-100"
                        ></div>
                        <div class="relative flex h-full flex-col items-center justify-center p-4 text-center">
                            <div class="mb-2 h-8 w-8 rounded-lg bg-green-500/20"></div>
                            <div class="text-xs text-muted-foreground">Analytics</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Side - Form -->
            <div class="flex w-full flex-col items-center justify-center p-4 sm:p-6 lg:w-1/2 lg:p-8">
                <div class="w-full max-w-md lg:max-w-lg">
                    <div class="flex flex-col gap-6 lg:gap-8">
                        <!-- Mobile Logo & Header -->
                        <div class="flex flex-col items-center gap-6 lg:hidden" :class="{ 'animate-slideInDown': isLoaded }">
                            <Link :href="home()" class="group flex flex-col items-center gap-3">
                                <div
                                    class="flex h-16 w-16 items-center justify-center rounded-2xl border border-border/50 bg-gradient-to-br from-primary/10 to-purple-500/10 transition-all duration-300 group-hover:scale-110 group-hover:from-primary/20 group-hover:to-purple-500/20"
                                >
                                    <AppLogoIcon class="size-8 fill-current text-primary" />
                                </div>
                                <span class="text-2xl font-bold text-foreground">BiolinkID</span>
                            </Link>

                            <!-- Mobile tagline -->
                            <div class="space-y-2 text-center">
                                <h3 class="text-lg font-semibold text-foreground">Biolink Platform Terdepan</h3>
                                <p class="max-w-xs text-sm text-muted-foreground">
                                    Bergabung dengan 1000+ users yang sudah membangun personal brand digital
                                </p>
                            </div>
                        </div>

                        <!-- Form Header -->
                        <div class="space-y-3 text-center lg:text-left" :class="{ 'animate-slideInRight': isLoaded }" style="animation-delay: 200ms">
                            <h1 class="text-3xl font-bold text-foreground lg:text-4xl">{{ title }}</h1>
                            <p class="text-base leading-relaxed text-muted-foreground lg:text-lg">{{ description }}</p>
                        </div>

                        <!-- Form Container with Enhanced Design -->
                        <div
                            class="rounded-2xl border border-border/50 bg-card/80 p-6 shadow-lg backdrop-blur-sm transition-all duration-300 hover:border-border hover:shadow-xl lg:p-8"
                            :class="{ 'animate-slideInUp': isLoaded }"
                            style="animation-delay: 400ms"
                        >
                            <slot />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
@keyframes slideInLeft {
    from {
        opacity: 0;
        transform: translateX(-20px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

@keyframes slideInRight {
    from {
        opacity: 0;
        transform: translateX(20px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

@keyframes slideInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes slideInDown {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-slideInLeft {
    animation: slideInLeft 0.8s ease-out forwards;
}

.animate-slideInRight {
    animation: slideInRight 0.8s ease-out forwards;
}

.animate-slideInUp {
    animation: slideInUp 0.8s ease-out forwards;
}

.animate-slideInDown {
    animation: slideInDown 0.8s ease-out forwards;
}
</style>

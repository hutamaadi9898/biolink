<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <Head title="Dashboard" />

        <div class="animate-fadeIn flex h-full flex-1 flex-col gap-4 p-3 sm:gap-6 sm:p-4 lg:p-6">
            <!-- Welcome Header - Mobile Optimized -->
            <div class="animate-slideDown">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                    <div class="flex items-center gap-4">
                        <!-- Profile Avatar -->
                        <div class="relative">
                            <div
                                class="flex h-12 w-12 items-center justify-center rounded-2xl bg-gradient-to-br from-primary to-purple-600 text-lg font-bold text-white shadow-lg transition-all duration-300 hover:scale-110 hover:shadow-xl sm:h-14 sm:w-14 sm:text-xl"
                            >
                                {{ getInitials(user.name) }}
                            </div>
                            <div v-if="isPro" class="absolute -top-1 -right-1">
                                <div
                                    class="flex h-5 w-5 items-center justify-center rounded-full bg-gradient-to-r from-amber-400 to-orange-500 text-xs font-bold text-white"
                                >
                                    ✦
                                </div>
                            </div>
                        </div>

                        <div>
                            <h1 class="text-xl font-bold text-foreground sm:text-2xl lg:text-3xl">Halo, {{ user.name.split(' ')[0] }}! 👋</h1>
                            <p class="text-sm text-muted-foreground sm:text-base">Selamat datang kembali di dashboard Anda</p>
                        </div>
                    </div>

                    <!-- Quick Actions - Mobile First -->
                    <div class="flex flex-col items-stretch gap-3 sm:flex-row sm:items-center">
                        <a
                            :href="profileUrl"
                            target="_blank"
                            class="group flex items-center justify-center gap-2 rounded-xl border border-border/50 bg-card/80 px-4 py-3 text-sm font-medium text-card-foreground backdrop-blur-sm transition-all duration-300 hover:scale-105 hover:border-primary/30 hover:bg-primary/5 hover:shadow-lg sm:justify-start"
                        >
                            <svg
                                class="h-4 w-4 transition-transform group-hover:scale-110"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.5"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M13.5 6H5.25A2.25 2.25 0 0 0 3 8.25v10.5A2.25 2.25 0 0 0 5.25 21h10.5A2.25 2.25 0 0 0 18 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"
                                />
                            </svg>
                            <span>Lihat Biolink</span>
                        </a>

                        <span
                            v-if="isPro"
                            class="flex items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-amber-400 to-orange-500 px-4 py-3 text-sm font-bold text-white shadow-lg"
                        >
                            <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
                            </svg>
                            PRO USER
                        </span>
                    </div>
                </div>
            </div>

            <!-- Enhanced Stats Cards - Bento Grid Layout -->
            <div class="grid grid-cols-2 gap-3 sm:gap-4 lg:grid-cols-5">
                <!-- Primary Stats - Featured Cards -->
                <div
                    class="col-span-2 rounded-2xl border border-border/50 bg-gradient-to-br from-card/80 to-muted/20 p-4 backdrop-blur-sm transition-all duration-300 hover:scale-[1.02] hover:shadow-lg sm:p-6 lg:col-span-2"
                >
                    <div class="mb-4 flex items-center justify-between">
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-primary/10">
                            <svg class="h-6 w-6 text-primary" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M13.19 8.688a4.5 4.5 0 0 1 1.242 7.244l-4.5 4.5a4.5 4.5 0 0 1-6.364-6.364l1.757-1.757m13.35-.622 1.757-1.757a4.5 4.5 0 0 0-6.364-6.364l-4.5 4.5a4.5 4.5 0 0 0 1.242 7.244"
                                />
                            </svg>
                        </div>
                        <div class="text-right">
                            <p class="text-2xl font-bold text-card-foreground sm:text-3xl">{{ stats.total_links }}</p>
                            <p class="text-xs text-muted-foreground sm:text-sm">Total Links</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 text-xs text-muted-foreground">
                        <div class="flex h-6 w-6 items-center justify-center rounded-full bg-green-500/10">
                            <span class="font-bold text-green-600">{{ stats.active_links }}</span>
                        </div>
                        <span>aktif dari {{ stats.total_links }} total</span>
                    </div>
                </div>

                <!-- View Stats -->
                <div
                    class="rounded-2xl border border-border/50 bg-gradient-to-br from-green-50/50 to-emerald-50/50 p-4 backdrop-blur-sm transition-all duration-300 hover:scale-[1.02] hover:shadow-lg sm:p-6 dark:from-green-950/20 dark:to-emerald-950/20"
                >
                    <div class="mb-2 flex items-center gap-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-green-500/10">
                            <svg class="h-5 w-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z"
                                />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-lg font-bold text-card-foreground sm:text-xl">{{ stats.profile_views }}</p>
                            <p class="text-xs text-muted-foreground">Views</p>
                        </div>
                    </div>
                </div>

                <!-- Click Stats -->
                <div
                    class="rounded-2xl border border-border/50 bg-gradient-to-br from-purple-50/50 to-violet-50/50 p-4 backdrop-blur-sm transition-all duration-300 hover:scale-[1.02] hover:shadow-lg sm:p-6 dark:from-purple-950/20 dark:to-violet-950/20"
                >
                    <div class="mb-2 flex items-center gap-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-purple-500/10">
                            <svg class="h-5 w-5 text-purple-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M15.042 21.672 13.684 16.6m0 0-2.51 2.225.569-9.47 5.227 7.917-3.286-.672ZM12 2.25V4.5m5.834.166-1.591 1.591M20.25 10.5H18M7.757 14.743l-1.59 1.59M6 10.5H3.75m4.007-4.243-1.59-1.59"
                                />
                            </svg>
                        </div>
                        <div>
                            <p class="text-lg font-bold text-card-foreground sm:text-xl">{{ stats.total_clicks }}</p>
                            <p class="text-xs text-muted-foreground">Clicks</p>
                        </div>
                    </div>
                </div>

                <!-- Portfolio Stats -->
                <div
                    class="rounded-2xl border border-border/50 bg-gradient-to-br from-orange-50/50 to-amber-50/50 p-4 backdrop-blur-sm transition-all duration-300 hover:scale-[1.02] hover:shadow-lg sm:p-6 dark:from-orange-950/20 dark:to-amber-950/20"
                >
                    <div class="mb-2 flex items-center gap-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-orange-500/10">
                            <svg class="h-5 w-5 text-orange-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M2.25 7.125C2.25 6.504 2.754 6 3.375 6h6c.621 0 1.125.504 1.125 1.125v3.75c0 .621-.504 1.125-1.125 1.125h-6a1.125 1.125 0 0 1-1.125-1.125v-3.75ZM14.25 8.625c0-.621.504-1.125 1.125-1.125h5.25c.621 0 1.125.504 1.125 1.125v8.25c0 .621-.504 1.125-1.125 1.125h-5.25a1.125 1.125 0 0 1-1.125-1.125v-8.25ZM3.75 16.125c0-.621.504-1.125 1.125-1.125h5.25c.621 0 1.125.504 1.125 1.125v2.25c0 .621-.504 1.125-1.125 1.125h-5.25A1.125 1.125 0 0 1 2.25 18.375v-2.25Z"
                                />
                            </svg>
                        </div>
                        <div>
                            <p class="text-lg font-bold text-card-foreground sm:text-xl">{{ stats.total_portfolios }}</p>
                            <p class="text-xs text-muted-foreground">Portfolio</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions - Enhanced Bento Grid -->
            <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 sm:gap-4 lg:grid-cols-4">
                <Link
                    href="/dashboard/links"
                    class="group rounded-2xl border border-border/50 bg-gradient-to-br from-card/80 to-primary/5 p-4 backdrop-blur-sm transition-all duration-300 hover:scale-[1.02] hover:border-primary/30 hover:from-primary/5 hover:to-primary/10 hover:shadow-xl sm:p-6"
                >
                    <div class="mb-3 flex items-center gap-4">
                        <div
                            class="flex h-12 w-12 items-center justify-center rounded-xl bg-primary/10 transition-all duration-300 group-hover:scale-110 group-hover:bg-primary/20"
                        >
                            <svg class="h-6 w-6 text-primary" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M13.19 8.688a4.5 4.5 0 0 1 1.242 7.244l-4.5 4.5a4.5 4.5 0 0 1-6.364-6.364l1.757-1.757m13.35-.622 1.757-1.757a4.5 4.5 0 0 0-6.364-6.364l-4.5 4.5a4.5 4.5 0 0 0 1.242 7.244"
                                />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h3 class="font-semibold text-card-foreground transition-colors group-hover:text-primary">Kelola Links</h3>
                            <p class="text-xs text-muted-foreground sm:text-sm">Tambah dan edit link</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 text-xs text-muted-foreground">
                        <span class="rounded-full bg-primary/10 px-2 py-1">{{ stats.total_links }} links</span>
                        <svg
                            class="h-3 w-3 opacity-60 transition-transform group-hover:translate-x-1"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="2"
                            stroke="currentColor"
                        >
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                        </svg>
                    </div>
                </Link>

                <Link
                    href="/dashboard/portfolio"
                    class="group rounded-2xl border border-border/50 bg-gradient-to-br from-card/80 to-green-500/5 p-4 backdrop-blur-sm transition-all duration-300 hover:scale-[1.02] hover:border-green-500/30 hover:from-green-500/5 hover:to-green-500/10 hover:shadow-xl sm:p-6"
                >
                    <div class="mb-3 flex items-center gap-4">
                        <div
                            class="flex h-12 w-12 items-center justify-center rounded-xl bg-green-500/10 transition-all duration-300 group-hover:scale-110 group-hover:bg-green-500/20"
                        >
                            <svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M2.25 7.125C2.25 6.504 2.754 6 3.375 6h6c.621 0 1.125.504 1.125 1.125v3.75c0 .621-.504 1.125-1.125 1.125h-6a1.125 1.125 0 0 1-1.125-1.125v-3.75ZM14.25 8.625c0-.621.504-1.125 1.125-1.125h5.25c.621 0 1.125.504 1.125 1.125v8.25c0 .621-.504 1.125-1.125 1.125h-5.25a1.125 1.125 0 0 1-1.125-1.125v-8.25ZM3.75 16.125c0-.621.504-1.125 1.125-1.125h5.25c.621 0 1.125.504 1.125 1.125v2.25c0 .621-.504 1.125-1.125 1.125h-5.25A1.125 1.125 0 0 1 2.25 18.375v-2.25Z"
                                />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h3 class="font-semibold text-card-foreground transition-colors group-hover:text-green-600">Portfolio</h3>
                            <p class="text-xs text-muted-foreground sm:text-sm">Showcase karya</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 text-xs text-muted-foreground">
                        <span class="rounded-full bg-green-500/10 px-2 py-1">{{ stats.total_portfolios }} items</span>
                        <svg
                            class="h-3 w-3 opacity-60 transition-transform group-hover:translate-x-1"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="2"
                            stroke="currentColor"
                        >
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                        </svg>
                    </div>
                </Link>

                <Link
                    href="/dashboard/themes"
                    class="group rounded-2xl border border-border/50 bg-gradient-to-br from-card/80 to-purple-500/5 p-4 backdrop-blur-sm transition-all duration-300 hover:scale-[1.02] hover:border-purple-500/30 hover:from-purple-500/5 hover:to-purple-500/10 hover:shadow-xl sm:p-6"
                >
                    <div class="mb-3 flex items-center gap-4">
                        <div
                            class="flex h-12 w-12 items-center justify-center rounded-xl bg-purple-500/10 transition-all duration-300 group-hover:scale-110 group-hover:bg-purple-500/20"
                        >
                            <svg class="h-6 w-6 text-purple-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M9.53 16.122a3 3 0 0 0-5.78 1.128 2.25 2.25 0 0 1-2.4 0 3 3 0 0 0-5.78-1.128 2.25 2.25 0 0 1 0-2.25 3 3 0 0 0 5.78-1.128 2.25 2.25 0 0 1 2.4 0 3 3 0 0 0 5.78 1.128 2.25 2.25 0 0 1 0 2.25Z"
                                />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h3 class="font-semibold text-card-foreground transition-colors group-hover:text-purple-600">Tema</h3>
                            <p class="text-xs text-muted-foreground sm:text-sm">Ubah tampilan</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 text-xs text-muted-foreground">
                        <span class="rounded-full bg-purple-500/10 px-2 py-1">Customize</span>
                        <svg
                            class="h-3 w-3 opacity-60 transition-transform group-hover:translate-x-1"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="2"
                            stroke="currentColor"
                        >
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                        </svg>
                    </div>
                </Link>

                <Link
                    href="/dashboard/analytics"
                    class="group rounded-2xl border border-border/50 bg-gradient-to-br from-card/80 to-orange-500/5 p-4 backdrop-blur-sm transition-all duration-300 hover:scale-[1.02] hover:border-orange-500/30 hover:from-orange-500/5 hover:to-orange-500/10 hover:shadow-xl sm:p-6"
                >
                    <div class="mb-3 flex items-center gap-4">
                        <div
                            class="flex h-12 w-12 items-center justify-center rounded-xl bg-orange-500/10 transition-all duration-300 group-hover:scale-110 group-hover:bg-orange-500/20"
                        >
                            <svg class="h-6 w-6 text-orange-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z"
                                />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h3 class="font-semibold text-card-foreground transition-colors group-hover:text-orange-600">Analytics</h3>
                            <p class="text-xs text-muted-foreground sm:text-sm">Lihat statistik</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 text-xs text-muted-foreground">
                        <span class="rounded-full bg-orange-500/10 px-2 py-1">{{ stats.profile_views }} views</span>
                        <svg
                            class="h-3 w-3 opacity-60 transition-transform group-hover:translate-x-1"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="2"
                            stroke="currentColor"
                        >
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                        </svg>
                    </div>
                </Link>
            </div>

            <!-- Analytics Overview - Enhanced Mobile Design -->
            <div
                class="rounded-2xl border border-border/50 bg-gradient-to-br from-card/80 to-muted/20 p-4 backdrop-blur-sm transition-all duration-300 hover:shadow-lg sm:p-6"
            >
                <div class="mb-6 flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-card-foreground sm:text-xl">Analytics Minggu Ini</h3>
                    <div class="rounded-full bg-muted/50 px-3 py-1 text-xs text-muted-foreground">Live Data</div>
                </div>

                <div class="grid gap-6 sm:gap-8 md:grid-cols-2">
                    <!-- Top Countries -->
                    <div class="space-y-4">
                        <h4 class="flex items-center gap-2 text-sm font-medium text-card-foreground">
                            <svg class="h-4 w-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3s-4.5 4.03-4.5 9 2.015 9 4.5 9z"
                                />
                            </svg>
                            Negara Teratas
                        </h4>
                        <div class="space-y-3">
                            <div
                                v-for="(count, country) in analytics.top_countries"
                                :key="country"
                                class="flex items-center justify-between rounded-xl bg-muted/30 p-3 transition-all hover:bg-muted/50"
                            >
                                <span class="text-sm text-muted-foreground">{{ country || 'Unknown' }}</span>
                                <div class="flex items-center gap-2">
                                    <div class="h-1.5 w-8 overflow-hidden rounded-full bg-blue-500/20">
                                        <div
                                            class="h-full rounded-full bg-blue-500"
                                            :style="{ width: `${(count / Math.max(...Object.values(analytics.top_countries))) * 100}%` }"
                                        ></div>
                                    </div>
                                    <span class="min-w-[2rem] text-right text-sm font-medium text-card-foreground">{{ count }}</span>
                                </div>
                            </div>
                            <div v-if="Object.keys(analytics.top_countries).length === 0" class="py-8 text-center">
                                <div class="mx-auto mb-3 flex h-12 w-12 items-center justify-center rounded-full bg-muted/50">
                                    <svg
                                        class="h-6 w-6 text-muted-foreground"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke-width="1.5"
                                        stroke="currentColor"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M3.75 3v11.25A2.25 2.25 0 006 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0118 16.5h-2.25m-7.5 0h7.5m-7.5 0l-1 3m8.5-3l1 3m0 0l-1-3m1 3l-1-3m-16.5-3h16.5"
                                        />
                                    </svg>
                                </div>
                                <p class="text-sm text-muted-foreground">Belum ada data analytics</p>
                            </div>
                        </div>
                    </div>

                    <!-- Device Breakdown -->
                    <div class="space-y-4">
                        <h4 class="flex items-center gap-2 text-sm font-medium text-card-foreground">
                            <svg class="h-4 w-4 text-green-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M10.5 1.5H8.25A2.25 2.25 0 006 3.75v16.5a2.25 2.25 0 002.25 2.25h7.5A2.25 2.25 0 0018 20.25V3.75a2.25 2.25 0 00-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 18.75h3"
                                />
                            </svg>
                            Tipe Perangkat
                        </h4>
                        <div class="space-y-3">
                            <div
                                v-for="(count, device) in analytics.device_breakdown"
                                :key="device"
                                class="flex items-center justify-between rounded-xl bg-muted/30 p-3 transition-all hover:bg-muted/50"
                            >
                                <span class="text-sm text-muted-foreground capitalize">{{ device || 'Unknown' }}</span>
                                <div class="flex items-center gap-2">
                                    <div class="h-1.5 w-8 overflow-hidden rounded-full bg-green-500/20">
                                        <div
                                            class="h-full rounded-full bg-green-500"
                                            :style="{ width: `${(count / Math.max(...Object.values(analytics.device_breakdown))) * 100}%` }"
                                        ></div>
                                    </div>
                                    <span class="min-w-[2rem] text-right text-sm font-medium text-card-foreground">{{ count }}</span>
                                </div>
                            </div>
                            <div v-if="Object.keys(analytics.device_breakdown).length === 0" class="py-8 text-center">
                                <div class="mx-auto mb-3 flex h-12 w-12 items-center justify-center rounded-full bg-muted/50">
                                    <svg
                                        class="h-6 w-6 text-muted-foreground"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke-width="1.5"
                                        stroke="currentColor"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M10.5 1.5H8.25A2.25 2.25 0 006 3.75v16.5a2.25 2.25 0 002.25 2.25h7.5A2.25 2.25 0 0018 20.25V3.75a2.25 2.25 0 00-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 18.75h3"
                                        />
                                    </svg>
                                </div>
                                <p class="text-sm text-muted-foreground">Belum ada data perangkat</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import type { BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/vue3';

const props = defineProps<{
    user: {
        id: number;
        name: string;
        email: string;
    };
    profile: {
        slug: string;
        display_name: string;
    };
    stats: {
        total_links: number;
        active_links: number;
        total_portfolios: number;
        profile_views: number;
        total_clicks: number;
    };
    analytics: {
        top_countries: Record<string, number>;
        device_breakdown: Record<string, number>;
    };
    profileUrl: string;
    isPro: boolean;
}>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
];

const getInitials = (name: string): string => {
    return name
        .split(' ')
        .map((n) => n[0])
        .join('')
        .toUpperCase();
};
</script>

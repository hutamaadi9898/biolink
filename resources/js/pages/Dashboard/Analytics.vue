<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <Head title="Analytics" />

        <div class="animate-fadeIn flex h-full flex-1 flex-col gap-4 p-3 sm:gap-6 sm:p-4 lg:p-6">
            <!-- Enhanced Header with Mobile-First Design -->
            <div class="animate-slideDown">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h1 class="text-xl font-bold text-foreground sm:text-2xl lg:text-3xl">Analytics</h1>
                        <p class="text-sm text-muted-foreground sm:text-base">Pantau performa biolink Anda secara real-time</p>
                    </div>

                    <!-- Enhanced Period Selector -->
                    <div class="flex items-center gap-3 rounded-xl border border-border/50 bg-card/80 p-3 backdrop-blur-sm">
                        <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-gradient-to-br from-blue-500 to-purple-500">
                            <svg class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5a2.25 2.25 0 002.25-2.25m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5a2.25 2.25 0 012.25 2.25v7.5"
                                />
                            </svg>
                        </div>
                        <div class="flex flex-col">
                            <Label for="period" class="text-xs font-medium text-muted-foreground">Period</Label>
                            <select
                                id="period"
                                v-model="selectedPeriod"
                                @change="updatePeriod"
                                class="border-none bg-transparent p-0 text-sm font-medium text-foreground focus:ring-0 focus:outline-none"
                            >
                                <option value="today">Hari Ini</option>
                                <option value="7days">7 Hari Terakhir</option>
                                <option value="30days">30 Hari Terakhir</option>
                                <option value="90days">90 Hari Terakhir</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Enhanced Stats Cards with Bento Grid -->
            <div class="animate-staggerFadeIn grid grid-cols-2 gap-3 sm:gap-4 lg:grid-cols-4">
                <div
                    class="group animate-scaleIn rounded-2xl border border-border/50 bg-gradient-to-br from-card/80 to-blue-50/20 p-4 backdrop-blur-sm transition-all duration-300 hover:scale-[1.02] hover:border-blue-500/30 hover:shadow-xl sm:p-6 dark:to-blue-950/20"
                    style="animation-delay: 0.1s"
                >
                    <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
                        <div
                            class="flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-br from-blue-500 to-blue-600 shadow-lg transition-all duration-300 group-hover:scale-110 group-hover:shadow-xl sm:h-14 sm:w-14"
                        >
                            <svg class="h-5 w-5 text-white sm:h-6 sm:w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z"
                                />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-xs font-medium text-muted-foreground sm:text-sm">Profile Views</p>
                            <p
                                class="animate-countUp text-lg font-bold text-card-foreground transition-colors duration-300 group-hover:text-blue-600 sm:text-2xl lg:text-3xl"
                            >
                                {{ formatNumber(stats.total_views) }}
                            </p>
                            <div class="mt-1 flex items-center gap-1">
                                <div class="h-1.5 w-8 overflow-hidden rounded-full bg-blue-200 dark:bg-blue-800">
                                    <div class="h-full w-3/4 rounded-full bg-gradient-to-r from-blue-500 to-blue-600"></div>
                                </div>
                                <span class="text-xs font-medium text-blue-600">+12%</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div
                    class="group animate-scaleIn rounded-2xl border border-border/50 bg-gradient-to-br from-card/80 to-green-50/20 p-4 backdrop-blur-sm transition-all duration-300 hover:scale-[1.02] hover:border-green-500/30 hover:shadow-xl sm:p-6 dark:to-green-950/20"
                    style="animation-delay: 0.2s"
                >
                    <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
                        <div
                            class="flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-br from-green-500 to-emerald-600 shadow-lg transition-all duration-300 group-hover:scale-110 group-hover:shadow-xl sm:h-14 sm:w-14"
                        >
                            <svg class="h-5 w-5 text-white sm:h-6 sm:w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M15.042 21.672L13.684 16.6m0 0-2.51 2.225.569-9.47 5.227 7.917-3.286-.672ZM12 2.25V4.5m5.834.166-1.591 1.591M20.25 10.5H18M7.757 14.743l-1.59 1.59M6 10.5H3.75m4.007-4.243l-1.59-1.59"
                                />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-xs font-medium text-muted-foreground sm:text-sm">Total Clicks</p>
                            <p
                                class="animate-countUp text-lg font-bold text-card-foreground transition-colors duration-300 group-hover:text-green-600 sm:text-2xl lg:text-3xl"
                            >
                                {{ formatNumber(stats.total_clicks) }}
                            </p>
                            <div class="mt-1 flex items-center gap-1">
                                <div class="h-1.5 w-8 overflow-hidden rounded-full bg-green-200 dark:bg-green-800">
                                    <div class="h-full w-4/5 rounded-full bg-gradient-to-r from-green-500 to-emerald-600"></div>
                                </div>
                                <span class="text-xs font-medium text-green-600">+18%</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div
                    class="group animate-scaleIn rounded-2xl border border-border/50 bg-gradient-to-br from-card/80 to-purple-50/20 p-4 backdrop-blur-sm transition-all duration-300 hover:scale-[1.02] hover:border-purple-500/30 hover:shadow-xl sm:p-6 dark:to-purple-950/20"
                    style="animation-delay: 0.3s"
                >
                    <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
                        <div
                            class="flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-br from-purple-500 to-violet-600 shadow-lg transition-all duration-300 group-hover:scale-110 group-hover:shadow-xl sm:h-14 sm:w-14"
                        >
                            <svg class="h-5 w-5 text-white sm:h-6 sm:w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M2.25 7.125C2.25 6.504 2.754 6 3.375 6h6c.621 0 1.125.504 1.125 1.125v3.75c0 .621-.504 1.125-1.125 1.125h-6a1.125 1.125 0 0 1-1.125-1.125v-3.75ZM14.25 8.625c0-.621.504-1.125 1.125-1.125h5.25c.621 0 1.125.504 1.125 1.125v8.25c0 .621-.504 1.125-1.125 1.125h-5.25a1.125 1.125 0 0 1-1.125-1.125v-8.25ZM3.75 16.125c0-.621.504-1.125 1.125-1.125h5.25c.621 0 1.125.504 1.125 1.125v2.25c0 .621-.504 1.125-1.125 1.125h-5.25A1.125 1.125 0 0 1 2.25 18.375v-2.25Z"
                                />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-xs font-medium text-muted-foreground sm:text-sm">Portfolio Views</p>
                            <p
                                class="animate-countUp text-lg font-bold text-card-foreground transition-colors duration-300 group-hover:text-purple-600 sm:text-2xl lg:text-3xl"
                            >
                                {{ formatNumber(stats.portfolio_views) }}
                            </p>
                            <div class="mt-1 flex items-center gap-1">
                                <div class="h-1.5 w-8 overflow-hidden rounded-full bg-purple-200 dark:bg-purple-800">
                                    <div class="h-full w-2/3 rounded-full bg-gradient-to-r from-purple-500 to-violet-600"></div>
                                </div>
                                <span class="text-xs font-medium text-purple-600">+8%</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div
                    class="group animate-scaleIn rounded-2xl border border-border/50 bg-gradient-to-br from-card/80 to-orange-50/20 p-4 backdrop-blur-sm transition-all duration-300 hover:scale-[1.02] hover:border-orange-500/30 hover:shadow-xl sm:p-6 dark:to-orange-950/20"
                    style="animation-delay: 0.4s"
                >
                    <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
                        <div
                            class="flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-br from-orange-500 to-red-500 shadow-lg transition-all duration-300 group-hover:scale-110 group-hover:shadow-xl sm:h-14 sm:w-14"
                        >
                            <svg class="h-5 w-5 text-white sm:h-6 sm:w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z"
                                />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-xs font-medium text-muted-foreground sm:text-sm">Unique Visitors</p>
                            <p
                                class="animate-countUp text-lg font-bold text-card-foreground transition-colors duration-300 group-hover:text-orange-600 sm:text-2xl lg:text-3xl"
                            >
                                {{ formatNumber(stats.unique_visitors) }}
                            </p>
                            <div class="mt-1 flex items-center gap-1">
                                <div class="h-1.5 w-8 overflow-hidden rounded-full bg-orange-200 dark:bg-orange-800">
                                    <div class="h-full w-3/5 rounded-full bg-gradient-to-r from-orange-500 to-red-500"></div>
                                </div>
                                <span class="text-xs font-medium text-orange-600">+15%</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Enhanced Charts Section with Bento Grid -->
            <div class="grid grid-cols-1 gap-4 sm:gap-6 lg:grid-cols-2">
                <!-- Enhanced Daily Breakdown Chart -->
                <div
                    class="rounded-2xl border border-border/50 bg-gradient-to-br from-card/80 to-blue-50/10 p-4 backdrop-blur-sm transition-all duration-300 hover:shadow-lg sm:p-6 dark:to-blue-950/10"
                >
                    <div class="mb-4 flex items-center gap-3 sm:mb-6">
                        <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-gradient-to-br from-blue-500 to-purple-500">
                            <svg class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z"
                                />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-card-foreground">Aktivitas Harian</h3>
                            <p class="text-sm text-muted-foreground">Performa 7 hari terakhir</p>
                        </div>
                    </div>

                    <div class="space-y-3">
                        <div
                            v-for="(day, index) in dailyBreakdown.slice(0, 7)"
                            :key="day.date"
                            class="group flex items-center justify-between rounded-xl p-3 transition-all duration-300 hover:bg-blue-50/50 dark:hover:bg-blue-950/20"
                        >
                            <div class="flex items-center gap-3">
                                <div class="h-2 w-2 rounded-full bg-gradient-to-r from-blue-500 to-purple-500"></div>
                                <span class="text-sm font-medium text-card-foreground">{{ formatDate(day.date) }}</span>
                            </div>
                            <div class="flex items-center gap-4">
                                <div class="text-right">
                                    <div class="text-sm font-semibold text-blue-600">{{ day.views }}</div>
                                    <div class="text-xs text-muted-foreground">views</div>
                                </div>
                                <div class="text-right">
                                    <div class="text-sm font-semibold text-green-600">{{ day.clicks }}</div>
                                    <div class="text-xs text-muted-foreground">clicks</div>
                                </div>
                            </div>
                        </div>

                        <div v-if="dailyBreakdown.length === 0" class="py-8 text-center">
                            <div class="mx-auto mb-3 flex h-12 w-12 items-center justify-center rounded-xl bg-gray-100 dark:bg-gray-800">
                                <svg class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z"
                                    />
                                </svg>
                            </div>
                            <p class="text-sm text-muted-foreground">Belum ada data aktivitas</p>
                        </div>
                    </div>
                </div>

                <!-- Enhanced Top Links -->
                <div
                    class="rounded-2xl border border-border/50 bg-gradient-to-br from-card/80 to-green-50/10 p-4 backdrop-blur-sm transition-all duration-300 hover:shadow-lg sm:p-6 dark:to-green-950/10"
                >
                    <div class="mb-4 flex items-center gap-3 sm:mb-6">
                        <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-gradient-to-br from-green-500 to-emerald-500">
                            <svg class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M13.19 8.688a4.5 4.5 0 011.242 7.244l-4.5 4.5a4.5 4.5 0 01-6.364-6.364l1.757-1.757m13.35-.622l1.757-1.757a4.5 4.5 0 00-6.364-6.364l-4.5 4.5a4.5 4.5 0 001.242 7.244"
                                />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-card-foreground">Link Teratas</h3>
                            <p class="text-sm text-muted-foreground">5 link dengan klik terbanyak</p>
                        </div>
                    </div>

                    <div class="space-y-3">
                        <div
                            v-for="(link, index) in topLinks.slice(0, 5)"
                            :key="link.id"
                            class="group flex items-center justify-between rounded-xl p-3 transition-all duration-300 hover:bg-green-50/50 dark:hover:bg-green-950/20"
                        >
                            <div class="flex min-w-0 flex-1 items-center gap-3">
                                <div
                                    class="flex h-6 w-6 items-center justify-center rounded-md bg-gradient-to-br from-green-500 to-emerald-500 text-xs font-bold text-white"
                                >
                                    {{ index + 1 }}
                                </div>
                                <span class="truncate text-sm font-medium text-card-foreground">{{ link.title }}</span>
                            </div>
                            <div class="ml-3 flex items-center gap-2">
                                <span class="text-sm font-semibold text-green-600">{{ link.clicks }}</span>
                                <span class="text-xs text-muted-foreground">clicks</span>
                            </div>
                        </div>

                        <div v-if="topLinks.length === 0" class="py-8 text-center">
                            <div class="mx-auto mb-3 flex h-12 w-12 items-center justify-center rounded-xl bg-gray-100 dark:bg-gray-800">
                                <svg class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M13.19 8.688a4.5 4.5 0 011.242 7.244l-4.5 4.5a4.5 4.5 0 01-6.364-6.364l1.757-1.757m13.35-.622l1.757-1.757a4.5 4.5 0 00-6.364-6.364l-4.5 4.5a4.5 4.5 0 001.242 7.244"
                                    />
                                </svg>
                            </div>
                            <p class="text-sm text-muted-foreground">Belum ada data link</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Enhanced Details Section with Better Mobile Layout -->
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 sm:gap-6 lg:grid-cols-3">
                <!-- Enhanced Top Countries -->
                <div
                    class="rounded-2xl border border-border/50 bg-gradient-to-br from-card/80 to-indigo-50/10 p-4 backdrop-blur-sm transition-all duration-300 hover:shadow-lg sm:p-6 dark:to-indigo-950/10"
                >
                    <div class="mb-4 flex items-center gap-3 sm:mb-6">
                        <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-gradient-to-br from-indigo-500 to-purple-500">
                            <svg class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3s-4.5 4.03-4.5 9 2.015 9 4.5 9z"
                                />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-card-foreground">Negara Teratas</h3>
                            <p class="text-sm text-muted-foreground">Visitor berdasarkan lokasi</p>
                        </div>
                    </div>

                    <div class="space-y-3">
                        <div
                            v-for="(count, country) in topCountries"
                            :key="country"
                            class="flex items-center justify-between rounded-lg p-2 transition-all duration-300 hover:bg-indigo-50/50 dark:hover:bg-indigo-950/20"
                        >
                            <span class="text-sm font-medium text-card-foreground">{{ country || 'Unknown' }}</span>
                            <span class="text-sm font-semibold text-indigo-600">{{ count }}</span>
                        </div>

                        <div v-if="Object.keys(topCountries).length === 0" class="py-6 text-center">
                            <div class="mx-auto mb-3 flex h-10 w-10 items-center justify-center rounded-xl bg-gray-100 dark:bg-gray-800">
                                <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3s-4.5 4.03-4.5 9 2.015 9 4.5 9z"
                                    />
                                </svg>
                            </div>
                            <p class="text-sm text-muted-foreground">Belum ada data negara</p>
                        </div>
                    </div>
                </div>

                <!-- Enhanced Device Breakdown -->
                <div
                    class="rounded-2xl border border-border/50 bg-gradient-to-br from-card/80 to-pink-50/10 p-4 backdrop-blur-sm transition-all duration-300 hover:shadow-lg sm:p-6 dark:to-pink-950/10"
                >
                    <div class="mb-4 flex items-center gap-3 sm:mb-6">
                        <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-gradient-to-br from-pink-500 to-rose-500">
                            <svg class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M10.5 1.5H8.25A2.25 2.25 0 006 3.75v16.5a2.25 2.25 0 002.25 2.25h7.5A2.25 2.25 0 0018 20.25V3.75a2.25 2.25 0 00-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 18.75h3"
                                />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-card-foreground">Perangkat</h3>
                            <p class="text-sm text-muted-foreground">Jenis perangkat visitor</p>
                        </div>
                    </div>

                    <div class="space-y-3">
                        <div
                            v-for="(count, device) in deviceBreakdown"
                            :key="device"
                            class="flex items-center justify-between rounded-lg p-2 transition-all duration-300 hover:bg-pink-50/50 dark:hover:bg-pink-950/20"
                        >
                            <span class="text-sm font-medium text-card-foreground capitalize">{{ device || 'Unknown' }}</span>
                            <span class="text-sm font-semibold text-pink-600">{{ count }}</span>
                        </div>

                        <div v-if="Object.keys(deviceBreakdown).length === 0" class="py-6 text-center">
                            <div class="mx-auto mb-3 flex h-10 w-10 items-center justify-center rounded-xl bg-gray-100 dark:bg-gray-800">
                                <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
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

                <!-- Enhanced Browser Breakdown -->
                <div
                    class="rounded-2xl border border-border/50 bg-gradient-to-br from-card/80 to-amber-50/10 p-4 backdrop-blur-sm transition-all duration-300 hover:shadow-lg sm:p-6 dark:to-amber-950/10"
                >
                    <div class="mb-4 flex items-center gap-3 sm:mb-6">
                        <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-gradient-to-br from-amber-500 to-orange-500">
                            <svg class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3s-4.5 4.03-4.5 9 2.015 9 4.5 9z"
                                />
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M15.91 11.672a.375.375 0 010 .656l-5.603 3.113a.375.375 0 01-.557-.328V8.887c0-.286.307-.466.557-.327l5.603 3.112z"
                                />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-card-foreground">Browser</h3>
                            <p class="text-sm text-muted-foreground">Browser yang digunakan</p>
                        </div>
                    </div>

                    <div class="space-y-3">
                        <div
                            v-for="(count, browser) in browserBreakdown"
                            :key="browser"
                            class="flex items-center justify-between rounded-lg p-2 transition-all duration-300 hover:bg-amber-50/50 dark:hover:bg-amber-950/20"
                        >
                            <span class="text-sm font-medium text-card-foreground">{{ browser || 'Unknown' }}</span>
                            <span class="text-sm font-semibold text-amber-600">{{ count }}</span>
                        </div>

                        <div v-if="Object.keys(browserBreakdown).length === 0" class="py-6 text-center">
                            <div class="mx-auto mb-3 flex h-10 w-10 items-center justify-center rounded-xl bg-gray-100 dark:bg-gray-800">
                                <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3s-4.5 4.03-4.5 9 2.015 9 4.5 9z"
                                    />
                                </svg>
                            </div>
                            <p class="text-sm text-muted-foreground">Belum ada data browser</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup lang="ts">
import { Label } from '@/components/ui/label';
import AppLayout from '@/layouts/AppLayout.vue';
import type { BreadcrumbItem } from '@/types';
import { Head, router } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps<{
    stats: {
        total_views: number;
        total_clicks: number;
        portfolio_views: number;
        unique_visitors: number;
    };
    dailyBreakdown: Array<{
        date: string;
        views: number;
        clicks: number;
    }>;
    topLinks: Array<{
        id: number;
        title: string;
        clicks: number;
    }>;
    topCountries: Record<string, number>;
    deviceBreakdown: Record<string, number>;
    browserBreakdown: Record<string, number>;
    period: string;
}>();

const selectedPeriod = ref(props.period);

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
    {
        title: 'Analytics',
        href: '/dashboard/analytics',
    },
];

const formatNumber = (num: number): string => {
    if (num >= 1000000) {
        return (num / 1000000).toFixed(1) + 'M';
    } else if (num >= 1000) {
        return (num / 1000).toFixed(1) + 'K';
    }
    return num.toString();
};

const formatDate = (dateString: string): string => {
    const date = new Date(dateString);
    return date.toLocaleDateString('id-ID', {
        month: 'short',
        day: 'numeric',
    });
};

const updatePeriod = () => {
    router.get(
        '/dashboard/analytics',
        { period: selectedPeriod.value },
        {
            preserveState: true,
            replace: true,
        },
    );
};
</script>

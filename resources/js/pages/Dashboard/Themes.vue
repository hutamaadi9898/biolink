<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <Head title="Themes" />

        <div class="animate-fadeIn flex h-full flex-1 flex-col gap-4 p-3 sm:gap-6 sm:p-4 lg:p-6">
            <!-- Enhanced Header with Mobile-First Design -->
            <div class="animate-slideDown">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h1 class="text-xl font-bold text-foreground sm:text-2xl lg:text-3xl">Themes</h1>
                        <p class="text-sm text-muted-foreground sm:text-base">Pilih tema yang cocok dengan style Anda</p>
                    </div>

                    <div class="flex items-center gap-3">
                        <span
                            v-if="isPro"
                            class="group animate-pulse rounded-full bg-gradient-to-r from-amber-400 via-orange-500 to-pink-500 px-3 py-1.5 text-xs font-medium text-white shadow-lg transition-all duration-300 hover:shadow-xl sm:px-4 sm:py-2 sm:text-sm"
                        >
                            <span class="flex items-center gap-1.5">
                                <svg class="h-3 w-3 sm:h-4 sm:w-4" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2l2.4 7.2h7.6l-6 4.8 2.4 7.2L12 17l-6 4.2 2.4-7.2-6-4.8h7.6z" />
                                </svg>
                                PRO MEMBER
                            </span>
                        </span>
                        <div
                            v-else
                            class="rounded-xl border border-purple-200/50 bg-gradient-to-r from-purple-100 to-pink-100 px-3 py-2 sm:px-4 dark:border-purple-700/50 dark:from-purple-900/20 dark:to-pink-900/20"
                        >
                            <span class="text-xs font-medium text-purple-700 sm:text-sm dark:text-purple-300"
                                >Upgrade ke Pro untuk akses semua tema</span
                            >
                        </div>
                    </div>
                </div>
            </div>

            <!-- Enhanced Current Theme Card -->
            <div
                v-if="currentTheme"
                class="animate-slideUp rounded-2xl border border-border/50 bg-gradient-to-br from-card/80 to-blue-50/20 p-4 backdrop-blur-sm sm:p-6 dark:to-blue-950/20"
            >
                <div class="mb-4 sm:mb-6">
                    <h3 class="flex items-center gap-2 text-lg font-semibold text-card-foreground sm:text-xl">
                        <div class="h-2 w-2 animate-pulse rounded-full bg-green-500"></div>
                        Tema Aktif
                    </h3>
                    <p class="text-sm text-muted-foreground">Tema yang sedang digunakan pada biolink Anda</p>
                </div>

                <div class="flex flex-col gap-4 sm:flex-row sm:gap-6">
                    <div
                        class="group relative overflow-hidden rounded-xl border border-border/50 bg-gradient-to-br from-white to-gray-50 shadow-lg transition-all duration-300 hover:scale-105 hover:shadow-xl dark:from-gray-800 dark:to-gray-900"
                    >
                        <img
                            v-if="currentTheme.preview_image"
                            :src="currentTheme.preview_image"
                            :alt="currentTheme.name"
                            class="h-24 w-36 object-cover sm:h-32 sm:w-48"
                        />
                        <div
                            v-else
                            class="flex h-24 w-36 items-center justify-center bg-gradient-to-br from-purple-100 to-pink-100 sm:h-32 sm:w-48 dark:from-purple-900/20 dark:to-pink-900/20"
                        >
                            <PlaceholderPattern />
                        </div>

                        <!-- Active Badge -->
                        <div class="absolute top-2 right-2">
                            <div class="rounded-full bg-green-500 px-2 py-1 shadow-lg">
                                <span class="text-xs font-medium text-white">Aktif</span>
                            </div>
                        </div>
                    </div>

                    <div class="flex-1">
                        <h4 class="mb-2 text-lg font-semibold text-card-foreground sm:text-xl">{{ currentTheme.name }}</h4>
                        <p class="mb-4 text-sm leading-relaxed text-muted-foreground sm:text-base">{{ currentTheme.description }}</p>
                        <div class="flex flex-wrap items-center gap-2 sm:gap-3">
                            <span
                                :class="[
                                    'rounded-full px-3 py-1.5 text-xs font-medium shadow-sm sm:text-sm',
                                    currentTheme.is_premium
                                        ? 'bg-gradient-to-r from-amber-400 to-orange-500 text-white'
                                        : 'bg-gradient-to-r from-green-500 to-emerald-500 text-white',
                                ]"
                            >
                                {{ currentTheme.is_premium ? '💎 Premium' : '🎉 Free' }}
                            </span>
                            <span
                                class="rounded-full bg-green-100 px-3 py-1.5 text-xs font-medium text-green-800 shadow-sm sm:text-sm dark:bg-green-900/20 dark:text-green-400"
                            >
                                ✅ Sedang Aktif
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Enhanced Free Themes Section -->
            <div v-if="freeThemes.length > 0" class="space-y-4 sm:space-y-6">
                <div class="flex items-center gap-3">
                    <div
                        class="flex h-8 w-8 items-center justify-center rounded-xl bg-gradient-to-br from-green-500 to-emerald-500 shadow-lg sm:h-10 sm:w-10"
                    >
                        <svg class="h-4 w-4 text-white sm:h-5 sm:w-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2l2.4 7.2h7.6l-6 4.8 2.4 7.2L12 17l-6 4.2 2.4-7.2-6-4.8h7.6z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-foreground sm:text-xl">Tema Gratis</h3>
                        <p class="text-xs text-muted-foreground sm:text-sm">{{ freeThemes.length }} tema tersedia gratis</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 sm:gap-6 lg:grid-cols-3">
                    <div
                        v-for="theme in freeThemes"
                        :key="theme.id"
                        class="group relative overflow-hidden rounded-2xl border border-border/50 bg-gradient-to-br from-card/80 to-green-50/20 backdrop-blur-sm transition-all duration-300 hover:scale-[1.02] hover:border-green-500/30 hover:shadow-xl dark:to-green-950/20"
                    >
                        <!-- Theme Preview with Enhanced Overlay -->
                        <div
                            class="relative aspect-video overflow-hidden bg-gradient-to-br from-green-100 to-emerald-100 dark:from-green-900/20 dark:to-emerald-900/20"
                        >
                            <img
                                v-if="theme.preview_image"
                                :src="theme.preview_image"
                                :alt="theme.name"
                                class="h-full w-full object-cover transition-all duration-500 group-hover:scale-110"
                            />
                            <div v-else class="flex h-full items-center justify-center">
                                <PlaceholderPattern />
                            </div>

                            <!-- Gradient Overlay -->
                            <div
                                class="absolute inset-0 bg-gradient-to-t from-black/40 via-transparent to-transparent opacity-0 transition-opacity duration-300 group-hover:opacity-100"
                            ></div>

                            <!-- Free Badge -->
                            <div class="absolute top-3 left-3">
                                <span
                                    class="inline-flex items-center gap-1 rounded-full bg-green-500/90 px-3 py-1 text-xs font-medium text-white shadow-lg backdrop-blur-sm"
                                >
                                    <svg class="h-3 w-3" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 2l2.4 7.2h7.6l-6 4.8 2.4 7.2L12 17l-6 4.2 2.4-7.2-6-4.8h7.6z" />
                                    </svg>
                                    Free
                                </span>
                            </div>

                            <!-- Action Buttons Overlay -->
                            <div
                                class="absolute top-3 right-3 flex translate-y-2 transform gap-2 opacity-0 transition-all duration-300 group-hover:translate-y-0 group-hover:opacity-100"
                            >
                                <Button
                                    variant="ghost"
                                    size="sm"
                                    @click="previewTheme(theme)"
                                    class="h-8 w-8 bg-white/90 text-gray-800 backdrop-blur-sm transition-all duration-300 hover:scale-110 hover:bg-white"
                                >
                                    <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z"
                                        />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    </svg>
                                </Button>
                            </div>
                        </div>

                        <!-- Enhanced Theme Content -->
                        <div class="p-4 sm:p-5">
                            <div class="mb-3">
                                <h4
                                    class="line-clamp-1 text-lg font-semibold text-card-foreground transition-colors duration-300 group-hover:text-green-600"
                                >
                                    {{ theme.name }}
                                </h4>
                            </div>

                            <p class="mb-4 line-clamp-2 text-sm leading-relaxed text-muted-foreground">{{ theme.description }}</p>

                            <!-- Enhanced Action Buttons -->
                            <div class="flex gap-2 sm:gap-3">
                                <Button
                                    v-if="currentTheme?.id !== theme.id"
                                    @click="applyTheme(theme.id)"
                                    class="h-10 flex-1 bg-gradient-to-r from-green-600 to-emerald-600 text-sm transition-all duration-300 hover:scale-105 hover:from-green-700 hover:to-emerald-700 sm:h-12 sm:text-base"
                                >
                                    <span class="flex items-center gap-1.5">
                                        <svg class="h-3 w-3 sm:h-4 sm:w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                        </svg>
                                        Terapkan
                                    </span>
                                </Button>
                                <Button
                                    v-else
                                    disabled
                                    variant="outline"
                                    class="h-10 flex-1 border-green-200 bg-green-50 text-sm text-green-700 sm:h-12 sm:text-base dark:border-green-800 dark:bg-green-950/20 dark:text-green-400"
                                >
                                    <span class="flex items-center gap-1.5">
                                        <div class="h-2 w-2 animate-pulse rounded-full bg-green-500"></div>
                                        Sedang Aktif
                                    </span>
                                </Button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Enhanced Premium Themes Section -->
            <div v-if="premiumThemes.length > 0" class="space-y-4 sm:space-y-6">
                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between sm:gap-4">
                    <div class="flex items-center gap-3">
                        <div
                            class="flex h-8 w-8 items-center justify-center rounded-xl bg-gradient-to-br from-amber-400 via-orange-500 to-pink-500 shadow-lg sm:h-10 sm:w-10"
                        >
                            <svg class="h-4 w-4 text-white sm:h-5 sm:w-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2l2.4 7.2h7.6l-6 4.8 2.4 7.2L12 17l-6 4.2 2.4-7.2-6-4.8h7.6z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-foreground sm:text-xl">Tema Premium</h3>
                            <p class="text-xs text-muted-foreground sm:text-sm">{{ premiumThemes.length }} tema eksklusif untuk member Pro</p>
                        </div>
                    </div>

                    <div v-if="!isPro" class="rounded-xl bg-gradient-to-r from-amber-400 to-orange-500 px-3 py-2 shadow-lg sm:px-4">
                        <span class="text-xs font-medium text-white sm:text-sm">Upgrade ke Pro untuk akses</span>
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 sm:gap-6 lg:grid-cols-3">
                    <div
                        v-for="theme in premiumThemes"
                        :key="theme.id"
                        :class="[
                            'group relative overflow-hidden rounded-2xl border border-border/50 bg-gradient-to-br from-card/80 to-amber-50/20 backdrop-blur-sm transition-all duration-300 dark:to-amber-950/20',
                            isPro ? 'hover:scale-[1.02] hover:border-amber-500/30 hover:shadow-xl' : 'opacity-75',
                        ]"
                    >
                        <!-- Premium Badge -->
                        <div class="absolute top-3 left-3 z-10">
                            <span
                                class="inline-flex items-center gap-1 rounded-full bg-gradient-to-r from-amber-400 via-orange-500 to-pink-500 px-3 py-1 text-xs font-medium text-white shadow-lg backdrop-blur-sm"
                            >
                                <svg class="h-3 w-3" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2l2.4 7.2h7.6l-6 4.8 2.4 7.2L12 17l-6 4.2 2.4-7.2-6-4.8h7.6z" />
                                </svg>
                                Premium
                            </span>
                        </div>

                        <!-- Enhanced Lock Overlay for Non-Pro Users -->
                        <div v-if="!isPro" class="absolute inset-0 z-20 flex items-center justify-center bg-black/60 backdrop-blur-sm">
                            <div class="text-center">
                                <div class="mx-auto mb-3 flex h-12 w-12 items-center justify-center rounded-2xl bg-white shadow-lg">
                                    <svg class="h-6 w-6 text-gray-600" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z"
                                        />
                                    </svg>
                                </div>
                                <p class="text-sm font-medium text-white">Upgrade ke Pro</p>
                            </div>
                        </div>

                        <!-- Theme Preview -->
                        <div
                            class="relative aspect-video overflow-hidden bg-gradient-to-br from-amber-100 to-orange-100 dark:from-amber-900/20 dark:to-orange-900/20"
                        >
                            <img
                                v-if="theme.preview_image"
                                :src="theme.preview_image"
                                :alt="theme.name"
                                class="h-full w-full object-cover transition-all duration-500 group-hover:scale-110"
                            />
                            <div v-else class="flex h-full items-center justify-center">
                                <PlaceholderPattern />
                            </div>

                            <!-- Gradient Overlay -->
                            <div
                                class="absolute inset-0 bg-gradient-to-t from-black/40 via-transparent to-transparent opacity-0 transition-opacity duration-300 group-hover:opacity-100"
                            ></div>

                            <!-- Action Buttons Overlay -->
                            <div
                                v-if="isPro"
                                class="absolute top-3 right-3 flex translate-y-2 transform gap-2 opacity-0 transition-all duration-300 group-hover:translate-y-0 group-hover:opacity-100"
                            >
                                <Button
                                    variant="ghost"
                                    size="sm"
                                    @click="previewTheme(theme)"
                                    class="h-8 w-8 bg-white/90 text-gray-800 backdrop-blur-sm transition-all duration-300 hover:scale-110 hover:bg-white"
                                >
                                    <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z"
                                        />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    </svg>
                                </Button>
                            </div>
                        </div>

                        <!-- Enhanced Theme Content -->
                        <div class="p-4 sm:p-5">
                            <div class="mb-3">
                                <h4
                                    class="line-clamp-1 text-lg font-semibold text-card-foreground transition-colors duration-300 group-hover:text-amber-600"
                                >
                                    {{ theme.name }}
                                </h4>
                            </div>

                            <p class="mb-4 line-clamp-2 text-sm leading-relaxed text-muted-foreground">{{ theme.description }}</p>

                            <!-- Enhanced Action Buttons -->
                            <div class="flex gap-2 sm:gap-3">
                                <Button
                                    v-if="isPro && currentTheme?.id !== theme.id"
                                    @click="applyTheme(theme.id)"
                                    class="h-10 flex-1 bg-gradient-to-r from-amber-600 to-orange-600 text-sm transition-all duration-300 hover:scale-105 hover:from-amber-700 hover:to-orange-700 sm:h-12 sm:text-base"
                                >
                                    <span class="flex items-center gap-1.5">
                                        <svg class="h-3 w-3 sm:h-4 sm:w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                        </svg>
                                        Terapkan
                                    </span>
                                </Button>
                                <Button
                                    v-else-if="isPro && currentTheme?.id === theme.id"
                                    disabled
                                    variant="outline"
                                    class="h-10 flex-1 border-amber-200 bg-amber-50 text-sm text-amber-700 sm:h-12 sm:text-base dark:border-amber-800 dark:bg-amber-950/20 dark:text-amber-400"
                                >
                                    <span class="flex items-center gap-1.5">
                                        <div class="h-2 w-2 animate-pulse rounded-full bg-amber-500"></div>
                                        Sedang Aktif
                                    </span>
                                </Button>
                                <Button v-else disabled variant="outline" class="h-10 flex-1 text-sm opacity-50 sm:h-12 sm:text-base">
                                    <span class="flex items-center gap-1.5">
                                        <svg class="h-3 w-3 sm:h-4 sm:w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z"
                                            />
                                        </svg>
                                        Perlu Pro
                                    </span>
                                </Button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Enhanced Upgrade CTA for Non-Pro Users -->
            <div
                v-if="!isPro"
                class="rounded-2xl border border-border/50 bg-gradient-to-br from-amber-50/80 via-orange-50/80 to-pink-50/80 p-6 shadow-lg backdrop-blur-sm sm:p-8 dark:from-amber-900/20 dark:via-orange-900/20 dark:to-pink-900/20"
            >
                <div class="flex flex-col items-start gap-4 sm:flex-row sm:items-center sm:gap-6">
                    <div
                        class="flex h-16 w-16 items-center justify-center rounded-2xl bg-gradient-to-br from-amber-400 via-orange-500 to-pink-500 shadow-xl sm:h-20 sm:w-20"
                    >
                        <svg class="h-8 w-8 text-white sm:h-10 sm:w-10" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 00-2.456 2.456zM16.894 20.567L16.5 21.75l-.394-1.183a2.25 2.25 0 00-1.423-1.423L13.5 18.75l1.183-.394a2.25 2.25 0 001.423-1.423l.394-1.183.394 1.183a2.25 2.25 0 001.423 1.423l1.183.394-1.183.394a2.25 2.25 0 00-1.423 1.423z"
                            />
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h3 class="mb-2 text-lg font-bold text-foreground sm:text-xl">Upgrade ke Pro</h3>
                        <p class="mb-4 text-sm leading-relaxed text-muted-foreground sm:text-base">
                            Dapatkan akses ke semua tema premium, fitur kustomisasi lanjutan, analytics mendalam, dan dukungan prioritas
                        </p>
                        <div class="flex flex-wrap gap-2">
                            <span class="inline-flex items-center gap-1 rounded-full bg-white/80 px-3 py-1 text-xs font-medium text-gray-700">
                                <svg class="h-3 w-3 text-green-500" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M20.285 2l-11.285 11.567-5.286-5.011-3.714 3.716 9 8.728 15-15.285z" />
                                </svg>
                                Tema Premium
                            </span>
                            <span class="inline-flex items-center gap-1 rounded-full bg-white/80 px-3 py-1 text-xs font-medium text-gray-700">
                                <svg class="h-3 w-3 text-green-500" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M20.285 2l-11.285 11.567-5.286-5.011-3.714 3.716 9 8.728 15-15.285z" />
                                </svg>
                                Analytics Pro
                            </span>
                            <span class="inline-flex items-center gap-1 rounded-full bg-white/80 px-3 py-1 text-xs font-medium text-gray-700">
                                <svg class="h-3 w-3 text-green-500" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M20.285 2l-11.285 11.567-5.286-5.011-3.714 3.716 9 8.728 15-15.285z" />
                                </svg>
                                Dukungan Prioritas
                            </span>
                        </div>
                    </div>
                    <Button
                        class="group bg-gradient-to-r from-amber-400 via-orange-500 to-pink-500 px-6 py-3 text-sm font-medium text-white transition-all duration-300 hover:scale-105 hover:from-amber-500 hover:via-orange-600 hover:to-pink-600 hover:shadow-xl sm:px-8 sm:py-4 sm:text-base"
                    >
                        <span class="flex items-center gap-2">
                            <svg
                                class="h-4 w-4 transition-transform group-hover:scale-110 sm:h-5 sm:w-5"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="2"
                                stroke="currentColor"
                            >
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                            </svg>
                            Upgrade Sekarang
                        </span>
                    </Button>
                </div>
            </div>
        </div>

        <!-- Enhanced Theme Preview Modal -->
        <div v-if="previewingTheme" class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 p-4 backdrop-blur-sm">
            <div class="animate-slideUp w-full max-w-4xl rounded-2xl border border-border/50 bg-card/95 shadow-2xl backdrop-blur-sm">
                <div class="flex items-center justify-between border-b border-border/50 p-4 sm:p-6">
                    <div>
                        <h3 class="text-lg font-semibold text-card-foreground sm:text-xl">{{ previewingTheme.name }}</h3>
                        <p class="text-sm text-muted-foreground">Preview tema sebelum diterapkan</p>
                    </div>
                    <Button
                        variant="ghost"
                        size="sm"
                        @click="previewingTheme = null"
                        class="transition-all duration-300 hover:scale-110 hover:bg-red-500/10 hover:text-red-600"
                    >
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </Button>
                </div>

                <div class="p-4 sm:p-6">
                    <div
                        class="aspect-video overflow-hidden rounded-xl border border-border/50 bg-gradient-to-br from-purple-100 to-pink-100 shadow-lg dark:from-purple-900/20 dark:to-pink-900/20"
                    >
                        <img
                            v-if="previewingTheme.preview_image"
                            :src="previewingTheme.preview_image"
                            :alt="previewingTheme.name"
                            class="h-full w-full object-cover"
                        />
                        <div v-else class="flex h-full items-center justify-center">
                            <PlaceholderPattern />
                        </div>
                    </div>

                    <div class="mt-6 flex flex-col items-start justify-between gap-4 sm:flex-row sm:items-center">
                        <div class="flex-1">
                            <h4 class="mb-2 text-lg font-semibold text-card-foreground">{{ previewingTheme.name }}</h4>
                            <p class="text-sm leading-relaxed text-muted-foreground">{{ previewingTheme.description }}</p>
                            <div class="mt-3 flex items-center gap-2">
                                <span
                                    :class="[
                                        'rounded-full px-3 py-1 text-xs font-medium',
                                        previewingTheme.is_premium
                                            ? 'bg-gradient-to-r from-amber-400 to-orange-500 text-white'
                                            : 'bg-gradient-to-r from-green-500 to-emerald-500 text-white',
                                    ]"
                                >
                                    {{ previewingTheme.is_premium ? '💎 Premium' : '🎉 Free' }}
                                </span>
                            </div>
                        </div>
                        <div class="flex w-full gap-3 sm:w-auto">
                            <Button variant="outline" @click="previewingTheme = null" class="flex-1 sm:flex-none"> Tutup </Button>
                            <Button
                                v-if="(isPro || !previewingTheme.is_premium) && currentTheme?.id !== previewingTheme.id"
                                @click="applyTheme(previewingTheme.id)"
                                class="flex-1 bg-gradient-to-r from-purple-600 to-pink-600 transition-all duration-300 hover:scale-105 hover:from-purple-700 hover:to-pink-700 sm:flex-none"
                            >
                                <span class="flex items-center gap-2">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                    </svg>
                                    Terapkan Tema
                                </span>
                            </Button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup lang="ts">
import PlaceholderPattern from '@/components/PlaceholderPattern.vue';
import { Button } from '@/components/ui/button';
import AppLayout from '@/layouts/AppLayout.vue';
import type { BreadcrumbItem } from '@/types';
import { Head, router } from '@inertiajs/vue3';
import { ref } from 'vue';

interface Theme {
    id: number;
    name: string;
    description: string;
    preview_image?: string;
    is_premium: boolean;
    sort_order: number;
}

const props = defineProps<{
    freeThemes: Theme[];
    premiumThemes: Theme[];
    currentTheme?: Theme;
    isPro: boolean;
}>();

const previewingTheme = ref<Theme | null>(null);

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
    {
        title: 'Themes',
        href: '/dashboard/themes',
    },
];

const applyTheme = (themeId: number) => {
    router.post(
        `/dashboard/themes/${themeId}/apply`,
        {},
        {
            onSuccess: () => {
                previewingTheme.value = null;
            },
        },
    );
};

const previewTheme = (theme: Theme) => {
    previewingTheme.value = theme;
};
</script>

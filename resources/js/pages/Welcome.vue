<template>
    <Head title="BiolinkID">
        <meta name="description" content="Platform biolink terbaik Indonesia" />
    </Head>
    <div class="min-h-screen bg-background">
        <!-- Navigation -->
        <nav class="relative z-50 border-b border-border/40 bg-background/95 backdrop-blur-md">
            <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-3 sm:px-6 sm:py-4">
                <div class="flex items-center gap-2">
                    <AppLogoIcon class="size-6 fill-current text-foreground sm:size-8" />
                    <span class="text-lg font-bold text-foreground sm:text-xl">BiolinkID</span>
                </div>
                <div class="flex items-center gap-2 sm:gap-3">
                    <Link
                        v-if="!$page.props.auth.user"
                        href="/login"
                        class="rounded-lg px-3 py-2 text-sm font-medium text-muted-foreground transition-colors hover:text-foreground sm:px-4"
                    >
                        Masuk
                    </Link>
                    <Link
                        v-if="!$page.props.auth.user"
                        href="/register"
                        class="rounded-lg bg-primary px-3 py-2 text-sm font-medium text-primary-foreground transition-colors hover:bg-primary/90 sm:px-4"
                    >
                        Daftar
                    </Link>
                    <Link
                        v-if="$page.props.auth.user"
                        href="/dashboard"
                        class="rounded-lg bg-primary px-3 py-2 text-sm font-medium text-primary-foreground transition-colors hover:bg-primary/90 sm:px-4"
                    >
                        Dashboard
                    </Link>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <section class="relative overflow-hidden bg-gradient-to-br from-background via-background to-muted/20">
            <!-- Background Elements -->
            <div class="absolute inset-0">
                <div
                    class="absolute top-0 right-1/4 h-72 w-72 animate-pulse rounded-full bg-gradient-to-br from-primary/10 to-purple-500/10 blur-3xl"
                ></div>
                <div
                    class="absolute bottom-0 left-1/4 h-96 w-96 animate-pulse rounded-full bg-gradient-to-tr from-blue-500/10 to-primary/10 blur-3xl [animation-delay:1s]"
                ></div>
                <!-- Floating orbs -->
                <div class="animate-float absolute top-20 left-10 h-4 w-4 rounded-full bg-primary/20"></div>
                <div class="animate-float absolute top-40 right-20 h-6 w-6 rounded-full bg-purple-500/20 [animation-delay:2s]"></div>
                <div class="animate-float absolute bottom-32 left-20 h-5 w-5 rounded-full bg-blue-500/20 [animation-delay:3s]"></div>
            </div>

            <div class="relative mx-auto max-w-7xl px-4 py-16 sm:px-6 sm:py-24 lg:py-32">
                <!-- Hero Content -->
                <div class="mx-auto max-w-2xl text-center">
                    <div
                        class="animate-fade-in mb-6 inline-flex items-center rounded-full border border-border/50 bg-card/60 px-3 py-1.5 text-xs text-muted-foreground backdrop-blur-sm sm:mb-8 sm:px-4 sm:py-2 sm:text-sm"
                    >
                        ✨ Platform biolink terpercaya untuk creator Indonesia
                    </div>
                    <h1 class="animate-fade-in text-3xl font-bold tracking-tight text-foreground [animation-delay:200ms] sm:text-4xl lg:text-6xl">
                        Platform Biolink
                        <span class="animate-gradient bg-gradient-to-r from-primary via-purple-600 to-blue-600 bg-clip-text text-transparent">
                            Terbaik Indonesia
                        </span>
                    </h1>
                    <p
                        class="animate-fade-in mt-4 px-4 text-base leading-relaxed text-muted-foreground [animation-delay:400ms] sm:mt-6 sm:px-0 sm:text-lg sm:leading-8"
                    >
                        Showcase portfolio, social media, dan e-commerce dalam satu link. Buat biolink yang menarik dan profesional dalam hitungan
                        menit dengan template yang stunning.
                    </p>
                    <div
                        class="animate-fade-in mt-8 flex flex-col items-center justify-center gap-4 px-4 [animation-delay:600ms] sm:mt-10 sm:flex-row sm:gap-x-6 sm:px-0"
                    >
                        <Link
                            v-if="!$page.props.auth.user"
                            href="/register"
                            class="group relative w-full overflow-hidden rounded-xl bg-primary px-6 py-3 text-base font-semibold text-primary-foreground shadow-lg transition-all hover:scale-105 hover:bg-primary/90 hover:shadow-xl sm:w-auto sm:px-8 sm:py-4"
                        >
                            <span class="relative z-10">Mulai Gratis</span>
                            <div
                                class="absolute inset-0 bg-gradient-to-r from-primary to-purple-600 opacity-0 transition-opacity group-hover:opacity-100"
                            ></div>
                        </Link>
                        <Link
                            v-if="$page.props.auth.user"
                            href="/dashboard"
                            class="group relative w-full overflow-hidden rounded-xl bg-primary px-6 py-3 text-base font-semibold text-primary-foreground shadow-lg transition-all hover:scale-105 hover:bg-primary/90 hover:shadow-xl sm:w-auto sm:px-8 sm:py-4"
                        >
                            <span class="relative z-10">Dashboard</span>
                            <div
                                class="absolute inset-0 bg-gradient-to-r from-primary to-purple-600 opacity-0 transition-opacity group-hover:opacity-100"
                            ></div>
                        </Link>
                        <Link href="#features" class="group text-base leading-6 font-semibold text-foreground transition-colors hover:text-primary">
                            Lihat Fitur <span aria-hidden="true" class="inline-block transition-transform group-hover:translate-x-1">→</span>
                        </Link>
                    </div>
                </div>

                <!-- Enhanced Bento Grid with Stock Images -->
                <div class="animate-fade-in mx-auto mt-12 max-w-6xl px-4 [animation-delay:800ms] sm:mt-16 sm:px-0 lg:mt-20">
                    <div class="grid grid-cols-1 gap-4 sm:gap-6 md:grid-cols-6 lg:grid-cols-8">
                        <!-- Large Feature Card with Beautiful Stock Image -->
                        <div
                            class="group animate-slide-up relative col-span-1 row-span-2 overflow-hidden rounded-2xl border border-border/70 bg-card transition-all [animation-delay:1000ms] hover:scale-[1.02] hover:shadow-2xl md:col-span-4 lg:col-span-5"
                        >
                            <div class="absolute inset-0">
                                <img
                                    src="https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=800&h=600&fit=crop&auto=format"
                                    alt="Design workspace"
                                    class="h-full w-full object-cover opacity-20 transition-opacity group-hover:opacity-30"
                                />
                                <div class="absolute inset-0 bg-gradient-to-br from-primary/10 via-transparent to-purple-600/10"></div>
                            </div>
                            <div class="relative z-10 flex h-full flex-col justify-between p-8">
                                <div>
                                    <div class="mb-4 inline-flex items-center rounded-full bg-primary/10 px-3 py-1 text-xs font-medium text-primary">
                                        ✨ Customizable Design
                                    </div>
                                    <h3 class="text-2xl font-bold text-card-foreground">Template Profesional</h3>
                                    <p class="mt-3 leading-relaxed text-muted-foreground">
                                        Pilih dari berbagai template yang dirancang oleh desainer profesional atau buat desain kustom sesuai brand
                                        Anda dengan mudah.
                                    </p>
                                </div>
                                <div class="mt-8 flex items-center gap-2 text-sm font-medium text-primary">
                                    <span>Jelajahi Template</span>
                                    <svg
                                        class="h-4 w-4 transition-transform group-hover:translate-x-1"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                    >
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <!-- Analytics Card with Data Visualization -->
                        <div
                            class="group animate-slide-up relative col-span-1 overflow-hidden rounded-2xl border border-border/70 bg-card transition-all [animation-delay:1200ms] hover:scale-[1.02] hover:shadow-xl md:col-span-2 lg:col-span-3"
                        >
                            <div class="absolute inset-0">
                                <img
                                    src="https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=600&h=400&fit=crop&auto=format"
                                    alt="Analytics dashboard"
                                    class="h-full w-full object-cover opacity-15"
                                />
                                <div class="absolute inset-0 bg-gradient-to-br from-blue-500/10 to-primary/10"></div>
                            </div>
                            <div class="relative z-10 p-6">
                                <div class="mb-3 flex items-center gap-2">
                                    <div class="h-2 w-2 animate-pulse rounded-full bg-green-500"></div>
                                    <span class="text-xs font-medium text-green-600">Live Analytics</span>
                                </div>
                                <h3 class="text-lg font-bold text-card-foreground">Real-time Analytics</h3>
                                <p class="mt-2 text-sm text-muted-foreground">Track clicks, views, dan engagement secara real-time</p>
                                <div class="mt-6 space-y-2">
                                    <div class="flex items-center justify-between text-xs">
                                        <span class="text-muted-foreground">Click Rate</span>
                                        <span class="font-medium text-primary">94.2%</span>
                                    </div>
                                    <div class="h-2 overflow-hidden rounded-full bg-muted">
                                        <div class="h-full rounded-full bg-gradient-to-r from-primary to-blue-500" style="width: 94.2%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Social Media Card -->
                        <div
                            class="group animate-slide-up relative col-span-1 overflow-hidden rounded-2xl border border-border/70 bg-card transition-all [animation-delay:1400ms] hover:scale-[1.02] hover:shadow-xl md:col-span-2 lg:col-span-3"
                        >
                            <div class="absolute inset-0">
                                <img
                                    src="https://images.unsplash.com/photo-1611162617474-5b21e879e113?w=600&h=400&fit=crop&auto=format"
                                    alt="Social media"
                                    class="h-full w-full object-cover opacity-15"
                                />
                                <div class="absolute inset-0 bg-gradient-to-br from-purple-500/10 to-pink-500/10"></div>
                            </div>
                            <div class="relative z-10 p-6">
                                <h3 class="text-lg font-bold text-card-foreground">Social Integration</h3>
                                <p class="mt-2 text-sm text-muted-foreground">Connect semua platform sosial media</p>
                                <div class="mt-6 flex gap-3">
                                    <div
                                        class="group/icon relative flex h-10 w-10 items-center justify-center rounded-full bg-gradient-to-br from-blue-500 to-blue-600 shadow-lg transition-transform hover:scale-110"
                                    >
                                        <svg class="h-5 w-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                            <path
                                                d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"
                                            />
                                        </svg>
                                    </div>
                                    <div
                                        class="group/icon relative flex h-10 w-10 items-center justify-center rounded-full bg-gradient-to-br from-pink-500 to-rose-600 shadow-lg transition-transform hover:scale-110"
                                    >
                                        <svg class="h-5 w-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                            <path
                                                d="M12.017 0C5.396 0 .029 5.367.029 11.987c0 5.079 3.158 9.417 7.618 11.174-.105-.949-.199-2.403.041-3.439.219-.937 1.406-5.957 1.406-5.957s-.359-.72-.359-1.781c0-1.663.967-2.911 2.168-2.911 1.024 0 1.518.769 1.518 1.688 0 1.029-.653 2.567-.992 3.992-.285 1.193.6 2.165 1.775 2.165 2.128 0 3.768-2.245 3.768-5.487 0-2.861-2.063-4.869-5.008-4.869-3.41 0-5.409 2.562-5.409 5.199 0 1.033.394 2.143.889 2.741.097.118.112.221.082.343-.09.375-.293 1.199-.334 1.363-.053.225-.172.271-.402.165-1.495-.69-2.433-2.878-2.433-4.646 0-3.776 2.748-7.252 7.92-7.252 4.158 0 7.392 2.967 7.392 6.923 0 4.135-2.607 7.462-6.233 7.462-1.214 0-2.357-.629-2.746-1.378l-.748 2.853c-.271 1.043-1.002 2.35-1.492 3.146C9.57 23.812 10.763 24.009 12.017 24.009c6.624 0 11.99-5.367 11.99-11.988C24.007 5.367 18.641.001 12.017.001z"
                                            />
                                        </svg>
                                    </div>
                                    <div
                                        class="group/icon relative flex h-10 w-10 items-center justify-center rounded-full bg-gradient-to-br from-purple-500 to-purple-600 shadow-lg transition-transform hover:scale-110"
                                    >
                                        <svg class="h-5 w-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                            <path
                                                d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"
                                            />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Portfolio Card with Beautiful Gallery -->
                        <div
                            class="group animate-slide-up relative col-span-1 overflow-hidden rounded-2xl border border-border/70 bg-card transition-all [animation-delay:1600ms] hover:scale-[1.02] hover:shadow-xl md:col-span-4 lg:col-span-5"
                        >
                            <div class="absolute inset-0">
                                <img
                                    src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=800&h=600&fit=crop&auto=format"
                                    alt="Portfolio showcase"
                                    class="h-full w-full object-cover opacity-10"
                                />
                                <div class="absolute inset-0 bg-gradient-to-br from-green-500/5 to-emerald-500/10"></div>
                            </div>
                            <div class="relative z-10 p-6">
                                <div class="mb-4 flex items-center justify-between">
                                    <div>
                                        <h3 class="text-lg font-bold text-card-foreground">Portfolio Showcase</h3>
                                        <p class="mt-1 text-sm text-muted-foreground">Tampilkan karya terbaik dengan galeri yang stunning</p>
                                    </div>
                                    <div class="rounded-full bg-green-100 px-2 py-1 text-xs font-medium text-green-700">Pro Feature</div>
                                </div>
                                <div class="mt-6 grid grid-cols-4 gap-3">
                                    <div class="group/img aspect-square overflow-hidden rounded-xl shadow-lg">
                                        <img
                                            src="https://images.unsplash.com/photo-1517077304055-6e89abbf09b0?w=200&h=200&fit=crop&auto=format"
                                            alt="Portfolio 1"
                                            class="h-full w-full object-cover transition-transform group-hover/img:scale-110"
                                        />
                                    </div>
                                    <div class="group/img aspect-square overflow-hidden rounded-xl shadow-lg">
                                        <img
                                            src="https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=200&h=200&fit=crop&auto=format"
                                            alt="Portfolio 2"
                                            class="h-full w-full object-cover transition-transform group-hover/img:scale-110"
                                        />
                                    </div>
                                    <div class="group/img aspect-square overflow-hidden rounded-xl shadow-lg">
                                        <img
                                            src="https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=200&h=200&fit=crop&auto=format"
                                            alt="Portfolio 3"
                                            class="h-full w-full object-cover transition-transform group-hover/img:scale-110"
                                        />
                                    </div>
                                    <div
                                        class="flex aspect-square items-center justify-center overflow-hidden rounded-xl border-2 border-dashed border-primary/30 bg-gradient-to-br from-primary/20 to-purple-500/20 shadow-lg"
                                    >
                                        <div class="text-center">
                                            <svg class="mx-auto mb-1 h-6 w-6 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                            </svg>
                                            <span class="text-xs font-medium text-primary">Add More</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section id="features" class="relative bg-gradient-to-br from-muted/30 via-background to-muted/20 py-16 sm:py-24 lg:py-32">
            <!-- Background Elements -->
            <div class="absolute inset-0 overflow-hidden">
                <div class="absolute -top-40 -right-32 h-80 w-80 rounded-full bg-gradient-to-br from-primary/5 to-purple-500/5 blur-3xl"></div>
                <div class="absolute -bottom-40 -left-32 h-80 w-80 rounded-full bg-gradient-to-tr from-blue-500/5 to-primary/5 blur-3xl"></div>
            </div>

            <div class="relative mx-auto max-w-7xl px-4 sm:px-6">
                <div class="mx-auto max-w-2xl text-center">
                    <div
                        class="mb-4 inline-flex items-center rounded-full border border-border/50 bg-card/60 px-3 py-1.5 text-xs text-muted-foreground backdrop-blur-sm sm:mb-6 sm:px-4 sm:py-2 sm:text-sm"
                    >
                        🚀 Fitur-fitur unggulan
                    </div>
                    <h2 class="text-2xl font-bold tracking-tight text-foreground sm:text-3xl lg:text-4xl">
                        Fitur Lengkap untuk
                        <span class="bg-gradient-to-r from-primary to-purple-600 bg-clip-text text-transparent">Kebutuhan Digital</span> Anda
                    </h2>
                    <p class="mt-4 px-4 text-base leading-relaxed text-muted-foreground sm:mt-6 sm:px-0 sm:text-lg sm:leading-8">
                        Semua yang Anda butuhkan untuk membangun presence online yang kuat dan profesional
                    </p>
                </div>
                <div class="mx-auto mt-12 max-w-6xl sm:mt-16">
                    <div class="grid grid-cols-1 gap-6 sm:gap-8 md:grid-cols-3">
                        <!-- Feature 1: Easy to Use -->
                        <div
                            class="group relative overflow-hidden rounded-2xl border border-border/70 bg-card/80 backdrop-blur-sm transition-all hover:scale-[1.02] hover:shadow-xl"
                        >
                            <div class="absolute inset-0">
                                <img
                                    src="https://images.unsplash.com/photo-1559526324-4b87b5e36e44?w=600&h=400&fit=crop&auto=format"
                                    alt="Easy to use interface"
                                    class="h-full w-full object-cover opacity-10 transition-opacity group-hover:opacity-15"
                                />
                                <div class="absolute inset-0 bg-gradient-to-br from-primary/5 to-blue-500/5"></div>
                            </div>
                            <div class="relative z-10 p-6 sm:p-8">
                                <div
                                    class="flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-br from-primary/10 to-primary/20 shadow-lg sm:h-16 sm:w-16 sm:rounded-2xl"
                                >
                                    <svg
                                        class="h-6 w-6 text-primary sm:h-8 sm:w-8"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke-width="1.5"
                                        stroke="currentColor"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M9.53 16.122a3 3 0 0 0-5.78 1.128 2.25 2.25 0 0 1-2.4 0 3 3 0 0 0-5.78-1.128 2.25 2.25 0 0 1 0-2.25 3 3 0 0 0 5.78-1.128 2.25 2.25 0 0 1 2.4 0 3 3 0 0 0 5.78 1.128 2.25 2.25 0 0 1 0 2.25Z"
                                        />
                                    </svg>
                                </div>
                                <h3 class="mt-4 text-lg font-bold text-card-foreground sm:mt-6 sm:text-xl">Mudah Digunakan</h3>
                                <p class="mt-2 text-sm leading-relaxed text-muted-foreground sm:mt-3 sm:text-base">
                                    Interface yang intuitif dan user-friendly memungkinkan siapa saja membuat biolink profesional tanpa perlu skill
                                    teknis
                                </p>
                                <div class="mt-4 flex items-center text-sm font-medium text-primary sm:mt-6">
                                    <span>Drag & Drop Builder</span>
                                    <svg
                                        class="ml-2 h-4 w-4 transition-transform group-hover:translate-x-1"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                    >
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <!-- Feature 2: Mobile Responsive -->
                        <div
                            class="group relative overflow-hidden rounded-2xl border border-border/70 bg-card/80 backdrop-blur-sm transition-all hover:scale-[1.02] hover:shadow-xl"
                        >
                            <div class="absolute inset-0">
                                <img
                                    src="https://images.unsplash.com/photo-1512941937669-90a1b58e7e9c?w=600&h=400&fit=crop&auto=format"
                                    alt="Mobile responsive design"
                                    class="h-full w-full object-cover opacity-10 transition-opacity group-hover:opacity-15"
                                />
                                <div class="absolute inset-0 bg-gradient-to-br from-green-500/5 to-emerald-500/5"></div>
                            </div>
                            <div class="relative z-10 p-8">
                                <div
                                    class="flex h-16 w-16 items-center justify-center rounded-2xl bg-gradient-to-br from-green-500/10 to-emerald-500/20 shadow-lg"
                                >
                                    <svg class="h-8 w-8 text-green-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M10.5 1.5H8.25A2.25 2.25 0 0 0 6 3.75v16.5a2.25 2.25 0 0 0 2.25 2.25h7.5A2.25 2.25 0 0 0 18 20.25V3.75a2.25 2.25 0 0 0-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 18.75h3"
                                        />
                                    </svg>
                                </div>
                                <h3 class="mt-6 text-xl font-bold text-card-foreground">Mobile Responsive</h3>
                                <p class="mt-3 leading-relaxed text-muted-foreground">
                                    Biolink Anda akan tampil sempurna di semua device, dari smartphone hingga desktop dengan loading yang super cepat
                                </p>
                                <div class="mt-6 flex items-center gap-4">
                                    <div class="flex items-center text-xs text-green-600">
                                        <div class="mr-2 h-2 w-2 rounded-full bg-green-500"></div>
                                        <span>99% Mobile Optimized</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Feature 3: Advanced Analytics -->
                        <div
                            class="group relative overflow-hidden rounded-2xl border border-border/70 bg-card/80 backdrop-blur-sm transition-all hover:scale-[1.02] hover:shadow-xl"
                        >
                            <div class="absolute inset-0">
                                <img
                                    src="https://images.unsplash.com/photo-1504868584819-f8e8b4b6d7e3?w=600&h=400&fit=crop&auto=format"
                                    alt="Advanced analytics"
                                    class="h-full w-full object-cover opacity-10 transition-opacity group-hover:opacity-15"
                                />
                                <div class="absolute inset-0 bg-gradient-to-br from-purple-500/5 to-pink-500/5"></div>
                            </div>
                            <div class="relative z-10 p-8">
                                <div
                                    class="flex h-16 w-16 items-center justify-center rounded-2xl bg-gradient-to-br from-purple-500/10 to-pink-500/20 shadow-lg"
                                >
                                    <svg class="h-8 w-8 text-purple-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z"
                                        />
                                    </svg>
                                </div>
                                <h3 class="mt-6 text-xl font-bold text-card-foreground">Advanced Analytics</h3>
                                <p class="mt-3 leading-relaxed text-muted-foreground">
                                    Pantau performa biolink dengan analytics mendalam, tracking visitors, dan insights untuk optimasi maksimal
                                </p>
                                <div class="mt-6 grid grid-cols-2 gap-4 text-xs">
                                    <div class="rounded-lg bg-purple-500/10 p-2 text-center">
                                        <div class="font-bold text-purple-600">24/7</div>
                                        <div class="text-muted-foreground">Real-time</div>
                                    </div>
                                    <div class="rounded-lg bg-pink-500/10 p-2 text-center">
                                        <div class="font-bold text-pink-600">50+</div>
                                        <div class="text-muted-foreground">Metrics</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Additional Features Showcase -->
                <div class="mx-auto mt-20 max-w-6xl">
                    <div class="rounded-3xl border border-border/70 bg-card/60 p-8 backdrop-blur-sm md:p-12">
                        <div class="grid grid-cols-1 items-center gap-12 lg:grid-cols-2">
                            <div>
                                <div class="mb-6 inline-flex items-center rounded-full bg-primary/10 px-4 py-2 text-sm font-medium text-primary">
                                    ⚡ Powerful Features
                                </div>
                                <h3 class="mb-6 text-2xl font-bold text-card-foreground">Lebih dari sekedar link dalam bio</h3>
                                <div class="space-y-6">
                                    <div class="flex gap-4">
                                        <div class="flex h-6 w-6 flex-shrink-0 items-center justify-center rounded-full bg-green-500/20">
                                            <svg class="h-3 w-3 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                                <path
                                                    fill-rule="evenodd"
                                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                    clip-rule="evenodd"
                                                />
                                            </svg>
                                        </div>
                                        <div>
                                            <h4 class="font-semibold text-card-foreground">Custom Domain</h4>
                                            <p class="text-sm text-muted-foreground">Gunakan domain sendiri untuk branding yang lebih profesional</p>
                                        </div>
                                    </div>
                                    <div class="flex gap-4">
                                        <div class="flex h-6 w-6 flex-shrink-0 items-center justify-center rounded-full bg-blue-500/20">
                                            <svg class="h-3 w-3 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                                <path
                                                    fill-rule="evenodd"
                                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                    clip-rule="evenodd"
                                                />
                                            </svg>
                                        </div>
                                        <div>
                                            <h4 class="font-semibold text-card-foreground">SEO Optimized</h4>
                                            <p class="text-sm text-muted-foreground">Biolink yang SEO-friendly untuk visibilitas maksimal</p>
                                        </div>
                                    </div>
                                    <div class="flex gap-4">
                                        <div class="flex h-6 w-6 flex-shrink-0 items-center justify-center rounded-full bg-purple-500/20">
                                            <svg class="h-3 w-3 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                                                <path
                                                    fill-rule="evenodd"
                                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                    clip-rule="evenodd"
                                                />
                                            </svg>
                                        </div>
                                        <div>
                                            <h4 class="font-semibold text-card-foreground">Advanced Themes</h4>
                                            <p class="text-sm text-muted-foreground">Puluhan template premium yang siap pakai</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="relative">
                                <div class="aspect-square overflow-hidden rounded-2xl shadow-2xl">
                                    <img
                                        src="https://images.unsplash.com/photo-1586717799252-bd134ad00e26?w=600&h=600&fit=crop&auto=format"
                                        alt="Professional biolink example"
                                        class="h-full w-full object-cover"
                                    />
                                </div>
                                <div
                                    class="absolute -right-6 -bottom-6 flex h-32 w-32 items-center justify-center rounded-2xl border border-border/50 bg-gradient-to-br from-primary/20 to-purple-500/20 backdrop-blur-sm"
                                >
                                    <div class="text-center">
                                        <div class="text-2xl font-bold text-primary">100+</div>
                                        <div class="text-xs text-muted-foreground">Templates</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="relative bg-gradient-to-br from-primary/5 via-background to-purple-500/5 py-16 sm:py-24 lg:py-32">
            <div class="absolute inset-0">
                <img
                    src="https://images.unsplash.com/photo-1519389950473-47ba0277781c?w=1200&h=800&fit=crop&auto=format"
                    alt="Team collaboration"
                    class="h-full w-full object-cover opacity-5"
                />
            </div>
            <div class="relative mx-auto max-w-4xl px-4 text-center sm:px-6">
                <h2 class="text-2xl font-bold tracking-tight text-foreground sm:text-3xl lg:text-5xl">Siap untuk memulai?</h2>
                <p class="mx-auto mt-4 max-w-2xl px-4 text-base leading-relaxed text-muted-foreground sm:mt-6 sm:px-0 sm:text-lg sm:leading-8">
                    Bergabung dengan ribuan creator Indonesia yang sudah mempercayakan biolink mereka kepada kami. Mulai gratis hari ini!
                </p>
                <div class="mt-8 flex flex-col items-center justify-center gap-4 sm:mt-10 sm:flex-row sm:gap-x-6">
                    <Link
                        v-if="!$page.props.auth.user"
                        href="/register"
                        class="group relative w-full overflow-hidden rounded-xl bg-primary px-6 py-3 text-base font-semibold text-primary-foreground shadow-xl transition-all hover:scale-105 hover:bg-primary/90 hover:shadow-2xl sm:w-auto sm:px-8 sm:py-4"
                    >
                        <span class="relative z-10">Buat Biolink Gratis</span>
                        <div
                            class="absolute inset-0 bg-gradient-to-r from-primary to-purple-600 opacity-0 transition-opacity group-hover:opacity-100"
                        ></div>
                    </Link>
                    <Link href="#features" class="group text-base leading-6 font-semibold text-foreground transition-colors hover:text-primary">
                        Lihat Demo <span aria-hidden="true" class="inline-block transition-transform group-hover:translate-x-1">→</span>
                    </Link>
                </div>
                <div class="mt-8 flex flex-col items-center justify-center gap-4 text-sm text-muted-foreground sm:mt-12 sm:flex-row sm:gap-8">
                    <div class="flex items-center gap-2">
                        <svg class="h-4 w-4 flex-shrink-0 text-green-500 sm:h-5 sm:w-5" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                fill-rule="evenodd"
                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                clip-rule="evenodd"
                            />
                        </svg>
                        <span>Gratis selamanya</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <svg class="h-4 w-4 flex-shrink-0 text-green-500 sm:h-5 sm:w-5" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                fill-rule="evenodd"
                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                clip-rule="evenodd"
                            />
                        </svg>
                        <span>Setup 5 menit</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <svg class="h-4 w-4 flex-shrink-0 text-green-500 sm:h-5 sm:w-5" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                fill-rule="evenodd"
                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                clip-rule="evenodd"
                            />
                        </svg>
                        <span>Support 24/7</span>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script setup lang="ts">
import AppLogoIcon from '@/components/AppLogoIcon.vue';
import { Head, Link } from '@inertiajs/vue3';
</script>

<template>
    <Head :title="user.name || 'Profile'">
        <meta name="description" :content="profile.bio || 'Profile page'" />
    </Head>

    <div class="min-h-screen bg-gradient-to-br from-slate-900 via-purple-900 to-slate-900">
        <!-- Background Effects -->
        <div class="absolute inset-0 opacity-40">
            <div class="h-full w-full bg-gradient-to-br from-purple-600/20 via-blue-600/20 to-teal-600/20"></div>
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_50%_50%,rgba(120,119,198,0.3),rgba(255,255,255,0))]"></div>
        </div>

        <div class="relative z-10 mx-auto max-w-7xl p-4 sm:p-6 lg:p-8">
            <!-- Mobile-First Bento Grid -->
            <div class="grid auto-rows-min grid-cols-1 gap-4 sm:grid-cols-2 sm:gap-6 lg:grid-cols-12 lg:gap-8">
                <!-- Profile Card - Full width on mobile, spans multiple columns on desktop -->
                <div class="sm:col-span-2 lg:col-span-4 lg:row-span-2">
                    <div class="h-full rounded-3xl border border-white/20 bg-white/10 p-6 shadow-2xl backdrop-blur-xl sm:p-8">
                        <!-- Avatar -->
                        <div class="relative mx-auto mb-6 h-24 w-24 sm:h-32 sm:w-32">
                            <div class="absolute inset-0 animate-pulse rounded-full bg-gradient-to-r from-purple-400 via-pink-500 to-red-500"></div>
                            <div class="relative h-full w-full p-1">
                                <div class="flex h-full w-full items-center justify-center overflow-hidden rounded-full bg-slate-900">
                                    <img
                                        v-if="profile.avatar || user.avatar"
                                        :src="profile.avatar || user.avatar"
                                        :alt="user.name"
                                        class="h-full w-full rounded-full object-cover"
                                    />
                                    <div v-else class="text-2xl font-bold text-white sm:text-3xl">
                                        {{ user.name?.[0]?.toUpperCase() || 'U' }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Name & Title -->
                        <div class="mb-6 text-center">
                            <h1 class="mb-2 text-xl font-bold text-white sm:text-2xl lg:text-3xl">
                                {{ profile.display_name || user.name }}
                            </h1>
                            <p v-if="profile.tagline" class="text-sm font-medium text-purple-300 sm:text-base">
                                {{ profile.tagline }}
                            </p>
                            <p v-if="profile.location" class="mt-1 flex items-center justify-center gap-1 text-xs text-white/60 sm:text-sm">
                                <svg class="h-3 w-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        fill-rule="evenodd"
                                        d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                                        clip-rule="evenodd"
                                    />
                                </svg>
                                {{ profile.location }}
                            </p>
                        </div>

                        <!-- Bio -->
                        <p v-if="profile.bio" class="mb-6 text-center text-sm leading-relaxed text-white/80 sm:text-base">
                            {{ profile.bio }}
                        </p>

                        <!-- Social Media Icons -->
                        <div v-if="uniqueSocialMediaLinks.length > 0" class="mb-6 flex flex-wrap justify-center gap-3">
                            <a
                                v-for="social in uniqueSocialMediaLinks"
                                :key="social.id"
                                :href="`/link/redirect/${social.id}`"
                                target="_blank"
                                :title="getSocialPlatformName(social)"
                                class="flex h-10 w-10 items-center justify-center rounded-full border border-white/30 bg-white/10 text-white transition-all duration-200 hover:scale-110 hover:bg-white/20 hover:shadow-lg"
                            >
                                <component :is="getSocialIcon(social)" class="h-5 w-5" />
                            </a>
                        </div>

                        <!-- Stats -->
                        <div class="flex items-center justify-center border-t border-white/10 pt-4">
                            <div class="text-center">
                                <div class="text-sm font-medium text-white/60">{{ formatNumber(profile.view_count) }} views</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions Card -->
                <div class="sm:col-span-1 lg:col-span-4">
                    <div class="h-full rounded-3xl border border-white/20 bg-white/10 p-6 shadow-2xl backdrop-blur-xl">
                        <h2 class="mb-4 flex items-center gap-2 text-lg font-bold text-white">
                            <div class="flex h-6 w-6 items-center justify-center rounded-lg bg-gradient-to-r from-blue-500 to-cyan-500">
                                <svg class="h-3 w-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            Quick Actions
                        </h2>

                        <div class="space-y-3">
                            <button
                                class="flex w-full items-center gap-3 rounded-xl border border-white/20 bg-white/10 p-3 text-sm text-white transition-colors duration-200 hover:bg-white/20"
                            >
                                <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M15 8a3 3 0 10-2.977-2.63l-4.94 2.47a3 3 0 100 4.319l4.94 2.47a3 3 0 10.895-1.789l-4.94-2.47a3.027 3.027 0 000-.74l4.94-2.47C13.456 7.68 14.19 8 15 8z"
                                    />
                                </svg>
                                Share Profile
                            </button>
                            <button
                                class="flex w-full items-center gap-3 rounded-xl border border-white/20 bg-white/10 p-3 text-sm text-white transition-colors duration-200 hover:bg-white/20"
                            >
                                <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        fill-rule="evenodd"
                                        d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm5 6a1 1 0 10-2 0v3.586l-1.293-1.293a1 1 0 10-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 11.586V8z"
                                        clip-rule="evenodd"
                                    />
                                </svg>
                                Save Contact
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Main Links Section -->
                <div class="sm:col-span-2 lg:col-span-12">
                    <div class="rounded-3xl border border-white/20 bg-white/10 p-6 shadow-2xl backdrop-blur-xl">
                        <h2 class="mb-6 flex items-center gap-2 text-xl font-bold text-white">
                            <div class="flex h-6 w-6 items-center justify-center rounded-lg bg-gradient-to-r from-green-500 to-emerald-500">
                                <svg class="h-3 w-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        fill-rule="evenodd"
                                        d="M12.586 4.586a2 2 0 112.828 2.828l-3 3a2 2 0 01-2.828 0 1 1 0 00-1.414 1.414 4 4 0 005.656 0l3-3a4 4 0 00-5.656-5.656l-1.5 1.5a1 1 0 101.414 1.414l1.5-1.5zm-5 5a2 2 0 012.828 0 1 1 0 101.414-1.414 4 4 0 00-5.656 0l-3 3a4 4 0 105.656 5.656l1.5-1.5a1 1 0 10-1.414-1.414l-1.5 1.5a2 2 0 11-2.828-2.828l3-3z"
                                        clip-rule="evenodd"
                                    />
                                </svg>
                            </div>
                            Links & Projects
                        </h2>

                        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                            <!-- Regular Links -->
                            <div
                                v-for="link in displayLinks"
                                :key="link.id"
                                class="group relative rounded-2xl border border-white/10 bg-white/5 transition-all duration-300 hover:scale-[1.02] hover:bg-white/15 hover:shadow-lg"
                            >
                                <!-- Embedded Content -->
                                <div v-if="link.show_as_embed" class="p-4">
                                    <!-- Embed Header -->
                                    <div class="mb-4 flex items-center justify-between">
                                        <h3 class="text-sm font-semibold text-white sm:text-base">{{ link.title }}</h3>
                                        <a
                                            :href="`/link/redirect/${link.id}`"
                                            target="_blank"
                                            class="rounded-lg bg-white/20 px-3 py-1 text-xs text-white transition-colors duration-200 hover:bg-white/30"
                                        >
                                            Open
                                        </a>
                                    </div>

                                    <!-- Embed Content -->
                                    <div class="overflow-hidden rounded-lg bg-black/20">
                                        <div v-html="link.embed_html" class="aspect-video w-full"></div>
                                    </div>
                                </div>

                                <!-- Regular Link -->
                                <a v-else :href="`/link/redirect/${link.id}`" target="_blank" class="block p-4">
                                    <!-- Gradient overlay on hover -->
                                    <div
                                        class="absolute inset-0 rounded-2xl bg-gradient-to-br from-white/10 to-transparent opacity-0 transition-opacity duration-300 group-hover:opacity-100"
                                    ></div>

                                    <div class="relative flex items-start gap-4">
                                        <!-- Icon -->
                                        <div
                                            class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-xl bg-gradient-to-br from-white/20 to-white/10 transition-transform duration-300 group-hover:scale-110"
                                        >
                                            <component :is="getLinkIcon(link.type)" class="h-6 w-6 text-white" />
                                        </div>

                                        <!-- Content -->
                                        <div class="min-w-0 flex-1">
                                            <h3
                                                class="mb-1 text-sm font-semibold text-white transition-colors duration-300 group-hover:text-purple-300 sm:text-base"
                                            >
                                                {{ link.title }}
                                            </h3>
                                            <p v-if="link.description" class="text-xs leading-relaxed text-white/60 sm:text-sm">
                                                {{ link.description }}
                                            </p>
                                        </div>

                                        <!-- Arrow -->
                                        <div
                                            class="flex-shrink-0 opacity-60 transition-all duration-300 group-hover:translate-x-1 group-hover:opacity-100"
                                        >
                                            <svg class="h-5 w-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                <path
                                                    fill-rule="evenodd"
                                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                                    clip-rule="evenodd"
                                                />
                                            </svg>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Portfolio Showcase -->
                <div v-if="portfolios.length > 0" class="sm:col-span-2 lg:col-span-12">
                    <div class="rounded-2xl border border-white/10 bg-white/5 p-6">
                        <h2 class="mb-6 flex items-center gap-3 text-lg font-semibold text-white">
                            <div class="flex h-8 w-8 items-center justify-center rounded-xl bg-gradient-to-br from-orange-500 to-red-500">
                                <svg class="h-4 w-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        fill-rule="evenodd"
                                        d="M3 4a2 2 0 00-2 2v10a2 2 0 002 2h14a2 2 0 002-2V6a2 2 0 00-2-2H3zm2 4a1 1 0 011-1h1a1 1 0 011 1v1a1 1 0 01-1 1H6a1 1 0 01-1-1V8zM6 10a2 2 0 100 4 2 2 0 000-4zm8-4a1 1 0 00-1 1v2a1 1 0 002 0V7a1 1 0 00-1-1z"
                                        clip-rule="evenodd"
                                    />
                                </svg>
                            </div>
                            Portfolio Showcase
                        </h2>

                        <!-- Bento Grid Layout -->
                        <div class="grid auto-rows-[200px] grid-cols-12 gap-3">
                            <div
                                v-for="(portfolio, index) in portfolios.slice(0, 8)"
                                :key="portfolio.id"
                                @click="openPortfolio(portfolio)"
                                :class="getBentoGridClass(index, portfolios.length)"
                                class="group relative cursor-pointer overflow-hidden rounded-xl border border-white/10 bg-white/5 transition-all duration-300 hover:scale-[1.02] hover:border-white/20 hover:bg-white/10"
                            >
                                <!-- Portfolio Image -->
                                <div class="absolute inset-0">
                                    <img
                                        :src="getPortfolioImage(portfolio)"
                                        :alt="portfolio.title"
                                        class="h-full w-full object-cover transition-all duration-500 group-hover:scale-110"
                                    />
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent"></div>
                                </div>

                                <!-- Portfolio Content -->
                                <div class="absolute right-0 bottom-0 left-0 p-4">
                                    <h3 class="mb-1 text-sm font-medium text-white transition-colors duration-300 group-hover:text-orange-300">
                                        {{ portfolio.title }}
                                    </h3>
                                    <p v-if="portfolio.description" class="line-clamp-2 text-xs leading-relaxed text-white/70">
                                        {{ portfolio.description }}
                                    </p>
                                </div>

                                <!-- Hover Overlay -->
                                <div
                                    class="absolute inset-0 bg-gradient-to-t from-orange-500/20 to-transparent opacity-0 transition-opacity duration-300 group-hover:opacity-100"
                                ></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Portfolio Modal -->
        <div v-if="selectedPortfolio" class="fixed inset-0 z-50 flex items-center justify-center bg-black/70 p-4" @click="closePortfolio">
            <div @click.stop class="max-h-[90vh] w-full max-w-3xl overflow-y-auto rounded-2xl border border-gray-200 bg-white shadow-xl">
                <div class="p-6 sm:p-8">
                    <div class="mb-6 flex items-start justify-between">
                        <h3 class="text-xl font-semibold text-gray-900 sm:text-2xl">{{ selectedPortfolio.title }}</h3>
                        <button @click="closePortfolio" class="rounded-lg p-2 text-gray-400 transition-colors hover:bg-gray-50 hover:text-gray-600">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <div class="mb-6 overflow-hidden rounded-xl border border-gray-100">
                        <img :src="getPortfolioImage(selectedPortfolio)" :alt="selectedPortfolio.title" class="h-auto w-full object-cover" />
                    </div>

                    <div v-if="selectedPortfolio.description" class="mb-8">
                        <p class="leading-relaxed text-gray-600">{{ selectedPortfolio.description }}</p>
                    </div>

                    <div v-if="selectedPortfolio.link" class="flex justify-start">
                        <a
                            :href="selectedPortfolio.link"
                            target="_blank"
                            class="inline-flex items-center gap-2 rounded-lg bg-gray-900 px-6 py-3 text-sm font-medium text-white transition-all duration-200 hover:scale-105 hover:bg-gray-800"
                        >
                            <span>View Project</span>
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"
                                ></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import FacebookIcon from '@/components/icons/FacebookIcon.vue';
import GitHubIcon from '@/components/icons/GitHubIcon.vue';
import InstagramIcon from '@/components/icons/InstagramIcon.vue';
import LinkedInIcon from '@/components/icons/LinkedInIcon.vue';
import SpotifyIcon from '@/components/icons/SpotifyIcon.vue';
import TikTokIcon from '@/components/icons/TikTokIcon.vue';
import TwitterIcon from '@/components/icons/TwitterIcon.vue';
import YouTubeIcon from '@/components/icons/YouTubeIcon.vue';
import { Head } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

interface LinkItem {
    id: number;
    title: string;
    url: string;
    description?: string;
    type: string;
    show_as_embed?: boolean;
    embed_type?: string;
    embed_data?: any;
    embed_html?: string;
    platform?: string;
}

interface PortfolioItem {
    id: number;
    title: string;
    description?: string;
    link?: string;
    image?: string;
}

interface User {
    id: number;
    name: string;
    email: string;
    avatar?: string;
}

interface Profile {
    bio?: string;
    view_count: number;
    avatar?: string;
    display_name?: string;
    tagline?: string;
    location?: string;
}

interface Props {
    user: User;
    profile: Profile;
    links: LinkItem[];
    portfolios: PortfolioItem[];
}

const props = defineProps<Props>();

const selectedPortfolio = ref<PortfolioItem | null>(null);

// Helper function to detect social platform from URL
const detectSocialPlatform = (url: string): string | null => {
    const urlLower = url.toLowerCase();
    if (urlLower.includes('instagram.com')) return 'instagram';
    if (urlLower.includes('twitter.com') || urlLower.includes('x.com')) return 'twitter';
    if (urlLower.includes('youtube.com') || urlLower.includes('youtu.be')) return 'youtube';
    if (urlLower.includes('tiktok.com')) return 'tiktok';
    if (urlLower.includes('linkedin.com')) return 'linkedin';
    if (urlLower.includes('facebook.com')) return 'facebook';
    if (urlLower.includes('github.com')) return 'github';
    if (urlLower.includes('spotify.com')) return 'spotify';
    return null;
};

// Helper function to detect YouTube embeddable content
const isYouTubeEmbeddable = (url: string): boolean => {
    const urlLower = url.toLowerCase();
    return urlLower.includes('youtube.com/watch') || urlLower.includes('youtu.be/') || urlLower.includes('youtube.com/embed/');
};

// Helper function to extract YouTube video ID
const extractYouTubeVideoId = (url: string): string | null => {
    const patterns = [
        /(?:youtube\.com\/watch\?v=|youtu\.be\/|youtube\.com\/embed\/)([a-zA-Z0-9_-]{11})/,
        /youtube\.com\/watch\?.*v=([a-zA-Z0-9_-]{11})/,
    ];

    for (const pattern of patterns) {
        const match = url.match(pattern);
        if (match) return match[1];
    }
    return null;
};

// Filter social media links and ensure only one per platform
const uniqueSocialMediaLinks = computed(() => {
    const socialLinks = props.links.filter((link) => link.type === 'social');
    const platformMap = new Map<string, LinkItem>();

    socialLinks.forEach((link) => {
        const platform = detectSocialPlatform(link.url);
        if (platform && !platformMap.has(platform)) {
            platformMap.set(platform, link);
        }
    });

    return Array.from(platformMap.values());
});

// Process all links for display - handle YouTube auto-detection and embedding
const displayLinks = computed(() => {
    const processed = props.links
        .filter((link) => link.type !== 'social')
        .map((link) => {
            // Auto-detect YouTube links that aren't marked as social
            if (link.type !== 'social' && isYouTubeEmbeddable(link.url)) {
                const videoId = extractYouTubeVideoId(link.url);
                if (videoId) {
                    return {
                        ...link,
                        show_as_embed: true,
                        embed_type: 'youtube',
                        embed_html: `<iframe width="100%" height="100%" src="https://www.youtube.com/embed/${videoId}" frameborder="0" allowfullscreen></iframe>`,
                    };
                }
            }
            return link;
        });

    return processed;
});

// Filter social media links (for backward compatibility)
const socialMediaLinks = computed(() => {
    return uniqueSocialMediaLinks.value;
});

// Filter regular links (non-social media) - now handled by displayLinks
const regularLinks = computed(() => {
    return displayLinks.value;
});

const formatNumber = (num: number): string => {
    if (num >= 1000000) {
        return (num / 1000000).toFixed(1).replace(/\.0$/, '') + 'M';
    }
    if (num >= 1000) {
        return (num / 1000).toFixed(1).replace(/\.0$/, '') + 'K';
    }
    return num.toString();
};

const openPortfolio = (portfolio: PortfolioItem) => {
    selectedPortfolio.value = portfolio;
};

const closePortfolio = () => {
    selectedPortfolio.value = null;
};

const getPortfolioImage = (portfolio: PortfolioItem) => {
    // Use uploaded image if available, otherwise fall back to stock images
    if (portfolio.image) {
        return `/storage/${portfolio.image}`;
    }

    const stockImages = [
        'https://images.unsplash.com/photo-1517077304055-6e89abbf09b0?w=800&h=600&fit=crop',
        'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=800&h=600&fit=crop',
        'https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=800&h=600&fit=crop',
        'https://images.unsplash.com/photo-1486312338219-ce68d2c6f44d?w=800&h=600&fit=crop',
        'https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=800&h=600&fit=crop',
        'https://images.unsplash.com/photo-1559526324-4b87b5e36e44?w=800&h=600&fit=crop',
        'https://images.unsplash.com/photo-1504805572947-34fad45aed93?w=800&h=600&fit=crop',
        'https://images.unsplash.com/photo-1581291518633-83b4ebd1d83e?w=800&h=600&fit=crop',
        'https://images.unsplash.com/photo-1557804506-669a67965ba0?w=800&h=600&fit=crop',
        'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=800&h=600&fit=crop',
    ];

    return stockImages[portfolio.id % stockImages.length];
};

const getLinkIcon = (type: string) => {
    const iconMap = {
        portfolio: {
            template: `<svg class="h-6 w-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6 6V5a3 3 0 013-3h2a3 3 0 013 3v1h2a2 2 0 012 2v3.57A22.952 22.952 0 0110 13a22.95 22.95 0 01-8-1.43V8a2 2 0 012-2h2zm2-1a1 1 0 011-1h2a1 1 0 011 1v1H8V5zm1 5a1 1 0 011-1h.01a1 1 0 110 2H10a1 1 0 01-1-1z" clip-rule="evenodd" /></svg>`,
        },
        custom: {
            template: `<svg class="h-6 w-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M12.586 4.586a2 2 0 112.828 2.828l-3 3a2 2 0 01-2.828 0 1 1 0 00-1.414 1.414 4 4 0 005.656 0l3-3a4 4 0 00-5.656-5.656l-1.5 1.5a1 1 0 101.414 1.414l1.5-1.5zm-5 5a2 2 0 012.828 0 1 1 0 101.414-1.414 4 4 0 00-5.656 0l-3 3a4 4 0 105.656 5.656l1.5-1.5a1 1 0 10-1.414-1.414l-1.5 1.5a2 2 0 11-2.828-2.828l3-3z" clip-rule="evenodd" /></svg>`,
        },
        deeplink: {
            template: `<svg class="h-6 w-6" fill="currentColor" viewBox="0 0 20 20"><path d="M11 3a1 1 0 100 2h2.586l-6.293 6.293a1 1 0 101.414 1.414L15 6.414V9a1 1 0 102 0V4a1 1 0 00-1-1h-5z" /><path d="M5 5a2 2 0 00-2 2v8a2 2 0 002 2h8a2 2 0 002-2v-3a1 1 0 10-2 0v3H5V7h3a1 1 0 000-2H5z" /></svg>`,
        },
    };

    // Check if it's a YouTube embed
    if (type === 'custom') {
        // You can add more specific logic here if needed
        return iconMap.custom;
    }

    return iconMap[type] || iconMap.custom;
};

const getSocialIcon = (social: LinkItem) => {
    const url = social.url.toLowerCase();

    if (url.includes('instagram.com')) {
        return InstagramIcon;
    } else if (url.includes('twitter.com') || url.includes('x.com')) {
        return TwitterIcon;
    } else if (url.includes('youtube.com')) {
        return YouTubeIcon;
    } else if (url.includes('tiktok.com')) {
        return TikTokIcon;
    } else if (url.includes('linkedin.com')) {
        return LinkedInIcon;
    } else if (url.includes('facebook.com')) {
        return FacebookIcon;
    } else if (url.includes('github.com')) {
        return GitHubIcon;
    } else if (url.includes('spotify.com')) {
        return SpotifyIcon;
    }

    // Default social icon (generic)
    return {
        template: `<svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
            <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
        </svg>`,
    };
};

const getSocialPlatformName = (social: LinkItem): string => {
    const url = social.url.toLowerCase();

    if (url.includes('instagram.com')) return 'Instagram';
    if (url.includes('twitter.com') || url.includes('x.com')) return 'Twitter';
    if (url.includes('youtube.com')) return 'YouTube';
    if (url.includes('tiktok.com')) return 'TikTok';
    if (url.includes('linkedin.com')) return 'LinkedIn';
    if (url.includes('facebook.com')) return 'Facebook';
    if (url.includes('github.com')) return 'GitHub';
    if (url.includes('spotify.com')) return 'Spotify';

    return social.platform || social.title || 'Social';
};

const getBentoGridClass = (index: number, totalItems: number): string => {
    // Base classes for all items
    const baseClasses = '';

    // Bento grid patterns based on index position
    const patterns = [
        // First item - large feature (takes up more space)
        'col-span-12 sm:col-span-6 lg:col-span-6 row-span-2',
        // Second item - medium
        'col-span-6 sm:col-span-3 lg:col-span-3 row-span-1',
        // Third item - medium
        'col-span-6 sm:col-span-3 lg:col-span-3 row-span-1',
        // Fourth item - tall
        'col-span-6 sm:col-span-3 lg:col-span-3 row-span-2',
        // Fifth item - medium
        'col-span-6 sm:col-span-3 lg:col-span-3 row-span-1',
        // Sixth item - wide
        'col-span-12 sm:col-span-6 lg:col-span-6 row-span-1',
        // Seventh item - small
        'col-span-6 sm:col-span-3 lg:col-span-3 row-span-1',
        // Eighth item - small
        'col-span-6 sm:col-span-3 lg:col-span-3 row-span-1',
    ];

    // Get pattern for current index, fallback to default for more items
    const pattern = patterns[index] || 'col-span-6 sm:col-span-4 lg:col-span-3 row-span-1';

    return `${baseClasses} ${pattern}`;
};
</script>

<style scoped>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>

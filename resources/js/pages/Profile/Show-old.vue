<template>
    <Head :title="user.name || 'Profile'">
        <meta name="description" :content="profile.bio || 'Profile page'" />
    </Head>

    <div class="min-h-screen transition-all duration-300" :style="{ backgroundColor: '#1a1a1a' }">
        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-5">
            <div class="h-full w-full bg-gradient-to-br from-purple-500 via-blue-500 to-teal-500"></div>
        </div>

        <div class="relative z-10 mx-auto max-w-4xl px-4 py-8">
            <!-- Profile Header Card -->
            <div class="mb-8 overflow-hidden rounded-3xl border border-white/20 bg-white/10 shadow-2xl backdrop-blur-md">
                <div class="p-8 text-center">
                    <!-- Avatar -->
                    <div class="mx-auto mb-6 h-32 w-32 overflow-hidden rounded-full bg-gradient-to-br from-purple-400 to-blue-500 p-1 shadow-xl">
                        <div class="flex h-full w-full items-center justify-center rounded-full bg-white/90">
                            <img
                                v-if="profile.avatar_url || user.avatar"
                                :src="profile.avatar_url || user.avatar"
                                :alt="user.name"
                                class="h-full w-full rounded-full object-cover"
                            />
                            <div v-else class="text-3xl font-bold text-gray-600">
                                {{ user.name?.[0]?.toUpperCase() || 'U' }}
                            </div>
                        </div>
                    </div>

                    <!-- Name & Bio -->
                    <h1 class="mb-3 text-3xl font-bold text-white">{{ user.name }}</h1>
                    <p v-if="profile.bio" class="mx-auto mb-4 max-w-2xl leading-relaxed text-white/80">
                        {{ profile.bio }}
                    </p>

                    <!-- Social Media Icons -->
                    <div v-if="socialMediaLinks.length > 0" class="mb-6 flex justify-center gap-3 flex-wrap">
                        <a 
                            v-for="social in socialMediaLinks" 
                            :key="social.id"
                            :href="`/link/redirect/${social.id}`"
                            target="_blank"
                            :title="getSocialPlatformName(social)"
                            class="flex items-center justify-center h-12 w-12 rounded-full border border-white/30 bg-white/10 text-white transition-all duration-200 hover:bg-white/20 hover:shadow-lg hover:scale-110"
                        >
                            <component :is="getSocialIcon(social)" class="h-6 w-6" />
                        </a>
                    </div>

                    <!-- View Count (smaller) -->
                    <div class="flex justify-center text-white/60">
                        <div class="text-center">
                            <div class="text-sm font-medium">{{ formatNumber(profile.view_count) }} views</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bento Grid Layout -->
            <div class="grid grid-cols-1 gap-6 md:grid-cols-12">
                <!-- Links Section - Main Column -->
                <div class="md:col-span-5">
                    <div class="space-y-4">
                        <h2 class="mb-4 flex items-center text-xl font-bold text-white">
                            <svg class="mr-2 h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    fill-rule="evenodd"
                                    d="M12.586 4.586a2 2 0 112.828 2.828l-3 3a2 2 0 01-2.828 0 1 1 0 00-1.414 1.414 4 4 0 005.656 0l3-3a4 4 0 00-5.656-5.656l-1.5 1.5a1 1 0 101.414 1.414l1.5-1.5zm-5 5a2 2 0 012.828 0 1 1 0 101.414-1.414 4 4 0 00-5.656 0l-3 3a4 4 0 105.656 5.656l1.5-1.5a1 1 0 10-1.414-1.414l-1.5 1.5a2 2 0 11-2.828-2.828l3-3z"
                                    clip-rule="evenodd"
                                />
                            </svg>
                            Links
                        </h2>

                        <!-- Link items -->
                        <div
                            v-for="link in regularLinks"
                            :key="link.id"
                            class="group block w-full"
                        >
                            <!-- Regular Link -->
                            <a
                                v-if="!link.show_as_embed"
                                :href="`/link/redirect/${link.id}`"
                                target="_blank"
                                class="group block w-full"
                            >
                                <div
                                    class="flex items-center gap-4 rounded-xl border border-white/20 bg-white/10 p-4 transition-all duration-300 hover:bg-white/20 hover:shadow-lg hover:shadow-black/20"
                                >
                                    <!-- Icon -->
                                    <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-lg bg-white/20">
                                        <component :is="getLinkIcon(link.type)" class="h-6 w-6 text-white" />
                                    </div>

                                    <!-- Link Content -->
                                    <div class="min-w-0 flex-1">
                                        <h3 class="font-semibold text-white transition-colors group-hover:text-purple-200">
                                            {{ link.title }}
                                        </h3>
                                        <p v-if="link.description" class="truncate text-sm text-white/70 transition-colors group-hover:text-white/80">
                                            {{ link.description }}
                                        </p>
                                    </div>

                                    <!-- Arrow -->
                                    <div class="flex-shrink-0">
                                        <svg
                                            class="h-5 w-5 text-white/50 transition-all group-hover:translate-x-1 group-hover:text-white/80"
                                            fill="currentColor"
                                            viewBox="0 0 20 20"
                                        >
                                            <path
                                                fill-rule="evenodd"
                                                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                                clip-rule="evenodd"
                                            />
                                        </svg>
                                    </div>
                                </div>
                            </a>

                            <!-- Embedded Content -->
                            <div
                                v-else
                                class="rounded-xl border border-white/20 bg-white/10 p-4"
                            >
                                <!-- Embed Header -->
                                <div class="mb-4 flex items-center justify-between">
                                    <h3 class="font-semibold text-white">{{ link.title }}</h3>
                                    <a
                                        :href="`/link/redirect/${link.id}`"
                                        target="_blank"
                                        class="rounded-lg bg-white/20 px-3 py-1 text-sm text-white hover:bg-white/30"
                                    >
                                        Open
                                    </a>
                                </div>

                                <!-- Embed Content -->
                                <div class="overflow-hidden rounded-lg bg-black/20">
                                    <div v-html="link.embed_html" class="aspect-video w-full"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Portfolio Side Column -->
                <div class="md:col-span-7">
                    <div class="grid grid-cols-1 gap-6">
                        <!-- Portfolio -->
                        <div v-if="portfolios.length > 0" class="space-y-6">
                            <h2 class="mb-4 flex items-center text-xl font-bold text-white">
                                <svg class="mr-2 h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        fill-rule="evenodd"
                                        d="M3 4a2 2 0 00-2 2v10a2 2 0 002 2h14a2 2 0 002-2V6a2 2 0 00-2-2H3zm2 4a1 1 0 011-1h1a1 1 0 011 1v1a1 1 0 01-1 1H6a1 1 0 01-1-1V8zM6 10a2 2 0 100 4 2 2 0 000-4zm8-4a1 1 0 00-1 1v2a1 1 0 002 0V7a1 1 0 00-1-1z"
                                        clip-rule="evenodd"
                                    />
                                </svg>
                                Portfolio
                            </h2>

                            <!-- Portfolio Grid -->
                            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                <div
                                    v-for="portfolio in portfolios"
                                    :key="portfolio.id"
                                    @click="openPortfolio(portfolio)"
                                    class="group cursor-pointer overflow-hidden rounded-xl border border-white/20 bg-white/10 transition-all duration-300 hover:scale-[1.02] hover:bg-white/20 hover:shadow-lg"
                                >
                                    <!-- Portfolio Image -->
                                    <div class="aspect-video overflow-hidden bg-gradient-to-br from-purple-500/20 to-blue-500/20">
                                        <img
                                            :src="getPortfolioStockImage(portfolio.id)"
                                            :alt="portfolio.title"
                                            class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-105"
                                        />
                                    </div>

                                    <!-- Portfolio Content -->
                                    <div class="p-4">
                                        <h3 class="mb-2 font-semibold text-white transition-colors group-hover:text-purple-200">
                                            {{ portfolio.title }}
                                        </h3>
                                        <p v-if="portfolio.description" class="line-clamp-2 text-sm text-white/70">
                                            {{ portfolio.description }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Portfolio Modal -->
        <div v-if="selectedPortfolio" class="fixed inset-0 z-50 flex items-center justify-center bg-black/80 px-4" @click="closePortfolio">
            <div @click.stop class="max-h-[90vh] w-full max-w-3xl overflow-y-auto rounded-2xl bg-white shadow-2xl">
                <div class="p-6">
                    <div class="mb-4 flex items-start justify-between">
                        <h3 class="text-2xl font-bold text-gray-900">{{ selectedPortfolio.title }}</h3>
                        <button @click="closePortfolio" class="rounded-lg p-2 text-gray-500 transition-colors hover:bg-gray-100 hover:text-gray-700">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <img
                        :src="getPortfolioStockImage(selectedPortfolio.id)"
                        :alt="selectedPortfolio.title"
                        class="mb-4 w-full rounded-xl shadow-lg"
                    />

                    <p v-if="selectedPortfolio.description" class="mb-6 leading-relaxed text-gray-700">{{ selectedPortfolio.description }}</p>

                    <a
                        v-if="selectedPortfolio.link"
                        :href="selectedPortfolio.link"
                        target="_blank"
                        class="inline-flex items-center rounded-xl bg-gradient-to-r from-purple-600 to-blue-600 px-6 py-3 text-white shadow-lg transition-all duration-300 hover:from-purple-700 hover:to-blue-700 hover:shadow-xl"
                    >
                        Lihat Project
                        <svg class="ml-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
</template>

<script setup lang="ts">
import { Head, router } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import InstagramIcon from '@/components/icons/InstagramIcon.vue';
import TwitterIcon from '@/components/icons/TwitterIcon.vue';
import YouTubeIcon from '@/components/icons/YouTubeIcon.vue';
import TikTokIcon from '@/components/icons/TikTokIcon.vue';
import LinkedInIcon from '@/components/icons/LinkedInIcon.vue';
import FacebookIcon from '@/components/icons/FacebookIcon.vue';
import GitHubIcon from '@/components/icons/GitHubIcon.vue';
import SpotifyIcon from '@/components/icons/SpotifyIcon.vue';

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
    avatar_url?: string;
}

interface Props {
    user: User;
    profile: Profile;
    links: LinkItem[];
    portfolios: PortfolioItem[];
}

const props = defineProps<Props>();

const selectedPortfolio = ref<PortfolioItem | null>(null);

// Filter social media links
const socialMediaLinks = computed(() => {
    return props.links.filter(link => link.type === 'social');
});

// Filter regular links (non-social media)
const regularLinks = computed(() => {
    return props.links.filter(link => link.type !== 'social');
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

const getPortfolioStockImage = (portfolioId: number) => {
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

    return stockImages[portfolioId % stockImages.length];
};

const getLinkIcon = (type: string) => {
    return 'svg'; // Will be replaced by dynamic icons based on type
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
        template: `<svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24">
            <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
        </svg>`
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
</script>

<style scoped>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>

<template>
    <Head :title="user.name || 'Profile'">
        <meta name="description" :content="profile.bio || 'Profile page'" />
    </Head>

    <div class="min-h-screen bg-gradient-to-br from-slate-900 via-purple-900 to-slate-900">
        <!-- Background Effects -->
        <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg%20width%3D%2260%22%20height%3D%2260%22%20viewBox%3D%220%200%2060%2060%22%20xmlns%3D%22http%3A//www.w3.org/2000/svg%22%3E%3Cg%20fill%3D%22none%22%20fill-rule%3D%22evenodd%22%3E%3Cg%20fill%3D%22%239C92AC%22%20fill-opacity%3D%220.05%22%3E%3Ccircle%20cx%3D%2230%22%20cy%3D%2230%22%20r%3D%221%22/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')] opacity-40"></div>
        
        <div class="relative z-10 mx-auto max-w-7xl p-4 sm:p-6 lg:p-8">
            <!-- Mobile-First Bento Grid -->
            <div class="grid gap-4 sm:gap-6 lg:gap-8 grid-cols-1 sm:grid-cols-2 lg:grid-cols-12 auto-rows-min">
                
                <!-- Profile Card - Full width on mobile, spans multiple columns on desktop -->
                <div class="sm:col-span-2 lg:col-span-4 lg:row-span-2">
                    <div class="h-full rounded-3xl bg-white/10 backdrop-blur-xl border border-white/20 p-6 sm:p-8 shadow-2xl">
                        <!-- Avatar -->
                        <div class="relative mb-6 mx-auto w-24 h-24 sm:w-32 sm:h-32">
                            <div class="absolute inset-0 rounded-full bg-gradient-to-r from-purple-400 via-pink-500 to-red-500 animate-pulse"></div>
                            <div class="relative h-full w-full p-1">
                                <div class="h-full w-full rounded-full bg-slate-900 flex items-center justify-center overflow-hidden">
                                    <img
                                        v-if="profile.avatar || user.avatar"
                                        :src="profile.avatar || user.avatar"
                                        :alt="user.name"
                                        class="h-full w-full rounded-full object-cover"
                                    />
                                    <div v-else class="text-2xl sm:text-3xl font-bold text-white">
                                        {{ user.name?.[0]?.toUpperCase() || 'U' }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Name & Title -->
                        <div class="text-center mb-6">
                            <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold text-white mb-2">
                                {{ profile.display_name || user.name }}
                            </h1>
                            <p v-if="profile.tagline" class="text-purple-300 text-sm sm:text-base font-medium">
                                {{ profile.tagline }}
                            </p>
                            <p v-if="profile.location" class="text-white/60 text-xs sm:text-sm mt-1 flex items-center justify-center gap-1">
                                <svg class="h-3 w-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                                </svg>
                                {{ profile.location }}
                            </p>
                        </div>

                        <!-- Bio -->
                        <p v-if="profile.bio" class="text-white/80 text-sm sm:text-base leading-relaxed text-center mb-6">
                            {{ profile.bio }}
                        </p>

                        <!-- Stats -->
                        <div class="flex justify-center items-center gap-4 pt-4 border-t border-white/10">
                            <div class="text-center">
                                <div class="text-lg sm:text-xl font-bold text-white">{{ formatNumber(profile.view_count) }}</div>
                                <div class="text-xs text-white/60">Views</div>
                            </div>
                            <div class="w-px h-8 bg-white/20"></div>
                            <div class="text-center">
                                <div class="text-lg sm:text-xl font-bold text-white">{{ socialMediaLinks.length + regularLinks.length }}</div>
                                <div class="text-xs text-white/60">Links</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Social Media Grid - 2x3 on mobile, elegant layout on desktop -->
                <div v-if="socialMediaLinks.length > 0" class="sm:col-span-2 lg:col-span-4">
                    <div class="rounded-3xl bg-white/10 backdrop-blur-xl border border-white/20 p-6 shadow-2xl h-full">
                        <h2 class="text-white font-bold text-lg mb-4 flex items-center gap-2">
                            <div class="h-6 w-6 rounded-lg bg-gradient-to-r from-purple-500 to-pink-500 flex items-center justify-center">
                                <svg class="h-3 w-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M15 8a3 3 0 10-2.977-2.63l-4.94 2.47a3 3 0 100 4.319l4.94 2.47a3 3 0 10.895-1.789l-4.94-2.47a3.027 3.027 0 000-.74l4.94-2.47C13.456 7.68 14.19 8 15 8z" />
                                </svg>
                            </div>
                            Social
                        </h2>
                        
                        <div class="grid grid-cols-3 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                            <a 
                                v-for="social in socialMediaLinks.slice(0, 6)" 
                                :key="social.id"
                                :href="`/link/redirect/${social.id}`"
                                target="_blank"
                                :title="getSocialPlatformName(social)"
                                class="group relative aspect-square rounded-2xl bg-white/5 border border-white/10 flex items-center justify-center transition-all duration-300 hover:bg-white/15 hover:scale-105 hover:shadow-lg"
                            >
                                <component :is="getSocialIcon(social)" class="h-6 w-6 sm:h-7 sm:w-7 text-white group-hover:scale-110 transition-transform duration-300" />
                                <div class="absolute inset-0 rounded-2xl bg-gradient-to-br from-white/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions Card -->
                <div class="sm:col-span-1 lg:col-span-4">
                    <div class="rounded-3xl bg-white/10 backdrop-blur-xl border border-white/20 p-6 shadow-2xl h-full">
                        <h2 class="text-white font-bold text-lg mb-4 flex items-center gap-2">
                            <div class="h-6 w-6 rounded-lg bg-gradient-to-r from-blue-500 to-cyan-500 flex items-center justify-center">
                                <svg class="h-3 w-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            Quick Actions
                        </h2>
                        
                        <div class="space-y-3">
                            <button class="w-full rounded-xl bg-white/10 border border-white/20 p-3 text-white text-sm hover:bg-white/20 transition-colors duration-200 flex items-center gap-3">
                                <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M15 8a3 3 0 10-2.977-2.63l-4.94 2.47a3 3 0 100 4.319l4.94 2.47a3 3 0 10.895-1.789l-4.94-2.47a3.027 3.027 0 000-.74l4.94-2.47C13.456 7.68 14.19 8 15 8z" />
                                </svg>
                                Share Profile
                            </button>
                            <button class="w-full rounded-xl bg-white/10 border border-white/20 p-3 text-white text-sm hover:bg-white/20 transition-colors duration-200 flex items-center gap-3">
                                <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm5 6a1 1 0 10-2 0v3.586l-1.293-1.293a1 1 0 10-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 11.586V8z" clip-rule="evenodd" />
                                </svg>
                                Save Contact
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Main Links Section -->
                <div class="sm:col-span-2 lg:col-span-8">
                    <div class="rounded-3xl bg-white/10 backdrop-blur-xl border border-white/20 p-6 shadow-2xl">
                        <h2 class="text-white font-bold text-xl mb-6 flex items-center gap-2">
                            <div class="h-6 w-6 rounded-lg bg-gradient-to-r from-green-500 to-emerald-500 flex items-center justify-center">
                                <svg class="h-3 w-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M12.586 4.586a2 2 0 112.828 2.828l-3 3a2 2 0 01-2.828 0 1 1 0 00-1.414 1.414 4 4 0 005.656 0l3-3a4 4 0 00-5.656-5.656l-1.5 1.5a1 1 0 101.414 1.414l1.5-1.5zm-5 5a2 2 0 012.828 0 1 1 0 101.414-1.414 4 4 0 00-5.656 0l-3 3a4 4 0 105.656 5.656l1.5-1.5a1 1 0 10-1.414-1.414l-1.5 1.5a2 2 0 11-2.828-2.828l3-3z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            Links & Projects
                        </h2>
                        
                        <div class="grid gap-4 sm:grid-cols-2">
                            <a
                                v-for="link in regularLinks"
                                :key="link.id"
                                :href="`/link/redirect/${link.id}`"
                                target="_blank"
                                class="group relative rounded-2xl bg-white/5 border border-white/10 p-4 transition-all duration-300 hover:bg-white/15 hover:scale-[1.02] hover:shadow-lg"
                            >
                                <!-- Gradient overlay on hover -->
                                <div class="absolute inset-0 rounded-2xl bg-gradient-to-br from-white/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                
                                <div class="relative flex items-start gap-4">
                                    <!-- Icon -->
                                    <div class="flex-shrink-0 w-12 h-12 rounded-xl bg-gradient-to-br from-white/20 to-white/10 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                                        <component :is="getLinkIcon(link.type)" class="h-6 w-6 text-white" />
                                    </div>
                                    
                                    <!-- Content -->
                                    <div class="flex-1 min-w-0">
                                        <h3 class="font-semibold text-white text-sm sm:text-base group-hover:text-purple-300 transition-colors duration-300 mb-1">
                                            {{ link.title }}
                                        </h3>
                                        <p v-if="link.description" class="text-white/60 text-xs sm:text-sm leading-relaxed">
                                            {{ link.description }}
                                        </p>
                                    </div>
                                    
                                    <!-- Arrow -->
                                    <div class="flex-shrink-0 opacity-60 group-hover:opacity-100 group-hover:translate-x-1 transition-all duration-300">
                                        <svg class="h-5 w-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Portfolio Showcase -->
                <div v-if="portfolios.length > 0" class="sm:col-span-2 lg:col-span-12">
                    <div class="rounded-3xl bg-white/10 backdrop-blur-xl border border-white/20 p-6 shadow-2xl">
                        <h2 class="text-white font-bold text-xl mb-6 flex items-center gap-2">
                            <div class="h-6 w-6 rounded-lg bg-gradient-to-r from-orange-500 to-red-500 flex items-center justify-center">
                                <svg class="h-3 w-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M3 4a2 2 0 00-2 2v10a2 2 0 002 2h14a2 2 0 002-2V6a2 2 0 00-2-2H3zm2 4a1 1 0 011-1h1a1 1 0 011 1v1a1 1 0 01-1 1H6a1 1 0 01-1-1V8zM6 10a2 2 0 100 4 2 2 0 000-4zm8-4a1 1 0 00-1 1v2a1 1 0 002 0V7a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            Portfolio Showcase
                        </h2>
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
                            <div
                                v-for="portfolio in portfolios.slice(0, 6)"
                                :key="portfolio.id"
                                @click="openPortfolio(portfolio)"
                                class="group cursor-pointer rounded-2xl bg-white/5 border border-white/10 overflow-hidden transition-all duration-300 hover:bg-white/15 hover:scale-[1.02] hover:shadow-lg"
                            >
                                <!-- Portfolio Image -->
                                <div class="aspect-video bg-gradient-to-br from-purple-500/20 to-blue-500/20 relative overflow-hidden">
                                    <img
                                        :src="getPortfolioStockImage(portfolio.id)"
                                        :alt="portfolio.title"
                                        class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-105"
                                    />
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent"></div>
                                </div>
                                
                                <!-- Portfolio Content -->
                                <div class="p-4">
                                    <h3 class="font-semibold text-white text-sm sm:text-base mb-2 group-hover:text-purple-300 transition-colors duration-300">
                                        {{ portfolio.title }}
                                    </h3>
                                    <p v-if="portfolio.description" class="text-white/60 text-xs sm:text-sm leading-relaxed line-clamp-2">
                                        {{ portfolio.description }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Portfolio Modal -->
        <div v-if="selectedPortfolio" class="fixed inset-0 z-50 flex items-center justify-center bg-black/80 backdrop-blur-sm p-4" @click="closePortfolio">
            <div @click.stop class="max-h-[90vh] w-full max-w-3xl overflow-y-auto rounded-3xl bg-white shadow-2xl">
                <div class="p-6">
                    <div class="mb-4 flex items-start justify-between">
                        <h3 class="text-2xl font-bold text-gray-900">{{ selectedPortfolio.title }}</h3>
                        <button @click="closePortfolio" class="rounded-xl p-2 text-gray-500 transition-colors hover:bg-gray-100 hover:text-gray-700">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <img
                        :src="getPortfolioStockImage(selectedPortfolio.id)"
                        :alt="selectedPortfolio.title"
                        class="mb-4 w-full rounded-2xl shadow-lg"
                    />

                    <p v-if="selectedPortfolio.description" class="mb-6 leading-relaxed text-gray-700">{{ selectedPortfolio.description }}</p>

                    <a
                        v-if="selectedPortfolio.link"
                        :href="selectedPortfolio.link"
                        target="_blank"
                        class="inline-flex items-center rounded-2xl bg-gradient-to-r from-purple-600 to-blue-600 px-6 py-3 text-white shadow-lg transition-all duration-300 hover:from-purple-700 hover:to-blue-700 hover:shadow-xl hover:scale-105"
                    >
                        View Project
                        <svg class="ml-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
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
    const iconMap = {
        portfolio: { template: `<svg class="h-6 w-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6 6V5a3 3 0 013-3h2a3 3 0 013 3v1h2a2 2 0 012 2v3.57A22.952 22.952 0 0110 13a22.95 22.95 0 01-8-1.43V8a2 2 0 012-2h2zm2-1a1 1 0 011-1h2a1 1 0 011 1v1H8V5zm1 5a1 1 0 011-1h.01a1 1 0 110 2H10a1 1 0 01-1-1z" clip-rule="evenodd" /></svg>` },
        custom: { template: `<svg class="h-6 w-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M12.586 4.586a2 2 0 112.828 2.828l-3 3a2 2 0 01-2.828 0 1 1 0 00-1.414 1.414 4 4 0 005.656 0l3-3a4 4 0 00-5.656-5.656l-1.5 1.5a1 1 0 101.414 1.414l1.5-1.5zm-5 5a2 2 0 012.828 0 1 1 0 101.414-1.414 4 4 0 00-5.656 0l-3 3a4 4 0 105.656 5.656l1.5-1.5a1 1 0 10-1.414-1.414l-1.5 1.5a2 2 0 11-2.828-2.828l3-3z" clip-rule="evenodd" /></svg>` },
        deeplink: { template: `<svg class="h-6 w-6" fill="currentColor" viewBox="0 0 20 20"><path d="M11 3a1 1 0 100 2h2.586l-6.293 6.293a1 1 0 101.414 1.414L15 6.414V9a1 1 0 102 0V4a1 1 0 00-1-1h-5z" /><path d="M5 5a2 2 0 00-2 2v8a2 2 0 002 2h8a2 2 0 002-2v-3a1 1 0 10-2 0v3H5V7h3a1 1 0 000-2H5z" /></svg>` },
    };
    
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

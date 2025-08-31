<template>
    <div class="space-y-6">
        <!-- Header -->
        <div class="text-center">
            <h3 class="mb-2 text-lg font-semibold text-card-foreground">Tambah Social Media</h3>
            <p class="text-sm text-muted-foreground">Pilih platform social media untuk ditambahkan ke biolink Anda</p>
        </div>

        <!-- Social Media Grid -->
        <div class="grid grid-cols-2 gap-3 sm:grid-cols-3 sm:gap-4 lg:grid-cols-4">
            <!-- Instagram -->
            <button
                @click="selectSocialMedia('instagram')"
                class="group flex flex-col items-center rounded-2xl border border-border/50 bg-gradient-to-br from-card/80 to-muted/10 p-4 transition-all duration-300 hover:scale-105 hover:border-pink-400/50 hover:from-pink-500/10 hover:to-orange-500/10 hover:shadow-lg sm:p-6"
            >
                <div
                    class="mb-3 flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-br from-pink-500/20 to-orange-500/20 transition-all duration-300 group-hover:from-pink-500/30 group-hover:to-orange-500/30"
                >
                    <svg class="h-6 w-6 text-pink-600" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M12.017 0C8.396 0 7.989.013 7.041.048 6.094.082 5.48.306 4.85.637a5.105 5.105 0 00-1.949 1.263A5.105 5.105 0 001.637 3.85C1.306 4.48 1.082 5.094 1.048 6.041.013 7.989 0 8.396 0 12.017s.013 4.028.048 4.976c.034.947.258 1.561.589 2.191.263.63.658 1.169 1.263 1.949a5.105 5.105 0 001.949 1.263c.63.331 1.244.555 2.191.589.948.035 1.355.048 4.976.048s4.028-.013 4.976-.048c.947-.034 1.561-.258 2.191-.589a5.105 5.105 0 001.949-1.263 5.105 5.105 0 001.263-1.949c.331-.63.555-1.244.589-2.191.035-.948.048-1.355.048-4.976s-.013-4.028-.048-4.976c-.034-.947-.258-1.561-.589-2.191a5.105 5.105 0 00-1.263-1.949A5.105 5.105 0 0019.15 1.637c-.63-.331-1.244-.555-2.191-.589C16.011.013 15.604 0 12.017 0zm0 2.162c3.204 0 3.584.012 4.85.07.3.007.92.028 1.6.096.68.064 1.287.181 1.82.384.434.164.784.36 1.132.724.36.36.556.688.724 1.132.203.533.32 1.14.384 1.82.068.68.089 1.3.096 1.6.058 1.266.07 1.646.07 4.85s-.012 3.584-.07 4.85c-.007.3-.028.92-.096 1.6-.064.68-.181 1.287-.384 1.82-.164.434-.36.784-.724 1.132a3.077 3.077 0 01-1.132.724c-.533.203-1.14.32-1.82.384-.68.068-1.3.089-1.6.096-1.266.058-1.646.07-4.85.07s-3.584-.012-4.85-.07c-.3-.007-.92-.028-1.6-.096-.68-.064-1.287-.181-1.82-.384a3.077 3.077 0 01-1.132-.724 3.077 3.077 0 01-.724-1.132c-.203-.533-.32-1.14-.384-1.82-.068-.68-.089-1.3-.096-1.6-.058-1.266-.07-1.646-.07-4.85s.012-3.584.07-4.85c.007-.3.028-.92.096-1.6.064-.68.181-1.287.384-1.82.164-.434.36-.784.724-1.132a3.077 3.077 0 011.132-.724c.533-.203 1.14-.32 1.82-.384.68-.068 1.3-.089 1.6-.096 1.266-.058 1.646-.07 4.85-.07zM12.017 15.33a3.314 3.314 0 110-6.628 3.314 3.314 0 010 6.628zm0-8.414a5.1 5.1 0 100 10.2 5.1 5.1 0 000-10.2zm6.532-1.194a1.2 1.2 0 11-2.4 0 1.2 1.2 0 012.4 0z"
                        />
                    </svg>
                </div>
                <span class="text-sm font-medium text-card-foreground transition-colors group-hover:text-pink-600">Instagram</span>
            </button>

            <!-- TikTok -->
            <button
                @click="selectSocialMedia('tiktok')"
                class="group flex flex-col items-center rounded-2xl border border-border/50 bg-gradient-to-br from-card/80 to-muted/10 p-4 transition-all duration-300 hover:scale-105 hover:border-gray-600/50 hover:from-gray-900/10 hover:to-red-500/10 hover:shadow-lg sm:p-6"
            >
                <div
                    class="mb-3 flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-br from-gray-900/20 to-red-500/20 transition-all duration-300 group-hover:from-gray-900/30 group-hover:to-red-500/30"
                >
                    <svg class="h-6 w-6 text-gray-900 dark:text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z"
                        />
                    </svg>
                </div>
                <span class="text-sm font-medium text-card-foreground transition-colors group-hover:text-gray-900 dark:group-hover:text-white"
                    >TikTok</span
                >
            </button>

            <!-- YouTube -->
            <button
                @click="selectSocialMedia('youtube')"
                class="group flex flex-col items-center rounded-2xl border border-border/50 bg-gradient-to-br from-card/80 to-muted/10 p-4 transition-all duration-300 hover:scale-105 hover:border-red-500/50 hover:from-red-600/10 hover:to-red-500/10 hover:shadow-lg sm:p-6"
            >
                <div
                    class="mb-3 flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-br from-red-600/20 to-red-500/20 transition-all duration-300 group-hover:from-red-600/30 group-hover:to-red-500/30"
                >
                    <svg class="h-6 w-6 text-red-600" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"
                        />
                    </svg>
                </div>
                <span class="text-sm font-medium text-card-foreground transition-colors group-hover:text-red-600">YouTube</span>
            </button>

            <!-- Twitter/X -->
            <button
                @click="selectSocialMedia('twitter')"
                class="group flex flex-col items-center rounded-2xl border border-border/50 bg-gradient-to-br from-card/80 to-muted/10 p-4 transition-all duration-300 hover:scale-105 hover:border-blue-400/50 hover:from-blue-500/10 hover:to-sky-500/10 hover:shadow-lg sm:p-6"
            >
                <div
                    class="mb-3 flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-br from-blue-500/20 to-sky-500/20 transition-all duration-300 group-hover:from-blue-500/30 group-hover:to-sky-500/30"
                >
                    <svg class="h-6 w-6 text-blue-500" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"
                        />
                    </svg>
                </div>
                <span class="text-sm font-medium text-card-foreground transition-colors group-hover:text-blue-500">Twitter</span>
            </button>

            <!-- LinkedIn -->
            <button
                @click="selectSocialMedia('linkedin')"
                class="group flex flex-col items-center rounded-2xl border border-border/50 bg-gradient-to-br from-card/80 to-muted/10 p-4 transition-all duration-300 hover:scale-105 hover:border-blue-600/50 hover:from-blue-700/10 hover:to-blue-600/10 hover:shadow-lg sm:p-6"
            >
                <div
                    class="mb-3 flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-br from-blue-700/20 to-blue-600/20 transition-all duration-300 group-hover:from-blue-700/30 group-hover:to-blue-600/30"
                >
                    <svg class="h-6 w-6 text-blue-700" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"
                        />
                    </svg>
                </div>
                <span class="text-sm font-medium text-card-foreground transition-colors group-hover:text-blue-700">LinkedIn</span>
            </button>

            <!-- WhatsApp -->
            <button
                @click="selectSocialMedia('whatsapp')"
                class="group flex flex-col items-center rounded-2xl border border-border/50 bg-gradient-to-br from-card/80 to-muted/10 p-4 transition-all duration-300 hover:scale-105 hover:border-green-500/50 hover:from-green-600/10 hover:to-green-500/10 hover:shadow-lg sm:p-6"
            >
                <div
                    class="mb-3 flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-br from-green-600/20 to-green-500/20 transition-all duration-300 group-hover:from-green-600/30 group-hover:to-green-500/30"
                >
                    <svg class="h-6 w-6 text-green-600" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.863 3.488"
                        />
                    </svg>
                </div>
                <span class="text-sm font-medium text-card-foreground transition-colors group-hover:text-green-600">WhatsApp</span>
            </button>

            <!-- Facebook -->
            <button
                @click="selectSocialMedia('facebook')"
                class="group flex flex-col items-center rounded-2xl border border-border/50 bg-gradient-to-br from-card/80 to-muted/10 p-4 transition-all duration-300 hover:scale-105 hover:border-blue-500/50 hover:from-blue-600/10 hover:to-blue-500/10 hover:shadow-lg sm:p-6"
            >
                <div
                    class="mb-3 flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-br from-blue-600/20 to-blue-500/20 transition-all duration-300 group-hover:from-blue-600/30 group-hover:to-blue-500/30"
                >
                    <svg class="h-6 w-6 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"
                        />
                    </svg>
                </div>
                <span class="text-sm font-medium text-card-foreground transition-colors group-hover:text-blue-600">Facebook</span>
            </button>

            <!-- GitHub -->
            <button
                @click="selectSocialMedia('github')"
                class="group flex flex-col items-center rounded-2xl border border-border/50 bg-gradient-to-br from-card/80 to-muted/10 p-4 transition-all duration-300 hover:scale-105 hover:border-gray-600/50 hover:from-gray-900/10 hover:to-gray-700/10 hover:shadow-lg sm:p-6"
            >
                <div
                    class="mb-3 flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-br from-gray-900/20 to-gray-700/20 transition-all duration-300 group-hover:from-gray-900/30 group-hover:to-gray-700/30"
                >
                    <svg class="h-6 w-6 text-gray-900 dark:text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"
                        />
                    </svg>
                </div>
                <span class="text-sm font-medium text-card-foreground transition-colors group-hover:text-gray-900 dark:group-hover:text-white"
                    >GitHub</span
                >
            </button>
        </div>

        <!-- Custom Social Media Input -->
        <div class="mt-6 border-t border-border/50 pt-6">
            <button
                @click="showCustomForm = !showCustomForm"
                class="flex w-full items-center justify-center gap-2 rounded-2xl border border-border/50 bg-gradient-to-br from-card/80 to-muted/10 p-4 transition-all duration-300 hover:border-primary/50 hover:from-primary/10 hover:to-purple-500/10"
            >
                <svg class="h-5 w-5 text-primary" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                <span class="font-medium text-card-foreground">Tambah Platform Lainnya</span>
            </button>

            <!-- Custom Form -->
            <div v-if="showCustomForm" class="mt-4 rounded-xl border border-border/50 bg-muted/20 p-4">
                <div class="space-y-3">
                    <div>
                        <label class="mb-2 block text-sm font-medium text-card-foreground">Nama Platform</label>
                        <input
                            v-model="customForm.title"
                            type="text"
                            placeholder="Contoh: Discord, Telegram, dll"
                            class="w-full rounded-lg border border-border bg-background px-3 py-2 text-sm focus:border-primary focus:ring-2 focus:ring-primary/20"
                        />
                    </div>
                    <div>
                        <label class="mb-2 block text-sm font-medium text-card-foreground">URL/Username</label>
                        <input
                            v-model="customForm.url"
                            type="text"
                            placeholder="https://discord.gg/username atau @username"
                            class="w-full rounded-lg border border-border bg-background px-3 py-2 text-sm focus:border-primary focus:ring-2 focus:ring-primary/20"
                        />
                    </div>
                    <div class="flex gap-2">
                        <button
                            @click="addCustomSocialMedia"
                            class="flex-1 rounded-lg bg-primary px-3 py-2 text-sm font-medium text-white transition-colors hover:bg-primary/90"
                        >
                            Tambah
                        </button>
                        <button
                            @click="
                                showCustomForm = false;
                                resetCustomForm();
                            "
                            class="rounded-lg border border-border px-3 py-2 text-sm font-medium text-muted-foreground transition-colors hover:bg-muted/50"
                        >
                            Batal
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script lang="ts">
import { reactive, ref } from 'vue';

const props = defineProps({
    modelValue: {
        type: Object,
        default: () => ({}),
    },
});

const emit = defineEmits(['update:modelValue', 'selected']);

const showCustomForm = ref(false);

const customForm = reactive({
    title: '',
    url: '',
});

const socialMediaData = {
    instagram: {
        title: 'Instagram',
        placeholder: 'https://instagram.com/username atau @username',
        icon: '📸',
    },
    tiktok: {
        title: 'TikTok',
        placeholder: 'https://tiktok.com/@username atau @username',
        icon: '🎵',
    },
    youtube: {
        title: 'YouTube',
        placeholder: 'https://youtube.com/@channel atau nama channel',
        icon: '📺',
    },
    twitter: {
        title: 'Twitter/X',
        placeholder: 'https://twitter.com/username atau @username',
        icon: '🐦',
    },
    linkedin: {
        title: 'LinkedIn',
        placeholder: 'https://linkedin.com/in/username',
        icon: '💼',
    },
    whatsapp: {
        title: 'WhatsApp',
        placeholder: 'https://wa.me/628123456789 atau nomor telepon',
        icon: '💬',
    },
    facebook: {
        title: 'Facebook',
        placeholder: 'https://facebook.com/username',
        icon: '👥',
    },
    github: {
        title: 'GitHub',
        placeholder: 'https://github.com/username',
        icon: '👨‍💻',
    },
};

const selectSocialMedia = (platform) => {
    const data = socialMediaData[platform];
    emit('selected', {
        type: 'social',
        title: data.title,
        url: '',
        platform: platform,
        icon: data.icon,
        placeholder: data.placeholder,
    });
};

const addCustomSocialMedia = () => {
    if (customForm.title && customForm.url) {
        emit('selected', {
            type: 'social',
            title: customForm.title,
            url: customForm.url,
            platform: 'custom',
            icon: '🔗',
        });
        resetCustomForm();
        showCustomForm.value = false;
    }
};

const resetCustomForm = () => {
    customForm.title = '';
    customForm.url = '';
};
</script>

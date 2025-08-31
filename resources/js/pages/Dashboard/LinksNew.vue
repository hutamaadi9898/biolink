<template>
    <AppLayout>
        <Head title="Links" />

        <!-- Modern Header -->
        <div class="bg-gradient-to-br from-gray-900 via-purple-900/20 to-blue-900/20 border-b border-gray-700/50">
            <div class="max-w-6xl mx-auto px-6 py-8">
                <!-- Header Content -->
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                    <div class="space-y-3">
                        <h1 class="text-4xl font-bold text-white">Manage Links</h1>
                        <p class="text-lg text-gray-300">Add, edit, and organize your social media and portfolio links</p>
                    </div>
                    
                    <div class="flex flex-col sm:flex-row gap-4">
                        <Button
                            @click="showWizard = true"
                            class="px-8 py-4 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-semibold rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 flex items-center justify-center gap-3"
                        >
                            <span>Add New Link</span>
                        </Button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Enhanced Content -->
        <div class="max-w-6xl mx-auto px-6 py-8">
            <div class="space-y-8">
                <!-- Test Content -->
                <div v-if="links.length > 0" class="space-y-4">
                    <h3 class="text-xl font-semibold text-white">Your Links</h3>
                    <div class="grid gap-4">
                        <div v-for="link in links" :key="link.id" class="p-4 bg-gray-800 rounded-xl">
                            <h4 class="text-white font-medium">{{ link.title }}</h4>
                            <p class="text-gray-400 text-sm">{{ link.url }}</p>
                        </div>
                    </div>
                </div>

                <!-- Empty State -->
                <div v-else class="text-center py-12">
                    <div class="mb-6 flex justify-center">
                        <div class="w-16 h-16 bg-gray-700 rounded-2xl flex items-center justify-center">
                            <span class="text-2xl">🔗</span>
                        </div>
                    </div>
                    <h3 class="text-xl font-semibold text-white mb-2">No links yet</h3>
                    <p class="text-gray-400 mb-6">
                        Click "Add New Link" above to get started
                    </p>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup lang="ts">
import { Button } from '@/components/ui/button';
import AppLayout from '@/layouts/AppLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps<{
    links: Array<{
        id: number;
        title: string;
        url: string;
        type: string;
        show_as_embed: boolean;
    }>;
}>();

const showWizard = ref(false);
</script>

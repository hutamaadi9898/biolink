<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <Head title="Portfolio" />

        <div class="animate-fadeIn flex h-full flex-1 flex-col gap-4 p-3 sm:gap-6 sm:p-4 lg:p-6">
            <!-- Enhanced Header with Mobile-First Design -->
            <div class="animate-slideDown">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h1 class="text-xl font-bold text-foreground sm:text-2xl lg:text-3xl">Portfolio</h1>
                        <p class="text-sm text-muted-foreground sm:text-base">Showcase karya dan project terbaik Anda</p>
                    </div>

                    <Button
                        @click="showAddForm = true"
                        class="group flex items-center justify-center gap-2 bg-gradient-to-r from-purple-600 to-pink-600 px-6 py-3 text-sm font-medium transition-all duration-300 hover:scale-105 hover:from-purple-700 hover:to-pink-700 hover:shadow-lg sm:text-base"
                    >
                        <svg
                            class="h-4 w-4 transition-transform group-hover:scale-110 sm:h-5 sm:w-5"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                        >
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        Tambah Portfolio
                    </Button>
                </div>
            </div>

            <!-- Enhanced Add Portfolio Form -->
            <div
                v-if="showAddForm"
                class="animate-slideUp rounded-2xl border border-border/50 bg-gradient-to-br from-card/80 to-purple-50/20 p-4 backdrop-blur-sm sm:p-6 dark:to-purple-950/20"
            >
                <div class="mb-6 flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-card-foreground sm:text-xl">Tambah Portfolio Baru</h3>
                        <p class="text-sm text-muted-foreground">Showcase karya terbaik Anda</p>
                    </div>
                    <Button
                        variant="ghost"
                        size="sm"
                        @click="showAddForm = false"
                        class="transition-all duration-300 hover:scale-110 hover:bg-red-500/10 hover:text-red-600"
                    >
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </Button>
                </div>

                <form @submit.prevent="addPortfolio" class="space-y-5">
                    <div class="grid gap-4 sm:grid-cols-2">
                        <div class="space-y-2">
                            <Label for="title" class="text-sm font-medium">Judul Portfolio *</Label>
                            <Input id="title" name="title" v-model="addForm.title" required class="h-12" placeholder="Masukkan judul portfolio" />
                            <div v-if="addForm.errors?.title" class="mt-1 flex items-center gap-1 text-sm text-red-600">
                                <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"
                                    />
                                </svg>
                                {{ addForm.errors.title }}
                            </div>
                        </div>

                        <div class="space-y-2">
                            <Label for="category" class="text-sm font-medium">Kategori</Label>
                            <select
                                id="category"
                                name="category"
                                v-model="addForm.category"
                                class="flex h-12 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 focus-visible:outline-none disabled:cursor-not-allowed disabled:opacity-50"
                            >
                                <option value="">Pilih kategori</option>
                                <option value="web">Web Development</option>
                                <option value="mobile">Mobile App</option>
                                <option value="design">UI/UX Design</option>
                                <option value="branding">Branding</option>
                                <option value="other">Lainnya</option>
                            </select>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <Label for="description" class="text-sm font-medium">Deskripsi</Label>
                        <textarea
                            id="description"
                            name="description"
                            v-model="addForm.description"
                            rows="3"
                            class="flex min-h-[80px] w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 focus-visible:outline-none disabled:cursor-not-allowed disabled:opacity-50"
                            placeholder="Deskripsikan project Anda..."
                        ></textarea>
                    </div>

                    <div class="grid gap-4 sm:grid-cols-2">
                        <div class="space-y-2">
                            <Label for="link" class="text-sm font-medium">Link Project</Label>
                            <Input id="link" name="link" v-model="addForm.link" type="url" class="h-12" placeholder="https://example.com" />
                        </div>

                        <div class="space-y-2">
                            <Label for="image" class="text-sm font-medium">Gambar Portfolio *</Label>
                            <input
                                id="image"
                                name="image"
                                type="file"
                                accept="image/*"
                                @change="addForm.image = $event.target.files[0]"
                                required
                                class="flex h-12 w-full rounded-md border border-input bg-background px-3 py-2 text-sm file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 focus-visible:outline-none disabled:cursor-not-allowed disabled:opacity-50"
                            />
                        </div>
                    </div>

                    <div class="flex flex-col justify-end gap-3 pt-4 sm:flex-row">
                        <Button type="button" variant="outline" @click="showAddForm = false" class="order-2 sm:order-1"> Batal </Button>
                        <Button
                            type="submit"
                            :disabled="addForm.processing"
                            class="order-1 bg-gradient-to-r from-purple-600 to-pink-600 transition-all duration-300 hover:scale-105 hover:from-purple-700 hover:to-pink-700 sm:order-2"
                        >
                            <span v-if="addForm.processing">Menyimpan...</span>
                            <span v-else>Simpan Portfolio</span>
                        </Button>
                    </div>
                </form>
            </div>

            <!-- Portfolio Grid -->
            <div v-if="portfolios.length > 0" class="grid grid-cols-1 gap-4 sm:grid-cols-2 sm:gap-6 lg:grid-cols-3" data-testid="portfolio-grid">
                <div
                    v-for="portfolio in portfolios"
                    :key="portfolio.id"
                    class="group animate-slideUp overflow-hidden rounded-2xl border border-border/50 bg-card/80 backdrop-blur-sm transition-all duration-300 hover:scale-105 hover:shadow-xl"
                    data-testid="portfolio-item"
                >
                    <!-- Image Section -->
                    <div
                        class="relative aspect-video overflow-hidden bg-gradient-to-br from-purple-100 to-pink-100 dark:from-purple-900/30 dark:to-pink-900/30"
                    >
                        <img
                            v-if="portfolio.image"
                            :src="`/storage/${portfolio.image}`"
                            :alt="portfolio.title"
                            class="h-full w-full object-cover transition-all duration-500 group-hover:scale-110"
                        />

                        <!-- Gradient Overlay -->
                        <div
                            class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 transition-opacity duration-300 group-hover:opacity-100"
                        ></div>

                        <!-- Category Badge -->
                        <div v-if="portfolio.category" class="absolute top-3 left-3">
                            <span
                                class="inline-flex items-center rounded-full bg-white/90 px-2 py-1 text-xs font-medium text-gray-800 backdrop-blur-sm"
                            >
                                {{ portfolio.category }}
                            </span>
                        </div>

                        <!-- Action Buttons Overlay -->
                        <div
                            class="absolute top-3 right-3 flex translate-y-2 transform gap-2 opacity-0 transition-all duration-300 group-hover:translate-y-0 group-hover:opacity-100"
                        >
                            <Button
                                variant="ghost"
                                size="sm"
                                @click="editPortfolio(portfolio)"
                                class="h-8 w-8 bg-white/90 text-gray-800 backdrop-blur-sm transition-all duration-300 hover:scale-110 hover:bg-white"
                                :data-testid="`edit-portfolio-${portfolio.id}`"
                            >
                                <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10"
                                    />
                                </svg>
                            </Button>

                            <Button
                                variant="ghost"
                                size="sm"
                                @click="deletePortfolio(portfolio.id)"
                                class="h-8 w-8 bg-red-500/90 text-white backdrop-blur-sm transition-all duration-300 hover:scale-110 hover:bg-red-600"
                                :data-testid="`delete-portfolio-${portfolio.id}`"
                            >
                                <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"
                                    />
                                </svg>
                            </Button>
                        </div>
                    </div>

                    <!-- Content Section -->
                    <div class="p-4 sm:p-5">
                        <div class="mb-3">
                            <h3 class="line-clamp-1 text-base font-semibold text-card-foreground sm:text-lg">
                                {{ portfolio.title }}
                            </h3>
                            <p v-if="portfolio.description" class="line-clamp-2 text-sm text-muted-foreground">
                                {{ portfolio.description }}
                            </p>
                        </div>

                        <!-- Footer -->
                        <div class="flex items-center justify-between border-t border-border/50 pt-3">
                            <a
                                v-if="portfolio.link"
                                :href="portfolio.link"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="inline-flex items-center gap-1 text-sm text-purple-600 transition-colors hover:text-purple-700 dark:text-purple-400 dark:hover:text-purple-300"
                            >
                                <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M13.19 8.688a4.5 4.5 0 0 1 1.242 7.244l-4.5 4.5a4.5 4.5 0 0 1-6.364-6.364l1.757-1.757m13.35-.622 1.757-1.757a4.5 4.5 0 0 0-6.364-6.364l-4.5 4.5a4.5 4.5 0 0 0 1.242 7.244"
                                    />
                                </svg>
                                Lihat Project
                            </a>
                            <span v-else class="text-sm text-muted-foreground">Tidak ada link</span>

                            <div class="flex items-center gap-1 text-xs text-muted-foreground">
                                <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z"
                                    />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                </svg>
                                {{ portfolio.view_count || 0 }} views
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Enhanced Empty State -->
            <div
                v-else
                class="animate-fadeIn rounded-2xl border border-border/50 bg-gradient-to-br from-card/50 to-purple-50/30 p-8 text-center backdrop-blur-sm sm:p-12 dark:to-purple-950/30"
            >
                <div class="mx-auto mb-6 flex h-20 w-20 items-center justify-center rounded-2xl bg-gradient-to-br from-purple-500/10 to-pink-500/10">
                    <svg class="h-10 w-10 text-muted-foreground" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z"
                        />
                    </svg>
                </div>
                <h3 class="mb-2 text-lg font-semibold text-card-foreground">Belum ada portfolio</h3>
                <p class="mb-6 text-sm text-muted-foreground">Mulai dengan menambahkan project pertama Anda untuk ditampilkan di biolink</p>
                <Button
                    @click="showAddForm = true"
                    class="bg-gradient-to-r from-purple-600 to-pink-600 transition-all duration-300 hover:scale-105 hover:from-purple-700 hover:to-pink-700"
                >
                    <svg class="mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    Tambah Portfolio Pertama
                </Button>
            </div>

            <!-- Enhanced Edit Portfolio Modal -->
            <div v-if="editingPortfolio" class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 p-4 backdrop-blur-sm">
                <div class="animate-slideUp w-full max-w-2xl rounded-2xl border border-border/50 bg-card/95 p-6 shadow-2xl backdrop-blur-sm">
                    <div class="mb-6 flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-semibold text-card-foreground sm:text-xl">Edit Portfolio</h3>
                            <p class="text-sm text-muted-foreground">Perbarui informasi portfolio Anda</p>
                        </div>
                        <Button
                            variant="ghost"
                            size="sm"
                            @click="editingPortfolio = null"
                            class="transition-all duration-300 hover:scale-110 hover:bg-red-500/10 hover:text-red-600"
                        >
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </Button>
                    </div>

                    <form @submit.prevent="updatePortfolio" class="space-y-5">
                        <div class="grid gap-4 sm:grid-cols-2">
                            <div class="space-y-2">
                                <Label for="edit_title" class="text-sm font-medium">Judul Portfolio *</Label>
                                <Input id="edit_title" v-model="editForm.title" required class="h-12" />
                            </div>

                            <div class="space-y-2">
                                <Label for="edit_category" class="text-sm font-medium">Kategori</Label>
                                <select
                                    id="edit_category"
                                    v-model="editForm.category"
                                    class="flex h-12 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 focus-visible:outline-none disabled:cursor-not-allowed disabled:opacity-50"
                                >
                                    <option value="">Pilih kategori</option>
                                    <option value="web">Web Development</option>
                                    <option value="mobile">Mobile App</option>
                                    <option value="design">UI/UX Design</option>
                                    <option value="branding">Branding</option>
                                    <option value="other">Lainnya</option>
                                </select>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <Label for="edit_description" class="text-sm font-medium">Deskripsi</Label>
                            <textarea
                                id="edit_description"
                                v-model="editForm.description"
                                rows="3"
                                class="flex min-h-[80px] w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 focus-visible:outline-none disabled:cursor-not-allowed disabled:opacity-50"
                            ></textarea>
                        </div>

                        <div class="grid gap-4 sm:grid-cols-2">
                            <div class="space-y-2">
                                <Label for="edit_link" class="text-sm font-medium">Link Project</Label>
                                <Input id="edit_link" v-model="editForm.link" type="url" class="h-12" />
                            </div>

                            <div class="space-y-2">
                                <Label for="edit_image" class="text-sm font-medium">Gambar Portfolio</Label>
                                <input
                                    id="edit_image"
                                    type="file"
                                    accept="image/*"
                                    @change="editForm.image = $event.target.files[0]"
                                    class="flex h-12 w-full rounded-md border border-input bg-background px-3 py-2 text-sm file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 focus-visible:outline-none disabled:cursor-not-allowed disabled:opacity-50"
                                />
                            </div>
                        </div>

                        <div class="flex flex-col justify-end gap-3 pt-4 sm:flex-row">
                            <Button type="button" variant="outline" @click="editingPortfolio = null" class="order-2 sm:order-1"> Batal </Button>
                            <Button
                                type="submit"
                                :disabled="editForm.processing"
                                class="order-1 bg-gradient-to-r from-purple-600 to-pink-600 transition-all duration-300 hover:scale-105 hover:from-purple-700 hover:to-pink-700 sm:order-2"
                            >
                                <span v-if="editForm.processing">Menyimpan...</span>
                                <span v-else>Update Portfolio</span>
                            </Button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AppLayout from '@/layouts/AppLayout.vue';
import type { BreadcrumbItem } from '@/types';
import { Head, router, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

interface Portfolio {
    id: number;
    title: string;
    description?: string;
    image?: string;
    link?: string;
    category?: string;
    view_count?: number;
    created_at: string;
    updated_at: string;
}

defineProps<{
    portfolios: Portfolio[];
}>();

const breadcrumbs: BreadcrumbItem[] = [
    { label: 'Dashboard', href: '/dashboard' },
    { label: 'Portfolio', href: '/dashboard/portfolio' },
];

// Form state
const showAddForm = ref(false);
const editingPortfolio = ref<Portfolio | null>(null);

// Add form
const addForm = useForm({
    title: '',
    description: '',
    image: null as File | null,
    link: '',
    category: '',
});

// Edit form
const editForm = useForm({
    title: '',
    description: '',
    image: null as File | null,
    link: '',
    category: '',
});

// Add portfolio
const addPortfolio = () => {
    addForm.post('/dashboard/portfolio', {
        onSuccess: () => {
            addForm.reset();
            showAddForm.value = false;
        },
    });
};

// Edit portfolio
const editPortfolio = (portfolio: Portfolio) => {
    editingPortfolio.value = portfolio;
    editForm.title = portfolio.title;
    editForm.description = portfolio.description || '';
    editForm.link = portfolio.link || '';
    editForm.category = portfolio.category || '';
    editForm.image = null;
};

// Update portfolio
const updatePortfolio = () => {
    if (!editingPortfolio.value) return;

    editForm.post(`/dashboard/portfolio/${editingPortfolio.value.id}?_method=PUT`, {
        onSuccess: () => {
            editForm.reset();
            editingPortfolio.value = null;
        },
    });
};

// Delete portfolio
const deletePortfolio = (portfolioId: number) => {
    if (confirm('Apakah Anda yakin ingin menghapus portfolio ini?')) {
        router.delete(`/dashboard/portfolio/${portfolioId}`);
    }
};
</script>

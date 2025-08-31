<script setup lang="ts">
import ProfileController from '@/actions/App/Http/Controllers/Settings/ProfileController';
import { edit } from '@/routes/profile';
import { send } from '@/routes/verification';
import { Form, Head, Link, usePage } from '@inertiajs/vue3';

import DeleteUser from '@/components/DeleteUser.vue';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AppLayout from '@/layouts/AppLayout.vue';
import SettingsLayout from '@/layouts/settings/Layout.vue';
import { type BreadcrumbItem } from '@/types';

interface Props {
    mustVerifyEmail: boolean;
    status?: string;
}

defineProps<Props>();

const breadcrumbItems: BreadcrumbItem[] = [
    {
        title: 'Profile settings',
        href: edit().url,
    },
];

const page = usePage();
const user = page.props.auth.user;
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbItems">
        <Head title="Profile settings" />

        <SettingsLayout>
            <div class="flex flex-col space-y-6 sm:space-y-8">
                <!-- Enhanced Header -->
                <div
                    class="animate-slideDown rounded-2xl border border-border/50 bg-gradient-to-br from-card/80 to-blue-50/20 p-4 backdrop-blur-sm sm:p-6 dark:to-blue-950/20"
                >
                    <div class="flex items-center gap-4">
                        <div
                            class="flex h-12 w-12 items-center justify-center rounded-2xl bg-gradient-to-br from-blue-500 to-purple-500 shadow-lg sm:h-16 sm:w-16"
                        >
                            <svg class="h-6 w-6 text-white sm:h-8 sm:w-8" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"
                                />
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-lg font-bold text-card-foreground sm:text-xl">Profile Information</h2>
                            <p class="text-sm text-muted-foreground">Update your name and email address to keep your account current</p>
                        </div>
                    </div>
                </div>

                <!-- Enhanced Profile Form -->
                <div
                    class="animate-slideUp rounded-2xl border border-border/50 bg-gradient-to-br from-card/80 to-purple-50/10 p-4 backdrop-blur-sm sm:p-6 dark:to-purple-950/10"
                >
                    <Form v-bind="ProfileController.update.form()" class="space-y-6" v-slot="{ errors, processing, recentlySuccessful }">
                        <div class="grid gap-4 sm:grid-cols-2">
                            <div class="space-y-2">
                                <Label for="name" class="text-sm font-medium text-foreground">Full Name</Label>
                                <div class="relative">
                                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                        <svg
                                            class="h-4 w-4 text-muted-foreground"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke-width="1.5"
                                            stroke="currentColor"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"
                                            />
                                        </svg>
                                    </div>
                                    <Input
                                        id="name"
                                        class="h-12 pl-10 transition-all duration-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20"
                                        name="name"
                                        :default-value="user.name"
                                        required
                                        autocomplete="name"
                                        placeholder="Masukkan nama lengkap"
                                    />
                                </div>
                                <InputError class="mt-2" :message="errors.name" />
                            </div>

                            <div class="space-y-2">
                                <Label for="email" class="text-sm font-medium text-foreground">Email Address</Label>
                                <div class="relative">
                                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                        <svg
                                            class="h-4 w-4 text-muted-foreground"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke-width="1.5"
                                            stroke="currentColor"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"
                                            />
                                        </svg>
                                    </div>
                                    <Input
                                        id="email"
                                        type="email"
                                        class="h-12 pl-10 transition-all duration-300 focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20"
                                        name="email"
                                        :default-value="user.email"
                                        required
                                        autocomplete="username"
                                        placeholder="nama@email.com"
                                    />
                                </div>
                                <InputError class="mt-2" :message="errors.email" />
                            </div>
                        </div>

                        <!-- Email Verification Alert -->
                        <div
                            v-if="mustVerifyEmail && !user.email_verified_at"
                            class="rounded-xl border border-amber-200 bg-gradient-to-br from-amber-50 to-orange-50 p-4 sm:p-6 dark:from-amber-950/20 dark:to-orange-950/20"
                        >
                            <div class="flex items-start gap-3">
                                <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-amber-500">
                                    <svg class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"
                                        />
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <h4 class="text-sm font-medium text-amber-800 dark:text-amber-200">Email belum terverifikasi</h4>
                                    <p class="mt-1 text-sm text-amber-700 dark:text-amber-300">
                                        Alamat email Anda belum terverifikasi.
                                        <Link
                                            :href="send()"
                                            as="button"
                                            class="font-medium underline underline-offset-4 transition-colors duration-300 hover:text-amber-900 dark:hover:text-amber-100"
                                        >
                                            Klik di sini untuk mengirim ulang email verifikasi.
                                        </Link>
                                    </p>

                                    <div v-if="status === 'verification-link-sent'" class="mt-3 rounded-lg bg-green-100 p-3 dark:bg-green-900/20">
                                        <div class="flex items-center gap-2">
                                            <svg class="h-4 w-4 text-green-600" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M20.285 2l-11.285 11.567-5.286-5.011-3.714 3.716 9 8.728 15-15.285z" />
                                            </svg>
                                            <span class="text-sm font-medium text-green-800 dark:text-green-200">
                                                Link verifikasi baru telah dikirim ke email Anda.
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Enhanced Action Buttons -->
                        <div class="flex flex-col items-start justify-between gap-4 border-t border-border/50 pt-4 sm:flex-row sm:items-center">
                            <div class="flex items-center gap-4">
                                <Button
                                    :disabled="processing"
                                    class="group bg-gradient-to-r from-blue-600 to-purple-600 px-6 py-3 transition-all duration-300 hover:scale-105 hover:from-blue-700 hover:to-purple-700 hover:shadow-lg"
                                >
                                    <span v-if="processing" class="flex items-center gap-2">
                                        <svg class="h-4 w-4 animate-spin" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path
                                                class="opacity-75"
                                                fill="currentColor"
                                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
                                            ></path>
                                        </svg>
                                        Menyimpan...
                                    </span>
                                    <span v-else class="flex items-center gap-2">
                                        <svg
                                            class="h-4 w-4 transition-transform group-hover:scale-110"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke-width="2"
                                            stroke="currentColor"
                                        >
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                        </svg>
                                        Simpan Perubahan
                                    </span>
                                </Button>

                                <Transition
                                    enter-active-class="transition ease-in-out duration-300"
                                    enter-from-class="opacity-0 translate-x-2"
                                    enter-to-class="opacity-100 translate-x-0"
                                    leave-active-class="transition ease-in-out duration-300"
                                    leave-from-class="opacity-100 translate-x-0"
                                    leave-to-class="opacity-0 translate-x-2"
                                >
                                    <div
                                        v-show="recentlySuccessful"
                                        class="flex items-center gap-2 rounded-lg bg-green-100 px-3 py-2 dark:bg-green-900/20"
                                    >
                                        <svg class="h-4 w-4 text-green-600" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M20.285 2l-11.285 11.567-5.286-5.011-3.714 3.716 9 8.728 15-15.285z" />
                                        </svg>
                                        <span class="text-sm font-medium text-green-800 dark:text-green-200">Profile berhasil diupdate!</span>
                                    </div>
                                </Transition>
                            </div>

                            <!-- Security Tip -->
                            <div class="flex items-center gap-2 text-xs text-muted-foreground">
                                <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.623 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"
                                    />
                                </svg>
                                <span>Data Anda dilindungi dengan enkripsi end-to-end</span>
                            </div>
                        </div>
                    </Form>
                </div>

                <!-- Enhanced Delete User Section -->
                <DeleteUser />
            </div>
        </SettingsLayout>
    </AppLayout>
</template>

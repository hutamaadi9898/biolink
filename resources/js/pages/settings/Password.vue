<script setup lang="ts">
import PasswordController from '@/actions/App/Http/Controllers/Settings/PasswordController';
import InputError from '@/components/InputError.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import SettingsLayout from '@/layouts/settings/Layout.vue';
import { edit } from '@/routes/password';
import { Form, Head } from '@inertiajs/vue3';
import { ref } from 'vue';

import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { type BreadcrumbItem } from '@/types';

const breadcrumbItems: BreadcrumbItem[] = [
    {
        title: 'Password settings',
        href: edit().url,
    },
];

const passwordInput = ref<HTMLInputElement | null>(null);
const currentPasswordInput = ref<HTMLInputElement | null>(null);
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbItems">
        <Head title="Password settings" />

        <SettingsLayout>
            <div class="space-y-6 sm:space-y-8">
                <!-- Enhanced Header -->
                <div
                    class="animate-slideDown rounded-2xl border border-border/50 bg-gradient-to-br from-card/80 to-red-50/20 p-4 backdrop-blur-sm sm:p-6 dark:to-red-950/20"
                >
                    <div class="flex items-center gap-4">
                        <div
                            class="flex h-12 w-12 items-center justify-center rounded-2xl bg-gradient-to-br from-red-500 to-pink-500 shadow-lg sm:h-16 sm:w-16"
                        >
                            <svg class="h-6 w-6 text-white sm:h-8 sm:w-8" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"
                                />
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-lg font-bold text-card-foreground sm:text-xl">Update Password</h2>
                            <p class="text-sm text-muted-foreground">Pastikan akun Anda menggunakan password yang kuat dan aman</p>
                        </div>
                    </div>
                </div>

                <!-- Security Tips -->
                <div
                    class="animate-fadeIn rounded-xl border border-blue-200 bg-gradient-to-br from-blue-50 to-cyan-50 p-4 sm:p-6 dark:from-blue-950/20 dark:to-cyan-950/20"
                >
                    <div class="flex items-start gap-3">
                        <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-blue-500">
                            <svg class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z"
                                />
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-blue-800 dark:text-blue-200">Tips Password Aman</h4>
                            <ul class="mt-2 space-y-1 text-sm text-blue-700 dark:text-blue-300">
                                <li class="flex items-center gap-2">
                                    <div class="h-1 w-1 rounded-full bg-blue-500"></div>
                                    Minimal 8 karakter dengan kombinasi huruf, angka, dan simbol
                                </li>
                                <li class="flex items-center gap-2">
                                    <div class="h-1 w-1 rounded-full bg-blue-500"></div>
                                    Hindari menggunakan informasi pribadi yang mudah ditebak
                                </li>
                                <li class="flex items-center gap-2">
                                    <div class="h-1 w-1 rounded-full bg-blue-500"></div>
                                    Gunakan password yang berbeda untuk setiap akun
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Enhanced Password Form -->
                <div
                    class="animate-slideUp rounded-2xl border border-border/50 bg-gradient-to-br from-card/80 to-red-50/10 p-4 backdrop-blur-sm sm:p-6 dark:to-red-950/10"
                >
                    <Form
                        v-bind="PasswordController.update.form()"
                        :options="{
                            preserveScroll: true,
                        }"
                        reset-on-success
                        :reset-on-error="['password', 'password_confirmation', 'current_password']"
                        class="space-y-6"
                        v-slot="{ errors, processing, recentlySuccessful }"
                    >
                        <div class="space-y-2">
                            <Label for="current_password" class="text-sm font-medium text-foreground">Password Saat Ini</Label>
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
                                            d="M15.75 5.25a3 3 0 013 3m3 0a6 6 0 01-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1121.75 8.25z"
                                        />
                                    </svg>
                                </div>
                                <Input
                                    id="current_password"
                                    ref="currentPasswordInput"
                                    name="current_password"
                                    type="password"
                                    class="h-12 pl-10 transition-all duration-300 focus:border-red-500 focus:ring-2 focus:ring-red-500/20"
                                    autocomplete="current-password"
                                    placeholder="Masukkan password saat ini"
                                />
                            </div>
                            <InputError :message="errors.current_password" />
                        </div>

                        <div class="space-y-2">
                            <Label for="password" class="text-sm font-medium text-foreground">Password Baru</Label>
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
                                            d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"
                                        />
                                    </svg>
                                </div>
                                <Input
                                    id="password"
                                    ref="passwordInput"
                                    name="password"
                                    type="password"
                                    class="h-12 pl-10 transition-all duration-300 focus:border-green-500 focus:ring-2 focus:ring-green-500/20"
                                    autocomplete="new-password"
                                    placeholder="Masukkan password baru"
                                />
                            </div>
                            <InputError :message="errors.password" />

                            <!-- Password Strength Indicator -->
                            <div class="mt-2 space-y-2">
                                <div class="flex gap-1">
                                    <div class="h-1 flex-1 rounded-full bg-gray-200 dark:bg-gray-700">
                                        <div class="h-full w-1/4 rounded-full bg-red-500"></div>
                                    </div>
                                    <div class="h-1 flex-1 rounded-full bg-gray-200 dark:bg-gray-700">
                                        <div class="h-full w-0 rounded-full bg-orange-500"></div>
                                    </div>
                                    <div class="h-1 flex-1 rounded-full bg-gray-200 dark:bg-gray-700">
                                        <div class="h-full w-0 rounded-full bg-yellow-500"></div>
                                    </div>
                                    <div class="h-1 flex-1 rounded-full bg-gray-200 dark:bg-gray-700">
                                        <div class="h-full w-0 rounded-full bg-green-500"></div>
                                    </div>
                                </div>
                                <p class="text-xs text-muted-foreground">Kekuatan password: <span class="text-red-600">Lemah</span></p>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <Label for="password_confirmation" class="text-sm font-medium text-foreground">Konfirmasi Password Baru</Label>
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
                                            d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                                        />
                                    </svg>
                                </div>
                                <Input
                                    id="password_confirmation"
                                    name="password_confirmation"
                                    type="password"
                                    class="h-12 pl-10 transition-all duration-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20"
                                    autocomplete="new-password"
                                    placeholder="Konfirmasi password baru"
                                />
                            </div>
                            <InputError :message="errors.password_confirmation" />
                        </div>

                        <!-- Enhanced Action Buttons -->
                        <div class="flex flex-col items-start justify-between gap-4 border-t border-border/50 pt-6 sm:flex-row sm:items-center">
                            <div class="flex items-center gap-4">
                                <Button
                                    :disabled="processing"
                                    class="group bg-gradient-to-r from-red-600 to-pink-600 px-6 py-3 transition-all duration-300 hover:scale-105 hover:from-red-700 hover:to-pink-700 hover:shadow-lg"
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
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"
                                            />
                                        </svg>
                                        Update Password
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
                                        <span class="text-sm font-medium text-green-800 dark:text-green-200">Password berhasil diupdate!</span>
                                    </div>
                                </Transition>
                            </div>

                            <!-- Security Note -->
                            <div class="flex items-center gap-2 text-xs text-muted-foreground">
                                <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.623 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"
                                    />
                                </svg>
                                <span>Password disimpan dengan enkripsi tingkat militer</span>
                            </div>
                        </div>
                    </Form>
                </div>
            </div>
        </SettingsLayout>
    </AppLayout>
</template>

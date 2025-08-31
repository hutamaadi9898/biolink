<script setup lang="ts">
import AuthenticatedSessionController from '@/actions/App/Http/Controllers/Auth/AuthenticatedSessionController';
import InputError from '@/components/InputError.vue';
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import { Checkbox } from '@/components/ui/checkbox';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AuthBase from '@/layouts/AuthLayout.vue';
import { register } from '@/routes';
import { request } from '@/routes/password';
import { Form, Head } from '@inertiajs/vue3';
import { Eye, EyeOff, LoaderCircle, Lock, Mail } from 'lucide-vue-next';
import { ref } from 'vue';

defineProps<{
    status?: string;
    canResetPassword: boolean;
}>();

const showPassword = ref(false);
const formData = ref({
    email: '',
    password: '',
    remember: false,
});
</script>

<template>
    <AuthBase title="Selamat Datang Kembali" description="Masuk ke akun Anda untuk melanjutkan mengelola biolink">
        <Head title="Masuk" />

        <div
            v-if="status"
            class="mb-6 rounded-xl border border-green-200 bg-green-50 p-4 text-center text-sm font-medium text-green-700 dark:border-green-800 dark:bg-green-900/20 dark:text-green-400"
        >
            {{ status }}
        </div>

        <Form v-bind="AuthenticatedSessionController.store.form()" :reset-on-success="['password']" v-slot="{ errors, processing }" class="space-y-6">
            <!-- Quick Login with Google -->
            <div class="space-y-4">
                <a
                    href="/auth/google"
                    class="group flex h-12 w-full items-center justify-center gap-3 rounded-xl border border-border bg-card/50 px-4 py-3 text-sm font-medium text-foreground backdrop-blur-sm transition-all duration-300 hover:scale-[1.02] hover:border-primary/30 hover:bg-muted/50 hover:shadow-lg focus:ring-2 focus:ring-primary/20 focus:outline-none active:scale-[0.98]"
                    :tabindex="1"
                >
                    <svg class="h-5 w-5 transition-transform group-hover:scale-110" viewBox="0 0 24 24">
                        <path
                            fill="#4285F4"
                            d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"
                        />
                        <path
                            fill="#34A853"
                            d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"
                        />
                        <path
                            fill="#FBBC04"
                            d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"
                        />
                        <path
                            fill="#EA4335"
                            d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"
                        />
                    </svg>
                    <span class="font-medium">Masuk dengan Google</span>
                    <div class="ml-auto rounded-full bg-primary/10 px-2 py-1 text-xs text-primary opacity-60">Cepat</div>
                </a>

                <!-- Divider -->
                <div class="relative">
                    <div class="absolute inset-0 flex items-center">
                        <span class="w-full border-t border-border/60" />
                    </div>
                    <div class="relative flex justify-center text-xs">
                        <span class="rounded-full border border-border/30 bg-card px-3 py-1 text-muted-foreground"> atau masuk dengan email </span>
                    </div>
                </div>
            </div>

            <!-- Email & Password Form -->
            <div class="space-y-5">
                <!-- Email Field -->
                <div class="space-y-2">
                    <Label for="email" class="text-sm font-medium text-foreground">Email Address</Label>
                    <div class="relative">
                        <div class="absolute top-1/2 left-3 -translate-y-1/2 transform text-muted-foreground">
                            <Mail class="h-4 w-4" />
                        </div>
                        <Input
                            id="email"
                            type="email"
                            name="email"
                            v-model="formData.email"
                            required
                            autofocus
                            :tabindex="2"
                            autocomplete="email"
                            placeholder="nama@email.com"
                            class="h-12 pr-4 pl-10 text-base transition-all duration-300 focus:border-primary focus:ring-2 focus:ring-primary/20"
                        />
                    </div>
                    <InputError :message="errors.email" />
                </div>

                <!-- Password Field -->
                <div class="space-y-2">
                    <div class="flex items-center justify-between">
                        <Label for="password" class="text-sm font-medium text-foreground">Password</Label>
                        <TextLink
                            v-if="canResetPassword"
                            :href="request()"
                            class="text-xs text-primary transition-colors hover:text-primary/80"
                            :tabindex="6"
                        >
                            Lupa password?
                        </TextLink>
                    </div>
                    <div class="relative">
                        <div class="absolute top-1/2 left-3 -translate-y-1/2 transform text-muted-foreground">
                            <Lock class="h-4 w-4" />
                        </div>
                        <Input
                            id="password"
                            :type="showPassword ? 'text' : 'password'"
                            name="password"
                            v-model="formData.password"
                            required
                            :tabindex="3"
                            autocomplete="current-password"
                            placeholder="Masukkan password Anda"
                            class="h-12 pr-12 pl-10 text-base transition-all duration-300 focus:border-primary focus:ring-2 focus:ring-primary/20"
                        />
                        <button
                            type="button"
                            @click="showPassword = !showPassword"
                            class="absolute top-1/2 right-3 -translate-y-1/2 transform text-muted-foreground transition-colors hover:text-foreground"
                            :tabindex="7"
                        >
                            <Eye v-if="!showPassword" class="h-4 w-4" />
                            <EyeOff v-else class="h-4 w-4" />
                        </button>
                    </div>
                    <InputError :message="errors.password" />
                </div>

                <!-- Remember Me -->
                <div class="flex items-center justify-between pt-2">
                    <div class="flex items-center space-x-3">
                        <Checkbox
                            id="remember"
                            name="remember"
                            v-model="formData.remember"
                            :tabindex="4"
                            class="transition-all duration-300 data-[state=checked]:border-primary data-[state=checked]:bg-primary"
                        />
                        <Label for="remember" class="cursor-pointer text-sm text-muted-foreground"> Ingat saya selama 30 hari </Label>
                    </div>
                </div>

                <!-- Login Button -->
                <Button
                    type="submit"
                    class="group mt-8 h-12 w-full bg-gradient-to-r from-primary to-purple-600 text-base font-medium transition-all duration-300 hover:scale-[1.02] hover:from-primary/90 hover:to-purple-600/90 active:scale-[0.98]"
                    :tabindex="5"
                    :disabled="processing"
                >
                    <div v-if="processing" class="flex items-center gap-2">
                        <LoaderCircle class="h-4 w-4 animate-spin" />
                        <span>Sedang masuk...</span>
                    </div>
                    <div v-else class="flex items-center justify-center gap-2">
                        <span>Masuk</span>
                        <svg
                            class="h-4 w-4 transition-transform group-hover:translate-x-1"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="2"
                            stroke="currentColor"
                        >
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                        </svg>
                    </div>
                </Button>
            </div>

            <!-- Register Link -->
            <div class="text-center text-sm text-muted-foreground">
                Belum punya akun?
                <TextLink :href="register()" class="font-medium text-primary transition-colors hover:text-primary/80" :tabindex="8">
                    Daftar sekarang
                </TextLink>
            </div>

            <!-- Security Note -->
            <div class="rounded-xl bg-muted/30 p-4 text-center">
                <div class="flex items-center justify-center gap-2 text-xs text-muted-foreground">
                    <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75m-6 0h.008v.008H9V12.75Z" />
                    </svg>
                    <span>Akun Anda dilindungi dengan enkripsi end-to-end</span>
                </div>
            </div>
        </Form>
    </AuthBase>
</template>

<style scoped>
.group:hover .group-hover\:translate-x-1 {
    transform: translateX(0.25rem);
}
</style>

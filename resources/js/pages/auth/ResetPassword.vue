<script setup lang="ts">
import NewPasswordController from '@/actions/App/Http/Controllers/Auth/NewPasswordController';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AuthLayout from '@/layouts/AuthLayout.vue';
import { Form, Head } from '@inertiajs/vue3';
import { LoaderCircle } from 'lucide-vue-next';
import { ref } from 'vue';

const props = defineProps<{
    token: string;
    email: string;
}>();

const inputEmail = ref(props.email);
</script>

<template>
    <AuthLayout title="Reset password" description="Please enter your new password below">
        <Head title="Reset password" />

        <div class="animate-fade-in mx-auto w-full max-w-md">
            <Form
                v-bind="NewPasswordController.store.form()"
                :transform="(data) => ({ ...data, token, email })"
                :reset-on-success="['password', 'password_confirmation']"
                v-slot="{ errors, processing }"
            >
                <div class="grid gap-6">
                    <div class="grid gap-3">
                        <Label for="email" class="text-sm font-medium text-card-foreground">Email</Label>
                        <div class="relative">
                            <div class="absolute top-1/2 left-3 -translate-y-1/2 transform text-muted-foreground">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"
                                    />
                                </svg>
                            </div>
                            <Input
                                id="email"
                                type="email"
                                name="email"
                                autocomplete="email"
                                v-model="inputEmail"
                                class="h-12 w-full cursor-not-allowed border-border/50 bg-muted/30 pl-10"
                                readonly
                            />
                        </div>
                        <InputError :message="errors.email" />
                    </div>

                    <div class="animate-fade-in grid gap-3 [animation-delay:200ms]">
                        <Label for="password" class="text-sm font-medium text-card-foreground">New Password</Label>
                        <div class="relative">
                            <div class="absolute top-1/2 left-3 -translate-y-1/2 transform text-muted-foreground">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"
                                    />
                                </svg>
                            </div>
                            <Input
                                id="password"
                                type="password"
                                name="password"
                                autocomplete="new-password"
                                class="h-12 w-full border-border/50 pl-10 transition-colors focus:border-primary/50"
                                autofocus
                                placeholder="Enter new password"
                            />
                        </div>
                        <InputError :message="errors.password" />
                    </div>

                    <div class="animate-fade-in grid gap-3 [animation-delay:400ms]">
                        <Label for="password_confirmation" class="text-sm font-medium text-card-foreground">Confirm Password</Label>
                        <div class="relative">
                            <div class="absolute top-1/2 left-3 -translate-y-1/2 transform text-muted-foreground">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"
                                    />
                                </svg>
                            </div>
                            <Input
                                id="password_confirmation"
                                type="password"
                                name="password_confirmation"
                                autocomplete="new-password"
                                class="h-12 w-full border-border/50 pl-10 transition-colors focus:border-primary/50"
                                placeholder="Confirm new password"
                            />
                        </div>
                        <InputError :message="errors.password_confirmation" />
                    </div>

                    <Button
                        type="submit"
                        class="animate-fade-in mt-6 h-12 w-full bg-gradient-to-r from-primary to-purple-600 font-medium text-primary-foreground shadow-lg transition-all duration-200 [animation-delay:600ms] hover:scale-[1.02] hover:from-primary/90 hover:to-purple-600/90 hover:shadow-xl"
                        :disabled="processing"
                    >
                        <LoaderCircle v-if="processing" class="mr-2 h-4 w-4 animate-spin" />
                        <span v-if="!processing">Reset password</span>
                        <span v-else>Resetting password...</span>
                    </Button>
                </div>
            </Form>
        </div>
    </AuthLayout>
</template>

<script setup lang="ts">
import ConfirmablePasswordController from '@/actions/App/Http/Controllers/Auth/ConfirmablePasswordController';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AuthLayout from '@/layouts/AuthLayout.vue';
import { Form, Head } from '@inertiajs/vue3';
import { LoaderCircle } from 'lucide-vue-next';
</script>

<template>
    <AuthLayout title="Confirm your password" description="This is a secure area of the application. Please confirm your password before continuing.">
        <Head title="Confirm password" />

        <div class="animate-fade-in mx-auto w-full max-w-md space-y-6">
            <div class="space-y-4 text-center">
                <div class="mb-4 flex items-center justify-center">
                    <div class="flex h-16 w-16 items-center justify-center rounded-full bg-yellow-100">
                        <svg class="h-8 w-8 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"
                            />
                        </svg>
                    </div>
                </div>
                <p class="text-sm text-muted-foreground">For security purposes, please confirm your password to continue.</p>
            </div>

            <Form
                v-bind="ConfirmablePasswordController.store.form()"
                reset-on-success
                v-slot="{ errors, processing }"
                class="animate-fade-in [animation-delay:200ms]"
            >
                <div class="space-y-6">
                    <div class="grid gap-3">
                        <Label htmlFor="password" class="text-sm font-medium text-card-foreground">Current Password</Label>
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
                                class="h-12 w-full border-border/50 pl-10 transition-colors focus:border-primary/50"
                                required
                                autocomplete="current-password"
                                autofocus
                                placeholder="Enter your password"
                            />
                        </div>
                        <InputError :message="errors.password" />
                    </div>

                    <Button
                        class="h-12 w-full bg-gradient-to-r from-primary to-purple-600 font-medium text-primary-foreground shadow-lg transition-all duration-200 hover:scale-[1.02] hover:from-primary/90 hover:to-purple-600/90 hover:shadow-xl"
                        :disabled="processing"
                    >
                        <LoaderCircle v-if="processing" class="mr-2 h-4 w-4 animate-spin" />
                        <svg v-if="!processing" class="mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span v-if="!processing">Confirm Password</span>
                        <span v-else>Confirming...</span>
                    </Button>
                </div>
            </Form>
        </div>
    </AuthLayout>
</template>

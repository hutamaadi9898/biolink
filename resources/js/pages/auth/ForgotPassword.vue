<script setup lang="ts">
import PasswordResetLinkController from '@/actions/App/Http/Controllers/Auth/PasswordResetLinkController';
import InputError from '@/components/InputError.vue';
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AuthLayout from '@/layouts/AuthLayout.vue';
import { login } from '@/routes';
import { Form, Head } from '@inertiajs/vue3';
import { LoaderCircle } from 'lucide-vue-next';

defineProps<{
    status?: string;
}>();
</script>

<template>
    <AuthLayout title="Forgot password" description="Enter your email to receive a password reset link">
        <Head title="Forgot password" />

        <div class="mx-auto w-full max-w-md">
            <div v-if="status" class="animate-fade-in mb-6 text-center text-sm font-medium text-green-600">
                {{ status }}
            </div>

            <div class="animate-fade-in space-y-6 [animation-delay:200ms]">
                <Form v-bind="PasswordResetLinkController.store.form()" v-slot="{ errors, processing }">
                    <div class="grid gap-3">
                        <Label for="email" class="text-sm font-medium text-card-foreground">Email address</Label>
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
                                autofocus
                                placeholder="name@example.com"
                                class="h-12 w-full border-border/50 pl-10 transition-colors focus:border-primary/50"
                            />
                        </div>
                        <InputError :message="errors.email" />
                    </div>

                    <div class="mt-8 flex items-center justify-start">
                        <Button
                            class="h-12 w-full bg-gradient-to-r from-primary to-purple-600 font-medium text-primary-foreground shadow-lg transition-all duration-200 hover:scale-[1.02] hover:from-primary/90 hover:to-purple-600/90 hover:shadow-xl"
                            :disabled="processing"
                        >
                            <LoaderCircle v-if="processing" class="mr-2 h-4 w-4 animate-spin" />
                            <span v-if="!processing">Email password reset link</span>
                            <span v-else>Sending link...</span>
                        </Button>
                    </div>
                </Form>

                <div class="space-x-1 text-center text-sm text-muted-foreground">
                    <span>Or, return to</span>
                    <TextLink :href="login()" class="font-medium text-primary transition-colors hover:text-primary/80">log in</TextLink>
                </div>
            </div>
        </div>
    </AuthLayout>
</template>

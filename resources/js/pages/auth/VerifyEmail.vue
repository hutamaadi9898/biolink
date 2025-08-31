<script setup lang="ts">
import EmailVerificationNotificationController from '@/actions/App/Http/Controllers/Auth/EmailVerificationNotificationController';
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import AuthLayout from '@/layouts/AuthLayout.vue';
import { logout } from '@/routes';
import { Form, Head } from '@inertiajs/vue3';
import { LoaderCircle } from 'lucide-vue-next';

defineProps<{
    status?: string;
}>();
</script>

<template>
    <AuthLayout title="Verify email" description="Please verify your email address by clicking on the link we just emailed to you.">
        <Head title="Email verification" />

        <div class="animate-fade-in mx-auto w-full max-w-md space-y-6">
            <div v-if="status === 'verification-link-sent'" class="animate-fade-in mb-6 text-center text-sm font-medium text-green-600">
                <div class="mb-2 flex items-center justify-center">
                    <div class="flex h-8 w-8 items-center justify-center rounded-full bg-green-100">
                        <svg class="h-4 w-4 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                </div>
                A new verification link has been sent to the email address you provided during registration.
            </div>

            <div class="animate-fade-in space-y-4 text-center [animation-delay:200ms]">
                <div class="mb-4 flex items-center justify-center">
                    <div class="flex h-16 w-16 items-center justify-center rounded-full bg-primary/10">
                        <svg class="h-8 w-8 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"
                            />
                        </svg>
                    </div>
                </div>
                <p class="text-sm text-muted-foreground">Check your email inbox and click the verification link to activate your account.</p>
            </div>

            <Form
                v-bind="EmailVerificationNotificationController.store.form()"
                class="animate-fade-in space-y-6 text-center [animation-delay:400ms]"
                v-slot="{ processing }"
            >
                <Button
                    :disabled="processing"
                    variant="secondary"
                    class="h-12 w-full border-border/50 transition-all duration-200 hover:scale-[1.02] hover:bg-muted/80"
                >
                    <LoaderCircle v-if="processing" class="mr-2 h-4 w-4 animate-spin" />
                    <svg v-if="!processing" class="mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"
                        />
                    </svg>
                    <span v-if="!processing">Resend verification email</span>
                    <span v-else>Sending...</span>
                </Button>

                <div class="border-t border-border/50 pt-6">
                    <TextLink
                        :href="logout()"
                        as="button"
                        class="mx-auto block text-sm text-muted-foreground transition-colors hover:text-foreground"
                    >
                        <svg class="mr-1 inline h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"
                            />
                        </svg>
                        Log out
                    </TextLink>
                </div>
            </Form>
        </div>
    </AuthLayout>
</template>

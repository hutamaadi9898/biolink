<template>
    <AppLayout>
        <Head title="Links" />

        <!-- Modern Header -->
        <div class="border-b border-gray-700/50 bg-gradient-to-br from-gray-900 via-purple-900/20 to-blue-900/20">
            <div class="mx-auto max-w-6xl px-6 py-8">
                <!-- Header Content -->
                <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
                    <div class="space-y-3">
                        <div class="flex items-center gap-2 text-sm text-gray-400">
                            <template v-for="(breadcrumb, index) in breadcrumbs" :key="index">
                                <a :href="breadcrumb.href" class="transition-colors hover:text-gray-200">
                                    {{ breadcrumb.title }}
                                </a>
                                <span v-if="index < breadcrumbs.length - 1" class="text-gray-600">/</span>
                            </template>
                        </div>
                        <h1 class="text-4xl font-bold text-white">Manage Links</h1>
                        <p class="text-lg text-gray-300">Add, edit, and organize your social media and portfolio links</p>
                    </div>

                    <div class="flex flex-col gap-4 sm:flex-row">
                        <Button
                            @click="showWizard = true"
                            class="flex items-center justify-center gap-3 rounded-2xl bg-gradient-to-r from-blue-600 to-purple-600 px-8 py-4 font-semibold text-white shadow-lg transition-all duration-300 hover:from-blue-700 hover:to-purple-700 hover:shadow-xl"
                        >
                            <PlusIcon class="h-5 w-5" />
                            Add New Link
                        </Button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Enhanced Content -->
        <div class="mx-auto max-w-6xl px-6 py-8">
            <div class="space-y-8">
                <!-- Simplified Wizard Modal -->
                <Transition
                    enter-active-class="transition duration-300 ease-out"
                    enter-from-class="transform scale-95 opacity-0"
                    enter-to-class="transform scale-100 opacity-100"
                    leave-active-class="transition duration-200 ease-in"
                    leave-from-class="transform scale-100 opacity-100"
                    leave-to-class="transform scale-95 opacity-0"
                >
                    <div v-if="showWizard" class="fixed inset-0 z-50 flex items-center justify-center bg-black/80 p-4 backdrop-blur-sm">
                        <div
                            class="w-full max-w-2xl overflow-hidden rounded-3xl border border-gray-600/50 bg-gray-800/95 shadow-2xl backdrop-blur-sm"
                        >
                            <!-- Modal Header -->
                            <div class="border-b border-gray-600/50 p-6">
                                <div class="flex items-center justify-between">
                                    <h3 class="flex items-center gap-2 text-xl font-semibold text-white">
                                        <div class="flex h-8 w-8 items-center justify-center rounded-xl bg-blue-600/20">
                                            <PlusIcon class="h-4 w-4 text-blue-400" />
                                        </div>
                                        Add New Link
                                    </h3>
                                    <button
                                        @click="closeWizard"
                                        class="rounded-xl p-2 text-gray-400 transition-colors hover:bg-gray-700/50 hover:text-gray-200"
                                    >
                                        <XMarkIcon class="h-5 w-5" />
                                    </button>
                                </div>

                                <!-- Simplified Progress Steps -->
                                <div class="mt-6 flex items-center gap-2">
                                    <div v-for="(step, index) in wizardSteps" :key="index" class="flex items-center">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="flex h-8 w-8 items-center justify-center rounded-full text-sm font-medium transition-colors"
                                                :class="[index <= currentStep ? 'bg-blue-600 text-white' : 'bg-gray-600 text-gray-400']"
                                            >
                                                <span v-if="index < currentStep">✓</span>
                                                <span v-else>{{ index + 1 }}</span>
                                            </div>
                                            <span class="text-sm font-medium text-gray-200">{{ step.title }}</span>
                                            <div v-if="index < wizardSteps.length - 1" class="mx-2 h-px w-6 bg-gray-600"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="p-8">
                                <form @submit.prevent="handleStepSubmit">
                                    <!-- Step 1: Simplified Link Type -->
                                    <div v-show="currentStep === 0" class="space-y-6">
                                        <div class="mb-8 text-center">
                                            <h3 class="mb-2 text-2xl font-bold text-white">What type of link are you adding?</h3>
                                            <p class="text-gray-400">Choose between social media or general links</p>
                                        </div>

                                        <div class="grid grid-cols-2 gap-4">
                                            <button
                                                v-for="linkType in simplifiedLinkTypes"
                                                :key="linkType.value"
                                                type="button"
                                                @click="selectLinkType(linkType.value)"
                                                class="group rounded-2xl border-2 p-6 transition-all duration-300 hover:scale-105"
                                                :class="[
                                                    addForm.type === linkType.value
                                                        ? 'border-blue-500 bg-blue-500/10 shadow-lg ring-4 ring-blue-500/20'
                                                        : 'border-gray-600 bg-gray-700/50 hover:border-blue-500/50 hover:shadow-md',
                                                ]"
                                            >
                                                <div class="text-center">
                                                    <div class="mb-3 text-4xl transition-transform duration-300 group-hover:scale-110">
                                                        {{ linkType.emoji }}
                                                    </div>
                                                    <h4 class="mb-2 font-semibold text-white">{{ linkType.title }}</h4>
                                                    <p class="text-sm text-gray-400">{{ linkType.description }}</p>
                                                </div>
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Step 2: Enhanced Link Details with Auto-Embed Detection -->
                                    <div v-show="currentStep === 1" class="space-y-6">
                                        <div class="mb-8 text-center">
                                            <h3 class="mb-2 text-2xl font-bold text-white">
                                                {{ addForm.type === 'social' ? 'Social Media Details' : 'Link Details' }}
                                            </h3>
                                            <p class="text-gray-400">
                                                {{
                                                    addForm.type === 'social'
                                                        ? 'Choose your platform and enter your username'
                                                        : 'Add your link title and URL'
                                                }}
                                            </p>
                                        </div>

                                        <!-- Social Media Selection -->
                                        <div v-if="addForm.type === 'social'" class="space-y-6">
                                            <div class="space-y-4">
                                                <label class="text-sm font-medium text-gray-200">Select Social Media Platform</label>
                                                <div class="grid grid-cols-2 gap-3">
                                                    <button
                                                        v-for="social in socialPlatforms"
                                                        :key="social.name"
                                                        type="button"
                                                        @click="selectSocialPlatform(social)"
                                                        class="group flex items-center gap-3 rounded-xl border-2 p-4 transition-all duration-300 hover:scale-[1.02]"
                                                        :class="[
                                                            selectedSocial?.name === social.name
                                                                ? 'border-blue-500 bg-blue-500/10 shadow-lg ring-2 ring-blue-500/20'
                                                                : 'border-gray-600 bg-gray-700/50 hover:border-blue-500/50 hover:shadow-md',
                                                        ]"
                                                    >
                                                        <div class="text-2xl transition-transform duration-300 group-hover:scale-110">
                                                            {{ social.emoji }}
                                                        </div>
                                                        <span class="font-medium text-white">{{ social.name }}</span>
                                                    </button>
                                                </div>
                                            </div>

                                            <div v-if="selectedSocial" class="space-y-2">
                                                <label class="flex items-center gap-2 text-sm font-medium text-gray-200">
                                                    <span class="text-xl">{{ selectedSocial.emoji }}</span>
                                                    {{ selectedSocial.name }} Username
                                                </label>
                                                <Input
                                                    v-model="addForm.username"
                                                    :placeholder="selectedSocial.placeholder"
                                                    class="h-14 rounded-xl border-gray-600 bg-gray-700/50 text-lg text-white placeholder-gray-400 focus:border-blue-500 focus:ring-blue-500"
                                                    required
                                                />
                                                <p class="text-xs text-gray-400">{{ selectedSocial.hint }}</p>
                                                <p v-if="addForm.errors.username" class="flex items-center gap-1 text-sm text-red-400">
                                                    <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                                        <path
                                                            fill-rule="evenodd"
                                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                            clip-rule="evenodd"
                                                        />
                                                    </svg>
                                                    {{ addForm.errors.username }}
                                                </p>
                                            </div>
                                        </div>

                                        <!-- Enhanced Regular Link Details -->
                                        <div v-else class="space-y-6">
                                            <div class="space-y-2">
                                                <label class="flex items-center gap-2 text-sm font-medium text-gray-200">
                                                    <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path
                                                            stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"
                                                        />
                                                    </svg>
                                                    Link Title
                                                </label>
                                                <Input
                                                    v-model="addForm.title"
                                                    placeholder="e.g., My Portfolio Website"
                                                    class="h-14 rounded-xl border-gray-600 bg-gray-700/50 text-lg text-white placeholder-gray-400 focus:border-blue-500 focus:ring-blue-500"
                                                    required
                                                />
                                                <p v-if="addForm.errors.title" class="flex items-center gap-1 text-sm text-red-400">
                                                    <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                                        <path
                                                            fill-rule="evenodd"
                                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                            clip-rule="evenodd"
                                                        />
                                                    </svg>
                                                    {{ addForm.errors.title }}
                                                </p>
                                            </div>

                                            <div class="space-y-2">
                                                <label class="flex items-center gap-2 text-sm font-medium text-gray-200">
                                                    <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path
                                                            stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"
                                                        />
                                                    </svg>
                                                    URL
                                                </label>
                                                <Input
                                                    v-model="addForm.url"
                                                    type="url"
                                                    placeholder="https://example.com"
                                                    class="h-14 rounded-xl border-gray-600 bg-gray-700/50 text-lg text-white placeholder-gray-400 focus:border-blue-500 focus:ring-blue-500"
                                                    @input="detectEmbedType"
                                                    required
                                                />
                                                <p v-if="addForm.errors.url" class="flex items-center gap-1 text-sm text-red-400">
                                                    <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                                        <path
                                                            fill-rule="evenodd"
                                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                            clip-rule="evenodd"
                                                        />
                                                    </svg>
                                                    {{ addForm.errors.url }}
                                                </p>
                                            </div>

                                            <!-- Auto-Embed Detection Alert -->
                                            <div v-if="detectedEmbed" class="rounded-xl border border-purple-500/50 bg-purple-500/10 p-4">
                                                <div class="flex items-start gap-3">
                                                    <div class="flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-lg bg-purple-500/20">
                                                        <svg class="h-4 w-4 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path
                                                                stroke-linecap="round"
                                                                stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"
                                                            />
                                                        </svg>
                                                    </div>
                                                    <div class="flex-1">
                                                        <h5 class="mb-1 text-sm font-semibold text-purple-300">Rich Media Detected!</h5>
                                                        <p class="mb-3 text-sm text-gray-300">
                                                            We detected this is a <strong>{{ detectedEmbed.platform }}</strong> link. Would you like
                                                            to show it as an embedded preview?
                                                        </p>
                                                        <div class="flex items-center gap-3">
                                                            <button
                                                                type="button"
                                                                @click="acceptEmbed"
                                                                class="rounded-lg bg-purple-600 px-4 py-2 text-sm font-medium text-white transition-colors hover:bg-purple-700"
                                                            >
                                                                Yes, show as embed
                                                            </button>
                                                            <button
                                                                type="button"
                                                                @click="rejectEmbed"
                                                                class="rounded-lg bg-gray-600 px-4 py-2 text-sm font-medium text-white transition-colors hover:bg-gray-700"
                                                            >
                                                                No, show as regular link
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Custom Image Upload for Non-Embed Links -->
                                            <div v-if="!addForm.show_as_embed && addForm.type !== 'social'" class="space-y-2">
                                                <label class="flex items-center gap-2 text-sm font-medium text-gray-200">
                                                    <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path
                                                            stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"
                                                        />
                                                    </svg>
                                                    Custom Image (Optional)
                                                </label>
                                                <div class="relative">
                                                    <input
                                                        ref="imageInput"
                                                        type="file"
                                                        accept="image/*"
                                                        @change="handleImageUpload"
                                                        class="absolute inset-0 h-full w-full cursor-pointer opacity-0"
                                                    />
                                                    <div
                                                        class="flex items-center gap-4 rounded-xl border-2 border-dashed border-gray-600 p-4 transition-colors hover:border-blue-500/50"
                                                    >
                                                        <div v-if="imagePreview" class="flex items-center gap-3">
                                                            <img :src="imagePreview" alt="Preview" class="h-12 w-12 rounded-lg object-cover" />
                                                            <div class="flex-1">
                                                                <p class="text-sm font-medium text-white">{{ selectedImageName }}</p>
                                                                <p class="text-xs text-gray-400">Click to change image</p>
                                                            </div>
                                                            <button
                                                                type="button"
                                                                @click="clearImage"
                                                                class="p-1 text-gray-400 transition-colors hover:text-red-400"
                                                            >
                                                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path
                                                                        stroke-linecap="round"
                                                                        stroke-linejoin="round"
                                                                        stroke-width="2"
                                                                        d="M6 18L18 6M6 6l12 12"
                                                                    />
                                                                </svg>
                                                            </button>
                                                        </div>
                                                        <div v-else class="flex items-center gap-3 text-gray-400">
                                                            <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path
                                                                    stroke-linecap="round"
                                                                    stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"
                                                                />
                                                            </svg>
                                                            <div>
                                                                <p class="text-sm font-medium">Click to upload an image</p>
                                                                <p class="text-xs">PNG, JPG up to 5MB</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <p v-if="addForm.errors.image" class="flex items-center gap-1 text-sm text-red-400">
                                                    <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                                        <path
                                                            fill-rule="evenodd"
                                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                            clip-rule="evenodd"
                                                        />
                                                    </svg>
                                                    {{ addForm.errors.image }}
                                                </p>
                                            </div>

                                            <!-- Enhanced Preview -->
                                            <div class="rounded-xl border-2 border-dashed border-gray-600 bg-gray-700/30 p-4">
                                                <h5 class="mb-3 text-sm font-medium text-gray-200">Preview</h5>
                                                <div class="flex items-center gap-3">
                                                    <div
                                                        class="flex h-12 w-12 flex-shrink-0 items-center justify-center overflow-hidden rounded-xl"
                                                        :class="imagePreview ? '' : getLinkIconStyle(addForm.type)"
                                                    >
                                                        <img
                                                            v-if="imagePreview"
                                                            :src="imagePreview"
                                                            alt="Link preview"
                                                            class="h-full w-full object-cover"
                                                        />
                                                        <span v-else class="text-xl">{{ getLinkEmoji(addForm.type) }}</span>
                                                    </div>
                                                    <div class="min-w-0 flex-1">
                                                        <h6 class="truncate font-semibold text-white">
                                                            {{ addForm.title || 'Link Title' }}
                                                        </h6>
                                                        <p class="truncate text-sm text-gray-400">
                                                            {{ addForm.url || 'https://example.com' }}
                                                        </p>
                                                        <div v-if="addForm.show_as_embed && detectedEmbed" class="mt-1 flex items-center gap-1">
                                                            <svg
                                                                class="h-3 w-3 text-purple-400"
                                                                fill="none"
                                                                stroke="currentColor"
                                                                viewBox="0 0 24 24"
                                                            >
                                                                <path
                                                                    stroke-linecap="round"
                                                                    stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 002 2v8a2 2 0 002 2z"
                                                                />
                                                            </svg>
                                                            <span class="text-xs text-purple-400">{{ detectedEmbed.platform }} embed</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Navigation Buttons -->
                                    <div class="mt-8 flex items-center justify-between border-t border-gray-600 pt-6">
                                        <Button
                                            v-if="currentStep > 0"
                                            type="button"
                                            @click="previousStep"
                                            variant="outline"
                                            class="flex items-center gap-2 rounded-xl border-gray-600 bg-gray-700/50 px-6 py-3 text-gray-300 hover:bg-gray-600/50"
                                        >
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                            </svg>
                                            Back
                                        </Button>
                                        <div v-else></div>

                                        <div class="flex items-center gap-3">
                                            <Button
                                                type="button"
                                                @click="closeWizard"
                                                variant="outline"
                                                class="rounded-xl border-gray-600 bg-gray-700/50 px-4 py-3 text-gray-300 hover:bg-gray-600/50"
                                            >
                                                Cancel
                                            </Button>

                                            <Button
                                                v-if="currentStep < wizardSteps.length - 1"
                                                type="button"
                                                @click="nextStep"
                                                :disabled="!canProceed"
                                                class="flex items-center gap-2 rounded-xl bg-gradient-to-r from-blue-600 to-purple-600 px-8 py-3 font-semibold text-white shadow-lg transition-all duration-300 hover:from-blue-700 hover:to-purple-700 hover:shadow-xl disabled:cursor-not-allowed disabled:opacity-50"
                                            >
                                                Continue
                                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                                </svg>
                                            </Button>

                                            <Button
                                                v-else
                                                type="submit"
                                                :disabled="addForm.processing || !canProceed"
                                                class="flex items-center gap-2 rounded-xl bg-gradient-to-r from-green-600 to-emerald-600 px-8 py-3 font-semibold text-white shadow-lg transition-all duration-300 hover:from-green-700 hover:to-emerald-700 hover:shadow-xl disabled:cursor-not-allowed disabled:opacity-50"
                                            >
                                                <svg v-if="addForm.processing" class="h-5 w-5 animate-spin" fill="none" viewBox="0 0 24 24">
                                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                    <path
                                                        class="opacity-75"
                                                        fill="currentColor"
                                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
                                                    ></path>
                                                </svg>
                                                <svg v-else class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                </svg>
                                                {{ addForm.processing ? 'Creating...' : 'Create Link' }}
                                            </Button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </Transition>

                <!-- Links List -->
                <div v-if="links.length > 0" class="space-y-4">
                    <h3 class="flex items-center gap-2 text-xl font-semibold text-white">
                        <div class="flex h-6 w-6 items-center justify-center rounded-lg bg-gray-700">
                            <LinkIcon class="h-4 w-4 text-gray-300" />
                        </div>
                        Your Links
                    </h3>

                    <div class="space-y-3">
                        <div
                            v-for="link in links"
                            :key="link.id"
                            class="group rounded-2xl border border-gray-600/50 bg-gray-800/90 p-5 backdrop-blur-sm transition-all duration-300 hover:border-gray-500/50 hover:shadow-md"
                        >
                            <div class="flex items-center justify-between">
                                <!-- Link Info -->
                                <div class="flex min-w-0 flex-1 items-center gap-4">
                                    <!-- Icon -->
                                    <div
                                        class="flex h-12 w-12 flex-shrink-0 items-center justify-center overflow-hidden rounded-2xl text-xl"
                                        :class="link.image ? '' : getLinkIconStyle(link.type)"
                                    >
                                        <img v-if="link.image" :src="'/storage/' + link.image" alt="Link image" class="h-full w-full object-cover" />
                                        <span v-else>{{ getLinkEmoji(link.type) }}</span>
                                    </div>

                                    <!-- Link Details -->
                                    <div class="min-w-0 flex-1">
                                        <div class="mb-1 flex items-center gap-3">
                                            <h4 class="truncate text-lg font-semibold text-white">{{ link.title }}</h4>
                                            <span
                                                v-if="link.embed_type"
                                                class="flex items-center gap-1 rounded-full bg-purple-500/20 px-3 py-1 text-xs font-medium text-purple-300"
                                            >
                                                <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 002 2v8a2 2 0 002 2z"
                                                    />
                                                </svg>
                                                {{ link.embed_type }}
                                            </span>
                                        </div>
                                        <p class="mb-2 truncate text-sm text-gray-400">{{ link.url }}</p>
                                        <div class="flex items-center gap-4">
                                            <span class="flex items-center gap-1 text-xs text-gray-500">
                                                <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                                                    />
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"
                                                    />
                                                </svg>
                                                {{ link.click_count || 0 }} clicks
                                            </span>
                                            <div class="flex items-center gap-1">
                                                <div class="h-2 w-2 rounded-full" :class="link.is_active ? 'bg-green-400' : 'bg-gray-500'"></div>
                                                <span class="text-xs text-gray-500">{{ link.is_active ? 'Active' : 'Inactive' }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Actions -->
                                <div class="flex items-center gap-1">
                                    <!-- Toggle Button -->
                                    <button
                                        @click="toggleLink(link)"
                                        :class="link.is_active ? 'text-green-400 hover:bg-green-500/10' : 'text-gray-500 hover:bg-gray-700/50'"
                                        class="rounded-xl p-2 transition-colors"
                                        :title="link.is_active ? 'Deactivate' : 'Activate'"
                                    >
                                        <EyeIcon v-if="link.is_active" class="h-5 w-5" />
                                        <EyeSlashIcon v-else class="h-5 w-5" />
                                    </button>

                                    <!-- Edit Button -->
                                    <button
                                        @click="editLink(link)"
                                        class="rounded-xl p-2 text-blue-400 transition-colors hover:bg-blue-500/10"
                                        title="Edit"
                                    >
                                        <PencilIcon class="h-5 w-5" />
                                    </button>

                                    <!-- Delete Button -->
                                    <button
                                        @click="deleteLink(link)"
                                        class="rounded-xl p-2 text-red-400 transition-colors hover:bg-red-500/10"
                                        title="Delete"
                                    >
                                        <TrashIcon class="h-5 w-5" />
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Empty State -->
                <div v-else class="rounded-3xl border-2 border-dashed border-gray-600 bg-gray-800/90 p-12 text-center backdrop-blur-sm">
                    <div class="mb-6 flex justify-center">
                        <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-gray-700">
                            <LinkIcon class="h-8 w-8 text-gray-400" />
                        </div>
                    </div>
                    <h3 class="mb-2 text-xl font-semibold text-white">No links yet</h3>
                    <p class="mb-6 text-gray-400">Click "Add New Link" above to get started</p>
                </div>
            </div>
        </div>

        <!-- Enhanced Edit Modal -->
        <Transition
            enter-active-class="transition duration-300 ease-out"
            enter-from-class="transform scale-95 opacity-0"
            enter-to-class="transform scale-100 opacity-100"
            leave-active-class="transition duration-200 ease-in"
            leave-from-class="transform scale-100 opacity-100"
            leave-to-class="transform scale-95 opacity-0"
        >
            <div v-if="editingLink" class="fixed inset-0 z-50 flex items-center justify-center bg-black/80 p-4 backdrop-blur-sm">
                <div class="w-full max-w-lg overflow-hidden rounded-3xl border border-gray-600/50 bg-gray-800/95 shadow-2xl backdrop-blur-sm">
                    <!-- Modal Header -->
                    <div class="border-b border-gray-600/50 p-6">
                        <div class="flex items-center justify-between">
                            <h3 class="flex items-center gap-2 text-xl font-semibold text-white">
                                <div class="flex h-8 w-8 items-center justify-center rounded-xl bg-blue-600/20">
                                    <PencilIcon class="h-4 w-4 text-blue-400" />
                                </div>
                                Edit Link
                            </h3>
                            <button
                                @click="editingLink = null"
                                class="rounded-xl p-2 text-gray-400 transition-colors hover:bg-gray-700/50 hover:text-gray-200"
                            >
                                <XMarkIcon class="h-5 w-5" />
                            </button>
                        </div>
                    </div>

                    <!-- Modal Content -->
                    <div class="p-6">
                        <form @submit.prevent="updateLink" class="space-y-6">
                            <div class="space-y-2">
                                <label class="flex items-center gap-2 text-sm font-medium text-gray-200">
                                    <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"
                                        />
                                    </svg>
                                    Title
                                </label>
                                <Input
                                    v-model="editForm.title"
                                    placeholder="Link title"
                                    class="h-12 rounded-xl border-gray-600 bg-gray-700/50 text-white placeholder-gray-400 focus:border-blue-500 focus:ring-blue-500"
                                    required
                                />
                            </div>

                            <div class="space-y-2">
                                <label class="flex items-center gap-2 text-sm font-medium text-gray-200">
                                    <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"
                                        />
                                    </svg>
                                    URL
                                </label>
                                <Input
                                    v-model="editForm.url"
                                    type="url"
                                    placeholder="https://example.com"
                                    class="h-12 rounded-xl border-gray-600 bg-gray-700/50 text-white placeholder-gray-400 focus:border-blue-500 focus:ring-blue-500"
                                    required
                                />
                            </div>

                            <div class="space-y-2">
                                <label class="flex items-center gap-2 text-sm font-medium text-gray-200">
                                    <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"
                                        />
                                    </svg>
                                    Category
                                </label>
                                <select
                                    v-model="editForm.type"
                                    class="h-12 w-full rounded-xl border-gray-600 bg-gray-700/50 text-white focus:border-blue-500 focus:ring-blue-500"
                                >
                                    <option value="custom">🔗 General Link</option>
                                    <option value="social">📱 Social Media</option>
                                </select>
                            </div>

                            <label
                                class="flex cursor-pointer items-center gap-3 rounded-xl border border-gray-600 p-3 transition-colors hover:border-purple-500/50 hover:bg-purple-500/5"
                            >
                                <input
                                    v-model="editForm.show_as_embed"
                                    type="checkbox"
                                    class="h-4 w-4 rounded border-gray-500 bg-gray-700 text-purple-600 focus:ring-purple-500"
                                />
                                <div class="flex items-center gap-2">
                                    <svg class="h-4 w-4 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 002 2v8a2 2 0 002 2z"
                                        />
                                    </svg>
                                    <span class="text-sm font-medium text-gray-200">Show as embed</span>
                                </div>
                            </label>

                            <div class="flex justify-end gap-3 border-t border-gray-600 pt-4">
                                <Button
                                    type="button"
                                    variant="outline"
                                    @click="editingLink = null"
                                    class="rounded-xl border-gray-600 bg-gray-700/50 px-6 py-2.5 text-gray-300 hover:bg-gray-600/50"
                                >
                                    Cancel
                                </Button>
                                <Button
                                    type="submit"
                                    :disabled="editForm.processing"
                                    class="rounded-xl bg-gradient-to-r from-blue-600 to-purple-600 px-6 py-2.5 font-medium text-white shadow-lg transition-all duration-300 hover:from-blue-700 hover:to-purple-700 hover:shadow-xl disabled:opacity-50"
                                >
                                    {{ editForm.processing ? 'Saving...' : 'Save Changes' }}
                                </Button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </Transition>
    </AppLayout>
</template>

<script lang="ts">
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import AppLayout from '@/layouts/AppLayout.vue';
import { EyeIcon, EyeSlashIcon, LinkIcon, PencilIcon, PlusIcon, TrashIcon, XMarkIcon } from '@heroicons/vue/24/outline';
import { Head, router, useForm } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

const props = defineProps({
    links: Array,
});

const editingLink = ref(null);

// Simplified Wizard state
const showWizard = ref(false);
const currentStep = ref(0);
const selectedSocial = ref(null);
const detectedEmbed = ref(null);
const imagePreview = ref(null);
const selectedImageName = ref('');
const imageInput = ref(null);

const wizardSteps = [
    { title: 'Type', completed: false },
    { title: 'Details', completed: false },
];

// Simplified link types - only 2 options
const simplifiedLinkTypes = [
    {
        value: 'custom',
        title: 'Links',
        emoji: '🔗',
        description: 'Any website, portfolio, or general link',
    },
    {
        value: 'social',
        title: 'Social Media',
        emoji: '📱',
        description: 'Instagram, TikTok, YouTube, and more',
    },
];

const socialPlatforms = [
    {
        name: 'Instagram',
        emoji: '📷',
        baseUrl: 'https://instagram.com/',
        placeholder: 'your_username',
        hint: 'Enter your Instagram username without @',
    },
    {
        name: 'TikTok',
        emoji: '🎵',
        baseUrl: 'https://tiktok.com/@',
        placeholder: 'your_username',
        hint: 'Enter your TikTok username without @',
    },
    {
        name: 'YouTube',
        emoji: '🎥',
        baseUrl: 'https://youtube.com/@',
        placeholder: 'your_channel',
        hint: 'Enter your YouTube channel name',
    },
    {
        name: 'Twitter',
        emoji: '🐦',
        baseUrl: 'https://twitter.com/',
        placeholder: 'your_username',
        hint: 'Enter your Twitter username without @',
    },
    {
        name: 'LinkedIn',
        emoji: '💼',
        baseUrl: 'https://linkedin.com/in/',
        placeholder: 'your-profile',
        hint: 'Enter your LinkedIn profile ID',
    },
    {
        name: 'Facebook',
        emoji: '👥',
        baseUrl: 'https://facebook.com/',
        placeholder: 'your.name',
        hint: 'Enter your Facebook profile name',
    },
    {
        name: 'Spotify',
        emoji: '🎧',
        baseUrl: 'https://open.spotify.com/user/',
        placeholder: 'your_username',
        hint: 'Enter your Spotify username',
    },
    {
        name: 'GitHub',
        emoji: '⚡',
        baseUrl: 'https://github.com/',
        placeholder: 'your_username',
        hint: 'Enter your GitHub username',
    },
];

const breadcrumbs = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
    {
        title: 'Links',
        href: '/dashboard/links',
    },
];

// Enhanced Add Form with image support
const addForm = useForm({
    title: '',
    url: '',
    username: '',
    type: 'custom',
    show_as_embed: false,
    image: null,
});

// Auto-embed detection function
const detectEmbedType = () => {
    const url = addForm.url;
    if (!url) {
        detectedEmbed.value = null;
        return;
    }

    // YouTube detection
    if (url.includes('youtube.com') || url.includes('youtu.be')) {
        detectedEmbed.value = { platform: 'YouTube', type: 'youtube' };
        return;
    }

    // Spotify detection
    if (url.includes('spotify.com')) {
        detectedEmbed.value = { platform: 'Spotify', type: 'spotify' };
        return;
    }

    // Instagram detection
    if (url.includes('instagram.com')) {
        detectedEmbed.value = { platform: 'Instagram', type: 'instagram' };
        return;
    }

    detectedEmbed.value = null;
};

const acceptEmbed = () => {
    addForm.show_as_embed = true;
    detectedEmbed.value = null;
};

const rejectEmbed = () => {
    addForm.show_as_embed = false;
    detectedEmbed.value = null;
};

// Image upload handling
const handleImageUpload = (event) => {
    const file = event.target.files[0];
    if (file) {
        // Validate file size (5MB)
        if (file.size > 5 * 1024 * 1024) {
            alert('File size must be less than 5MB');
            return;
        }

        addForm.image = file;
        selectedImageName.value = file.name;

        // Create preview
        const reader = new FileReader();
        reader.onload = (e) => {
            imagePreview.value = e.target.result;
        };
        reader.readAsDataURL(file);
    }
};

const clearImage = () => {
    addForm.image = null;
    imagePreview.value = null;
    selectedImageName.value = '';
    if (imageInput.value) {
        imageInput.value.value = '';
    }
};

// Wizard functions
const canProceed = computed(() => {
    if (currentStep.value === 0) return addForm.type !== '';
    if (currentStep.value === 1) {
        if (addForm.type === 'social') {
            return selectedSocial.value && addForm.username !== '';
        }
        return addForm.title !== '' && addForm.url !== '';
    }
    return true;
});

const selectLinkType = (type) => {
    addForm.type = type;
    if (type !== 'social') {
        selectedSocial.value = null;
        addForm.username = '';
    }
};

const selectSocialPlatform = (social) => {
    selectedSocial.value = social;
    addForm.title = `${social.emoji} ${social.name}`;
    addForm.show_as_embed = ['YouTube', 'Spotify', 'Instagram'].includes(social.name);
};

const nextStep = () => {
    if (canProceed.value && currentStep.value < wizardSteps.length - 1) {
        currentStep.value++;
    }
};

const previousStep = () => {
    if (currentStep.value > 0) {
        currentStep.value--;
    }
};

const closeWizard = () => {
    showWizard.value = false;
    currentStep.value = 0;
    selectedSocial.value = null;
    detectedEmbed.value = null;
    clearImage();
    addForm.reset();
};

const handleStepSubmit = () => {
    if (currentStep.value === wizardSteps.length - 1) {
        addLink();
    } else {
        nextStep();
    }
};

// Enhanced Edit Form
const editForm = useForm({
    title: '',
    url: '',
    type: 'custom',
    show_as_embed: false,
});

const addLink = () => {
    // If it's a social media link, construct the URL from username
    if (addForm.type === 'social' && selectedSocial.value && addForm.username) {
        addForm.url = selectedSocial.value.baseUrl + addForm.username.replace('@', '');
        addForm.title = `${selectedSocial.value.emoji} ${selectedSocial.value.name}`;
    }

    addForm.post('/dashboard/links', {
        onSuccess: () => {
            addForm.reset();
            closeWizard();
        },
    });
};

const editLink = (link) => {
    editingLink.value = link;
    editForm.title = link.title;
    editForm.url = link.url;
    editForm.type = link.type || 'custom';
    editForm.show_as_embed = link.show_as_embed || false;
};

const updateLink = () => {
    editForm.put(`/dashboard/links/${editingLink.value.id}`, {
        onSuccess: () => {
            editingLink.value = null;
            editForm.reset();
        },
    });
};

const deleteLink = (link) => {
    if (confirm('Are you sure you want to delete this link?')) {
        router.delete(`/dashboard/links/${link.id}`);
    }
};

const toggleLink = (link) => {
    router.patch(`/dashboard/links/${link.id}/toggle`);
};

// Helper functions for link icons and styles
const getLinkIcon = (type) => {
    const icons = {
        social: '📱',
        custom: '🔗',
    };
    return icons[type] || LinkIcon;
};

const getLinkEmoji = (type) => {
    const emojis = {
        social: '📱',
        custom: '🔗',
    };
    return emojis[type] || '🔗';
};

const getLinkIconStyle = (type) => {
    const styles = {
        social: 'bg-gradient-to-br from-pink-100 to-rose-100 text-pink-600',
        custom: 'bg-gradient-to-br from-blue-100 to-indigo-100 text-blue-600',
    };
    return styles[type] || 'bg-gradient-to-br from-gray-100 to-slate-100 text-gray-600';
};
</script>

<style scoped>
@keyframes slideUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-slideUp {
    animation: slideUp 0.3s ease-out;
}

.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>

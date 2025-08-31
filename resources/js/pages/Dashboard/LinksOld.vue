<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <Head title="Links" />

        <div class="min-h-screen bg-gradient-to-br from-gray-900 via-slate-900 to-gray-800 p-4 lg:p-8">
            <!-- Modern Header -->
            <div class="mb-8 text-center">
                <h1 class="text-4xl font-bold bg-gradient-to-r from-white via-blue-200 to-purple-200 bg-clip-text text-transparent mb-2">
                    Links
                </h1>
                <p class="text-gray-300 text-lg">Create and manage your biolink collection</p>
            </div>

            <!-- Success Notification -->
            <Transition
                enter-active-class="transition duration-300 ease-out"
                enter-from-class="transform scale-95 opacity-0"
                enter-to-class="transform scale-100 opacity-100"
                leave-active-class="transition duration-200 ease-in"
                leave-from-class="transform scale-100 opacity-100"
                leave-to-class="transform scale-95 opacity-0"
            >
                <div
                    v-if="$page.props.flash?.success"
                    class="mb-6 rounded-2xl border border-emerald-500/30 bg-emerald-900/20 p-4 shadow-sm"
                >
                    <div class="flex items-center gap-3">
                        <div class="flex-shrink-0">
                            <svg class="w-5 h-5 text-emerald-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <p class="text-emerald-200 font-medium">{{ $page.props.flash.success }}</p>
                    </div>
                </div>
            </Transition>

            <div class="max-w-4xl mx-auto">
                <!-- Main Content - Links -->
                <div class="space-y-6">
                    <!-- Step-by-Step Add Link Wizard -->
                    <div v-if="!showWizard" class="text-center">
                        <Button
                            @click="showWizard = true"
                            class="group mx-auto bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-semibold px-8 py-4 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 flex items-center gap-3"
                        >
                            <PlusIcon class="w-6 h-6 group-hover:rotate-90 transition-transform duration-300" />
                            <span class="text-lg">Add New Link</span>
                        </Button>
                        <p class="text-gray-400 mt-3">Start building your biolink collection</p>
                    </div>

                    <!-- Multi-Step Wizard -->
                    <Transition
                        enter-active-class="transition duration-500 ease-out"
                        enter-from-class="transform scale-95 opacity-0 translate-y-8"
                        enter-to-class="transform scale-100 opacity-100 translate-y-0"
                        leave-active-class="transition duration-300 ease-in"
                        leave-from-class="transform scale-100 opacity-100 translate-y-0"
                        leave-to-class="transform scale-95 opacity-0 translate-y-8"
                    >
                        <div v-if="showWizard" class="bg-gray-800/90 backdrop-blur-sm rounded-3xl border border-gray-600/50 shadow-xl overflow-hidden">
                            <!-- Wizard Header with Progress -->
                            <div class="p-6 border-b border-gray-600/50 bg-gradient-to-r from-gray-800/50 to-gray-700/50">
                                <div class="flex items-center justify-between mb-4">
                                    <h2 class="text-xl font-semibold text-white flex items-center gap-2">
                                        <div class="w-8 h-8 bg-blue-600/20 rounded-xl flex items-center justify-center">
                                            <PlusIcon class="w-4 h-4 text-blue-400" />
                                        </div>
                                        Add New Link
                                    </h2>
                                    <button
                                        @click="closeWizard"
                                        class="p-2 rounded-xl text-gray-400 hover:text-gray-200 hover:bg-gray-700/50 transition-colors"
                                    >
                                        <XMarkIcon class="w-5 h-5" />
                                    </button>
                                </div>
                                
                                <!-- Progress Steps -->
                                <div class="flex items-center gap-4">
                                    <div
                                        v-for="(step, index) in wizardSteps"
                                        :key="index"
                                        class="flex items-center gap-2"
                                    >
                                        <div
                                            class="flex items-center justify-center w-8 h-8 rounded-full text-sm font-medium transition-all duration-300"
                                            :class="[
                                                currentStep > index
                                                    ? 'bg-green-500 text-white'
                                                    : currentStep === index
                                                    ? 'bg-blue-500 text-white ring-4 ring-blue-500/20'
                                                    : 'bg-gray-600 text-gray-300'
                                            ]"
                                        >
                                            <svg v-if="currentStep > index" class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                            </svg>
                                            <span v-else>{{ index + 1 }}</span>
                                        </div>
                                        <span class="text-sm font-medium text-gray-200">{{ step.title }}</span>
                                        <div v-if="index < wizardSteps.length - 1" class="w-6 h-px bg-gray-600 mx-2"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="p-8">
                                <form @submit.prevent="handleStepSubmit">
                                    <!-- Step 1: Link Type -->
                                    <div v-show="currentStep === 0" class="space-y-6">
                                        <div class="text-center mb-8">
                                            <h3 class="text-2xl font-bold text-white mb-2">What type of link are you adding?</h3>
                                            <p class="text-gray-400">Choose the category that best describes your link</p>
                                        </div>
                                        
                                        <div class="grid grid-cols-2 gap-4">
                                            <button
                                                v-for="linkType in linkTypes"
                                                :key="linkType.value"
                                                type="button"
                                                @click="selectLinkType(linkType.value)"
                                                class="group p-6 rounded-2xl border-2 transition-all duration-300 hover:scale-105"
                                                :class="[
                                                    addForm.type === linkType.value
                                                        ? 'border-blue-500 bg-blue-500/10 shadow-lg ring-4 ring-blue-500/20'
                                                        : 'border-gray-600 bg-gray-700/50 hover:border-blue-500/50 hover:shadow-md'
                                                ]"
                                            >
                                                <div class="text-center">
                                                    <div class="text-4xl mb-3 group-hover:scale-110 transition-transform duration-300">
                                                        {{ linkType.emoji }}
                                                    </div>
                                                    <h4 class="font-semibold text-white mb-2">{{ linkType.title }}</h4>
                                                    <p class="text-sm text-gray-400">{{ linkType.description }}</p>
                                                </div>
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Step 2: Link Details -->
                                    <div v-show="currentStep === 1" class="space-y-6">
                                        <div class="text-center mb-8">
                                            <h3 class="text-2xl font-bold text-white mb-2">
                                                {{ addForm.type === 'social' ? 'Social Media Details' : 'Link Details' }}
                                            </h3>
                                            <p class="text-gray-400">
                                                {{ addForm.type === 'social' ? 'Choose your platform and enter your username' : 'Add your link title and URL' }}
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
                                                        class="group flex items-center gap-3 p-4 rounded-xl border-2 transition-all duration-300 hover:scale-[1.02]"
                                                        :class="[
                                                            selectedSocial?.name === social.name
                                                                ? 'border-blue-500 bg-blue-500/10 shadow-lg ring-2 ring-blue-500/20'
                                                                : 'border-gray-600 bg-gray-700/50 hover:border-blue-500/50 hover:shadow-md'
                                                        ]"
                                                    >
                                                        <div class="text-2xl group-hover:scale-110 transition-transform duration-300">{{ social.emoji }}</div>
                                                        <span class="font-medium text-white">{{ social.name }}</span>
                                                    </button>
                                                </div>
                                            </div>

                                            <div v-if="selectedSocial" class="space-y-2">
                                                <label class="text-sm font-medium text-gray-200 flex items-center gap-2">
                                                    <span class="text-xl">{{ selectedSocial.emoji }}</span>
                                                    {{ selectedSocial.name }} Username
                                                </label>
                                                <Input
                                                    v-model="addForm.username"
                                                    :placeholder="selectedSocial.placeholder"
                                                    class="h-14 text-lg bg-gray-700/50 border-gray-600 text-white placeholder-gray-400 focus:border-blue-500 focus:ring-blue-500 rounded-xl"
                                                    required
                                                />
                                                <p class="text-xs text-gray-400">{{ selectedSocial.hint }}</p>
                                                <p v-if="addForm.errors.username" class="text-sm text-red-400 flex items-center gap-1">
                                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                                    </svg>
                                                    {{ addForm.errors.username }}
                                                </p>
                                            </div>
                                        </div>

                                        <!-- Regular Link Details -->
                                        <div v-else class="space-y-6">
                                            <div class="space-y-2">
                                                <label class="text-sm font-medium text-gray-200 flex items-center gap-2">
                                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                                    </svg>
                                                    Link Title
                                                </label>
                                                <Input
                                                    v-model="addForm.title"
                                                    placeholder="e.g., My Portfolio Website"
                                                    class="h-14 text-lg bg-gray-700/50 border-gray-600 text-white placeholder-gray-400 focus:border-blue-500 focus:ring-blue-500 rounded-xl"
                                                    required
                                                />
                                                <p v-if="addForm.errors.title" class="text-sm text-red-400 flex items-center gap-1">
                                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                                    </svg>
                                                    {{ addForm.errors.title }}
                                                </p>
                                            </div>

                                            <div class="space-y-2">
                                                <label class="text-sm font-medium text-gray-200 flex items-center gap-2">
                                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                                                    </svg>
                                                    URL
                                                </label>
                                                <Input
                                                    v-model="addForm.url"
                                                    type="url"
                                                    placeholder="https://example.com"
                                                    class="h-14 text-lg bg-gray-700/50 border-gray-600 text-white placeholder-gray-400 focus:border-blue-500 focus:ring-blue-500 rounded-xl"
                                                    required
                                                />
                                                <p v-if="addForm.errors.url" class="text-sm text-red-400 flex items-center gap-1">
                                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                                    </svg>
                                                    {{ addForm.errors.url }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Step 3: Options & Preview -->
                                    <div v-show="currentStep === 2" class="space-y-6">
                                        <div class="text-center mb-8">
                                            <h3 class="text-2xl font-bold text-white mb-2">Customize your link</h3>
                                            <p class="text-gray-400">Configure display options and preview your link</p>
                                        </div>

                                        <div class="grid gap-6 lg:grid-cols-2">
                                            <!-- Options -->
                                            <div class="space-y-4">
                                                <h4 class="font-semibold text-white mb-4">Display Options</h4>
                                                
                                                <!-- Embed Option -->
                                                <label class="flex items-start gap-4 p-4 rounded-xl border border-gray-600 hover:border-purple-500/50 hover:bg-purple-500/5 transition-colors cursor-pointer">
                                                    <input
                                                        v-model="addForm.show_as_embed"
                                                        type="checkbox"
                                                        class="w-5 h-5 text-purple-600 focus:ring-purple-500 border-gray-500 bg-gray-700 rounded mt-0.5"
                                                    />
                                                    <div class="flex-1">
                                                        <div class="flex items-center gap-2 mb-1">
                                                            <svg class="w-5 h-5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 002 2v8a2 2 0 002 2z" />
                                                            </svg>
                                                            <span class="font-medium text-white">Rich Media Preview</span>
                                                        </div>
                                                        <p class="text-sm text-gray-400">Show embedded content for YouTube, Spotify, and Instagram links</p>
                                                    </div>
                                                </label>
                                            </div>

                                            <!-- Preview -->
                                            <div class="space-y-4">
                                                <h4 class="font-semibold text-white mb-4">Preview</h4>
                                                <div class="p-4 rounded-xl border-2 border-dashed border-gray-600 bg-gray-700/30">
                                                    <div class="flex items-center gap-3">
                                                        <div class="w-12 h-12 rounded-xl flex items-center justify-center text-xl"
                                                             :class="getLinkIconStyle(addForm.type)">
                                                            {{ getLinkEmoji(addForm.type) }}
                                                        </div>
                                                        <div class="flex-1 min-w-0">
                                                            <h5 class="font-semibold text-white truncate">
                                                                {{ getPreviewTitle() }}
                                                            </h5>
                                                            <p class="text-sm text-gray-400 truncate">
                                                                {{ getPreviewUrl() }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Navigation Buttons -->
                                    <div class="flex items-center justify-between mt-8 pt-6 border-t border-gray-600">
                                        <Button
                                            v-if="currentStep > 0"
                                            type="button"
                                            @click="previousStep"
                                            variant="outline"
                                            class="px-6 py-3 rounded-xl border-gray-600 text-gray-300 bg-gray-700/50 hover:bg-gray-600/50 flex items-center gap-2"
                                        >
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                                                class="px-4 py-3 rounded-xl border-gray-600 text-gray-300 bg-gray-700/50 hover:bg-gray-600/50"
                                            >
                                                Cancel
                                            </Button>
                                            
                                            <Button
                                                v-if="currentStep < wizardSteps.length - 1"
                                                type="button"
                                                @click="nextStep"
                                                :disabled="!canProceed"
                                                class="px-8 py-3 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed flex items-center gap-2"
                                            >
                                                Continue
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                                </svg>
                                            </Button>
                                            
                                            <Button
                                                v-else
                                                type="submit"
                                                :disabled="addForm.processing || !addForm.title || !addForm.url"
                                                class="px-8 py-3 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed flex items-center gap-2"
                                            >
                                                <svg v-if="addForm.processing" class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24">
                                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                                </svg>
                                                <svg v-else class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                </svg>
                                                {{ addForm.processing ? 'Creating...' : 'Create Link' }}
                                            </Button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </Transition>
                    <!-- Links List -->
                    <div v-if="links.length > 0" class="space-y-4">
                        <h3 class="text-xl font-semibold text-white flex items-center gap-2">
                            <div class="w-6 h-6 bg-gray-700 rounded-lg flex items-center justify-center">
                                <LinkIcon class="w-4 h-4 text-gray-300" />
                            </div>
                            Your Links
                        </h3>

                        <div class="space-y-3">
                            <div
                                v-for="link in links"
                                :key="link.id"
                                class="group bg-gray-800/90 backdrop-blur-sm rounded-2xl border border-gray-600/50 p-5 transition-all duration-300 hover:border-gray-500/50 hover:shadow-md"
                            >
                                <div class="flex items-center justify-between">
                                    <!-- Link Info -->
                                    <div class="flex items-center gap-4 flex-1 min-w-0">
                                        <!-- Icon -->
                                        <div class="flex h-12 w-12 items-center justify-center rounded-2xl flex-shrink-0 text-xl"
                                             :class="getLinkIconStyle(link.type)">
                                            {{ getLinkEmoji(link.type) }}
                                        </div>
                                        
                                        <!-- Link Details -->
                                        <div class="min-w-0 flex-1">
                                            <div class="flex items-center gap-3 mb-1">
                                                <h4 class="font-semibold text-white truncate text-lg">{{ link.title }}</h4>
                                                <span v-if="link.embed_type" class="px-3 py-1 text-xs font-medium bg-purple-500/20 text-purple-300 rounded-full flex items-center gap-1">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                                    </svg>
                                                    {{ link.embed_type }}
                                                </span>
                                            </div>
                                            <p class="text-sm text-gray-400 truncate mb-2">{{ link.url }}</p>
                                            <div class="flex items-center gap-4">
                                                <span class="text-xs text-gray-500 flex items-center gap-1">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                    </svg>
                                                    {{ link.click_count || 0 }} clicks
                                                </span>
                                                <div class="flex items-center gap-1">
                                                    <div class="w-2 h-2 rounded-full" :class="link.is_active ? 'bg-green-400' : 'bg-gray-500'"></div>
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
                                            class="p-2 rounded-xl transition-colors"
                                            :title="link.is_active ? 'Deactivate' : 'Activate'"
                                        >
                                            <EyeIcon v-if="link.is_active" class="w-5 h-5" />
                                            <EyeSlashIcon v-else class="w-5 h-5" />
                                        </button>

                                        <!-- Edit Button -->
                                        <button
                                            @click="editLink(link)"
                                            class="p-2 rounded-xl text-blue-400 hover:bg-blue-500/10 transition-colors"
                                            title="Edit"
                                        >
                                            <PencilIcon class="w-5 h-5" />
                                        </button>

                                        <!-- Delete Button -->
                                        <button
                                            @click="deleteLink(link)"
                                            class="p-2 rounded-xl text-red-400 hover:bg-red-500/10 transition-colors"
                                            title="Delete"
                                        >
                                            <TrashIcon class="w-5 h-5" />
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Empty State -->
                    <div
                        v-else
                        class="bg-gray-800/90 backdrop-blur-sm rounded-3xl border-2 border-dashed border-gray-600 p-12 text-center"
                    >
                        <div class="mb-6 flex justify-center">
                            <div class="w-16 h-16 bg-gray-700 rounded-2xl flex items-center justify-center">
                                <LinkIcon class="w-8 h-8 text-gray-400" />
                            </div>
                        </div>
                        <h3 class="text-xl font-semibold text-white mb-2">No links yet</h3>
                        <p class="text-gray-400 mb-6">
                            Click "Add New Link" above to get started
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modern Edit Modal -->
        <Transition
            enter-active-class="transition duration-300 ease-out"
            enter-from-class="transform scale-95 opacity-0"
            enter-to-class="transform scale-100 opacity-100"
            leave-active-class="transition duration-200 ease-in"
            leave-from-class="transform scale-100 opacity-100"
            leave-to-class="transform scale-95 opacity-0"
        >
            <div v-if="editingLink" class="fixed inset-0 z-50 flex items-center justify-center bg-black/80 backdrop-blur-sm p-4">
                <div class="w-full max-w-lg bg-gray-800/95 backdrop-blur-sm rounded-3xl shadow-2xl overflow-hidden border border-gray-600/50">
                    <!-- Modal Header -->
                    <div class="p-6 border-b border-gray-600/50">
                        <div class="flex items-center justify-between">
                            <h3 class="text-xl font-semibold text-white flex items-center gap-2">
                                <div class="w-8 h-8 bg-blue-600/20 rounded-xl flex items-center justify-center">
                                    <PencilIcon class="w-4 h-4 text-blue-400" />
                                </div>
                                Edit Link
                            </h3>
                            <button 
                                @click="editingLink = null" 
                                class="p-2 rounded-xl text-gray-400 hover:text-gray-200 hover:bg-gray-700/50 transition-colors"
                            >
                                <XMarkIcon class="w-5 h-5" />
                            </button>
                        </div>
                    </div>

                    <!-- Modal Content -->
                    <div class="p-6">
                        <form @submit.prevent="updateLink" class="space-y-6">
                            <div class="space-y-2">
                                <label class="text-sm font-medium text-gray-200 flex items-center gap-2">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                    </svg>
                                    Title
                                </label>
                                <Input v-model="editForm.title" placeholder="Link title" class="h-12 rounded-xl bg-gray-700/50 border-gray-600 text-white placeholder-gray-400 focus:border-blue-500 focus:ring-blue-500" required />
                            </div>
                            
                            <div class="space-y-2">
                                <label class="text-sm font-medium text-gray-200 flex items-center gap-2">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                                    </svg>
                                    URL
                                </label>
                                <Input v-model="editForm.url" type="url" placeholder="https://example.com" class="h-12 rounded-xl bg-gray-700/50 border-gray-600 text-white placeholder-gray-400 focus:border-blue-500 focus:ring-blue-500" required />
                            </div>

                            <div class="space-y-2">
                                <label class="text-sm font-medium text-gray-200 flex items-center gap-2">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                    </svg>
                                    Category
                                </label>
                                <select
                                    v-model="editForm.type"
                                    class="h-12 w-full rounded-xl bg-gray-700/50 border-gray-600 text-white focus:border-blue-500 focus:ring-blue-500"
                                >
                                    <option value="custom">🔗 General Link</option>
                                    <option value="social">📱 Social Media</option>
                                    <option value="portfolio">💼 Portfolio</option>
                                    <option value="deeplink">📲 Mobile App</option>
                                </select>
                            </div>

                            <label class="flex items-center gap-3 p-3 rounded-xl border border-gray-600 hover:border-purple-500/50 hover:bg-purple-500/5 transition-colors cursor-pointer">
                                <input
                                    v-model="editForm.show_as_embed"
                                    type="checkbox"
                                    class="w-4 h-4 text-purple-600 focus:ring-purple-500 border-gray-500 bg-gray-700 rounded"
                                />
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 002 2v8a2 2 0 002 2z" />
                                    </svg>
                                    <span class="text-sm font-medium text-gray-200">Show as embed</span>
                                </div>
                            </label>
                            
                            <div class="flex justify-end gap-3 pt-4 border-t border-gray-600">
                                <Button 
                                    type="button" 
                                    variant="outline" 
                                    @click="editingLink = null"
                                    class="px-6 py-2.5 rounded-xl border-gray-600 text-gray-300 bg-gray-700/50 hover:bg-gray-600/50"
                                >
                                    Cancel
                                </Button>
                                <Button 
                                    type="submit" 
                                    :disabled="editForm.processing" 
                                    class="px-6 py-2.5 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-medium rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 disabled:opacity-50"
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

<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import AppLayout from '@/layouts/AppLayout.vue';
import { EyeIcon, EyeSlashIcon, LinkIcon, PencilIcon, PlusIcon, TrashIcon, XMarkIcon } from '@heroicons/vue/24/outline';
import { Head, router, useForm } from '@inertiajs/vue3';
import { computed, ref, Transition } from 'vue';

const props = defineProps({
    links: Array,
});

const editingLink = ref(null);

// Wizard state
const showWizard = ref(false);
const currentStep = ref(0);
const selectedSocial = ref(null);

const wizardSteps = [
    { title: 'Type', completed: false },
    { title: 'Details', completed: false }, 
    { title: 'Options', completed: false },
];

const linkTypes = [
    {
        value: 'custom',
        title: 'General Link',
        emoji: '🔗',
        description: 'Any website or link you want to share'
    },
    {
        value: 'social',
        title: 'Social Media',
        emoji: '📱',
        description: 'Instagram, TikTok, Twitter, and more'
    },
    {
        value: 'portfolio',
        title: 'Portfolio',
        emoji: '💼',
        description: 'Your work, projects, or professional links'
    },
    {
        value: 'deeplink',
        title: 'Mobile App',
        emoji: '📲',
        description: 'App store links or mobile app deep links'
    },
];

const socialPlatforms = [
    {
        name: 'Instagram',
        emoji: '📷',
        baseUrl: 'https://instagram.com/',
        placeholder: 'your_username',
        hint: 'Enter your Instagram username without @'
    },
    {
        name: 'TikTok',
        emoji: '🎵',
        baseUrl: 'https://tiktok.com/@',
        placeholder: 'your_username',
        hint: 'Enter your TikTok username without @'
    },
    {
        name: 'YouTube',
        emoji: '🎥',
        baseUrl: 'https://youtube.com/@',
        placeholder: 'your_channel',
        hint: 'Enter your YouTube channel name'
    },
    {
        name: 'Twitter',
        emoji: '🐦',
        baseUrl: 'https://twitter.com/',
        placeholder: 'your_username',
        hint: 'Enter your Twitter username without @'
    },
    {
        name: 'LinkedIn',
        emoji: '💼',
        baseUrl: 'https://linkedin.com/in/',
        placeholder: 'your-profile',
        hint: 'Enter your LinkedIn profile ID'
    },
    {
        name: 'Facebook',
        emoji: '👥',
        baseUrl: 'https://facebook.com/',
        placeholder: 'your.name',
        hint: 'Enter your Facebook profile name'
    },
    {
        name: 'Spotify',
        emoji: '🎧',
        baseUrl: 'https://open.spotify.com/user/',
        placeholder: 'your_username',
        hint: 'Enter your Spotify username'
    },
    {
        name: 'GitHub',
        emoji: '⚡',
        baseUrl: 'https://github.com/',
        placeholder: 'your_username',
        hint: 'Enter your GitHub username'
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

// Enhanced Add Form with embed support
const addForm = useForm({
    title: '',
    url: '',
    username: '',
    type: 'custom',
    show_as_embed: false,
});

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

const getPreviewTitle = () => {
    if (addForm.type === 'social' && selectedSocial.value) {
        return `${selectedSocial.value.emoji} ${selectedSocial.value.name}`;
    }
    return addForm.title || 'Link Title';
};

const getPreviewUrl = () => {
    if (addForm.type === 'social' && selectedSocial.value && addForm.username) {
        return selectedSocial.value.baseUrl + addForm.username.replace('@', '');
    }
    return addForm.url || 'https://example.com';
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
    addForm.reset();
};

const handleStepSubmit = () => {
    if (currentStep.value === wizardSteps.length - 1) {
        addLink();
    } else {
        nextStep();
    }
};

// Enhanced Edit Form with embed support
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
        'social': '📱',
        'portfolio': '💼', 
        'deeplink': '📲',
        'custom': '🔗',
    };
    return icons[type] || LinkIcon;
};

const getLinkEmoji = (type) => {
    const emojis = {
        'social': '📱',
        'portfolio': '💼', 
        'deeplink': '📲',
        'custom': '🔗',
    };
    return emojis[type] || '🔗';
};

const getLinkIconStyle = (type) => {
    const styles = {
        'social': 'bg-gradient-to-br from-pink-100 to-rose-100 text-pink-600',
        'portfolio': 'bg-gradient-to-br from-blue-100 to-indigo-100 text-blue-600',
        'deeplink': 'bg-gradient-to-br from-green-100 to-emerald-100 text-green-600', 
        'custom': 'bg-gradient-to-br from-gray-100 to-slate-100 text-gray-600',
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

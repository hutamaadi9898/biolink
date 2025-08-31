#!/usr/bin/env bash

# Fix common ESLint issues automatically

echo "🔧 Fixing common ESLint issues..."

# Fix unused variables by commenting them out
echo "📝 Commenting out unused variables..."

# Files to fix
FILES=(
    "resources/js/components/UserInfo.vue"
    "resources/js/layouts/AdminLayout.vue"
    "resources/js/pages/Dashboard/Analytics.vue"
    "resources/js/pages/Dashboard/Index.vue"
    "resources/js/pages/Dashboard/Profile.vue"
    "resources/js/pages/Dashboard/Themes.vue"
    "resources/js/pages/Profile/Show-old.vue"
    "resources/js/pages/Profile/Show.vue"
)

# Comment out specific unused variables
sed -i 's/const showAvatar = ref/\/\/ const showAvatar = ref/g' resources/js/components/UserInfo.vue
sed -i 's/const toggleMobileMenu = /\/\/ const toggleMobileMenu = /g' resources/js/layouts/AdminLayout.vue
sed -i 's/, index//g' resources/js/pages/Dashboard/Analytics.vue
sed -i 's/const props = defineProps/\/\/ const props = defineProps/g' resources/js/pages/Dashboard/Index.vue
sed -i 's/const submit = /\/\/ const submit = /g' resources/js/pages/Dashboard/Profile.vue
sed -i 's/const props = defineProps/\/\/ const props = defineProps/g' resources/js/pages/Dashboard/Themes.vue
sed -i 's/import { router/\/\/ import { router/g' resources/js/pages/Profile/Show-old.vue
sed -i 's/, type//g' resources/js/pages/Profile/Show-old.vue
sed -i 's/const socialMediaLinks = /\/\/ const socialMediaLinks = /g' resources/js/pages/Profile/Show.vue
sed -i 's/const regularLinks = /\/\/ const regularLinks = /g' resources/js/pages/Profile/Show.vue
sed -i 's/, totalItems//g' resources/js/pages/Profile/Show.vue

echo "✅ Basic fixes applied. Running ESLint again..."

npm run lint

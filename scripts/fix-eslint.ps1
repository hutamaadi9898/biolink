#!/usr/bin/env pwsh

# Fix common ESLint issues automatically

Write-Host "🔧 Fixing common ESLint issues..." -ForegroundColor Cyan

# Fix UserInfo.vue
Write-Host "📝 Fixing UserInfo.vue..."
$content = Get-Content "resources/js/components/UserInfo.vue" -Raw
$content = $content -replace "const showAvatar = ref", "// const showAvatar = ref"
Set-Content "resources/js/components/UserInfo.vue" -Value $content

# Fix AdminLayout.vue
Write-Host "📝 Fixing AdminLayout.vue..."
$content = Get-Content "resources/js/layouts/AdminLayout.vue" -Raw
$content = $content -replace "const toggleMobileMenu = ", "// const toggleMobileMenu = "
Set-Content "resources/js/layouts/AdminLayout.vue" -Value $content

# Fix Analytics.vue
Write-Host "📝 Fixing Analytics.vue..."
$content = Get-Content "resources/js/pages/Dashboard/Analytics.vue" -Raw
$content = $content -replace ", index\)", ")"
Set-Content "resources/js/pages/Dashboard/Analytics.vue" -Value $content

# Fix Dashboard Index.vue
Write-Host "📝 Fixing Dashboard Index.vue..."
$content = Get-Content "resources/js/pages/Dashboard/Index.vue" -Raw
$content = $content -replace "const props = defineProps", "// const props = defineProps"
Set-Content "resources/js/pages/Dashboard/Index.vue" -Value $content

# Fix Dashboard Profile.vue
Write-Host "📝 Fixing Dashboard Profile.vue..."
$content = Get-Content "resources/js/pages/Dashboard/Profile.vue" -Raw
$content = $content -replace "const submit = ", "// const submit = "
$content = $content -replace "import AppLayout", "// import AppLayout"
Set-Content "resources/js/pages/Dashboard/Profile.vue" -Value $content

# Fix Themes.vue
Write-Host "📝 Fixing Themes.vue..."
$content = Get-Content "resources/js/pages/Dashboard/Themes.vue" -Raw
$content = $content -replace "const props = defineProps", "// const props = defineProps"
Set-Content "resources/js/pages/Dashboard/Themes.vue" -Value $content

# Fix Show-old.vue
Write-Host "📝 Fixing Show-old.vue..."
$content = Get-Content "resources/js/pages/Profile/Show-old.vue" -Raw
$content = $content -replace "import { router", "// import { router"
$content = $content -replace ", type\)", ")"
Set-Content "resources/js/pages/Profile/Show-old.vue" -Value $content

# Fix Show.vue
Write-Host "📝 Fixing Show.vue..."
$content = Get-Content "resources/js/pages/Profile/Show.vue" -Raw
$content = $content -replace "const socialMediaLinks = ", "// const socialMediaLinks = "
$content = $content -replace "const regularLinks = ", "// const regularLinks = "
$content = $content -replace ", totalItems", ""
Set-Content "resources/js/pages/Profile/Show.vue" -Value $content

Write-Host "✅ Basic fixes applied. Running ESLint again..." -ForegroundColor Green

npm run lint

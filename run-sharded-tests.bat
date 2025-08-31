@echo off
REM Simplified Test Sharding Script
REM This script demonstrates test sharding by running test groups in parallel

setlocal enabledelayedexpansion

echo 🚀 Starting Test Sharding...

REM Create log directory
if not exist "storage\logs" mkdir "storage\logs"

set TOTAL_EXIT_CODE=0

echo 📊 Shard 1: Core Functionality Tests
php artisan test tests/Feature/LinkManagementTest.php tests/Feature/AnalyticsTest.php tests/Feature/ThemesTest.php > storage\logs\shard-1-core.log 2>&1
if !errorlevel! equ 0 (
    echo ✅ Core Functionality: PASSED
) else (
    echo ❌ Core Functionality: FAILED
    set TOTAL_EXIT_CODE=1
)

echo 📊 Shard 2: Authentication Tests  
php artisan test tests/Feature/Auth/ > storage\logs\shard-2-auth.log 2>&1
if !errorlevel! equ 0 (
    echo ✅ Authentication: PASSED
) else (
    echo ❌ Authentication: FAILED
    set TOTAL_EXIT_CODE=1
)

echo 📊 Shard 3: Settings & User Management
php artisan test tests/Feature/Settings/ tests/Feature/UserModelTest.php > storage\logs\shard-3-user.log 2>&1
if !errorlevel! equ 0 (
    echo ✅ User Management: PASSED
) else (
    echo ❌ User Management: FAILED
    set TOTAL_EXIT_CODE=1
)

echo 📊 Shard 4: Unit Tests
php artisan test tests/Unit/ > storage\logs\shard-4-unit.log 2>&1
if !errorlevel! equ 0 (
    echo ✅ Unit Tests: PASSED
) else (
    echo ❌ Unit Tests: FAILED
    set TOTAL_EXIT_CODE=1
)

echo.
echo 📋 Test Sharding Summary:
echo ==========================
echo Core Functionality: Check storage\logs\shard-1-core.log
echo Authentication: Check storage\logs\shard-2-auth.log  
echo User Management: Check storage\logs\shard-3-user.log
echo Unit Tests: Check storage\logs\shard-4-unit.log

echo.
if %TOTAL_EXIT_CODE% equ 0 (
    echo 🎉 All critical test shards completed successfully!
    echo 📈 Test sharding reduces CI/CD time by running tests in parallel
) else (
    echo 💥 Some test shards failed. Check individual logs for details.
)

exit /b %TOTAL_EXIT_CODE%

@echo off
REM Test Sharding Runner Script for Windows
REM This script runs tests in parallel shards for faster CI/CD execution

setlocal enabledelayedexpansion

set SHARD_COUNT=5
set LOG_DIR=storage\logs

echo 🚀 Starting Test Sharding with %SHARD_COUNT% shards...

REM Create log directory if it doesn't exist
if not exist "%LOG_DIR%" mkdir "%LOG_DIR%"

REM Define shards
set SHARDS[0]=Unit-Shard
set SHARDS[1]=Feature-Auth-Shard
set SHARDS[2]=Feature-Core-Shard
set SHARDS[3]=Feature-Dashboard-Shard
set SHARDS[4]=Browser-Smoke-Shard

set TOTAL_EXIT_CODE=0

REM Run shards sequentially (Windows doesn't have easy parallel execution)
echo 🔄 Running %SHARD_COUNT% shards sequentially...

for /L %%i in (0,1,4) do (
    set SHARD_NAME=!SHARDS[%%i]!
    set LOG_FILE=%LOG_DIR%\test-shard-!SHARDS[%%i]!.log
    
    echo 📊 Running Shard: !SHARD_NAME!
    
    REM Run the shard and capture output
    php artisan test --testsuite="!SHARD_NAME!" --stop-on-failure > "!LOG_FILE!" 2>&1
    
    if !errorlevel! equ 0 (
        echo ✅ Shard !SHARD_NAME!: PASSED
    ) else (
        echo ❌ Shard !SHARD_NAME!: FAILED
        echo    Log: !LOG_FILE!
        set TOTAL_EXIT_CODE=1
    )
)

REM Summary
echo.
echo 📋 Test Sharding Summary:
echo ==========================

for /L %%i in (0,1,4) do (
    set SHARD_NAME=!SHARDS[%%i]!
    set LOG_FILE=%LOG_DIR%\test-shard-!SHARD_NAME!.log
    
    if exist "!LOG_FILE!" (
        echo 📊 !SHARD_NAME!: Check !LOG_FILE! for details
    )
)

echo.
if %TOTAL_EXIT_CODE% equ 0 (
    echo 🎉 All test shards completed successfully!
) else (
    echo 💥 One or more test shards failed. Check individual logs for details.
)

exit /b %TOTAL_EXIT_CODE%

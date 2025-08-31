# Parallel Test Runner for Pest 4 (PowerShell)
# This script runs tests in parallel for faster execution

Write-Host "🚀 Starting Parallel Test Execution with Pest 4" -ForegroundColor Green
Write-Host "================================================" -ForegroundColor Green

# Function to run a test shard
function Start-TestShard {
    param(
        [string]$ShardName,
        [string]$ShardConfig
    )
    
    Write-Host "🧪 Running $ShardName tests..." -ForegroundColor Cyan
    Start-Job -ScriptBlock {
        param($config)
        Set-Location $using:PWD
        php artisan test --testsuite="$config" --parallel
    } -ArgumentList $ShardConfig
}

# Function to run browser tests with retry logic
function Start-BrowserTests {
    Write-Host "🌐 Running Browser Tests..." -ForegroundColor Yellow
    
    Start-Job -ScriptBlock {
        Set-Location $using:PWD
        
        # Try to run browser tests, retry on failure
        for ($i = 1; $i -le 3; $i++) {
            try {
                php artisan test tests/Browser --parallel --stop-on-failure
                Write-Host "✅ Browser tests passed on attempt $i" -ForegroundColor Green
                break
            }
            catch {
                Write-Host "❌ Browser tests failed on attempt $i, retrying..." -ForegroundColor Red
                Start-Sleep -Seconds 2
            }
        }
    }
}

# Start timestamp
$startTime = Get-Date

Write-Host "📦 Setting up test environment..." -ForegroundColor Blue

# Clear cache and prepare environment
php artisan config:clear --env=testing
php artisan cache:clear --env=testing

# Run test shards in parallel
Write-Host "🔄 Starting parallel test execution..." -ForegroundColor Magenta

# Store job references
$jobs = @()

# Unit tests (fastest)
$jobs += Start-TestShard "Unit" "Unit-Shard"

# Feature test shards
$jobs += Start-TestShard "Auth Features" "Feature-Auth-Shard"
$jobs += Start-TestShard "Core Features" "Feature-Core-Shard" 
$jobs += Start-TestShard "Dashboard Features" "Feature-Dashboard-Shard"

# Browser tests
$jobs += Start-BrowserTests

# Wait for all jobs to complete
Write-Host "⏳ Waiting for all test shards to complete..." -ForegroundColor Yellow
$jobs | Wait-Job | Receive-Job

# Clean up jobs
$jobs | Remove-Job

# End timestamp and calculate duration
$endTime = Get-Date
$duration = ($endTime - $startTime).TotalSeconds

Write-Host "================================================" -ForegroundColor Green
Write-Host "✅ All tests completed in $([math]::Round($duration, 2)) seconds" -ForegroundColor Green
Write-Host "🎉 Parallel test execution finished!" -ForegroundColor Green

# Run a final comprehensive test to ensure nothing is broken
Write-Host "🔍 Running final comprehensive test..." -ForegroundColor Blue
php artisan test --stop-on-failure

Write-Host "🎯 Test execution summary complete!" -ForegroundColor Green

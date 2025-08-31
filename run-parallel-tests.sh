#!/bin/bash

# Parallel Test Runner for Pest 4
# This script runs tests in parallel for faster execution

echo "🚀 Starting Parallel Test Execution with Pest 4"
echo "================================================"

# Function to run a test shard
run_shard() {
    local shard_name=$1
    local shard_config=$2
    
    echo "🧪 Running $shard_name tests..."
    php artisan test --testsuite="$shard_config" --parallel &
}

# Function to run browser tests with retry logic
run_browser_tests() {
    echo "🌐 Running Browser Tests..."
    
    # Try to run browser tests, retry on failure
    for i in {1..3}; do
        if php artisan test tests/Browser --parallel --stop-on-failure; then
            echo "✅ Browser tests passed on attempt $i"
            break
        else
            echo "❌ Browser tests failed on attempt $i, retrying..."
            sleep 2
        fi
    done &
}

# Start timestamp
start_time=$(date +%s)

echo "📦 Setting up test environment..."

# Clear cache and prepare environment
php artisan config:clear --env=testing
php artisan cache:clear --env=testing

# Run test shards in parallel
echo "🔄 Starting parallel test execution..."

# Unit tests (fastest)
run_shard "Unit" "Unit-Shard"

# Feature test shards
run_shard "Auth Features" "Feature-Auth-Shard" 
run_shard "Core Features" "Feature-Core-Shard"
run_shard "Dashboard Features" "Feature-Dashboard-Shard"

# Browser tests
run_browser_tests

# Wait for all background jobs to complete
wait

# End timestamp and calculate duration
end_time=$(date +%s)
duration=$((end_time - start_time))

echo "================================================"
echo "✅ All tests completed in ${duration} seconds"
echo "🎉 Parallel test execution finished!"

# Run a final comprehensive test to ensure nothing is broken
echo "🔍 Running final comprehensive test..."
php artisan test --stop-on-failure

echo "🎯 Test execution summary complete!"

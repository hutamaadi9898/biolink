#!/usr/bin/env bash

# Test Sharding Runner Script
# This script runs tests in parallel shards for faster CI/CD execution

set -e

SHARD_COUNT=5
PARALLEL_PROCESSES=4

echo "🚀 Starting Test Sharding with $SHARD_COUNT shards..."

# Function to run a specific test shard
run_shard() {
    local shard_name=$1
    local log_file="storage/logs/test-shard-${shard_name}.log"
    
    echo "📊 Running Shard: $shard_name"
    
    # Create log directory if it doesn't exist
    mkdir -p storage/logs
    
    # Run the shard and capture output
    if php artisan test --testsuite="$shard_name" --stop-on-failure > "$log_file" 2>&1; then
        echo "✅ Shard $shard_name: PASSED"
        return 0
    else
        echo "❌ Shard $shard_name: FAILED"
        echo "   Log: $log_file"
        return 1
    fi
}

# Export the function so it can be used by parallel processes
export -f run_shard

# Define shards
SHARDS=(
    "Unit-Shard"
    "Feature-Auth-Shard" 
    "Feature-Core-Shard"
    "Feature-Dashboard-Shard"
    "Browser-Smoke-Shard"
)

# Run shards in parallel
echo "🔄 Running $SHARD_COUNT shards in parallel (max $PARALLEL_PROCESSES processes)..."

# Use GNU parallel if available, otherwise run sequentially
if command -v parallel &> /dev/null; then
    printf '%s\n' "${SHARDS[@]}" | parallel -j $PARALLEL_PROCESSES run_shard
    PARALLEL_EXIT_CODE=$?
else
    echo "⚠️  GNU parallel not found, running shards sequentially..."
    PARALLEL_EXIT_CODE=0
    for shard in "${SHARDS[@]}"; do
        if ! run_shard "$shard"; then
            PARALLEL_EXIT_CODE=1
        fi
    done
fi

# Summary
echo ""
echo "📋 Test Sharding Summary:"
echo "=========================="

TOTAL_TESTS=0
PASSED_TESTS=0
FAILED_TESTS=0

for shard in "${SHARDS[@]}"; do
    log_file="storage/logs/test-shard-${shard}.log"
    if [ -f "$log_file" ]; then
        # Extract test results from log
        if grep -q "Tests:" "$log_file"; then
            result=$(grep "Tests:" "$log_file" | tail -1)
            echo "📊 $shard: $result"
        else
            echo "📊 $shard: No results found"
        fi
    fi
done

echo ""
if [ $PARALLEL_EXIT_CODE -eq 0 ]; then
    echo "🎉 All test shards completed successfully!"
    exit 0
else
    echo "💥 One or more test shards failed. Check individual logs for details."
    exit 1
fi

#!/bin/bash

# CI/CD Health Check and Fix Script
# This script helps identify and fix common CI/CD issues

echo "🔍 Biolink ID - CI/CD Health Check"
echo "=================================="

# Check if we're in the right directory
if [ ! -f "artisan" ]; then
    echo "❌ Error: Not in Laravel project root directory"
    exit 1
fi

echo "✅ Found Laravel project"

# Check PHP dependencies
echo "📦 Checking PHP dependencies..."
if composer validate --no-check-publish --no-check-platform; then
    echo "✅ Composer.json is valid"
else
    echo "❌ Composer.json has issues"
fi

# Check Node dependencies
echo "📦 Checking Node dependencies..."
if npm ls --depth=0 > /dev/null 2>&1; then
    echo "✅ Node dependencies are valid"
else
    echo "⚠️  Node dependencies may have issues"
fi

# Check Laravel configuration
echo "🔧 Checking Laravel configuration..."
if php artisan --version > /dev/null 2>&1; then
    echo "✅ Laravel is working"
else
    echo "❌ Laravel has configuration issues"
fi

# Check environment file
if [ -f ".env.example" ]; then
    echo "✅ Environment example exists"
else
    echo "❌ .env.example is missing"
fi

# Check database setup
echo "🗄️  Checking database setup..."
if php artisan migrate:status > /dev/null 2>&1; then
    echo "✅ Database is accessible"
else
    echo "⚠️  Database may need setup"
fi

# Run basic tests
echo "🧪 Running basic tests..."
if ./vendor/bin/pest tests/Unit/ExampleTest.php > /dev/null 2>&1; then
    echo "✅ Basic tests pass"
else
    echo "❌ Basic tests fail"
fi

# Check linting (but don't fail)
echo "🎨 Checking code style..."
if ./vendor/bin/pint --test > /dev/null 2>&1; then
    echo "✅ PHP code style is good"
else
    echo "⚠️  PHP code style needs attention (run: vendor/bin/pint)"
fi

if npm run lint > /dev/null 2>&1; then
    echo "✅ JavaScript/Vue code style is good"
else
    echo "⚠️  JavaScript/Vue code needs linting fixes (run: npm run lint)"
fi

# Check build process
echo "🏗️  Checking build process..."
if npm run build > /dev/null 2>&1; then
    echo "✅ Frontend builds successfully"
else
    echo "❌ Frontend build fails"
fi

echo ""
echo "🎯 CI/CD Status Summary:"
echo "========================"
echo "✅ = Good to go"
echo "⚠️  = Needs attention but won't block CI"
echo "❌ = Critical issue that will break CI"

echo ""
echo "🔧 Quick fixes you can run:"
echo "- Fix PHP code style: vendor/bin/pint"
echo "- Fix JS/Vue linting: npm run lint"
echo "- Format code: npm run format"
echo "- Run tests: php artisan test"
echo "- Build assets: npm run build"

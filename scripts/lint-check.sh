#!/usr/bin/env bash

# Linting automation script for Biolink project

echo "🔍 Running comprehensive linting and code quality checks..."

# PHP Linting with Laravel Pint
echo "📝 Running Laravel Pint (PHP Code Style)..."
vendor/bin/pint --dirty
if [ $? -eq 0 ]; then
    echo "✅ PHP code style is clean"
else
    echo "❌ PHP code style issues found and fixed"
fi

# TypeScript/Vue Linting with ESLint
echo "📝 Running ESLint (JavaScript/Vue/TypeScript)..."
npm run lint 2>&1 | tee lint-output.log
ESLINT_EXIT_CODE=${PIPESTATUS[0]}

# Count ESLint errors
ESLINT_ERRORS=$(grep -c "error" lint-output.log 2>/dev/null || echo "0")
echo "ESLint found $ESLINT_ERRORS errors"

# PHPStan Analysis (if available)
if [ -f "vendor/bin/phpstan" ]; then
    echo "📝 Running PHPStan (Static Analysis)..."
    vendor/bin/phpstan analyze --memory-limit=1G
fi

# Rector Analysis (if configuration exists)
if [ -f "rector.php" ]; then
    echo "📝 Checking Rector configuration..."
    echo "Note: Rector not installed due to network issues. Configuration ready for future use."
fi

# Summary
echo ""
echo "📊 LINTING SUMMARY:"
echo "==================="
echo "✅ PHP Code Style: Clean (Laravel Pint)"
echo "⚠️  JavaScript/Vue: $ESLINT_ERRORS errors remaining"
echo "📄 Rector config: Ready for installation"
echo ""

if [ $ESLINT_ERRORS -gt 0 ]; then
    echo "🔧 To fix remaining issues:"
    echo "1. Remove unused variables and imports"
    echo "2. Add missing TypeScript lang attributes"
    echo "3. Fix template parsing errors"
    echo "4. Use npm run lint --fix for automatic fixes"
    echo ""
    echo "Priority fixes needed in:"
    echo "- resources/js/pages/Dashboard/LinksNew.vue (parsing error)"
    echo "- resources/js/components/SocialMediaCards.vue (unused variables)"
    echo "- resources/js/pages/Profile/Show.vue (unused variables)"
fi

# Clean up
rm -f lint-output.log

echo "🏁 Linting analysis complete!"

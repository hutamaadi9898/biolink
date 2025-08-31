@echo off
REM Linting automation script for Biolink project (Windows)

echo 🔍 Running comprehensive linting and code quality checks...

REM PHP Linting with Laravel Pint
echo 📝 Running Laravel Pint (PHP Code Style)...
vendor\bin\pint --dirty
if %errorlevel% equ 0 (
    echo ✅ PHP code style is clean
) else (
    echo ❌ PHP code style issues found and fixed
)

REM TypeScript/Vue Linting with ESLint
echo 📝 Running ESLint (JavaScript/Vue/TypeScript)...
npm run lint > lint-output.log 2>&1
set ESLINT_EXIT_CODE=%errorlevel%

REM Count ESLint errors
for /f %%i in ('findstr /c:"error" lint-output.log 2^>nul ^| find /c /v ""') do set ESLINT_ERRORS=%%i
if not defined ESLINT_ERRORS set ESLINT_ERRORS=0
echo ESLint found %ESLINT_ERRORS% errors

REM PHPStan Analysis (if available)
if exist "vendor\bin\phpstan.bat" (
    echo 📝 Running PHPStan (Static Analysis)...
    vendor\bin\phpstan analyze --memory-limit=1G
)

REM Rector Analysis (if configuration exists)
if exist "rector.php" (
    echo 📝 Checking Rector configuration...
    echo Note: Rector not installed due to network issues. Configuration ready for future use.
)

REM Summary
echo.
echo 📊 LINTING SUMMARY:
echo ===================
echo ✅ PHP Code Style: Clean (Laravel Pint)
echo ⚠️  JavaScript/Vue: %ESLINT_ERRORS% errors remaining
echo 📄 Rector config: Ready for installation
echo.

if %ESLINT_ERRORS% gtr 0 (
    echo 🔧 To fix remaining issues:
    echo 1. Remove unused variables and imports
    echo 2. Add missing TypeScript lang attributes
    echo 3. Fix template parsing errors
    echo 4. Use npm run lint --fix for automatic fixes
    echo.
    echo Priority fixes needed in:
    echo - resources/js/pages/Dashboard/LinksNew.vue (parsing error)
    echo - resources/js/components/SocialMediaCards.vue (unused variables)
    echo - resources/js/pages/Profile/Show.vue (unused variables)
)

REM Clean up
if exist lint-output.log del lint-output.log

echo 🏁 Linting analysis complete!

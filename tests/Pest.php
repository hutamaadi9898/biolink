<?php

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
|
| The closure you provide to your test functions is always bound to a specific PHPUnit test
| case class. By default, that class is "PHPUnit\Framework\TestCase". Of course, you may
| need to change it using the "pest()" function to bind a different classes or traits.
|
*/

pest()->extend(Tests\TestCase::class)
    ->in('Feature', 'Unit', 'Browser');

/*
|--------------------------------------------------------------------------
| Parallel Testing Configuration
|--------------------------------------------------------------------------
|
| Configure Pest to run tests in parallel by default for faster execution.
| This leverages Pest 4's built-in parallel testing capabilities.
|
*/

// Disable parallel execution for CI/CD compatibility
// if (! defined('PEST_PARALLEL')) {
//     define('PEST_PARALLEL', true);
// }

/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
|
| When you're writing tests, you often need to check that values meet certain conditions. The
| "expect()" function gives you access to a set of "expectations" methods that you can use
| to assert different things. Of course, you may extend the Expectation API at any time.
|
*/

expect()->extend('toBeOne', function () {
    return $this->toBe(1);
});

/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
|
| While Pest is very powerful out-of-the-box, you may have some testing code specific to your
| project that you don't want to repeat in every file. Here you can also expose helpers as
| global functions to help you to reduce the number of lines of code in your test files.
|
*/

function something()
{ 
    // ..
}

/*
|--------------------------------------------------------------------------
| Browser Testing Configuration
|--------------------------------------------------------------------------
|
| Configure browser testing for Pest 4. This uses feature tests that 
| simulate browser behavior without requiring actual browser automation.
|
*/

function visitPage(string $url, array $options = [])
{
    return test()->get($url);
}

function visitAsUser(string $url, $user = null)
{
    if ($user) {
        test()->actingAs($user);
    }
    return test()->get($url);
}

/*
|--------------------------------------------------------------------------
| Test Helper Functions for Parallel Execution
|--------------------------------------------------------------------------
|
| Helper functions to optimize test execution in parallel environments.
|
*/

function runParallelTest(callable $callback)
{
    return $callback();
}

function getTestShardConfig(): string
{
    return $_ENV['TEST_SHARD'] ?? 'default';
}

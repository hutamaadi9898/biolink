<?php

use App\Models\Theme;
use Database\Seeders\ThemeSeeder;

beforeEach(function () {
    // Run the theme seeder before each test
    $this->seed(ThemeSeeder::class);
});

test('theme seeder creates all expected themes', function () {
    $expectedThemes = [
        'Klasik Minimalis',
        'Neon Jakarta',
        'Batik Modern',
        'Sunset Bali',
        'Professional Dark',
        'Creative Portfolio',
    ];

    $actualThemes = Theme::pluck('name')->toArray();

    foreach ($expectedThemes as $expectedTheme) {
        expect($actualThemes)->toContain($expectedTheme);
    }

    expect(Theme::count())->toBe(6);
});

test('themes have correct premium status', function () {
    $freeThemes = Theme::where('is_premium', false)->pluck('name')->toArray();
    $premiumThemes = Theme::where('is_premium', true)->pluck('name')->toArray();

    expect($freeThemes)->toContain('Klasik Minimalis');
    expect($freeThemes)->toContain('Neon Jakarta');
    expect($freeThemes)->toContain('Batik Modern');

    expect($premiumThemes)->toContain('Sunset Bali');
    expect($premiumThemes)->toContain('Professional Dark');
    expect($premiumThemes)->toContain('Creative Portfolio');
});

test('themes have proper configuration structure', function () {
    $theme = Theme::where('name', 'Klasik Minimalis')->first();

    expect($theme->config)->toBeArray();
    expect($theme->config)->toHaveKey('colors');
    expect($theme->config)->toHaveKey('fonts');
    expect($theme->config)->toHaveKey('layout');
    expect($theme->config)->toHaveKey('button_style');
    expect($theme->config)->toHaveKey('spacing');

    expect($theme->config['colors'])->toHaveKey('primary');
    expect($theme->config['colors'])->toHaveKey('secondary');
    expect($theme->config['colors'])->toHaveKey('background');
    expect($theme->config['colors'])->toHaveKey('text');
});

test('theme slugs are properly formatted', function () {
    $themes = Theme::all();

    foreach ($themes as $theme) {
        expect($theme->slug)->toMatch('/^[a-z0-9-]+$/');
        expect($theme->slug)->not->toBeEmpty();
    }
});

test('themes are ordered correctly', function () {
    $themes = Theme::orderBy('sort_order')->get();

    expect($themes->first()->name)->toBe('Klasik Minimalis');
    expect($themes->first()->sort_order)->toBe(1);

    expect($themes->last()->name)->toBe('Creative Portfolio');
    expect($themes->last()->sort_order)->toBe(6);
});

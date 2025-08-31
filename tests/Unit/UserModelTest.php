<?php

use App\Models\User;
use App\Models\Profile;
use App\Models\Link;
use App\Models\Portfolio;
use App\Models\Analytics;

beforeEach(function () {
    $this->artisan('migrate:fresh');
});

test('user can have a profile', function () {
    $user = User::factory()->create();
    $profile = Profile::factory()->create(['user_id' => $user->id]);
    
    expect($user->fresh()->profile)->toBeInstanceOf(Profile::class);
    expect($user->profile->id)->toBe($profile->id);
});

test('user can have multiple links', function () {
    $user = User::factory()->create();
    $links = Link::factory()->count(3)->create(['user_id' => $user->id]);
    
    expect($user->fresh()->links)->toHaveCount(3);
    expect($user->links->first())->toBeInstanceOf(Link::class);
});

test('user can have multiple portfolios', function () {
    $user = User::factory()->create();
    $portfolios = Portfolio::factory()->count(2)->create(['user_id' => $user->id]);
    
    expect($user->fresh()->portfolios)->toHaveCount(2);
    expect($user->portfolios->first())->toBeInstanceOf(Portfolio::class);
});

test('user can have analytics', function () {
    $user = User::factory()->create();
    $analytics = Analytics::factory()->count(5)->create(['user_id' => $user->id]);
    
    expect($user->fresh()->analytics)->toHaveCount(5);
    expect($user->analytics->first())->toBeInstanceOf(Analytics::class);
});

test('user slug is unique', function () {
    $user1 = User::factory()->create(['slug' => 'testuser']);
    
    expect(function () {
        User::factory()->create(['slug' => 'testuser']);
    })->toThrow(\Illuminate\Database\QueryException::class);
});

test('user slug is automatically generated from name', function () {
    $user = User::factory()->make(['name' => 'John Doe']);
    // Don't set slug in factory, let the model generate it
    $user->slug = null;
    $user->save();
    
    expect($user->slug)->toBe('john-doe');
});

test('user can check if theme is applied', function () {
    // First, seed themes so we have valid theme IDs
    $this->seed(\Database\Seeders\ThemeSeeder::class);
    
    $user = User::factory()->create();
    
    // User should not have any themes by default
    expect($user->hasTheme(1))->toBeFalse();
    expect($user->hasThemeApplied())->toBeFalse();
    
    // Apply a theme
    $user->userThemes()->create([
        'theme_id' => 1,
        'is_active' => true,
    ]);
    
    expect($user->hasTheme(1))->toBeTrue();
    expect($user->hasThemeApplied())->toBeTrue();
    expect($user->hasTheme(2))->toBeFalse();
});

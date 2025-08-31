<?php

use App\Models\Analytics;
use App\Models\Link;
use App\Models\Portfolio;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

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
    $user = User::factory()->create(['name' => 'John Doe', 'slug' => null]);

    expect($user->slug)->toStartWith('john-doe');
});

test('user can check if theme is applied', function () {
    $user = User::factory()->create();

    // Test when no theme is applied
    expect($user->hasThemeApplied())->toBeFalse();
});

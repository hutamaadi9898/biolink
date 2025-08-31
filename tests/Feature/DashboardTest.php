<?php

use App\Models\Analytics;
use App\Models\Link;
use App\Models\Portfolio;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('guests are redirected to the login page', function () {
    $response = $this->get(route('dashboard'));
    $response->assertRedirect(route('login'));
});

test('authenticated users can visit the dashboard', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->get(route('dashboard'));
    $response->assertStatus(200);
});

test('dashboard displays with modern dark mode structure', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->get(route('dashboard'));

    $response->assertOk();
    $response->assertInertia(fn ($page) => $page
        ->component('Dashboard/Index')
        ->hasAll([
            'stats',
            'recentLinks',
            'recentAnalytics',
        ])
    );
});

test('dashboard shows correct user stats', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    // Create test data
    $links = Link::factory()->count(3)->create(['user_id' => $user->id]);
    $portfolios = Portfolio::factory()->count(2)->create(['user_id' => $user->id]);

    // Create analytics - 5 profile views and 3 link clicks for the user with recent timestamps
    Analytics::factory()->count(5)->create([
        'user_id' => $user->id,
        'event_type' => 'profile_view',
        'occurred_at' => now()->subHours(1), // Ensure it's within the current week
    ]);

    Analytics::factory()->count(3)->create([
        'user_id' => $user->id,
        'event_type' => 'link_click',
        'occurred_at' => now()->subHours(2), // Ensure it's within the current week
    ]);

    $response = $this->get(route('dashboard'));

    $response->assertInertia(fn ($page) => $page
        ->component('Dashboard/Index')
        ->where('stats.total_links', 3)
        ->where('stats.total_portfolios', 2)
        ->where('stats.profile_views', 5)
        ->where('stats.total_clicks', 3)
    );
});

test('dashboard shows recent links correctly', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    // Create recent links with clear time difference
    $olderLink = Link::factory()->create([
        'user_id' => $user->id,
        'created_at' => now()->subHour(),
    ]);

    $recentLink = Link::factory()->create([
        'user_id' => $user->id,
        'created_at' => now(),
    ]);

    $response = $this->get(route('dashboard'));

    $response->assertInertia(fn ($page) => $page
        ->component('Dashboard/Index')
        ->has('recentLinks', 2)
        ->has('recentLinks.0.id')
        ->has('recentLinks.1.id')
    );
});

test('dashboard filters out other users data', function () {
    $user = User::factory()->create();
    $otherUser = User::factory()->create();
    $this->actingAs($user);

    // Create data for current user
    $userLink = Link::factory()->create(['user_id' => $user->id]);

    // Create data for other user
    $otherLink = Link::factory()->create(['user_id' => $otherUser->id]);
    $otherPortfolio = Portfolio::factory()->create(['user_id' => $otherUser->id]);

    $response = $this->get(route('dashboard'));

    $response->assertInertia(fn ($page) => $page
        ->component('Dashboard/Index')
        ->where('stats.total_links', 1)
        ->where('stats.total_portfolios', 0)
        ->has('recentLinks', 1)
        ->where('recentLinks.0.id', $userLink->id)
    );
});

test('dashboard handles user with no data gracefully', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->get(route('dashboard'));

    $response->assertInertia(fn ($page) => $page
        ->component('Dashboard/Index')
        ->where('stats.total_links', 0)
        ->where('stats.profile_views', 0)
        ->where('stats.total_clicks', 0)
        ->where('stats.total_portfolios', 0)
        ->has('recentLinks', 0)
    );
});

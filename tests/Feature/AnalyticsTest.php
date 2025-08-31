<?php

use App\Models\Analytics;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->user = User::factory()->create();
});

test('guests cannot access analytics page', function () {
    $response = $this->get(route('dashboard.analytics.index'));
    $response->assertRedirect(route('login'));
});

test('authenticated users can access analytics page', function () {
    $this->actingAs($this->user);

    $response = $this->get(route('dashboard.analytics.index'));
    $response->assertOk();
    $response->assertInertia(fn ($page) => $page
        ->component('Dashboard/Analytics')
        ->hasAll([
            'stats',
            'dailyBreakdown',
            'topLinks',
            'topCountries',
            'deviceBreakdown',
            'browserBreakdown',
            'period',
        ])
    );
});

test('analytics page displays correct data for user', function () {
    $this->actingAs($this->user);

    // Create test data - analytics events
    Analytics::factory()->create([
        'user_id' => $this->user->id,
        'event_type' => 'profile_view',
        'country' => 'ID',
        'device_type' => 'mobile',
        'browser' => 'Chrome',
        'created_at' => now(),
    ]);

    Analytics::factory()->create([
        'user_id' => $this->user->id,
        'event_type' => 'link_click',
        'country' => 'US',
        'device_type' => 'desktop',
        'browser' => 'Firefox',
        'created_at' => now(),
    ]);

    $response = $this->get(route('dashboard.analytics.index'));
    $response->assertOk();

    $response->assertInertia(fn ($page) => $page
        ->component('Dashboard/Analytics')
        ->has('stats')
        ->has('dailyBreakdown')
        ->has('topLinks')
        ->has('topCountries')
        ->has('deviceBreakdown')
        ->has('browserBreakdown')
    );
});

test('analytics api returns filtered data by date range', function () {
    $this->actingAs($this->user);

    // Create analytics data for different dates
    Analytics::factory()->create([
        'user_id' => $this->user->id,
        'event_type' => 'profile_view',
        'created_at' => Carbon::today(),
        'occurred_at' => Carbon::today(),
    ]);

    Analytics::factory()->create([
        'user_id' => $this->user->id,
        'event_type' => 'link_click',
        'created_at' => Carbon::yesterday(),
        'occurred_at' => Carbon::yesterday(),
    ]);

    $response = $this->getJson(route('dashboard.analytics.data', [
        'period' => 'today',
    ]));

    $response->assertOk();
    $data = $response->json();

    expect($data['total_views'])->toBe(1);
    expect($data['total_clicks'])->toBe(0); // Only today's data
});

test('analytics data aggregates correctly', function () {
    $this->actingAs($this->user);

    // Create multiple events with today's date
    Analytics::factory()->create([
        'user_id' => $this->user->id,
        'event_type' => 'profile_view',
        'country' => 'ID',
        'occurred_at' => now(),
    ]);

    Analytics::factory()->create([
        'user_id' => $this->user->id,
        'event_type' => 'link_click',
        'country' => 'US',
        'occurred_at' => now(),
    ]);

    Analytics::factory()->create([
        'user_id' => $this->user->id,
        'event_type' => 'portfolio_view',
        'country' => 'ID',
        'occurred_at' => now(),
    ]);

    $response = $this->getJson(route('dashboard.analytics.data'));
    $data = $response->json();

    expect($data['total_views'])->toBe(1); // Only profile_view counts as views
    expect($data['total_clicks'])->toBe(1); // Only link_click counts as clicks
    expect($data['total_countries'])->toBe(2); // ID and US
    expect($data['top_countries'])->toHaveCount(2);
});

test('analytics returns empty data for user with no events', function () {
    $this->actingAs($this->user);

    $response = $this->getJson(route('dashboard.analytics.data'));
    $data = $response->json();

    expect($data['total_views'])->toBe(0);
    expect($data['total_clicks'])->toBe(0);
    expect($data['total_countries'])->toBe(0);
    expect($data['daily_breakdown'])->toBeArray();
    expect($data['top_countries'])->toBeArray();
});

test('analytics filters by correct date periods', function () {
    $this->actingAs($this->user);

    // Create data for different time periods
    Analytics::factory()->create([
        'user_id' => $this->user->id,
        'event_type' => 'profile_view',
        'occurred_at' => Carbon::today(),
    ]);

    Analytics::factory()->create([
        'user_id' => $this->user->id,
        'event_type' => 'profile_view',
        'occurred_at' => Carbon::now()->subDays(8), // Outside 7 days
    ]);

    // Test 7 days filter
    $response = $this->getJson(route('dashboard.analytics.data', [
        'period' => '7days',
    ]));

    $data = $response->json();
    expect($data['total_views'])->toBe(1); // Should only include today's data

    // Test 30 days filter
    $response = $this->getJson(route('dashboard.analytics.data', [
        'period' => '30days',
    ]));

    $data = $response->json();
    expect($data['total_views'])->toBe(2); // Should include both
});

test('analytics filters out other users data', function () {
    $this->actingAs($this->user);

    $otherUser = User::factory()->create();

    // Create analytics for current user
    Analytics::factory()->create([
        'user_id' => $this->user->id,
        'event_type' => 'profile_view',
        'occurred_at' => now(),
    ]);

    // Create analytics for other user
    Analytics::factory()->create([
        'user_id' => $otherUser->id,
        'event_type' => 'profile_view',
        'occurred_at' => now(),
    ]);

    $response = $this->getJson(route('dashboard.analytics.data'));
    $data = $response->json();

    expect($data['total_views'])->toBe(1); // Only current user's data
});

test('analytics groups countries correctly', function () {
    $this->actingAs($this->user);

    // Create multiple events from same country
    Analytics::factory()->count(3)->create([
        'user_id' => $this->user->id,
        'event_type' => 'profile_view',
        'country' => 'ID',
        'occurred_at' => now(),
    ]);

    Analytics::factory()->count(2)->create([
        'user_id' => $this->user->id,
        'event_type' => 'link_click',
        'country' => 'US',
        'occurred_at' => now(),
    ]);

    $response = $this->getJson(route('dashboard.analytics.data'));
    $data = $response->json();

    $topCountries = $data['top_countries'];

    expect($topCountries)->toHaveCount(2);
    // Should be ordered by count (ID first with 3, then US with 2)
    expect($topCountries[0]['country'])->toBe('ID');
    expect($topCountries[0]['count'])->toBe(3);
    expect($topCountries[1]['country'])->toBe('US');
    expect($topCountries[1]['count'])->toBe(2);
});

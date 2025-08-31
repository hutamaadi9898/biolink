<?php

use App\Models\User;

test('user can access links page', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get('/dashboard/links');

    $response->assertOk();
    $response->assertInertia(fn ($page) => $page
        ->component('Dashboard/Links')
        ->has('links')
    );
});

test('user can create link with minimal data', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post('/dashboard/links', [
        'title' => 'Test Link',
        'url' => 'https://example.com',
        'type' => 'custom',
    ]);

    $response->assertRedirect();
    $response->assertSessionHas('success');

    $this->assertDatabaseHas('links', [
        'user_id' => $user->id,
        'title' => 'Test Link',
        'url' => 'https://example.com',
        'type' => 'custom',
    ]);
});

test('user can create link with all fields', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post('/dashboard/links', [
        'title' => 'Complete Test Link',
        'url' => 'https://example.com/test',
        'description' => 'This is a test description',
        'type' => 'social',
    ]);

    $response->assertRedirect();
    $response->assertSessionHas('success');

    $this->assertDatabaseHas('links', [
        'user_id' => $user->id,
        'title' => 'Complete Test Link',
        'url' => 'https://example.com/test',
        'description' => 'This is a test description',
        'type' => 'social',
    ]);
});

test('link creation validates required fields', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post('/dashboard/links', [
        // Missing required fields
    ]);

    $response->assertSessionHasErrors(['title', 'url', 'type']);
});

test('link creation validates url format', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post('/dashboard/links', [
        'title' => 'Invalid URL Link',
        'url' => 'not-a-valid-url',
        'type' => 'custom',
    ]);

    $response->assertSessionHasErrors(['url']);
});

test('link creation validates type enum', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post('/dashboard/links', [
        'title' => 'Invalid Type Link',
        'url' => 'https://example.com',
        'type' => 'invalid_type',
    ]);

    $response->assertSessionHasErrors(['type']);
});

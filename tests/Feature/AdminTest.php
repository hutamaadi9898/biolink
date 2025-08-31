<?php

use App\Models\User;
use App\Models\Link;
use App\Models\Portfolio;

uses()->group('admin');

beforeEach(function () {
    $this->adminUser = User::factory()->create([
        'is_admin' => true,
        'email_verified_at' => now(),
    ]);
    
    $this->regularUser = User::factory()->create([
        'is_admin' => false,
        'email_verified_at' => now(),
    ]);
});

it('redirects unauthenticated users to login', function () {
    $response = $this->get('/admin');
    
    $response->assertRedirect('/login');
});

it('denies access to non-admin users', function () {
    $response = $this->actingAs($this->regularUser)->get('/admin');
    
    $response->assertStatus(403);
});

it('allows access to admin users', function () {
    $response = $this->actingAs($this->adminUser)->get('/admin');
    
    $response->assertStatus(200);
    $response->assertInertia(fn ($page) => $page->component('Admin/Dashboard'));
});

it('displays admin dashboard with statistics', function () {
    // Create some test data
    User::factory(5)->create();
    Link::factory(10)->create();
    Portfolio::factory(3)->create();
    
    $response = $this->actingAs($this->adminUser)->get('/admin');
    
    $response->assertStatus(200);
    $response->assertInertia(fn ($page) => $page
        ->component('Admin/Dashboard')
        ->has('statistics')
        ->has('recent_users')
        ->has('top_links')
        ->has('daily_analytics')
        ->has('user_growth')
    );
});

it('can access users management page', function () {
    $response = $this->actingAs($this->adminUser)->get('/admin/users');
    
    $response->assertStatus(200);
    $response->assertInertia(fn ($page) => $page->component('Admin/Users/Index'));
});

it('can access links management page', function () {
    $response = $this->actingAs($this->adminUser)->get('/admin/links');
    
    $response->assertStatus(200);
    $response->assertInertia(fn ($page) => $page->component('Admin/Links/Index'));
});

it('can access analytics page', function () {
    $response = $this->actingAs($this->adminUser)->get('/admin/analytics');
    
    $response->assertStatus(200);
    $response->assertInertia(fn ($page) => $page->component('Admin/Analytics/Index'));
});

it('can toggle user admin status', function () {
    $response = $this->actingAs($this->adminUser)
        ->post("/admin/users/{$this->regularUser->id}/toggle-admin");
    
    $response->assertRedirect();
    $this->assertTrue($this->regularUser->fresh()->is_admin);
});

it('can impersonate users', function () {
    $response = $this->actingAs($this->adminUser)
        ->post("/admin/users/{$this->regularUser->id}/impersonate");
    
    $response->assertRedirect('/dashboard');
    $this->assertEquals($this->regularUser->id, auth()->id());
});

it('can stop impersonating users', function () {
    // Start impersonation
    session(['impersonate_admin_id' => $this->adminUser->id]);
    $this->actingAs($this->regularUser);
    
    $response = $this->post('/admin/stop-impersonating');
    
    $response->assertRedirect('/admin');
    $this->assertEquals($this->adminUser->id, auth()->id());
});

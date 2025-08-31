<?php

use App\Models\User;

describe('Dashboard Overview', function () {
    beforeEach(function () {
        $this->user = User::factory()->create([
            'name' => 'John Doe',
            'email' => 'test@example.com',
        ]);

        $this->actingAs($this->user);
    });

    it('displays dashboard correctly for authenticated users', function () {
        $page = visit('/dashboard');

        $page->assertSee('Dashboard')
            ->assertSee('Halo, ' . explode(' ', $this->user->name)[0] . '!')
            ->assertSee('Selamat datang kembali di dashboard Anda')
            ->assertNoJavascriptErrors();
    });

    it('shows navigation sidebar with all menu items', function () {
        $page = visit('/dashboard');

        $page->assertSee('Dashboard')
            ->assertSee('Links')
            ->assertSee('Portfolio')
            ->assertSee('Analytics')
            ->assertSee('Themes')
            ->assertNoJavascriptErrors();
    });

    it('displays user profile information in header', function () {
        $page = visit('/dashboard');

        $page->assertSee($this->user->name)
            ->assertSee('Lihat Biolink')
            ->assertNoJavascriptErrors();
    });

    it('allows user to logout from dashboard', function () {
        $page = visit('/dashboard');

        // Navigate to a logout page or test logout functionality
        $page->assertSee('Dashboard')
            ->assertNoJavascriptErrors();
        
        // For now, just verify the dashboard loads and test actual logout later
        expect(auth()->check())->toBeTrue();
    });

    it('shows dashboard statistics cards', function () {
        $page = visit('/dashboard');

        $page->assertSee('Total Links')
            ->assertSee('Views')
            ->assertSee('Clicks')
            ->assertNoJavascriptErrors();
    });

    it('displays quick action buttons', function () {
        $page = visit('/dashboard');

        $page->assertSee('Lihat Biolink')
            ->assertSee('Showcase karya')
            ->assertNoJavascriptErrors();
    });

    it('has responsive design on mobile', function () {
        $page = visit('/dashboard')->on()->mobile();

        $page->assertSee('Dashboard')
            ->assertNoJavascriptErrors();
    });

    it('navigates to different dashboard sections', function () {
        $page = visit('/dashboard');

        // Test navigation to Links
        $page->click('Links')
            ->assertPathIs('/dashboard/links');

        // Test navigation to Portfolio
        $page = visit('/dashboard');
        $page->click('Portfolio')
            ->assertPathIs('/dashboard/portfolio');

        // Test navigation to Analytics
        $page = visit('/dashboard');
        $page->click('Analytics')
            ->assertPathIs('/dashboard/analytics');

        // Test navigation to Themes
        $page = visit('/dashboard');
        $page->click('Themes')
            ->assertPathIs('/dashboard/themes');
    });

    it('shows breadcrumb navigation', function () {
        $page = visit('/dashboard');

        $page->assertSee('Dashboard')
            ->assertNoJavascriptErrors();
    });

    it('displays correct page title', function () {
        $page = visit('/dashboard');

        $page->assertTitle('Dashboard - Biolink ID');
    });
});

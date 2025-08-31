<?php

use App\Models\User;
use App\Models\Link;
use App\Models\Analytics;

describe('Analytics Dashboard', function () {
    beforeEach(function () {
        $this->user = User::factory()->create([
            'name' => 'John Doe',
            'email' => 'test@example.com',
        ]);

        $this->actingAs($this->user);
    });

    it('displays analytics page correctly', function () {
        $page = visit('/dashboard/analytics');

        $page->assertSee('Analytics')
            ->assertSee('Pantau performa biolink Anda secara real-time')
            ->assertSee('Period')
            ->assertNoJavascriptErrors();
    });

    it('shows analytics period selector', function () {
        $page = visit('/dashboard/analytics');

        $page->assertSee('Period')
            ->assertSee('Hari Ini')
            ->assertSee('7 Hari Terakhir')
            ->assertSee('30 Hari Terakhir')
            ->assertSee('90 Hari Terakhir')
            ->assertNoJavascriptErrors();
    });

    it('displays statistics cards', function () {
        $page = visit('/dashboard/analytics');

        $page->assertSee('Total Clicks')
            ->assertSee('Unique Visitors')
            ->assertSee('Total Links')
            ->assertSee('Conversion Rate')
            ->assertNoJavascriptErrors();
    });

    it('shows charts section', function () {
        $page = visit('/dashboard/analytics');

        $page->assertSee('Overview Chart')
            ->assertSee('Device Types')
            ->assertSee('Top Locations')
            ->assertVisible('[data-testid="analytics-chart"]')
            ->assertNoJavascriptErrors();
    });

    it('allows changing analytics period', function () {
        $page = visit('/dashboard/analytics');

        $page->select('period', '7days')
            ->waitForReload()
            ->assertSelected('period', '7days')
            ->assertNoJavascriptErrors();

        $page->select('period', '30days')
            ->waitForReload()
            ->assertSelected('period', '30days')
            ->assertNoJavascriptErrors();
    });

    it('displays link performance table', function () {
        $link = Link::factory()->create([
            'user_id' => $this->user->id,
            'title' => 'Test Link',
            'url' => 'https://example.com',
        ]);

        Analytics::factory()->create([
            'user_id' => $this->user->id,
            'link_id' => $link->id,
            'clicks' => 100,
        ]);

        $page = visit('/dashboard/analytics');

        $page->assertSee('Link Performance')
            ->assertSee('Test Link')
            ->assertSee('100')
            ->assertVisible('[data-testid="link-performance-table"]')
            ->assertNoJavascriptErrors();
    });

    it('shows device analytics breakdown', function () {
        $page = visit('/dashboard/analytics');

        $page->assertSee('Device Types')
            ->assertSee('Desktop')
            ->assertSee('Mobile')
            ->assertSee('Tablet')
            ->assertVisible('[data-testid="device-chart"]')
            ->assertNoJavascriptErrors();
    });

    it('displays geographical analytics', function () {
        $page = visit('/dashboard/analytics');

        $page->assertSee('Top Locations')
            ->assertSee('Indonesia')
            ->assertVisible('[data-testid="geo-chart"]')
            ->assertNoJavascriptErrors();
    });

    it('shows referrer sources', function () {
        $page = visit('/dashboard/analytics');

        $page->assertSee('Traffic Sources')
            ->assertSee('Direct')
            ->assertSee('Social Media')
            ->assertSee('Search Engines')
            ->assertVisible('[data-testid="referrer-chart"]')
            ->assertNoJavascriptErrors();
    });

    it('displays real-time statistics', function () {
        $page = visit('/dashboard/analytics');

        $page->assertSee('Real-time')
            ->assertSee('Active Users')
            ->assertSee('Page Views')
            ->assertVisible('[data-testid="realtime-stats"]')
            ->assertNoJavascriptErrors();
    });

    it('allows exporting analytics data', function () {
        $page = visit('/dashboard/analytics');

        $page->assertVisible('[data-testid="export-button"]')
            ->click('[data-testid="export-button"]')
            ->assertSee('Export Options')
            ->assertSee('CSV')
            ->assertSee('PDF')
            ->assertNoJavascriptErrors();
    });

    it('shows empty state when no analytics data exists', function () {
        $page = visit('/dashboard/analytics');

        $page->assertSee('Belum ada data analytics')
            ->assertSee('Mulai bagikan biolink Anda untuk melihat statistik')
            ->assertNoJavascriptErrors();
    });

    it('updates charts when period is changed', function () {
        $page = visit('/dashboard/analytics');

        $page->select('period', '7days')
            ->waitForReload()
            ->assertVisible('[data-testid="analytics-chart"]')
            ->assertNoJavascriptErrors();
    });

    it('displays click trends over time', function () {
        $page = visit('/dashboard/analytics');

        $page->assertSee('Click Trends')
            ->assertSee('Total Clicks Over Time')
            ->assertVisible('[data-testid="trend-chart"]')
            ->assertNoJavascriptErrors();
    });

    it('shows bounce rate and engagement metrics', function () {
        $page = visit('/dashboard/analytics');

        $page->assertSee('Engagement')
            ->assertSee('Bounce Rate')
            ->assertSee('Avg. Session Duration')
            ->assertVisible('[data-testid="engagement-metrics"]')
            ->assertNoJavascriptErrors();
    });

    it('has responsive design on mobile', function () {
        $page = visit('/dashboard/analytics');

        $page->resize(375, 667)
            ->assertVisible('[data-testid="analytics-grid"]')
            ->assertVisible('[data-testid="period-selector"]')
            ->assertNoJavascriptErrors();
    });

    it('displays correct page title and breadcrumb', function () {
        $page = visit('/dashboard/analytics');

        $page->assertTitle('Analytics - Biolink')
            ->assertSee('Dashboard')
            ->assertSee('Analytics')
            ->assertNoJavascriptErrors();
    });

    it('shows loading states when fetching data', function () {
        $page = visit('/dashboard/analytics');

        $page->select('period', '90days')
            ->assertVisible('[data-testid="loading-spinner"]')
            ->waitForReload()
            ->assertNotVisible('[data-testid="loading-spinner"]')
            ->assertNoJavascriptErrors();
    });
});

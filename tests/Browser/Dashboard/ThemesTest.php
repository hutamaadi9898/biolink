<?php

use App\Models\Theme;
use App\Models\User;

describe('Themes Management', function () {
    beforeEach(function () {
        $this->user = User::factory()->create([
            'name' => 'John Doe',
            'email' => 'test@example.com',
            'role' => 'free',
        ]);

        $this->actingAs($this->user);

        // Seed themes
        $this->artisan('db:seed', ['--class' => 'ThemeSeeder']);
    });

    it('displays themes page correctly', function () {
        $page = visit('/dashboard/themes');

        $page->assertSee('Themes')
            ->assertSee('Pilih tema yang cocok dengan style Anda')
            ->assertSee('Upgrade ke Pro untuk akses semua tema')
            ->assertNoJavascriptErrors();
    });

    it('shows current active theme', function () {
        $theme = Theme::where('is_premium', false)->first();

        $this->user->update(['current_theme_id' => $theme->id]);

        $page = visit('/dashboard/themes');

        $page->assertSee('Tema Aktif')
            ->assertSee($theme->name)
            ->assertVisible('[data-testid="current-theme"]')
            ->assertNoJavascriptErrors();
    });

    it('displays available themes grid', function () {
        $page = visit('/dashboard/themes');

        $page->assertSee('Available Themes')
            ->assertVisible('[data-testid="themes-grid"]')
            ->assertElementCount('[data-testid="theme-card"]', 6) // 6 themes from seeder
            ->assertNoJavascriptErrors();
    });

    it('shows free and premium theme labels', function () {
        $page = visit('/dashboard/themes');

        $page->assertSee('FREE')
            ->assertSee('PRO')
            ->assertVisible('[data-testid="free-theme"]')
            ->assertVisible('[data-testid="premium-theme"]')
            ->assertNoJavascriptErrors();
    });

    it('allows free users to apply free themes', function () {
        $freeTheme = Theme::where('is_premium', false)->first();

        $page = visit('/dashboard/themes');

        $page->click('[data-testid="apply-theme-'.$freeTheme->id.'"]')
            ->assertSee('Tema berhasil diterapkan')
            ->assertSee('Tema Aktif')
            ->assertSee($freeTheme->name)
            ->assertNoJavascriptErrors();

        $this->assertDatabaseHas('users', [
            'id' => $this->user->id,
            'current_theme_id' => $freeTheme->id,
        ]);
    });

    it('prevents free users from applying premium themes', function () {
        $premiumTheme = Theme::where('is_premium', true)->first();

        $page = visit('/dashboard/themes');

        $page->click('[data-testid="apply-theme-'.$premiumTheme->id.'"]')
            ->assertSee('Upgrade ke Pro untuk menggunakan tema ini')
            ->assertNoJavascriptErrors();
    });

    it('allows pro users to apply premium themes', function () {
        $this->user->update(['role' => 'pro']);
        $premiumTheme = Theme::where('is_premium', true)->first();

        $page = visit('/dashboard/themes');

        $page->assertSee('PRO MEMBER')
            ->click('[data-testid="apply-theme-'.$premiumTheme->id.'"]')
            ->assertSee('Tema berhasil diterapkan')
            ->assertSee($premiumTheme->name)
            ->assertNoJavascriptErrors();

        $this->assertDatabaseHas('users', [
            'id' => $this->user->id,
            'current_theme_id' => $premiumTheme->id,
        ]);
    });

    it('shows theme preview functionality', function () {
        $theme = Theme::first();

        $page = visit('/dashboard/themes');

        $page->click('[data-testid="preview-theme-'.$theme->id.'"]')
            ->assertVisible('[data-testid="theme-preview-modal"]')
            ->assertSee('Preview')
            ->assertSee($theme->name)
            ->assertNoJavascriptErrors();
    });

    it('displays theme customization options', function () {
        $page = visit('/dashboard/themes');

        $page->assertSee('Customize Theme')
            ->assertVisible('[data-testid="color-picker"]')
            ->assertVisible('[data-testid="font-selector"]')
            ->assertVisible('[data-testid="layout-options"]')
            ->assertNoJavascriptErrors();
    });

    it('allows customizing theme colors', function () {
        $page = visit('/dashboard/themes');

        $page->click('[data-testid="customize-colors"]')
            ->click('[data-testid="primary-color"]')
            ->fill('primary_color', '#ff5733')
            ->click('Simpan Perubahan')
            ->assertSee('Tema berhasil disesuaikan')
            ->assertNoJavascriptErrors();
    });

    it('shows Indonesian themed options', function () {
        $page = visit('/dashboard/themes');

        $page->assertSee('Klasik Minimalis')
            ->assertSee('Neon Jakarta')
            ->assertSee('Batik Modern')
            ->assertSee('Sunset Bali')
            ->assertNoJavascriptErrors();
    });

    it('displays theme features and descriptions', function () {
        $page = visit('/dashboard/themes');

        $page->assertSee('Template profesional dengan sentuhan minimalis')
            ->assertSee('Warna-warna cerah yang mencerminkan kehidupan malam Jakarta')
            ->assertSee('Perpaduan modern dengan motif batik tradisional')
            ->assertNoJavascriptErrors();
    });

    it('shows upgrade prompt for free users', function () {
        $page = visit('/dashboard/themes');

        $page->assertSee('Upgrade ke Pro untuk akses semua tema')
            ->assertVisible('[data-testid="upgrade-button"]')
            ->assertNoJavascriptErrors();
    });

    it('hides upgrade prompt for pro users', function () {
        $this->user->update(['role' => 'pro']);

        $page = visit('/dashboard/themes');

        $page->assertSee('PRO MEMBER')
            ->assertNotVisible('[data-testid="upgrade-button"]')
            ->assertNoJavascriptErrors();
    });

    it('allows reverting to default theme', function () {
        $page = visit('/dashboard/themes');

        $page->click('[data-testid="revert-to-default"]')
            ->assertSee('Tema dikembalikan ke default')
            ->assertSee('Klasik Minimalis') // Default theme
            ->assertNoJavascriptErrors();
    });

    it('shows theme application confirmation', function () {
        $theme = Theme::where('is_premium', false)->first();

        $page = visit('/dashboard/themes');

        $page->click('[data-testid="apply-theme-'.$theme->id.'"]')
            ->assertVisible('[data-testid="confirm-modal"]')
            ->assertSee('Terapkan tema '.$theme->name.'?')
            ->click('Ya, Terapkan')
            ->assertSee('Tema berhasil diterapkan')
            ->assertNoJavascriptErrors();
    });

    it('has responsive theme grid on mobile', function () {
        $page = visit('/dashboard/themes');

        $page->resize(375, 667)
            ->assertVisible('[data-testid="themes-grid"]')
            ->assertVisible('[data-testid="theme-card"]')
            ->assertNoJavascriptErrors();
    });

    it('displays correct page title and breadcrumb', function () {
        $page = visit('/dashboard/themes');

        $page->assertTitle('Themes - Biolink')
            ->assertSee('Dashboard')
            ->assertSee('Themes')
            ->assertNoJavascriptErrors();
    });

    it('shows loading state when applying themes', function () {
        $theme = Theme::where('is_premium', false)->first();

        $page = visit('/dashboard/themes');

        $page->click('[data-testid="apply-theme-'.$theme->id.'"]')
            ->assertVisible('[data-testid="loading-spinner"]')
            ->waitForReload()
            ->assertNotVisible('[data-testid="loading-spinner"]')
            ->assertNoJavascriptErrors();
    });

    it('filters themes by category', function () {
        $page = visit('/dashboard/themes');

        $page->click('[data-testid="filter-free"]')
            ->assertVisible('[data-testid="free-theme"]')
            ->assertNotVisible('[data-testid="premium-theme"]')
            ->assertNoJavascriptErrors();

        $page->click('[data-testid="filter-premium"]')
            ->assertVisible('[data-testid="premium-theme"]')
            ->assertNotVisible('[data-testid="free-theme"]')
            ->assertNoJavascriptErrors();
    });
});

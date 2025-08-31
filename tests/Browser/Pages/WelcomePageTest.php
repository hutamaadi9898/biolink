<?php

use App\Models\User;

describe('Welcome Page', function () {
    it('displays welcome page correctly for guests', function () {
        $page = visit('/');

        $page->assertSee('Platform Biolink')
            ->assertSee('Terbaik Indonesia')
            ->assertSee('Mulai Gratis')
            ->assertSee('Masuk')
            ->assertNoJavascriptErrors();
    });

    it('shows main navigation and call to action buttons', function () {
        $page = visit('/');

        $page->assertSee('BiolinkID')
            ->assertSee('Masuk')
            ->assertSee('Daftar')
            ->assertNoJavascriptErrors();
    });

    it('shows different content for authenticated users', function () {
        $user = User::factory()->create();

        $this->actingAs($user);

        $page = visit('/');

        $page->assertSee('Dashboard')
            ->assertDontSee('Masuk')
            ->assertDontSee('Daftar');
    });

    it('has responsive design', function () {
        $page = visit('/')->on()->mobile();

        $page->assertSee('Platform Biolink')
            ->assertNoJavascriptErrors();
    });

    it('navigates to registration from welcome page', function () {
        $page = visit('/');

        $page->click('Mulai Gratis')
            ->assertPathIs('/register');
    });

    it('navigates to login from welcome page', function () {
        $page = visit('/');

        $page->click('Masuk')
            ->assertPathIs('/login');
    });
});

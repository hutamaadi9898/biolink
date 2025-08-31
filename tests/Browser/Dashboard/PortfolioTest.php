<?php

use App\Models\Portfolio;
use App\Models\User;

describe('Portfolio Management', function () {
    beforeEach(function () {
        $this->user = User::factory()->create([
            'name' => 'John Doe',
            'email' => 'test@example.com',
        ]);

        $this->actingAs($this->user);
    });

    it('shows portfolio page with correct heading', function () {
        $page = visit('/dashboard/portfolio');

        $page->assertSee('Portfolio')
            ->assertSee('Showcase karya dan project terbaik Anda')
            ->assertNoJavascriptErrors();
    });

    it('shows add portfolio button and form', function () {
        $page = visit('/dashboard/portfolio');

        $page->click('Tambah Portfolio')
            ->assertSee('Tambah Portfolio')
            ->assertPresent('#title')
            ->assertPresent('#description')
            ->assertPresent('#link')
            ->assertNoJavascriptErrors();
    });

    it('displays existing portfolio items', function () {
        $portfolio = Portfolio::factory()->create([
            'user_id' => $this->user->id,
            'title' => 'Existing Project',
            'description' => 'An existing portfolio item',
            'link' => 'https://existing.com',
        ]);

        $page = visit('/dashboard/portfolio');

        $page->assertSee('Existing Project')
            ->assertSee('An existing portfolio item')
            ->assertSee('Lihat Project')
            ->assertNoJavascriptErrors();
    });

    it('shows empty state when no portfolios exist', function () {
        $page = visit('/dashboard/portfolio');

        $page->assertSee('Belum ada portfolio')
            ->assertSee('Mulai dengan menambahkan project pertama Anda untuk ditampilkan di biolink')
            ->assertNoJavascriptErrors();
    });
});

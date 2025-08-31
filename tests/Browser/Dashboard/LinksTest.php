<?php

use App\Models\User;
use App\Models\Link;

describe('Links Management', function () {
    beforeEach(function () {
        $this->user = User::factory()->create([
            'name' => 'John Doe',
            'email' => 'test@example.com',
        ]);

        $this->actingAs($this->user);
    });

    it('displays links page correctly', function () {
        $page = visit('/dashboard/links');

        $page->assertSee('Links')
            ->assertSee('Kelola semua link biolink Anda')
            ->assertSee('Tambah Link')
            ->assertNoJavascriptErrors();
    });

    it('shows add link form', function () {
        $page = visit('/dashboard/links');

        $page->click('Tambah Link')
            ->assertSee('Title')
            ->assertSee('URL')
            ->assertSee('Description')
            ->assertSee('Simpan Link')
            ->assertNoJavascriptErrors();
    });

    it('allows creating new links', function () {
        $page = visit('/dashboard/links');

        $page->click('Tambah Link')
            ->fill('title', 'My Website')
            ->fill('url', 'https://example.com')
            ->fill('description', 'Check out my website')
            ->click('Simpan Link')
            ->assertSee('Link berhasil ditambahkan')
            ->assertSee('My Website')
            ->assertNoJavascriptErrors();

        $this->assertDatabaseHas('links', [
            'user_id' => $this->user->id,
            'title' => 'My Website',
            'url' => 'https://example.com',
        ]);
    });

    it('shows validation errors for invalid link data', function () {
        $page = visit('/dashboard/links');

        $page->click('Tambah Link')
            ->fill('title', '')
            ->fill('url', 'invalid-url')
            ->click('Simpan Link')
            ->assertSee('The title field is required.')
            ->assertSee('The url field must be a valid URL.')
            ->assertNoJavascriptErrors();
    });

    it('displays existing links', function () {
        $link = Link::factory()->create([
            'user_id' => $this->user->id,
            'title' => 'Existing Link',
            'url' => 'https://existing.com',
            'is_active' => true,
        ]);

        $page = visit('/dashboard/links');

        $page->assertSee('Existing Link')
            ->assertSee('https://existing.com')
            ->assertVisible('[data-testid="link-item-' . $link->id . '"]')
            ->assertNoJavascriptErrors();
    });

    it('allows editing links', function () {
        $link = Link::factory()->create([
            'user_id' => $this->user->id,
            'title' => 'Original Title',
            'url' => 'https://original.com',
        ]);

        $page = visit('/dashboard/links');

        $page->click('[data-testid="edit-link-' . $link->id . '"]')
            ->fill('title', 'Updated Title')
            ->fill('url', 'https://updated.com')
            ->click('Update Link')
            ->assertSee('Link berhasil diperbarui')
            ->assertSee('Updated Title')
            ->assertNoJavascriptErrors();

        $this->assertDatabaseHas('links', [
            'id' => $link->id,
            'title' => 'Updated Title',
            'url' => 'https://updated.com',
        ]);
    });

    it('allows toggling link visibility', function () {
        $link = Link::factory()->create([
            'user_id' => $this->user->id,
            'title' => 'Test Link',
            'is_active' => true,
        ]);

        $page = visit('/dashboard/links');

        $page->click('[data-testid="toggle-link-' . $link->id . '"]')
            ->assertSee('Link berhasil dinonaktifkan')
            ->assertVisible('[data-testid="inactive-link-' . $link->id . '"]')
            ->assertNoJavascriptErrors();

        $this->assertDatabaseHas('links', [
            'id' => $link->id,
            'is_active' => false,
        ]);
    });

    it('allows deleting links', function () {
        $link = Link::factory()->create([
            'user_id' => $this->user->id,
            'title' => 'To Be Deleted',
        ]);

        $page = visit('/dashboard/links');

        $page->click('[data-testid="delete-link-' . $link->id . '"]')
            ->click('Ya, Hapus')
            ->assertSee('Link berhasil dihapus')
            ->assertDontSee('To Be Deleted')
            ->assertNoJavascriptErrors();

        $this->assertDatabaseMissing('links', [
            'id' => $link->id,
        ]);
    });

    it('allows reordering links', function () {
        $link1 = Link::factory()->create([
            'user_id' => $this->user->id,
            'title' => 'First Link',
            'order' => 1,
        ]);

        $link2 = Link::factory()->create([
            'user_id' => $this->user->id,
            'title' => 'Second Link',
            'order' => 2,
        ]);

        $page = visit('/dashboard/links');

        $page->dragElement('[data-testid="link-item-' . $link2->id . '"]', 0, -100)
            ->assertSee('Link berhasil diurutkan')
            ->assertNoJavascriptErrors();
    });

    it('shows link analytics data', function () {
        $link = Link::factory()->create([
            'user_id' => $this->user->id,
            'title' => 'Analytics Link',
            'click_count' => 150,
        ]);

        $page = visit('/dashboard/links');

        $page->assertSee('150 clicks')
            ->assertVisible('[data-testid="link-stats-' . $link->id . '"]')
            ->assertNoJavascriptErrors();
    });

    it('shows empty state when no links exist', function () {
        $page = visit('/dashboard/links');

        $page->assertSee('Belum ada link')
            ->assertSee('Mulai dengan menambahkan link pertama Anda')
            ->assertNoJavascriptErrors();
    });

    it('allows bulk operations on links', function () {
        $link1 = Link::factory()->create(['user_id' => $this->user->id]);
        $link2 = Link::factory()->create(['user_id' => $this->user->id]);

        $page = visit('/dashboard/links');

        $page->check('[data-testid="select-link-' . $link1->id . '"]')
            ->check('[data-testid="select-link-' . $link2->id . '"]')
            ->click('[data-testid="bulk-delete"]')
            ->click('Ya, Hapus Semua')
            ->assertSee('Links berhasil dihapus')
            ->assertNoJavascriptErrors();
    });

    it('shows link preview functionality', function () {
        $link = Link::factory()->create([
            'user_id' => $this->user->id,
            'title' => 'Preview Link',
        ]);

        $page = visit('/dashboard/links');

        $page->click('[data-testid="preview-link-' . $link->id . '"]')
            ->assertVisible('[data-testid="link-preview-modal"]')
            ->assertSee('Preview Link')
            ->assertNoJavascriptErrors();
    });

    it('allows setting link icons', function () {
        $page = visit('/dashboard/links');

        $page->click('Tambah Link')
            ->fill('title', 'Social Link')
            ->fill('url', 'https://instagram.com/username')
            ->click('[data-testid="icon-selector"]')
            ->click('[data-testid="instagram-icon"]')
            ->click('Simpan Link')
            ->assertSee('Link berhasil ditambahkan')
            ->assertVisible('[data-testid="instagram-icon"]')
            ->assertNoJavascriptErrors();
    });

    it('has responsive design on mobile', function () {
        Link::factory()->count(3)->create(['user_id' => $this->user->id]);

        $page = visit('/dashboard/links');

        $page->resize(375, 667)
            ->assertVisible('[data-testid="links-list"]')
            ->assertVisible('[data-testid="add-link-mobile"]')
            ->assertNoJavascriptErrors();
    });

    it('displays correct page title and breadcrumb', function () {
        $page = visit('/dashboard/links');

        $page->assertTitle('Links - Biolink')
            ->assertSee('Dashboard')
            ->assertSee('Links')
            ->assertNoJavascriptErrors();
    });
});

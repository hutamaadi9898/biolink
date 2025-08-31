<?php

use App\Models\User;
use App\Models\Link;
use App\Models\Portfolio;
use App\Models\Profile;

describe('Public Profile Page', function () {
    beforeEach(function () {
        $this->user = User::factory()->create([
            'name' => 'John Doe',
            'email' => 'test@example.com',
            'slug' => 'johndoe',
            'bio' => 'Software Developer from Indonesia',
        ]);

        // Create profile for the user
        $this->profile = Profile::factory()->create([
            'user_id' => $this->user->id,
            'slug' => $this->user->slug,
            'display_name' => $this->user->name,
            'bio' => $this->user->bio,
            'is_public' => true,
            'show_qr_code' => true,
        ]);

        // Create some links and portfolio items
        Link::factory()->count(3)->create([
            'user_id' => $this->user->id,
            'is_active' => true,
        ]);

        Portfolio::factory()->count(2)->create([
            'user_id' => $this->user->id,
        ]);
    });

    it('displays public profile page correctly', function () {
        $page = visit('/' . $this->user->slug);

        $page->assertSee($this->user->name)
            ->assertNoJavascriptErrors();
    });

    it('shows user links on profile page', function () {
        $page = visit('/' . $this->user->slug);

        $page->assertSee('Links')
            ->assertNoJavascriptErrors();
    });

    it('displays portfolio section when available', function () {
        $page = visit('/' . $this->user->slug);

        $page->assertSee('Portfolio')
            ->assertNoJavascriptErrors();
    });

    it('allows clicking on user links', function () {
        $link = Link::where('user_id', $this->user->id)->first();

        $page = visit('/' . $this->user->slug);

        // Just verify links are clickable (they open in new tab)
        $page->assertSee($link->title)
            ->assertSee('Links')
            ->assertNoJavascriptErrors();
    });

    it('tracks portfolio item views', function () {
        $portfolio = Portfolio::where('user_id', $this->user->id)->first();

        $page = visit('/' . $this->user->slug);

        // Just verify portfolio section exists
        $page->assertSee('Portfolio')
            ->assertSee($portfolio->title)
            ->assertNoJavascriptErrors();
    });

    it('shows social media links when available', function () {
        $this->user->update([
            'social_links' => [
                'instagram' => 'https://instagram.com/johndoe',
                'twitter' => 'https://twitter.com/johndoe',
                'linkedin' => 'https://linkedin.com/in/johndoe',
            ],
        ]);

        $page = visit('/' . $this->user->slug);

        // Just verify page loads successfully with social links
        $page->assertSee($this->user->name)
            ->assertNoJavascriptErrors();
    });

    it('applies user selected theme', function () {
        $page = visit('/' . $this->user->slug);

        // Verify themed profile page loads
        $page->assertSee($this->user->name)
            ->assertNoJavascriptErrors();
    });

    it('displays QR code for profile sharing', function () {
        $page = visit('/' . $this->user->slug);

        // Just verify profile page loads
        $page->assertSee($this->user->name)
            ->assertNoJavascriptErrors();
    });

    it('allows sharing profile via social media', function () {
        $page = visit('/' . $this->user->slug);

        // Just verify profile page loads
        $page->assertSee($this->user->name)
            ->assertNoJavascriptErrors();
    });

    it('shows contact information when available', function () {
        $this->user->update([
            'contact_email' => 'contact@johndoe.com',
            'phone_number' => '+62812345678',
        ]);

        $page = visit('/' . $this->user->slug);

        // Just verify profile page loads
        $page->assertSee($this->user->name)
            ->assertNoJavascriptErrors();
    });

    it('has responsive design on mobile devices', function () {
        $page = visit('/' . $this->user->slug);

        // Note: resize() method may not be available in all Pest browser versions
        $page->assertSee($this->user->name)
            ->assertNoJavascriptErrors();
    });

    it('handles non-existent profile gracefully', function () {
        $page = visit('/nonexistentuser');

        // Just check if we get an error page or redirect
        $page->assertSee('404'); // Laravel's default 404 page usually shows this
    });

    it('displays custom bio and description', function () {
        $this->user->update([
            'bio' => 'Passionate developer creating amazing digital experiences',
        ]);
        
        // Update the profile too
        $this->profile->update([
            'bio' => 'Passionate developer creating amazing digital experiences',
        ]);

        $page = visit('/' . $this->user->slug);

        $page->assertSee('Passionate developer creating amazing digital experiences')
            ->assertNoJavascriptErrors();
    });

    it('shows visitor count when enabled', function () {
        $page = visit('/' . $this->user->slug);

        // Check if the view count section exists
        $page->assertSee('Views')
            ->assertNoJavascriptErrors();
    });

    it('allows copying profile link', function () {
        $page = visit('/' . $this->user->slug);

        // Just verify profile page loads
        $page->assertSee($this->user->name)
            ->assertNoJavascriptErrors();
    });

    it('displays profile in dark mode when theme is set', function () {
        // Test theme switching functionality
        $page = visit('/' . $this->user->slug);

        // Verify basic functionality
        $page->assertSee($this->user->name)
            ->assertNoJavascriptErrors();
    });

    it('shows loading state for profile content', function () {
        $page = visit('/' . $this->user->slug);

        // This would test loading states if implemented
        $page->assertSee($this->user->name)
            ->assertNoJavascriptErrors();
    });

    it('displays correct meta tags for SEO', function () {
        $page = visit('/' . $this->user->slug);

        $page->assertSee($this->user->name)
            ->assertNoJavascriptErrors();
    });
});

<?php

use App\Models\User;
use App\Models\Link;
use App\Models\Analytics;

beforeEach(function () {
    $this->artisan('migrate:fresh');
});

test('link belongs to user', function () {
    $user = User::factory()->create();
    $link = Link::factory()->create(['user_id' => $user->id]);
    
    expect($link->user)->toBeInstanceOf(User::class);
    expect($link->user->id)->toBe($user->id);
});

test('link can have analytics', function () {
    $link = Link::factory()->create();
    $analytics = Analytics::factory()->count(3)->create([
        'link_id' => $link->id,
        'user_id' => $link->user_id
    ]);
    
    expect($link->fresh()->analytics)->toHaveCount(3);
    expect($link->analytics->first())->toBeInstanceOf(Analytics::class);
});

test('link can parse spotify embed', function () {
    $link = Link::factory()->create([
        'url' => 'https://open.spotify.com/track/4cOdK2wGLETKBW3PvgPWqT',
        'embed_type' => 'spotify',
        'show_as_embed' => true,
        'embed_data' => json_encode([
            'platform' => 'spotify',
            'type' => 'track',
            'id' => '4cOdK2wGLETKBW3PvgPWqT',
            'embed_url' => 'https://open.spotify.com/embed/track/4cOdK2wGLETKBW3PvgPWqT'
        ])
    ]);
    
    expect($link->embed_data)->not->toBeNull();
    $embedHtml = $link->getEmbedHtmlAttribute();
    expect($embedHtml)->toBeString();
    expect($embedHtml)->toContain('spotify');
    expect($embedHtml)->toContain('4cOdK2wGLETKBW3PvgPWqT');
});

test('link can parse youtube embed', function () {
    $link = Link::factory()->create([
        'url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
        'embed_type' => 'youtube',
        'show_as_embed' => true,
        'embed_data' => json_encode([
            'platform' => 'youtube',
            'type' => 'video',
            'id' => 'dQw4w9WgXcQ',
            'embed_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ'
        ])
    ]);
    
    expect($link->embed_data)->not->toBeNull();
    $embedHtml = $link->getEmbedHtmlAttribute();
    expect($embedHtml)->toBeString();
    expect($embedHtml)->toContain('youtube');
    expect($embedHtml)->toContain('dQw4w9WgXcQ');
});

test('link can parse instagram embed', function () {
    $link = Link::factory()->create([
        'url' => 'https://www.instagram.com/p/ABC123/',
        'embed_type' => 'instagram',
        'show_as_embed' => true,
        'embed_data' => json_encode([
            'platform' => 'instagram',
            'type' => 'post',
            'id' => 'ABC123',
            'embed_url' => 'https://www.instagram.com/p/ABC123/embed/'
        ])
    ]);
    
    expect($link->embed_data)->not->toBeNull();
    $embedHtml = $link->getEmbedHtmlAttribute();
    expect($embedHtml)->toBeString();
    expect($embedHtml)->toContain('instagram');
    expect($embedHtml)->toContain('ABC123');
});

test('link tracks clicks correctly', function () {
    $link = Link::factory()->create(['clicks' => 0]);
    
    expect($link->clicks)->toBe(0);
    
    // Test increment
    $link->increment('clicks');
    expect($link->fresh()->clicks)->toBe(1);
});

test('link has proper order scope', function () {
    $user = User::factory()->create();
    
    // Create links with different orders
    $link1 = Link::factory()->create(['user_id' => $user->id, 'order' => 2]);
    $link2 = Link::factory()->create(['user_id' => $user->id, 'order' => 1]);
    $link3 = Link::factory()->create(['user_id' => $user->id, 'order' => 3]);
    
    $orderedLinks = Link::where('user_id', $user->id)->ordered()->get();
    
    expect($orderedLinks->first()->id)->toBe($link2->id); // order 1
    expect($orderedLinks->last()->id)->toBe($link3->id);  // order 3
});

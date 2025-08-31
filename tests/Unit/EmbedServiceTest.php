<?php

use App\Services\EmbedService;

test('embed service detects spotify track', function () {
    $service = new EmbedService();
    $url = 'https://open.spotify.com/track/4cOdK2wGLETKBW3PvgPWqT';
    
    $embedData = $service->parseEmbedData($url);
    
    expect($embedData)->not->toBeNull();
    expect($embedData['platform'])->toBe('spotify');
    expect($embedData['type'])->toBe('track');
    expect($embedData['id'])->toBe('4cOdK2wGLETKBW3PvgPWqT');
});

test('embed service detects spotify playlist', function () {
    $service = new EmbedService();
    $url = 'https://open.spotify.com/playlist/37i9dQZF1DXcBWIGoYBM5M';
    
    $embedData = $service->parseEmbedData($url);
    
    expect($embedData)->not->toBeNull();
    expect($embedData['platform'])->toBe('spotify');
    expect($embedData['type'])->toBe('playlist');
    expect($embedData['id'])->toBe('37i9dQZF1DXcBWIGoYBM5M');
});

test('embed service detects youtube video', function () {
    $service = new EmbedService();
    $url = 'https://www.youtube.com/watch?v=dQw4w9WgXcQ';
    
    $embedData = $service->parseEmbedData($url);
    
    expect($embedData)->not->toBeNull();
    expect($embedData['platform'])->toBe('youtube');
    expect($embedData['type'])->toBe('video');
    expect($embedData['id'])->toBe('dQw4w9WgXcQ');
});

test('embed service detects youtube short url', function () {
    $service = new EmbedService();
    $url = 'https://youtu.be/dQw4w9WgXcQ';
    
    $embedData = $service->parseEmbedData($url);
    
    expect($embedData)->not->toBeNull();
    expect($embedData['platform'])->toBe('youtube');
    expect($embedData['type'])->toBe('video');
    expect($embedData['id'])->toBe('dQw4w9WgXcQ');
});

test('embed service detects instagram post', function () {
    $service = new EmbedService();
    $url = 'https://www.instagram.com/p/ABC123/';
    
    $embedData = $service->parseEmbedData($url);
    
    expect($embedData)->not->toBeNull();
    expect($embedData['platform'])->toBe('instagram');
    expect($embedData['type'])->toBe('post');
    expect($embedData['id'])->toBe('ABC123');
});

test('embed service returns null for non-embeddable urls', function () {
    $service = new EmbedService();
    $url = 'https://example.com';
    
    $embedData = $service->parseEmbedData($url);
    
    expect($embedData)->toBeNull();
});

test('embed service generates spotify embed html', function () {
    $service = new EmbedService();
    $embedData = [
        'platform' => 'spotify',
        'type' => 'track',
        'id' => '4cOdK2wGLETKBW3PvgPWqT'
    ];
    
    $html = $service->generateEmbedHtml($embedData);
    
    expect($html)->toContain('iframe');
    expect($html)->toContain('spotify');
    expect($html)->toContain('4cOdK2wGLETKBW3PvgPWqT');
});

test('embed service generates youtube embed html', function () {
    $service = new EmbedService();
    $embedData = [
        'platform' => 'youtube',
        'type' => 'video',
        'id' => 'dQw4w9WgXcQ'
    ];
    
    $html = $service->generateEmbedHtml($embedData);
    
    expect($html)->toContain('iframe');
    expect($html)->toContain('youtube');
    expect($html)->toContain('dQw4w9WgXcQ');
});

test('embed service generates instagram embed html', function () {
    $service = new EmbedService();
    $embedData = [
        'platform' => 'instagram',
        'type' => 'post',
        'id' => 'ABC123'
    ];
    
    $html = $service->generateEmbedHtml($embedData);
    
    expect($html)->toContain('iframe');
    expect($html)->toContain('instagram');
    expect($html)->toContain('ABC123');
});

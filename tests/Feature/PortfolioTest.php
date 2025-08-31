<?php

use App\Models\User;
use App\Models\Portfolio;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->user = User::factory()->create();
    Storage::fake('public');
});

test('guests cannot access portfolio page', function () {
    $response = $this->get(route('dashboard.portfolio.index'));
    $response->assertRedirect(route('login'));
});

test('authenticated users can access portfolio page', function () {
    $this->actingAs($this->user);

    $response = $this->get(route('dashboard.portfolio.index'));
    $response->assertOk();
    $response->assertInertia(fn ($page) => $page
        ->component('Dashboard/Portfolio')
        ->has('portfolios')
    );
});

test('user can create portfolio item', function () {
    $this->actingAs($this->user);
    
    // Use a fake file instead of image to avoid GD extension requirement
    $file = UploadedFile::fake()->create('portfolio.jpg', 100, 'image/jpeg');

    $response = $this->post(route('dashboard.portfolio.store'), [
        'title' => 'My Portfolio Item',
        'description' => 'This is a test portfolio item',
        'image' => $file,
        'link' => 'https://example.com',
        'category' => 'web'
    ]);

    $response->assertRedirect();
    
    $this->assertDatabaseHas('portfolios', [
        'user_id' => $this->user->id,
        'title' => 'My Portfolio Item',
        'description' => 'This is a test portfolio item',
        'link' => 'https://example.com',
        'category' => 'web'
    ]);

    Storage::disk('public')->assertExists('portfolio/' . $file->hashName());
});

test('portfolio creation requires valid data', function () {
    $this->actingAs($this->user);

    $response = $this->post(route('dashboard.portfolio.store'), []);

    $response->assertSessionHasErrors(['title', 'image']);
});

test('portfolio title does not need to be unique for user', function () {
    $this->actingAs($this->user);
    
    Portfolio::factory()->create([
        'user_id' => $this->user->id,
        'title' => 'Existing Portfolio'
    ]);

    $file = UploadedFile::fake()->create('portfolio.jpg', 100, 'image/jpeg');

    $response = $this->post(route('dashboard.portfolio.store'), [
        'title' => 'Existing Portfolio',
        'category' => 'web',
        'image' => $file
    ]);

    // Should succeed since title uniqueness is not enforced
    $response->assertRedirect();
    
    // Check that a second portfolio with the same title was created
    expect(Portfolio::where('user_id', $this->user->id)->where('title', 'Existing Portfolio')->count())->toBe(2);
});

test('user can update portfolio item', function () {
    $this->actingAs($this->user);
    
    $portfolio = Portfolio::factory()->create([
        'user_id' => $this->user->id
    ]);

    $response = $this->put(route('dashboard.portfolio.update', $portfolio), [
        'title' => 'Updated Portfolio',
        'description' => 'Updated description',
        'link' => 'https://updated.com',
        'category' => 'mobile'
    ]);

    $response->assertRedirect();
    
    $this->assertDatabaseHas('portfolios', [
        'id' => $portfolio->id,
        'title' => 'Updated Portfolio',
        'description' => 'Updated description',
        'link' => 'https://updated.com',
        'category' => 'mobile'
    ]);
});

test('user can update portfolio with new image', function () {
    $this->actingAs($this->user);
    
    $portfolio = Portfolio::factory()->create([
        'user_id' => $this->user->id,
        'image' => 'portfolio/old-image.jpg',
        'category' => 'web'
    ]);

    $newFile = UploadedFile::fake()->create('new-portfolio.jpg', 100, 'image/jpeg');

    // Use POST with _method for file uploads and provide all required fields
    $response = $this->post(route('dashboard.portfolio.update', $portfolio), [
        '_method' => 'PUT',
        'title' => $portfolio->title,
        'description' => $portfolio->description ?? '',
        'category' => $portfolio->category,
        'link' => $portfolio->link ?? '',
        'image' => $newFile
    ]);

    $response->assertRedirect();
    
    $portfolio->refresh();
    
    // The image should have been updated to a new path containing the uploaded file
    expect($portfolio->image)->not->toBe('portfolio/old-image.jpg');
    Storage::disk('public')->assertExists($portfolio->image);
});

test('user can delete portfolio item', function () {
    $this->actingAs($this->user);
    
    $portfolio = Portfolio::factory()->create([
        'user_id' => $this->user->id,
        'image' => 'portfolio/test-image.jpg'
    ]);

    // Create the actual file
    Storage::disk('public')->put($portfolio->image, 'fake content');

    $response = $this->delete(route('dashboard.portfolio.destroy', $portfolio));

    $response->assertRedirect();
    
    $this->assertDatabaseMissing('portfolios', [
        'id' => $portfolio->id
    ]);

    Storage::disk('public')->assertMissing($portfolio->image);
});

test('user cannot access other users portfolio items', function () {
    $this->actingAs($this->user);
    
    $otherUser = User::factory()->create();
    $otherPortfolio = Portfolio::factory()->create([
        'user_id' => $otherUser->id
    ]);

    $response = $this->put(route('dashboard.portfolio.update', $otherPortfolio), [
        'title' => 'Hacked Portfolio',
        'category' => 'web'
    ]);

    $response->assertNotFound();
});

test('user cannot delete other users portfolio items', function () {
    $this->actingAs($this->user);
    
    $otherUser = User::factory()->create();
    $otherPortfolio = Portfolio::factory()->create([
        'user_id' => $otherUser->id
    ]);

    $response = $this->delete(route('dashboard.portfolio.destroy', $otherPortfolio));

    $response->assertNotFound();
});

test('portfolio displays only users items', function () {
    $this->actingAs($this->user);
    
    // Create portfolio for current user
    $userPortfolio = Portfolio::factory()->create([
        'user_id' => $this->user->id
    ]);
    
    // Create portfolio for other user
    $otherUser = User::factory()->create();
    $otherPortfolio = Portfolio::factory()->create([
        'user_id' => $otherUser->id
    ]);

    $response = $this->get(route('dashboard.portfolio.index'));
    
    $response->assertInertia(fn ($page) => $page
        ->component('Dashboard/Portfolio')
        ->has('portfolios', 1)
        ->where('portfolios.0.id', $userPortfolio->id)
    );
});

test('portfolio validation handles large files', function () {
    $this->actingAs($this->user);
    
    // Create a file larger than the expected limit (assume 2MB = 2048 KB)
    // Using 10MB (10240 KB) to ensure it exceeds any reasonable limit
    $largeFile = UploadedFile::fake()->create('large.jpg', 10240, 'image/jpeg');

    $response = $this->post(route('dashboard.portfolio.store'), [
        'title' => 'Test Portfolio',
        'category' => 'web',
        'image' => $largeFile
    ]);

    // The response should either have errors or redirect and have errors in session
    if ($response->getStatusCode() === 302) {
        $response->assertSessionHasErrors(['image']);
    } else {
        $response->assertStatus(422);
    }
});

test('portfolio supports different image formats', function () {
    $this->actingAs($this->user);
    
    $formats = [
        ['extension' => 'jpg', 'mime' => 'image/jpeg'],
        ['extension' => 'jpeg', 'mime' => 'image/jpeg'],
        ['extension' => 'png', 'mime' => 'image/png'],
        ['extension' => 'gif', 'mime' => 'image/gif'],
    ];
    
    foreach ($formats as $format) {
        $file = UploadedFile::fake()->create("test.{$format['extension']}", 100, $format['mime']);
        
        $response = $this->post(route('dashboard.portfolio.store'), [
            'title' => "Test Portfolio {$format['extension']}",
            'category' => 'web',
            'image' => $file
        ]);

        $response->assertRedirect();
    }
    
    $actualCount = Portfolio::where('user_id', $this->user->id)->count();
    expect($actualCount)->toBe(count($formats));
});

<?php

namespace Database\Factories;

use App\Models\Link;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Link>
 */
class LinkFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $types = ['social', 'portfolio', 'deeplink', 'custom'];
        $type = fake()->randomElement($types);
        $isEmbed = fake()->boolean(30);

        return [
            'user_id' => User::factory(),
            'type' => $type,
            'title' => fake()->sentence(3),
            'url' => fake()->url(),
            'description' => fake()->optional()->paragraph(),
            'icon' => fake()->optional()->imageUrl(50, 50),
            'link_type' => $isEmbed ? 'embed' : 'standard',
            'embed_type' => $isEmbed ? fake()->randomElement(['spotify', 'youtube', 'instagram']) : null,
            'embed_data' => $isEmbed ? $this->generateEmbedData() : null,
            'show_as_embed' => $isEmbed,
            'order' => fake()->numberBetween(1, 10),
            'is_active' => fake()->boolean(90),
            'click_count' => fake()->numberBetween(0, 1000),
        ];
    }

    /**
     * Indicate that the link is a Spotify embed.
     */
    public function spotify(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'social',
            'link_type' => 'embed',
            'embed_type' => 'spotify',
            'url' => 'https://open.spotify.com/track/4cOdK2wGLETKBW3PvgPWqT',
            'embed_data' => json_encode([
                'platform' => 'spotify',
                'type' => 'track',
                'id' => '4cOdK2wGLETKBW3PvgPWqT',
                'url' => 'https://open.spotify.com/track/4cOdK2wGLETKBW3PvgPWqT',
            ]),
            'show_as_embed' => true,
        ]);
    }

    /**
     * Indicate that the link is a YouTube embed.
     */
    public function youtube(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'social',
            'link_type' => 'embed',
            'embed_type' => 'youtube',
            'url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
            'embed_data' => json_encode([
                'platform' => 'youtube',
                'type' => 'video',
                'id' => 'dQw4w9WgXcQ',
                'url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
            ]),
            'show_as_embed' => true,
        ]);
    }

    /**
     * Indicate that the link is an Instagram embed.
     */
    public function instagram(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'social',
            'link_type' => 'embed',
            'embed_type' => 'instagram',
            'url' => 'https://www.instagram.com/p/ABC123/',
            'embed_data' => json_encode([
                'platform' => 'instagram',
                'type' => 'post',
                'id' => 'ABC123',
                'url' => 'https://www.instagram.com/p/ABC123/',
            ]),
            'show_as_embed' => true,
        ]);
    }

    /**
     * Indicate that the link is active.
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => true,
        ]);
    }

    /**
     * Indicate that the link is inactive.
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }

    /**
     * Generate sample embed data.
     */
    private function generateEmbedData(): ?string
    {
        $platforms = ['spotify', 'youtube', 'instagram'];
        $platform = fake()->randomElement($platforms);

        $data = match ($platform) {
            'spotify' => [
                'platform' => 'spotify',
                'type' => 'track',
                'id' => fake()->regexify('[a-zA-Z0-9]{22}'),
                'url' => 'https://open.spotify.com/track/'.fake()->regexify('[a-zA-Z0-9]{22}'),
            ],
            'youtube' => [
                'platform' => 'youtube',
                'type' => 'video',
                'id' => fake()->regexify('[a-zA-Z0-9_-]{11}'),
                'url' => 'https://www.youtube.com/watch?v='.fake()->regexify('[a-zA-Z0-9_-]{11}'),
            ],
            'instagram' => [
                'platform' => 'instagram',
                'type' => 'post',
                'id' => fake()->regexify('[a-zA-Z0-9_-]{11}'),
                'url' => 'https://www.instagram.com/p/'.fake()->regexify('[a-zA-Z0-9_-]{11}').'/',
            ],
        };

        return json_encode($data);
    }
}

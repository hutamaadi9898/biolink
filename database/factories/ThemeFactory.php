<?php

namespace Database\Factories;

use App\Models\Theme;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Theme>
 */
class ThemeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $categories = ['business', 'creative', 'minimal', 'colorful', 'modern', 'classic'];
        
        return [
            'name' => fake()->unique()->words(2, true),
            'slug' => fake()->unique()->slug(),
            'description' => fake()->sentence(),
            'preview_image' => fake()->imageUrl(400, 600, 'themes'),
            'config' => [
                'category' => fake()->randomElement($categories),
                'colors' => [
                    'primary' => fake()->hexColor(),
                    'secondary' => fake()->hexColor(),
                    'background' => fake()->hexColor(),
                    'text' => fake()->hexColor(),
                ],
                'css_vars' => [
                    '--primary-color' => fake()->hexColor(),
                    '--bg-color' => fake()->hexColor(),
                    '--text-color' => fake()->hexColor(),
                ],
            ],
            'is_premium' => fake()->boolean(30),
            'is_active' => true,
            'sort_order' => fake()->numberBetween(1, 100),
        ];
    }

    /**
     * Indicate that the theme is premium.
     */
    public function premium(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_premium' => true,
        ]);
    }

    /**
     * Indicate that the theme is free.
     */
    public function free(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_premium' => false,
        ]);
    }

    /**
     * Indicate that the theme is inactive.
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }

    /**
     * Create a business theme.
     */
    public function business(): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => 'Professional Business',
            'config' => array_merge($attributes['config'] ?? [], [
                'category' => 'business',
                'colors' => [
                    'primary' => '#1e40af',
                    'secondary' => '#6b7280',
                    'background' => '#ffffff',
                    'text' => '#111827',
                ],
            ]),
        ]);
    }

    /**
     * Create a creative theme.
     */
    public function creative(): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => 'Creative Artist',
            'config' => array_merge($attributes['config'] ?? [], [
                'category' => 'creative',
                'colors' => [
                    'primary' => '#7c3aed',
                    'secondary' => '#ec4899',
                    'background' => '#f8fafc',
                    'text' => '#0f172a',
                ],
            ]),
        ]);
    }

    /**
     * Create a minimal theme.
     */
    public function minimal(): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => 'Clean Minimal',
            'config' => array_merge($attributes['config'] ?? [], [
                'category' => 'minimal',
                'colors' => [
                    'primary' => '#000000',
                    'secondary' => '#6b7280',
                    'background' => '#ffffff',
                    'text' => '#000000',
                ],
            ]),
        ]);
    }
}

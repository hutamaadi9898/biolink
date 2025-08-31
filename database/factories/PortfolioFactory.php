<?php

namespace Database\Factories;

use App\Models\Portfolio;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Portfolio>
 */
class PortfolioFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $categories = ['design', 'development', 'photography', 'writing', 'music', 'video', 'art'];
        $technologies = ['HTML', 'CSS', 'JavaScript', 'React', 'Vue', 'Laravel', 'PHP', 'Python', 'Figma', 'Photoshop'];
        
        return [
            'user_id' => User::factory(),
            'title' => fake()->sentence(4),
            'description' => fake()->paragraph(3),
            'image' => fake()->imageUrl(800, 600),
            'link' => fake()->optional()->url(),
            'category' => fake()->randomElement($categories),
            'tags' => json_encode(fake()->randomElements($technologies, fake()->numberBetween(1, 4))),
            'is_featured' => fake()->boolean(20),
            'order' => fake()->numberBetween(1, 10),
            'is_active' => fake()->boolean(90),
            'view_count' => fake()->numberBetween(0, 1000),
            'project_date' => fake()->dateTimeBetween('-2 years', 'now')->format('Y-m-d'),
            'gallery' => json_encode($this->generateGallery()),
        ];
    }

    /**
     * Generate sample gallery images.
     */
    private function generateGallery(): array
    {
        if (fake()->boolean(60)) {
            return [
                fake()->imageUrl(800, 600),
                fake()->imageUrl(800, 600),
                fake()->imageUrl(800, 600),
            ];
        }
        
        return [];
    }

    /**
     * Indicate that this is a featured portfolio item.
     */
    public function featured(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_featured' => true,
            'order' => fake()->numberBetween(1, 3),
        ]);
    }

    /**
     * Indicate that this is a design portfolio item.
     */
    public function design(): static
    {
        return $this->state(fn (array $attributes) => [
            'category' => 'design',
            'title' => 'UI/UX Design for ' . fake()->company(),
            'description' => 'Modern and intuitive user interface design focusing on user experience and accessibility.',
            'tags' => json_encode(['Figma', 'Adobe XD', 'Sketch', 'InVision']),
        ]);
    }

    /**
     * Indicate that this is a development portfolio item.
     */
    public function development(): static
    {
        return $this->state(fn (array $attributes) => [
            'category' => 'development',
            'title' => fake()->randomElement(['E-commerce Platform', 'Mobile App', 'Web Application', 'SaaS Dashboard']),
            'description' => 'Full-stack web application built with modern technologies and best practices.',
            'tags' => json_encode(['Laravel', 'Vue.js', 'TailwindCSS', 'MySQL']),
            'link' => 'https://github.com/' . fake()->userName() . '/' . fake()->slug(),
        ]);
    }

    /**
     * Indicate that this is a photography portfolio item.
     */
    public function photography(): static
    {
        return $this->state(fn (array $attributes) => [
            'category' => 'photography',
            'title' => fake()->randomElement(['Portrait Session', 'Wedding Photography', 'Product Photography', 'Street Photography']),
            'description' => 'Professional photography capturing moments and emotions with artistic vision.',
            'tags' => json_encode(['Canon 5D Mark IV', 'Adobe Lightroom', 'Photoshop']),
            'gallery' => json_encode([
                fake()->imageUrl(800, 600),
                fake()->imageUrl(800, 600),
                fake()->imageUrl(800, 600),
                fake()->imageUrl(800, 600),
            ]),
        ]);
    }

    /**
     * Indicate that this portfolio item is inactive.
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }
}

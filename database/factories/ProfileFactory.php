<?php

namespace Database\Factories;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Profile>
 */
class ProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'slug' => fake()->unique()->slug(),
            'display_name' => fake()->name(),
            'bio' => fake()->paragraph(),
            'tagline' => fake()->sentence(),
            'avatar' => fake()->optional()->imageUrl(200, 200),
            'cover_image' => fake()->optional()->imageUrl(800, 400),
            'location' => fake()->city(),
            'social_links' => json_encode($this->generateSocialLinks()),
            'contact_info' => json_encode([
                'email' => fake()->optional()->safeEmail(),
                'phone' => fake()->optional()->phoneNumber(),
            ]),
            'is_public' => fake()->boolean(90),
            'show_qr_code' => fake()->boolean(70),
            'view_count' => fake()->numberBetween(0, 10000),
            'seo_data' => json_encode([
                'title' => fake()->optional()->sentence(6),
                'description' => fake()->optional()->sentence(12),
                'keywords' => fake()->optional()->words(5, true),
            ]),
        ];
    }

    /**
     * Generate sample social links.
     */
    private function generateSocialLinks(): array
    {
        $links = [];
        
        if (fake()->boolean(70)) {
            $links['instagram'] = 'https://instagram.com/' . fake()->userName();
        }
        
        if (fake()->boolean(60)) {
            $links['tiktok'] = 'https://tiktok.com/@' . fake()->userName();
        }
        
        if (fake()->boolean(50)) {
            $links['youtube'] = 'https://youtube.com/@' . fake()->userName();
        }
        
        if (fake()->boolean(40)) {
            $links['twitter'] = 'https://twitter.com/' . fake()->userName();
        }
        
        if (fake()->boolean(30)) {
            $links['linkedin'] = 'https://linkedin.com/in/' . fake()->userName();
        }
        
        return $links;
    }

    /**
     * Indicate that the profile is for a content creator.
     */
    public function creator(): static
    {
        return $this->state(fn (array $attributes) => [
            'bio' => 'Content creator passionate about sharing knowledge and inspiration. Follow my journey!',
            'social_links' => json_encode([
                'instagram' => 'https://instagram.com/' . fake()->userName(),
                'tiktok' => 'https://tiktok.com/@' . fake()->userName(),
                'youtube' => 'https://youtube.com/@' . fake()->userName(),
            ]),
        ]);
    }

    /**
     * Indicate that the profile is for a business.
     */
    public function business(): static
    {
        return $this->state(fn (array $attributes) => [
            'bio' => 'Professional business profile. Get in touch for collaborations and services.',
            'location' => fake()->city() . ', Indonesia',
            'social_links' => json_encode([
                'linkedin' => 'https://linkedin.com/in/' . fake()->userName(),
                'instagram' => 'https://instagram.com/' . fake()->userName(),
            ]),
        ]);
    }
}

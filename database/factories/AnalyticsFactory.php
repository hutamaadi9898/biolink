<?php

namespace Database\Factories;

use App\Models\Analytics;
use App\Models\User;
use App\Models\Link;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Analytics>
 */
class AnalyticsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $eventTypes = ['profile_view', 'link_click', 'portfolio_view'];
        $deviceTypes = ['mobile', 'desktop', 'tablet'];
        $referrers = ['direct', 'instagram', 'twitter', 'facebook', 'google'];
        
        return [
            'user_id' => User::factory(),
            'event_type' => fake()->randomElement($eventTypes),
            'event_data' => fake()->optional()->url(),
            'ip_address' => fake()->ipv4(),
            'user_agent' => fake()->userAgent(),
            'referrer' => fake()->optional()->randomElement($referrers),
            'country' => fake()->countryCode(),
            'city' => fake()->city(),
            'device_type' => fake()->randomElement($deviceTypes),
            'browser' => fake()->randomElement(['Chrome', 'Firefox', 'Safari', 'Edge']),
            'os' => fake()->randomElement(['Windows', 'macOS', 'Linux', 'iOS', 'Android']),
            'metadata' => json_encode([
                'utm_source' => fake()->optional()->randomElement(['instagram', 'facebook', 'twitter']),
                'utm_medium' => fake()->optional()->randomElement(['social', 'email', 'cpc']),
                'utm_campaign' => fake()->optional()->word(),
            ]),
            'occurred_at' => fake()->dateTimeBetween('-1 month', 'now'),
        ];
    }

    /**
     * Indicate that this is a link click event.
     */
    public function linkClick(): static
    {
        return $this->state(fn (array $attributes) => [
            'event_type' => 'link_click',
        ]);
    }

    /**
     * Indicate that this is a link click event with a specific link.
     */
    public function forLink(Link $link): static
    {
        return $this->state(fn (array $attributes) => [
            'event_type' => 'link_click',
            'user_id' => $link->user_id,
        ]);
    }

    /**
     * Indicate that this is a profile view event.
     */
    public function profileView(): static
    {
        return $this->state(fn (array $attributes) => [
            'event_type' => 'profile_view',
        ]);
    }

    /**
     * Indicate that this is a portfolio view event.
     */
    public function portfolioView(): static
    {
        return $this->state(fn (array $attributes) => [
            'event_type' => 'portfolio_view',
        ]);
    }

    /**
     * Indicate that this is from mobile device.
     */
    public function mobile(): static
    {
        return $this->state(fn (array $attributes) => [
            'device_type' => 'mobile',
            'user_agent' => 'Mozilla/5.0 (iPhone; CPU iPhone OS 15_0 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/15.0 Mobile/15E148 Safari/604.1',
            'os' => 'iOS',
            'browser' => 'Safari',
        ]);
    }

    /**
     * Indicate that this is from desktop device.
     */
    public function desktop(): static
    {
        return $this->state(fn (array $attributes) => [
            'device_type' => 'desktop',
            'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36',
            'os' => 'Windows',
            'browser' => 'Chrome',
        ]);
    }

    /**
     * Indicate that this is from Indonesia.
     */
    public function indonesia(): static
    {
        return $this->state(fn (array $attributes) => [
            'country' => 'ID',
            'city' => fake()->randomElement(['Jakarta', 'Surabaya', 'Bandung', 'Medan', 'Bekasi', 'Tangerang']),
        ]);
    }

    /**
     * Indicate that this came from social media.
     */
    public function fromSocial(): static
    {
        $platforms = ['instagram', 'tiktok', 'twitter', 'facebook'];
        $platform = fake()->randomElement($platforms);
        
        return $this->state(fn (array $attributes) => [
            'referrer' => $platform,
            'metadata' => json_encode([
                'utm_source' => $platform,
                'utm_medium' => 'social',
            ]),
        ]);
    }
}

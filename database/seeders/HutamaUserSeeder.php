<?php

namespace Database\Seeders;

use App\Models\Link;
use App\Models\Portfolio;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class HutamaUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create or find the user
        $user = User::firstOrCreate(
            ['email' => 'hutama@example.com'],
            [
                'name' => 'Hutama Adi Rahardjo',
                'email' => 'hutama@example.com',
                'email_verified_at' => now(),
                'password' => bcrypt('password'),
                'remember_token' => Str::random(10),
                'username' => 'hutama-adi-rahardjo',
                'slug' => 'hutama-adi-rahardjo',
                'role' => 'pro',
                'bio' => 'Full-Stack Developer & Tech Enthusiast',
            ]
        );

        // Create or update profile
        $profile = Profile::updateOrCreate(
            ['user_id' => $user->id],
            [
                'slug' => 'hutama-adi-rahardjo',
                'bio' => '🚀 Full-Stack Developer | Laravel & Vue.js Enthusiast | Building amazing web experiences with modern technologies. Passionate about clean code, user experience, and innovative solutions.',
                'view_count' => rand(1500, 5000),
                'avatar' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=400&h=400&fit=crop&crop=face',
                'display_name' => 'Hutama Adi Rahardjo',
                'tagline' => 'Full-Stack Developer & Tech Enthusiast',
                'location' => 'Jakarta, Indonesia',
                'is_public' => true,
                'show_qr_code' => true,
            ]
        );

        // Create social media links
        $socialLinks = [
            [
                'title' => '📱 Instagram',
                'url' => 'https://instagram.com/hutama.dev',
                'description' => 'Follow my development journey',
                'type' => 'social',
                'order' => 1,
            ],
            [
                'title' => '🐦 Twitter',
                'url' => 'https://twitter.com/hutama_dev',
                'description' => 'Tech thoughts and updates',
                'type' => 'social',
                'order' => 2,
            ],
            [
                'title' => '💼 LinkedIn',
                'url' => 'https://linkedin.com/in/hutama-adi-rahardjo',
                'description' => 'Professional networking',
                'type' => 'social',
                'order' => 3,
            ],
            [
                'title' => '🐙 GitHub',
                'url' => 'https://github.com/hutama-dev',
                'description' => 'Open source projects',
                'type' => 'social',
                'order' => 4,
            ],
            [
                'title' => '🎵 Spotify',
                'url' => 'https://open.spotify.com/user/hutama.dev',
                'description' => 'Coding playlists',
                'type' => 'social',
                'order' => 5,
            ],
            [
                'title' => '🎥 YouTube',
                'url' => 'https://youtube.com/@hutama-dev',
                'description' => 'Development tutorials',
                'type' => 'social',
                'order' => 6,
            ],
        ];

        foreach ($socialLinks as $linkData) {
            Link::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'url' => $linkData['url'],
                ],
                $linkData + ['is_active' => true]
            );
        }

        // Create regular links
        $regularLinks = [
            [
                'title' => '🌐 Portfolio Website',
                'url' => 'https://hutama.dev',
                'description' => 'Check out my latest projects and work',
                'type' => 'portfolio',
                'order' => 10,
            ],
            [
                'title' => '📝 Technical Blog',
                'url' => 'https://blog.hutama.dev',
                'description' => 'Articles about web development and tech',
                'type' => 'custom',
                'order' => 11,
            ],
            [
                'title' => '💻 Laravel Course',
                'url' => 'https://course.hutama.dev/laravel',
                'description' => 'Master Laravel from beginner to advanced',
                'type' => 'custom',
                'order' => 12,
            ],
            [
                'title' => '🛍️ Shop My Setup',
                'url' => 'https://hutama.dev/setup',
                'description' => 'Developer tools and gear I use daily',
                'type' => 'custom',
                'order' => 13,
            ],
            [
                'title' => '☕ Buy Me a Coffee',
                'url' => 'https://buymeacoffee.com/hutama',
                'description' => 'Support my content creation',
                'type' => 'custom',
                'order' => 14,
            ],
        ];

        foreach ($regularLinks as $linkData) {
            Link::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'url' => $linkData['url'],
                ],
                $linkData + ['is_active' => true]
            );
        }

        // Create portfolio items
        $portfolios = [
            [
                'title' => 'E-Commerce Platform',
                'description' => 'A modern e-commerce platform built with Laravel, Vue.js, and Tailwind CSS. Features include real-time inventory, payment processing, and admin dashboard.',
                'link' => 'https://github.com/hutama-dev/ecommerce-platform',
            ],
            [
                'title' => 'Task Management App',
                'description' => 'Collaborative task management application with real-time updates, team features, and project tracking capabilities.',
                'link' => 'https://github.com/hutama-dev/task-manager',
            ],
            [
                'title' => 'API Gateway Service',
                'description' => 'Microservices API gateway with rate limiting, authentication, and request routing. Built for scalable enterprise applications.',
                'link' => 'https://github.com/hutama-dev/api-gateway',
            ],
            [
                'title' => 'Social Media Dashboard',
                'description' => 'Analytics dashboard for social media management with data visualization and automated reporting features.',
                'link' => 'https://github.com/hutama-dev/social-dashboard',
            ],
            [
                'title' => 'Real-time Chat Application',
                'description' => 'WebSocket-powered chat application with file sharing, emoji reactions, and group messaging capabilities.',
                'link' => 'https://github.com/hutama-dev/realtime-chat',
            ],
            [
                'title' => 'AI Content Generator',
                'description' => 'AI-powered content generation tool using OpenAI API with custom templates and workflow automation.',
                'link' => 'https://github.com/hutama-dev/ai-content-gen',
            ],
        ];

        foreach ($portfolios as $portfolioData) {
            Portfolio::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'title' => $portfolioData['title'],
                ],
                $portfolioData
            );
        }

        $this->command->info('✅ Hutama Adi Rahardjo user seeded successfully!');
        $this->command->info('📧 Email: hutama@example.com');
        $this->command->info('🔑 Password: password');
        $this->command->info('🔗 Profile URL: '.route('profile.show', $user->username ?? 'hutama-adi-rahardjo'));
    }
}

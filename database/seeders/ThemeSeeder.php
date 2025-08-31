<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Theme;

class ThemeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $themes = [
            [
                'name' => 'Klasik Minimalis',
                'slug' => 'klasik-minimalis',
                'description' => 'Tema sederhana dan bersih dengan layout klasik',
                'config' => [
                    'colors' => [
                        'primary' => '#000000',
                        'secondary' => '#ffffff',
                        'accent' => '#6366f1',
                        'background' => '#ffffff',
                        'text' => '#000000',
                    ],
                    'fonts' => [
                        'heading' => 'Inter',
                        'body' => 'Inter',
                    ],
                    'layout' => 'centered',
                    'button_style' => 'rounded',
                    'spacing' => 'normal',
                ],
                'is_premium' => false,
                'sort_order' => 1,
            ],
            [
                'name' => 'Neon Jakarta',
                'slug' => 'neon-jakarta',
                'description' => 'Tema modern dengan warna neon yang cocok untuk kreator muda',
                'config' => [
                    'colors' => [
                        'primary' => '#ff0080',
                        'secondary' => '#00ff80',
                        'accent' => '#0080ff',
                        'background' => '#0a0a0a',
                        'text' => '#ffffff',
                    ],
                    'fonts' => [
                        'heading' => 'Poppins',
                        'body' => 'Poppins',
                    ],
                    'layout' => 'centered',
                    'button_style' => 'rounded-full',
                    'spacing' => 'compact',
                ],
                'is_premium' => false,
                'sort_order' => 2,
            ],
            [
                'name' => 'Batik Modern',
                'slug' => 'batik-modern',
                'description' => 'Desain yang memadukan motif tradisional dengan sentuhan modern',
                'config' => [
                    'colors' => [
                        'primary' => '#8B4513',
                        'secondary' => '#D2691E',
                        'accent' => '#CD853F',
                        'background' => '#FFF8DC',
                        'text' => '#2F4F4F',
                    ],
                    'fonts' => [
                        'heading' => 'Playfair Display',
                        'body' => 'Source Sans Pro',
                    ],
                    'layout' => 'centered',
                    'button_style' => 'rounded',
                    'spacing' => 'relaxed',
                    'pattern' => 'batik-subtle',
                ],
                'is_premium' => false,
                'sort_order' => 3,
            ],
            [
                'name' => 'Sunset Bali',
                'slug' => 'sunset-bali',
                'description' => 'Tema premium dengan gradien sunset yang indah',
                'config' => [
                    'colors' => [
                        'primary' => '#ff6b6b',
                        'secondary' => '#ffa726',
                        'accent' => '#ab47bc',
                        'background' => 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)',
                        'text' => '#ffffff',
                    ],
                    'fonts' => [
                        'heading' => 'Montserrat',
                        'body' => 'Open Sans',
                    ],
                    'layout' => 'centered',
                    'button_style' => 'rounded-full',
                    'spacing' => 'normal',
                    'effects' => ['gradient-overlay', 'parallax'],
                ],
                'is_premium' => true,
                'sort_order' => 4,
            ],
            [
                'name' => 'Professional Dark',
                'slug' => 'professional-dark',
                'description' => 'Tema gelap premium untuk profesional dan bisnis',
                'config' => [
                    'colors' => [
                        'primary' => '#1e293b',
                        'secondary' => '#334155',
                        'accent' => '#3b82f6',
                        'background' => '#0f172a',
                        'text' => '#f1f5f9',
                    ],
                    'fonts' => [
                        'heading' => 'Inter',
                        'body' => 'Inter',
                    ],
                    'layout' => 'wide',
                    'button_style' => 'squared',
                    'spacing' => 'relaxed',
                    'effects' => ['blur-backdrop', 'smooth-animations'],
                ],
                'is_premium' => true,
                'sort_order' => 5,
            ],
            [
                'name' => 'Creative Portfolio',
                'slug' => 'creative-portfolio',
                'description' => 'Tema premium khusus untuk showcase portfolio kreatif',
                'config' => [
                    'colors' => [
                        'primary' => '#6366f1',
                        'secondary' => '#8b5cf6',
                        'accent' => '#06b6d4',
                        'background' => '#fafafa',
                        'text' => '#171717',
                    ],
                    'fonts' => [
                        'heading' => 'Space Grotesk',
                        'body' => 'Inter',
                    ],
                    'layout' => 'masonry',
                    'button_style' => 'rounded',
                    'spacing' => 'compact',
                    'effects' => ['hover-animations', 'portfolio-grid'],
                ],
                'is_premium' => true,
                'sort_order' => 6,
            ],
        ];

        foreach ($themes as $theme) {
            Theme::create($theme);
        }
    }
}

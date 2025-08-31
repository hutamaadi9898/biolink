<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            ThemeSeeder::class,
        ]);

        // Create a test user with profile
        $user = User::factory()->create([
            'name' => 'Ahmad Tester',
            'email' => 'test@biolink.test',
            'username' => 'ahmadtester',
            'role' => 'pro',
            'pro_expires_at' => now()->addYear(),
        ]);

        // Create profile for test user
        $user->profile()->create([
            'slug' => 'ahmadtester',
            'display_name' => 'Ahmad Tester',
            'bio' => 'Seorang kreator digital dari Jakarta yang berfokus pada desain UI/UX dan fotografi. Suka berbagi tips dan trik seputar teknologi dan bisnis online.',
            'tagline' => 'Digital Creator & UI/UX Designer',
            'location' => 'Jakarta, Indonesia',
            'social_links' => [
                'instagram' => 'https://instagram.com/ahmadtester',
                'tiktok' => 'https://tiktok.com/@ahmadtester',
                'youtube' => 'https://youtube.com/ahmadtester',
            ],
            'contact_info' => [
                'email' => 'ahmad@example.com',
                'whatsapp' => '+6281234567890',
            ],
            'seo_data' => [
                'title' => 'Ahmad Tester - Digital Creator',
                'description' => 'Portfolio dan link sosial media Ahmad Tester, kreator digital dari Jakarta',
                'keywords' => 'digital creator, ui ux designer, jakarta, indonesia',
            ],
        ]);

        // Create some sample links
        $user->links()->createMany([
            [
                'type' => 'social',
                'title' => 'Instagram',
                'url' => 'https://instagram.com/ahmadtester',
                'icon' => 'fab fa-instagram',
                'color' => '#E4405F',
                'order' => 1,
            ],
            [
                'type' => 'social',
                'title' => 'TikTok',
                'url' => 'https://tiktok.com/@ahmadtester',
                'icon' => 'fab fa-tiktok',
                'color' => '#000000',
                'order' => 2,
            ],
            [
                'type' => 'deeplink',
                'title' => 'Toko Shopee Saya',
                'url' => 'https://shopee.co.id/ahmadtester',
                'icon' => 'fas fa-shopping-bag',
                'color' => '#ee4d2d',
                'order' => 3,
            ],
            [
                'type' => 'deeplink',
                'title' => 'Chat WhatsApp',
                'url' => 'https://wa.me/6281234567890',
                'icon' => 'fab fa-whatsapp',
                'color' => '#25D366',
                'order' => 4,
            ],
            [
                'type' => 'custom',
                'title' => 'Portfolio Website',
                'url' => 'https://ahmadtester.com',
                'icon' => 'fas fa-globe',
                'color' => '#6366f1',
                'order' => 5,
            ],
        ]);

        // Create sample portfolio items
        $user->portfolios()->createMany([
            [
                'title' => 'Redesign Aplikasi Mobile Banking',
                'description' => 'Proyek redesign UI/UX untuk aplikasi mobile banking dengan fokus pada kemudahan penggunaan dan keamanan.',
                'category' => 'UI/UX Design',
                'tags' => ['mobile', 'banking', 'ui', 'ux', 'figma'],
                'is_featured' => true,
                'project_date' => now()->subMonths(2),
                'order' => 1,
            ],
            [
                'title' => 'Campaign Fotografi Produk',
                'description' => 'Sesi fotografi produk untuk brand fashion lokal dengan konsep minimalis dan modern.',
                'category' => 'Photography',
                'tags' => ['photography', 'fashion', 'product', 'commercial'],
                'is_featured' => true,
                'project_date' => now()->subMonth(),
                'order' => 2,
            ],
            [
                'title' => 'Website E-commerce',
                'description' => 'Pengembangan website e-commerce lengkap dengan sistem pembayaran dan manajemen inventory.',
                'category' => 'Web Development',
                'tags' => ['web', 'ecommerce', 'laravel', 'vue'],
                'project_date' => now()->subWeeks(2),
                'order' => 3,
            ],
        ]);
    }
}

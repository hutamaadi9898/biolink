# Biolink ID - Indonesian SaaS Biolink Platform

## 🚀 Platform Overview

Biolink ID adalah platform SaaS yang ditargetkan untuk pasar Indonesia, mirip dengan Bento.me, dirancang khusus untuk **influencer dan freelancer** untuk menampilkan portfolio, link sosial media, dan deep link e-commerce (Shopee, Tokopedia, WhatsApp).

## ✨ Key Features

- **🎨 Modern Profile Pages**: Mobile-first Bento grid layout dengan portfolio showcase
- **🔗 Smart Link Management**: Auto-detect embeddable content (YouTube, social media)
- **📊 Real-time Analytics**: Track profile views, link clicks, dan device statistics
- **🎭 Customizable Themes**: Dynamic theme system dengan live preview
- **📱 Mobile-First Design**: Responsive design optimized untuk mobile users
- **🌟 Social Media Integration**: Auto-detection dan embed untuk major platforms
- **� Portfolio Showcase**: Flexible Bento grid layout dengan image uploads
- **🔍 SEO Optimized**: Meta tags dan structured data untuk better discovery

## �🛠 Tech Stack

- **Backend**: Laravel 12 dengan PHP 8.4
- **Frontend**: Inertia.js v2 + Vue 3 + TypeScript
- **Styling**: TailwindCSS v4
- **Database**: SQLite (development) / PostgreSQL (production)
- **Cache/Queue**: Redis dengan batch processing
- **Analytics**: Custom real-time tracking system
- **Testing**: Pest v4 dengan browser testing support
- **Build**: Vite dengan Laravel plugin

## 📊 Database Schema

### Core Tables

1. **users** - User authentication dan role management (free/pro)
2. **profiles** - Public profile data dengan slug unik
3. **links** - Sistem link dengan auto-formatting untuk platform Indonesia
4. **portfolios** - Portfolio items dengan media support
5. **themes** - Tema dengan konfigurasi JSON
6. **user_themes** - Relasi user dan tema dengan kustomisasi
7. **analytics** - Tracking events (profile views, link clicks, portfolio views)

## 🎨 Features Implemented

### 1. User Authentication & Roles

- Email/password authentication
- Role system: `free` dan `pro`
- Expiry date untuk subscription pro
- Support untuk social login (prepared)

### 2. Profile Management

- Public profile dengan slug custom
- Avatar, bio, tagline, lokasi
- SEO metadata
- QR Code generator
- View counter

### 3. Links System

- Berbagai tipe link: social, portfolio, deeplink, custom
- Auto-formatting untuk platform Indonesia:
    - WhatsApp: Konversi ke format `wa.me/62xxxx`
    - Shopee: Auto-direct ke `shopee.co.id`
    - Tokopedia: Link formatting
- Click tracking dan statistik
- Drag & drop ordering
- Custom icons dan warna

### 4. Portfolio Showcase

- Upload images dan gallery
- Kategorisasi dan tags
- Featured portfolio items
- View tracking
- Project links

### 5. Theme System

- 6 tema default (3 gratis, 3 premium)
- Tema Indonesia-specific:
    - "Klasik Minimalis"
    - "Neon Jakarta"
    - "Batik Modern"
    - "Sunset Bali" (Premium)
    - "Professional Dark" (Premium)
    - "Creative Portfolio" (Premium)
- JSON-based configuration
- Custom colors, fonts, layouts
- Pro user customization

### 6. Analytics & Tracking

- Redis-based event tracking untuk performance
- Batch processing ke PostgreSQL
- Metrics: profile views, link clicks, portfolio views
- Geographic dan device analytics
- Referrer tracking

## 🌐 Frontend Components

### Public Profile (`/resources/js/pages/Profile/Show.vue`)

- Responsive design
- Theme-aware styling
- Interactive portfolio modal
- QR code display
- Analytics tracking

### Dashboard (`/resources/js/pages/Dashboard/Index.vue`)

- Statistics overview
- Quick action cards
- Analytics summary
- Pro user indicators

## 🚦 API Routes

### Public Routes

- `GET /{slug}` - Public profile display
- `GET /link/redirect/{linkId}` - Link redirection dengan tracking
- `POST /portfolio/track/{portfolioId}` - Portfolio view tracking
- `GET /qr/{slug}` - QR code generation

### Protected Routes (Dashboard)

- `/dashboard` - Main dashboard
- `/dashboard/profile` - Profile settings
- `/dashboard/links` - Link management
- `/dashboard/portfolio` - Portfolio management
- `/dashboard/themes` - Theme selection
- `/dashboard/analytics` - Analytics dashboard

## 🔧 Configuration

### Environment Variables

```env
APP_NAME="Biolink ID"
APP_LOCALE=id
CACHE_STORE=redis
QUEUE_CONNECTION=redis
```

### Indonesian Localization

- Middleware `SetLocale` untuk auto-detection bahasa Indonesia
- Default locale: `id` (Indonesian)
- Fallback: `en` (English)

## 🎯 Indonesia-Specific Features

1. **WhatsApp Integration**: Auto-format nomor Indonesia (+62)
2. **E-commerce Deep Links**: Support Shopee dan Tokopedia
3. **Local Themes**: Tema dengan sentuhan budaya Indonesia
4. **Indonesian Language**: UI dalam Bahasa Indonesia
5. **Local Analytics**: Tracking yang fokus pada market Indonesia

## 🚀 Getting Started

### 1. Setup Database

```bash
php artisan migrate
php artisan db:seed
```

### 2. Start Services

```bash
# Start Laravel development server
php artisan serve

# Start Redis (for caching & analytics)
# Make sure Redis is running on localhost:6379

# Process analytics queue (in production, use cron)
php artisan analytics:process-batch
```

### 3. Test Data

Seeder menciptakan:

- User test: `test@biolink.test` / `password`
- Username: `ahmadtester`
- Profile URL: `http://biolink.test/ahmadtester`
- Sample links dan portfolio

## 📈 Next Steps

1. **Authentication Pages**: Login/register forms
2. **File Upload**: Image handling untuk avatar dan portfolio
3. **Payment Integration**: Subscription system untuk Pro features
4. **Social Login**: Google, TikTok, Instagram OAuth
5. **Analytics Dashboard**: Detailed charts dan insights
6. **Theme Customizer**: Visual theme editor untuk Pro users
7. **Mobile App**: React Native companion app
8. **API**: RESTful API untuk third-party integrations

## 🎨 Design Principles

- **Mobile-First**: Optimized untuk penggunaan mobile
- **Indonesia-Centric**: Fitur dan design yang sesuai dengan pasar Indonesia
- **Performance**: Redis caching dan batch processing untuk scalability
- **User Experience**: Interface yang familiar untuk pengguna Indonesia
- **Monetization**: Clear separation antara free dan pro features

## 🔒 Security Features

- CSRF protection
- SQL injection prevention
- XSS protection via Vue.js
- Rate limiting (to be implemented)
- Input validation dan sanitization

---

Platform ini siap untuk development lebih lanjut dan deployment. Structure sudah solid untuk scaling dan menambah fitur-fitur advanced sesuai kebutuhan market Indonesia.

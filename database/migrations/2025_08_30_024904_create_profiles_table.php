<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('slug')->unique(); // biolink.test/username or custom slug
            $table->string('display_name');
            $table->text('bio')->nullable();
            $table->string('tagline')->nullable();
            $table->string('avatar')->nullable();
            $table->string('cover_image')->nullable();
            $table->string('location')->nullable();
            $table->json('social_links')->nullable(); // Instagram, TikTok, etc.
            $table->json('contact_info')->nullable(); // Phone, email for public display
            $table->boolean('is_public')->default(true);
            $table->boolean('show_qr_code')->default(true);
            $table->integer('view_count')->default(0);
            $table->json('seo_data')->nullable(); // meta title, description, keywords
            $table->timestamps();

            $table->index(['slug', 'is_public']);
            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};

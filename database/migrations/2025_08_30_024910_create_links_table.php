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
        Schema::create('links', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('type', ['social', 'portfolio', 'deeplink', 'custom'])->default('custom');
            $table->string('title');
            $table->text('url');
            $table->text('description')->nullable();
            $table->string('icon')->nullable(); // Font Awesome icon or image path
            $table->string('color')->nullable(); // Custom color for the link
            $table->integer('order')->default(0);
            $table->integer('click_count')->default(0);
            $table->boolean('is_active')->default(true);
            $table->json('metadata')->nullable(); // Auto-detected info about the link
            $table->timestamp('last_clicked_at')->nullable();
            $table->timestamps();
            
            $table->index(['user_id', 'is_active', 'order']);
            $table->index(['type', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('links');
    }
};

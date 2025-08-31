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
        Schema::create('portfolios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('image')->nullable(); // Main portfolio image
            $table->text('link')->nullable(); // External link to project
            $table->json('gallery')->nullable(); // Additional images
            $table->string('category')->nullable(); // e.g., "Web Design", "Photography"
            $table->json('tags')->nullable(); // Skills/tech used
            $table->integer('order')->default(0);
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->integer('view_count')->default(0);
            $table->date('project_date')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'is_active', 'order']);
            $table->index(['user_id', 'is_featured']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('portfolios');
    }
};

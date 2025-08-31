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
        Schema::table('links', function (Blueprint $table) {
            $table->enum('link_type', ['standard', 'embed'])->default('standard')->after('url');
            $table->enum('embed_type', ['spotify', 'youtube', 'instagram', 'tiktok'])->nullable()->after('link_type');
            $table->json('embed_data')->nullable()->after('embed_type');
            $table->boolean('show_as_embed')->default(false)->after('embed_data');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('links', function (Blueprint $table) {
            $table->dropColumn(['link_type', 'embed_type', 'embed_data', 'show_as_embed']);
        });
    }
};

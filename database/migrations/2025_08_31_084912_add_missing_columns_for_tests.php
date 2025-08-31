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
        // Add link_id column to analytics table
        Schema::table('analytics', function (Blueprint $table) {
            $table->unsignedBigInteger('link_id')->nullable()->after('user_id');
            $table->foreign('link_id')->references('id')->on('links')->onDelete('cascade');
            $table->index('link_id');
        });

        // Add clicks column to links table
        Schema::table('links', function (Blueprint $table) {
            $table->unsignedInteger('clicks')->default(0)->after('click_count');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('analytics', function (Blueprint $table) {
            $table->dropForeign(['link_id']);
            $table->dropColumn('link_id');
        });

        Schema::table('links', function (Blueprint $table) {
            $table->dropColumn('clicks');
        });
    }
};

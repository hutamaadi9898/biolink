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
        Schema::table('users', function (Blueprint $table) {
            $table->string('username')->unique()->nullable()->after('name');
            $table->enum('role', ['free', 'pro'])->default('free')->after('email_verified_at');
            $table->timestamp('pro_expires_at')->nullable()->after('role');
            $table->string('provider')->nullable()->after('pro_expires_at'); // google, tiktok, instagram
            $table->string('provider_id')->nullable()->after('provider');
            $table->json('provider_data')->nullable()->after('provider_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'username',
                'role',
                'pro_expires_at',
                'provider',
                'provider_id',
                'provider_data',
            ]);
        });
    }
};

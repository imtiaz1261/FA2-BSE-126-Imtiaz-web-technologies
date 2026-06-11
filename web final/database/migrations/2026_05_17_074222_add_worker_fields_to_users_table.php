<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('user')->after('password');
            $table->string('category')->nullable()->after('role');
            $table->integer('experience')->nullable()->after('category');
            $table->decimal('hourly_rate', 8, 2)->nullable()->after('experience');
            $table->text('address')->nullable()->after('hourly_rate');
            $table->decimal('lat', 10, 7)->nullable()->after('address');
            $table->decimal('lng', 10, 7)->nullable()->after('lat');
            $table->decimal('rating', 2, 1)->default(4.5)->after('lng');
            $table->text('bio')->nullable()->after('rating');
            $table->json('portfolio')->nullable()->after('bio');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'role',
                'category',
                'experience',
                'hourly_rate',
                'address',
                'lat',
                'lng',
                'rating',
                'bio',
                'portfolio',
            ]);
        });
    }
};

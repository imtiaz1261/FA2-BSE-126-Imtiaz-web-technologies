<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_available')->default(true)->after('portfolio');
            $table->unsignedInteger('total_jobs')->default(0)->after('is_available');
            $table->decimal('total_earnings', 12, 2)->default(0)->after('total_jobs');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['is_available', 'total_jobs', 'total_earnings']);
        });
    }
};

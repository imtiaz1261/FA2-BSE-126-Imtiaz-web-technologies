<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->string('customer_lat')->nullable()->after('customer_address');
            $table->string('customer_lng')->nullable()->after('customer_lat');
            $table->string('customer_formatted_address')->nullable()->after('customer_lng');
            $table->text('rejection_reason')->nullable()->after('status');
            $table->timestamp('accepted_at')->nullable()->after('rejection_reason');
            $table->timestamp('completed_at')->nullable()->after('accepted_at');
            $table->timestamp('rejected_at')->nullable()->after('completed_at');
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn([
                'customer_lat',
                'customer_lng',
                'customer_formatted_address',
                'rejection_reason',
                'accepted_at',
                'completed_at',
                'rejected_at',
            ]);
        });
    }
};

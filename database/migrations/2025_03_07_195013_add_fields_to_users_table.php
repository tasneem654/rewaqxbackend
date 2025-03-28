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
            $table->integer('points')->nullable()->default(0); // Points (integer, nullable, default 0)
            $table->timestamp('otp_expiration')->nullable(); // OTP expiration (timestamp, nullable)
            $table->boolean('isManager')->default(false); // isManager (boolean, default false)
            $table->string('otp', 6)->nullable(); // OTP (string, max length 6, nullable)
            $table->boolean('isAuthenticated')->default(false); // isAuthenticated (boolean, default false)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'points',
                'otp_expiration',
                'isManager',
                'otp',
                'isAuthenticated',
            ]);
        });
    }
};

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
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id('voucherid');
            $table->string('logo')->nullable(); // Stores the path to the image
            $table->string('title');
            $table->decimal('amount', 10, 2); // Assuming amount is monetary value
            $table->integer('point_cost');
            $table->string('voucher_code')->unique(); // Added voucher code column with unique constraint
            $table->boolean('is_available')->default(true);
            $table->timestamps(); // Adds created_at and updated_at columns
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vouchers');
    }
};
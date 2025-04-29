<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('stress_logs', function (Blueprint $table) {
            // Add primary key first
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->integer('heart_rate')->nullable();
            $table->integer('hrv')->nullable();
            $table->boolean('is_exercising')->default(false);
            $table->boolean('is_stressed')->default(false);
            $table->float('stress_score')->nullable();
            $table->smallInteger('hour_of_day')->nullable();
            $table->boolean('was_correct')->nullable();
            $table->json('context_data')->nullable();
            $table->timestamps();
        });
    }

    
    
    public function down()
    {
        Schema::dropIfExists('stress_logs');
    }
};

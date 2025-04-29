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
        Schema::create('user_health_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->integer('resting_hr_threshold')->default(100);
            $table->integer('exercising_hr_threshold')->default(130);
            $table->integer('hrv_threshold')->default(50);
            $table->integer('hr_min')->default(60);
            $table->integer('hr_max')->default(100);
            $table->integer('exercising_hr_max')->default(180);
            $table->integer('hrv_min')->default(20);
            $table->integer('hrv_max')->default(100);
            $table->float('stress_threshold')->default(0.65);
            $table->timestamps();
        });
    }
};

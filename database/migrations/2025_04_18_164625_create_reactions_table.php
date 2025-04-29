<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reactions', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('post_id');
            $table->string('emoji');
            $table->integer('points');
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');
        });

        // Composite primary key (done via raw SQL for PostgreSQL)
        DB::statement('ALTER TABLE reactions ADD PRIMARY KEY (user_id, post_id, emoji)');
    }

    public function down(): void
    {
        Schema::dropIfExists('reactions');
    }
};


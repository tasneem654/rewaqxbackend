<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveCommentsFromPostsTable extends Migration
{
    public function up()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn('comments');
        });
    }

    public function down()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->text('comments')->nullable();
        });
    }
}
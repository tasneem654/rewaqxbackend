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
        // No need to drop anything since we're removing the duplicate creation
        // This migration is now just a placeholder to update the migration history
    }
    
    public function down()
    {
        // Nothing needed here either
    }
};

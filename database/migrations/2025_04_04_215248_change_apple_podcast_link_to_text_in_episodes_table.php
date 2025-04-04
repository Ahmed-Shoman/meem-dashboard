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
        Schema::table('episodes', function (Blueprint $table) {
            // Change string to text
            $table->text('apple_podcast_link')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('episodes', function (Blueprint $table) {
            // Revert text back to string (255 length)
            $table->string('apple_podcast_link')->nullable()->change();
        });
    }
};

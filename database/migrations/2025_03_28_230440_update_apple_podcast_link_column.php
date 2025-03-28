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
        Schema::table('audio_library', function (Blueprint $table) {
            $table->text('apple_podcast_link')->change(); // Change to TEXT for longer URLs
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('audio_library', function (Blueprint $table) {
            $table->string('apple_podcast_link', 500)->change(); // Revert back to VARCHAR(500)
        });
    }
};

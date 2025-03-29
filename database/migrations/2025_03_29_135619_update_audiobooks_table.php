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
        Schema::table('audiobooks', function (Blueprint $table) {
            // Remove the old columns
            $table->dropColumn(['audio', 'audio_duration']);

            // Add new columns
            $table->string('presenter_image')->nullable()->after('presenter');
            $table->string('instagram')->nullable()->after('presenter_image');
            $table->string('snapchat')->nullable()->after('instagram');
            $table->string('x')->nullable()->after('snapchat'); // Twitter (X)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('audiobooks', function (Blueprint $table) {
            // Restore dropped columns
            $table->string('audio')->nullable();
            $table->string('audio_duration')->nullable();

            // Drop newly added columns
            $table->dropColumn(['presenter_image', 'instagram', 'snapchat', 'x']);
        });
    }
};

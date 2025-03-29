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
        Schema::table('audiobook_episodes', function (Blueprint $table) {
            $table->integer('episode_number')->after('audiobook_id');
            $table->string('guest_name')->nullable()->after('episode_number');
            $table->string('youtube_link')->nullable()->after('guest_name');
            $table->string('apple_podcast_link')->nullable()->after('youtube_link');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('audiobook_episodes', function (Blueprint $table) {
            $table->dropColumn(['episode_number', 'guest_name', 'youtube_link', 'apple_podcast_link']);
        });
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('audiobook_episodes', function (Blueprint $table) {
            $table->id();
            $table->integer('episode_number');
            $table->string('guest_name')->nullable();
            $table->string('youtube_link')->nullable();
            $table->string('apple_podcast_link')->nullable();
            $table->string('cover_image')->nullable();
            $table->string('audio_file');
            $table->string('audio_duration');
            $table->string('category');
            $table->text('description')->nullable();
            $table->text('short_description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('audiobook_episodes');
    }
};
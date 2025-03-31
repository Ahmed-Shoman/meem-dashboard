<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('audio_library', function (Blueprint $table) {
            $table->id();
            $table->foreignId('program_id')->constrained()->onDelete('cascade');
            $table->integer('episode_number')->nullable();
            $table->string('guest_name')->nullable();
            $table->string('youtube_link')->nullable();
            $table->text('apple_podcast_link')->nullable();
            $table->string('image');
            $table->string('sound');
            $table->string('sound_time');
            $table->string('category');
            $table->text('description')->nullable();
            $table->text('sub_description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('audio_library');
    }
};

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

            // Add a foreign key column to reference the audiobooks table
            $table->unsignedBigInteger('audiobook_id');

            // Foreign key constraint for linking episodes to audiobooks
            $table->foreign('audiobook_id')->references('id')->on('audiobooks')->onDelete('cascade');
        });
    }

    public function down()
    {
        // Drop the foreign key and the column first
        Schema::table('audiobook_episodes', function (Blueprint $table) {
            $table->dropForeign(['audiobook_id']);
            $table->dropColumn('audiobook_id');
        });

        // Drop the table
        Schema::dropIfExists('audiobook_episodes');
    }
};


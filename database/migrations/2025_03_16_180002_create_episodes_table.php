<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('episodes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('program_id');
            $table->string('episode_type')->nullable();
            $table->integer('episode_number')->nullable();
            $table->string('guest_name')->nullable();
            $table->string('youtube_link')->nullable();
            $table->string('apple_podcast_link')->nullable();
            $table->string('cover_image')->nullable();
            $table->string('audio_file')->nullable();
            $table->string('audio_duration')->nullable();
            $table->string('category')->nullable();
            $table->text('description')->nullable();
            $table->text('short_description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index('user_id');
            $table->index('program_id');

            // Foreign key relationships
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('program_id')
                ->references('id')
                ->on('programs')
                ->onDelete('cascade')
                ->onUpdate('cascade');

        });
    }

    public function down()
    {
        Schema::dropIfExists('episodes');
    }
};

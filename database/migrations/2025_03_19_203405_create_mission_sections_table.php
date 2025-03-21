<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('mission_sections', function (Blueprint $table) {
            $table->id();
            $table->string('main_title');
            $table->text('description')->nullable();
            $table->json('points')->nullable();
            $table->string('title2');
            $table->string('description2')->nullable();
            $table->string('story_text')->nullable();
            $table->string('title3');
            $table->string('description3')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('mission_sections');
    }
};

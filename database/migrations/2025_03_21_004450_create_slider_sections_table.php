<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('slider_sections', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->text('description')->nullable();
            $table->string('image')->nullable(); // Main image
            $table->json('slider_images')->nullable(); // Multiple images
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('slider_sections');
    }
};


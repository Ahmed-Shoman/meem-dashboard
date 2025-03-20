<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('partnerships', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Main Title
            $table->text('description')->nullable(); // Description
            $table->string('cta_button_text')->nullable(); // Call-to-Action Button Text
            $table->json('images')->nullable(); // Store multiple images as JSON
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('partnerships');
    }
};
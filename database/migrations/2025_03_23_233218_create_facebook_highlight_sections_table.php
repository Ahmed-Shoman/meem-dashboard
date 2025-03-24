<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('facebook_highlight_sections', function (Blueprint $table) {
            $table->id();
            $table->string('image')->nullable();           // Path to image
            $table->text('description')->nullable();       // Main text (bold)
            $table->text('sub_description')->nullable();   // Paragraph text
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('facebook_highlight_sections');
    }
};
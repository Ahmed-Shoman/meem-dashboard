<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('newsletter_sections', function (Blueprint $table) {
            $table->id();
            $table->string('main_title');
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->string('cta_button_text')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('newsletter_sections');
    }
};
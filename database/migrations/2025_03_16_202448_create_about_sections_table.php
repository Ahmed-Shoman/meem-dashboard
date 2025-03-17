<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('about_sections', function (Blueprint $table) {
            $table->id();
            $table->string('title')->default('من نحن');
            $table->text('description')->nullable();
            $table->string('background_media')->nullable();
            $table->string('title2');
            $table->string('sub_title2');
            $table->text('sub_description2')->nullable();
            $table->string('cta_text')->default('استكشاف المزيد');
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('about_sections');
    }
};

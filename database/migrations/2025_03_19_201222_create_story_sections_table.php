<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('story_sections', function (Blueprint $table) {
            $table->id();
            $table->string('title')->default('قصة ميم'); // العنوان
            $table->text('description')->nullable(); // الوصف
            $table->string('image')->nullable(); // الصورة
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('story_sections');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('audio_library', function (Blueprint $table) {
            $table->id();
            $table->string('image'); // صورة الغلاف
            $table->string('sound'); // ملف الصوت
            $table->string('sound_time'); // مدة الصوت
            $table->string('category'); // التصنيف
            $table->text('description')->nullable(); // الوصف
            $table->text('sub_description')->nullable(); // الوصف الفرعي
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('audio_library');
    }
};
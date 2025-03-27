<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('audio_library', function (Blueprint $table) {
            $table->id();
            $table->foreignId('program_id')->constrained('programs')->onDelete('cascade'); // إضافة العلاقة
            $table->string('image'); // صورة الغلاف
            $table->string('sound'); // ملف الصوت
            $table->string('sound_time'); // مدة الصوت
            $table->string('category'); // التصنيف
            $table->text('description')->nullable(); // الوصف
            $table->text('sub_description')->nullable(); // الوصف الفرعي
            $table->boolean('is_active')->nullable()->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('audio_library');
    }
};

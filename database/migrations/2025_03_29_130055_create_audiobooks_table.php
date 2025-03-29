<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // إنشاء جدول الكتب الصوتية
        Schema::create('audiobooks', function (Blueprint $table) {
            $table->id();
            $table->string('presenter'); // اسم المقدم (الراوي)
            $table->string('image')->nullable(); // صورة الكتاب الصوتي
            $table->integer('seasons')->default(1); // عدد المواسم
            $table->integer('episodes')->default(1); // عدد الحلقات
            $table->string('program_name'); // اسم البرنامج الصوتي
            $table->string('audio'); // رابط الملف الصوتي
            $table->string('audio_duration'); // مدة الكتاب الصوتي
            $table->boolean('is_active')->default(true); // حالة الكتاب الصوتي (نشط أو غير نشط)
            $table->text('description')->nullable(); // وصف الكتاب الصوتي
            $table->timestamps(); // الطوابع الزمنية
        });
    }

    public function down()
    {
        Schema::dropIfExists('audiobooks');
    }
};
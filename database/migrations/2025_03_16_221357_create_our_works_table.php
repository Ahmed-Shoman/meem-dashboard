<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('our_works', function (Blueprint $table) {
            $table->id();

            // العنوان الرئيسي
            $table->string('main_title');

            // العنوان الفرعي
            $table->string('subtitle')->nullable(); // تم تغيير الاسم ليكون أكثر اختصارًا ووضوحًا

            // نص الزر
          //  $table->string('cta_button_text')->nullable(); // CTA تعني Call To Action

            // شريط العملاء (شعارات الشركات)
            $table->json('client_logos')->nullable(); // تخزين اللوجوهات كـ JSON

            // نص توضيحي
            $table->text('description_text')->nullable(); // تم تحسين التسمية لتكون أكثر وضوحًا

            // إحصائيات عدد المستمعين
            $table->string('listeners_stat')->nullable(); // إحصائية عدد المستمعين
            $table->string('listeners_stat_description')->nullable(); // نص فرعي يوضح الإحصائية

            // إحصائيات عدد الحلقات
            $table->string('episodes_stat')->nullable(); // إحصائية عدد الحلقات
            $table->string('episodes_stat_description')->nullable(); // نص فرعي يوضح الإحصائية

            // عدد البرامج
            $table->string('programs_stat')->nullable(); // إحصائية عدد البرامج
            $table->string('programs_stat_description')->nullable();

            $table->string('banner_text')->nullable();


            // قائمة البرامج
            $table->json('program_list')->nullable(); // تم تغيير الاسم ليكون أكثر وضوحًا

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('our_works');
    }
};
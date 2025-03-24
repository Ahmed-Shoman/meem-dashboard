<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('partners', function (Blueprint $table) {
            $table->id();
            $table->string('title')->default('شركاؤنا'); // عنوان القسم
            $table->text('description')->nullable(); // الوصف
            $table->json('logos')->nullable(); // تخزين الشعارات كـ JSON
            $table->string('cta_text')->nullable(); // نص الزر
           // $table->string('cta_link')->nullable(); // رابط الزر
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('partners');
    }
};

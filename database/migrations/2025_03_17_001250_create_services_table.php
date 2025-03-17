<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // عنوان الخدمة
            $table->string('button_title');
            $table->string('service_name');
            $table->text('description')->nullable(); // وصف الخدمة
            $table->timestamps();
        });

        Schema::create('studio_bookings', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description1')->nullable();
            $table->text('description2')->nullable();
            $table->json('studio_images')->nullable();
            $table->json('equipment_list')->nullable();
            $table->string('cta_button_text')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('services');
        Schema::dropIfExists('studio_bookings');
    }
};

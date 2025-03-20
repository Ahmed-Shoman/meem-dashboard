<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('consultants', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // اسم المستشار
            $table->text('bio')->nullable(); // نبذة عن المستشار
            $table->string('image')->nullable(); // صورة المستشار
            $table->string('linkedin')->nullable(); // رابط لينكدإن
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('consultants');
    }
};
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('meem_originals', function (Blueprint $table) {
            $table->id();
            $table->string('main_title');
            $table->string('subtitle')->nullable();
            $table->text('description')->nullable();
            $table->date('date')->nullable();
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('meem_originals');
    }
};

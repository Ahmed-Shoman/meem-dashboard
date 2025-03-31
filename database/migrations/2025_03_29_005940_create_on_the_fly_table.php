<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up()
    {
        Schema::create('on_the_fly', function (Blueprint $table) {
            $table->id();
            $table->string('presenter');
            $table->string('presenter_image')->nullable();
            $table->string('image');
            $table->integer('seasons')->default(1);
            $table->integer('episodes')->default(1);
            $table->text('program_name');
            $table->boolean('is_active')->default(true);
            $table->text('program_description')->nullable();
            $table->string('instagram')->nullable();
            $table->string('snapchat')->nullable();
            $table->string('x')->nullable();
            $table->timestamps();
        });

        DB::statement("ALTER TABLE on_the_fly AUTO_INCREMENT = 1001;");
    }

    public function down()
    {
        Schema::dropIfExists('on_the_fly');
    }
};

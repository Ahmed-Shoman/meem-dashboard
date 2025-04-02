<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->string('program_name');
            $table->boolean('is_active')->default(true);
            $table->text('program_description')->nullable();
            $table->string('instagram')->nullable();
            $table->string('snapchat')->nullable();
            $table->string('x')->nullable();
            $table->string('type')->default('onthefly');
            $table->timestamps();

            // Indexes for performance optimization
            $table->index('program_name');
            $table->index('is_active');
        });
    }

    public function down()
    {
        Schema::dropIfExists('on_the_fly');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('programs', function (Blueprint $table) {
            $table->id();
            $table->string('program_name');
            $table->string('presenter');
            $table->string('presenter_image')->nullable();
            $table->string('image');
            $table->integer('seasons')->default(1);
            $table->integer('episodes')->default(1);
            $table->boolean('is_active')->default(true);
            $table->string('type')->default('programs');
            $table->text('program_description')->nullable();
            $table->string('instagram')->nullable();
            $table->string('snapchat')->nullable();
            $table->string('x')->nullable();
            $table->timestamps();

            // Indexes for performance
            $table->index('program_name');
            $table->index('is_active');
        });
    }

    public function down()
    {
        Schema::dropIfExists('programs');
    }
};

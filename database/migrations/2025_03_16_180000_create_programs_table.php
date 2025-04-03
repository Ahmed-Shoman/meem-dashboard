<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('programs', function (Blueprint $table) {
            $table->id();
            $table->string('program_name')->nullable();
            $table->string('presenter')->nullable();
            $table->string('presenter_image')->nullable();
            $table->string('image')->nullable();
            $table->integer('seasons')->nullable();
            $table->integer('episodes')->nullable();
            $table->boolean('is_active')->default(true);
            $table->string('type')->nullable();
            $table->text('description')->nullable();
            $table->string('instagram')->nullable();
            $table->string('snapchat')->nullable();
            $table->string('x')->nullable();
            $table->timestamps();

            // Indexes for performance optimization
            $table->index('program_name');
            $table->index('is_active');
        });
    }

    public function down()
    {
        Schema::dropIfExists('programs');
    }
};

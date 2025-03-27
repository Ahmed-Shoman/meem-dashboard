<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('news', function (Blueprint $table) {
    $table->id();
    $table->string('main_title');
    $table->string('subtitle')->nullable();
    $table->text('description')->nullable();
    $table->date('date')->nullable();
    $table->string('image')->nullable();
    $table->enum('category',['news','originals'])->nullable();

    $table->timestamps();
});


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news');
    }
};
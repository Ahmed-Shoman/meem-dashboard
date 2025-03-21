<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('new_programs', function (Blueprint $table) {
        $table->id();
        $table->string('title');
        $table->json('category')->nullable();
        $table->string('image');
        $table->integer('seasons')->default(1);
        $table->integer('episodes')->default(1);
        $table->string('producer');
        $table->text('description')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('new_programs');
    }
};
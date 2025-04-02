<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('email')->unique();
            $table->string('password')->nullable();
            $table->string('image')->nullable();
            $table->text('bio')->nullable();
            $table->boolean('is_admin')->default(false);
            $table->string('role')->nullable();
            $table->json('social_media')->nullable();

            // Change 'assignable' to a JSON column that holds the program data
            $table->json('assignable')->nullable(); 

            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('program_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');  // Foreign key for user
            $table->foreignId('program_id')->constrained()->onDelete('cascade');  // Foreign key for program
            $table->timestamps();  // To track when the user is assigned to a program
        });
    }

    public function down()
    {
        Schema::dropIfExists('program_user');
    }
};

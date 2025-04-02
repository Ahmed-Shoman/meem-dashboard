<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->string('program_name')->index();
            $table->string('author_name')->nullable();
            $table->text('author_bio')->nullable();
            $table->string('author_profile_picture')->nullable();
            $table->string('author_instagram')->nullable();
            $table->string('author_snapchat')->nullable();
            $table->string('author_x_twitter')->nullable();
            $table->string('type')->default('news');
            $table->text('content');
            $table->date('date')->nullable()->index();
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('news');
    }
};

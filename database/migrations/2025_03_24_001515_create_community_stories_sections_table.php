<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('community_stories_sections', function (Blueprint $table) {
            $table->id();
            $table->string('main_title')->nullable();
            $table->longText('description')->nullable();
            $table->json('links')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('community_stories_sections');
    }
};
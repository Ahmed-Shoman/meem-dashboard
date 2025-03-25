<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommunityStoriesSectionTable extends Migration
{
    public function up()
    {
        Schema::create('community_stories_section', function (Blueprint $table) {
            $table->id();
            $table->string('main_title');
            $table->json('links')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('community_stories_section');
    }
}
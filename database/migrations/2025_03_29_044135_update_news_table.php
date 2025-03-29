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
        Schema::table('news', function (Blueprint $table) {
            $table->string('author_name')->after('title')->nullable();
            $table->text('author_bio')->after('author_name')->nullable();
            $table->string('author_profile_picture')->after('author_bio')->nullable();
            $table->string('author_instagram')->after('author_profile_picture')->nullable();
            $table->string('author_snapchat')->after('author_instagram')->nullable();
            $table->string('author_x_twitter')->after('author_snapchat')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('news', function (Blueprint $table) {
            $table->dropColumn([
                'author_name',
                'author_bio',
                'author_profile_picture',
                'author_instagram',
                'author_snapchat',
                'author_x_twitter'
            ]);
        });
    }
};

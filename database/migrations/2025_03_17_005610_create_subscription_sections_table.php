<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('subscription_sections', function (Blueprint $table) {
            $table->id();

            //main tittle
            $table->string('main_title');

            //plan details
            // $table->string('plan_name')->nullable();
            // $table->text('plan_description')->nullable();
            // $table->string('plan_price')->nullable();
            $table->json('plan_details')->nullable();

            $table->json('feature_list')->nullable();



            //faqs
           // $table->string('faqs_main_title')->nullable();
            $table->json('faqs')->nullable();


           //listen now section
            $table->string('listen_now_title')->nullable();
            $table->text('listen_now_text')->nullable();
            $table->json('platform_links')->nullable();
            $table->string('listen_now_image')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('subscription_sections');
    }
};

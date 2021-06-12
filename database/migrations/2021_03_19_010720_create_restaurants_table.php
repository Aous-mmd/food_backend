<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRestaurantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('restaurants', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone');
            $table->string('email');
            $table->string('street')->nullable();
            $table->string('build_number')->nullable();
            $table->text('address')->nullable();
            $table->enum('from_day',['Saturday','Sunday','Monday','Tuesday','Wednesday','Thursday','Friday']);
            $table->enum('to_day',['Saturday','Sunday','Monday','Tuesday','Wednesday','Thursday','Friday']);
            $table->time('open_time');
            $table->time('close_time');
            $table->double('min_order');
            $table->string('android_url')->nullable();
            $table->string('iphone_url')->nullable();
            $table->string('owner');
            $table->string('facebook')->nullable();
            $table->string('instagram')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('twitter')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('restaurants');
    }
}

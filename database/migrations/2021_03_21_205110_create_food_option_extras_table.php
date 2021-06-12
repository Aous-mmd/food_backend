<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFoodOptionExtrasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('food_option_extras', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('food_option_id');
            $table->foreign('food_option_id')
                ->references('id')->on('food_option')
                ->onDelete('cascade');

            $table->unsignedBigInteger('extra_id');
            $table->foreign('extra_id')
                ->references('id')->on('extras')
                ->onDelete('cascade');

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
        Schema::dropIfExists('food_option_extras');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFoodOptionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('food_option', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('food_id');
            $table->foreign('food_id')
                ->references('id')->on('food')
                ->onDelete('cascade');

            $table->unsignedBigInteger('option_id');
            $table->foreign('option_id')
                ->references('id')->on('options')
                ->onDelete('cascade');

            $table->double('price');
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
        Schema::dropIfExists('food_option');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderDetailExtrasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_detail_extras', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('order_detail_id')->unsigned();
            $table->foreign('order_detail_id')
                ->references('id')->on('order_details')
                ->onDelete('cascade');

            $table->unsignedBigInteger('extra_id')->unsigned();
            $table->foreign('extra_id')
                ->references('id')->on('extras')
                ->onDelete('cascade');

            $table->integer('quantity');
            $table->double('price')->default(0);
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
        Schema::dropIfExists('order_detail_extras');
    }
}

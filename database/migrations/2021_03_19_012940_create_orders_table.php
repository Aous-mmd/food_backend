<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->enum('status',['pending','accept','reject'])->default('pending');
            $table->text('description')->nullable();
            $table->bigInteger('delivery_address_id')->nullable();
            $table->double('total_price')->nullable();
            $table->dateTime('started_at');
            $table->tinyInteger('is_deleted')->default(0);
            $table->string('customer_name');
            $table->string('customer_phone');
            $table->string('customer_email');
            $table->enum('type',['delivery','table_reservation','daily_order'])->default('delivery');
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
        Schema::dropIfExists('orders');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
            $table->unsignedInteger("user_address_id");
            $table->integer("total_price")->nullable();
            $table->char("tracking_code",20);
            $table->integer("status");
            $table->timestamp("time_buy");
            $table->integer("pay_status");

            $table->timestamps();

            $table->foreign('user_address_id')->references('id')->on('user_addresses');

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

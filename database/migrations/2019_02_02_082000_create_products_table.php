<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->char('title',250);
            $table->char('code',250)->unique();
            $table->text("description")->nullable();
            $table->json("product_data")->nullable();
            $table->unsignedInteger("provider_id")->nullable();
            $table->timestamp("publish_time")->nullable();
            $table->integer("status")->nullable();
            $table->integer("count_sell")->nullable();
            $table->integer("count_exist")->nullable();
            $table->integer("price")->nullable();
            $table->integer("provider_price_suggest")->nullable();
            $table->unsignedInteger('category_id');
            $table->timestamp("deleted_at")->nullable();
            $table->timestamps();

            $table->foreign('category_id')->references('id')->on('categories');
            $table->foreign('provider_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}

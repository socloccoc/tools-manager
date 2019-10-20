<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderWebsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_webs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id');
            $table->string('full_name', 191)->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('province', 191);
            $table->string('district', 191);
            $table->string('village', 191);
            $table->string('street', 191);
            $table->string('store_name', 191);
            $table->string('product_name', 191);
            $table->string('product_link', 191)->nullable();
            $table->integer('quantity');
            $table->string('option_1', 191)->nullable();
            $table->string('option_2', 191)->nullable();
            $table->string('promo_code', 191)->nullable();
            $table->string('transport', 191);
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
        Schema::dropIfExists('order_webs');
    }
}

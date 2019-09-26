<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddPointHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('add_point_histories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('sender_id');
            $table->integer('receiver_id');
            $table->integer('app_id');
            $table->integer('point');
            $table->string('key', 50);
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
        Schema::dropIfExists('add_point_histories');
    }
}

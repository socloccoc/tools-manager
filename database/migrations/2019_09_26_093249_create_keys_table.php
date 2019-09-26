<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKeysTable extends Migration
{
    public function up()
    {
        Schema::create('keys', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id');
            $table->integer('tool_id');
            $table->string('licence_key', 100);
            $table->string('serial_number', 100);
            $table->integer('point_order')->default(0);
            $table->integer('point_register')->default(0);
            $table->integer('user_create_id')->default(0);
            $table->integer('expire_time');
            $table->dateTime('expire_date')->nullable();
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
        Schema::dropIfExists('keys');
    }
}

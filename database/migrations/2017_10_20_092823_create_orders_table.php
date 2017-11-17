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
            $table->integer('openid_id');
            $table->integer('user_id');
            $table->uuid('uuid')->index();
            $table->uuid('sub_uuid');
            $table->string('prepay_id', 64)->nullable();
            $table->unsignedInteger('price');
            $table->string('name')->nullable();
            $table->string('mobile')->nullable();
            $table->string('address')->nullable();
            $table->tinyInteger('status')->default(0)->comment('订单状态');
            $table->tinyInteger('schedule')->comment('进度');
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

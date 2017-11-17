<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttachmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attachments', function (Blueprint $table) {
                       $table->increments('id');
            $table->integer('user_id')->index()->comment('上传者ID');
            $table->integer('own')->comment('所属模型：1/item');
            $table->integer('own_id')->comment('所属模型ID');
            $table->string('type')->comment('item:files');
            $table->string('path')->comment('附件路径');
            $table->index(['own', 'own_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attachments');
    }
}

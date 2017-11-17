<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStatusToItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::table('items', function (Blueprint $table) {
             $table->tinyInteger('status')->default(1)->comment('状态:0/删除，1/正常');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         Schema::table('items', function (Blueprint $table) {
            $table->dropColumn(['status']);
        });
    }
}

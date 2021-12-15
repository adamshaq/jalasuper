<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTblRegister20200928 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tbl_register', function (Blueprint $table) {
            $table->string('done_by',200)->nullable()->change();
            $table->string('phone',200)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbl_register', function (Blueprint $table) {
            $table->string('done_by',20)->nullable()->change();
            $table->string('phone',20)->nullable()->change();
        });
    }
}

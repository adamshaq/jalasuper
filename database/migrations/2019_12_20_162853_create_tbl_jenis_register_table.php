<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblJenisRegisterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_jenis_register', function (Blueprint $table) {
            $table->uuid('tbl_jenis_register_id');
            $table->string('jenis_register_nm',200);
            $table->string('jenis_register_tp',20)->nullable();
            $table->integer('duration')->default(365);
            $table->integer('warning')->default(0);
            $table->string('notification_tp')->default('NOTIFICATION_TP_1');
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->primary('tbl_jenis_register_id');
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
        Schema::dropIfExists('tbl_jenis_register');
    }
}

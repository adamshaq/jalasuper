<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblRegisterScanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_register_scan', function (Blueprint $table) {
            $table->string('tbl_register_scan_id',100)->primary();
            $table->string('tbl_register_id',100);
            $table->integer('scan_attempt')->default(0);
            $table->string('scan_by', 200)->nullable();
            $table->datetime('scan_datetime')->nullable();
            $table->integer('scan_tp')->default(0);
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
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
        Schema::dropIfExists('tbl_register_scan');
    }
}

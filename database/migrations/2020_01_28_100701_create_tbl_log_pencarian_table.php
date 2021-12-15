<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblLogPencarianTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_log_pencarian', function (Blueprint $table) {
            $table->uuid('tbl_log_pencarian_id')->primary();
            $table->string('search_param')->nullable();
            $table->string('jenis_register')->nullable();
            $table->string('tbl_company_id')->nullable();
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
        Schema::dropIfExists('tbl_log_pencarian');
    }
}

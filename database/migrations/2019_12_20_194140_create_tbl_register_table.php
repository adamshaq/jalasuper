<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblRegisterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_register', function (Blueprint $table) {
            $table->string('tbl_register_id',100);
            $table->string('file_tp',100)->nullable();
            $table->string('no_surat',1000)->nullable();
            $table->string('jenis_register',100)->nullable();
            $table->string('wajib_pajak',1000)->nullable();
            $table->string('note',1000)->nullable();
            $table->string('petugas_penerima',1000)->nullable();
            $table->string('info_02',1000)->nullable();
            $table->string('info_03',1000)->nullable();
            $table->datetime('datetime_input')->default(DB::Raw("current_timestamp"));
            $table->string('proses_st',20)->default('PROSES_ST_1');
            $table->string('tbl_company_id')->nullable();
            $table->datetime('datetime_deadline')->nullable();
            $table->datetime('datetime_done')->nullable();
            $table->string('done_by',20)->nullable();
            $table->string('phone',20)->nullable();
            $table->string('notification_st',1)->default('0');
            $table->string('tbl_company_id_from')->nullable();
            $table->text('pemohon_note')->nullable();
            $table->string('pemohon_note_st',1)->default("0");
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->timestamps();

            $table->primary('tbl_register_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_register');
    }
}
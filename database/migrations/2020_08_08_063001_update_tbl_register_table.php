<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTblRegisterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tbl_register', function (Blueprint $table) {
            $table->string('bpn_check_by', 200)->nullable()->after('pemohon_note_st');
            $table->datetime('bpn_check_datetime')->nullable()->after('bpn_check_by');
            $table->integer('bpn_check_count')->default(0)->after('bpn_check_datetime');

            $table->string('bpn_approve_by', 200)->nullable()->after('bpn_check_count');
            $table->datetime('bpn_approve_datetime')->nullable()->after('bpn_approve_by');
            $table->string('bpn_approve_st', 1)->default('0')->after('bpn_approve_datetime');
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
            $table->dropColumn(['bpn_check_by', 'bpn_check_datetime','bpn_check_count', 'bpn_approve_by','bpn_approve_datetime', 'bpn_approve_st']);
        });
    }
}

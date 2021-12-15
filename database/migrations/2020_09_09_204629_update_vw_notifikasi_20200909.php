<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateVwNotifikasi20200909 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("drop VIEW IF EXISTS vw_notifikasi");

        DB::unprepared("
        create or replace VIEW vw_notifikasi as 
        select
            `vw_register`.`tbl_company_id` AS `tbl_company_id`,
            coalesce(`vw_register`.`jenis_register_nm`,
            'TIDAK DIKETAHUI') AS `jenis_register_nm`,
            count(0) AS `total`,
            sum(case when `vw_register`.`status`= 'BELUM' then 1 else 0 end) AS `total_belum_proses`,
            sum(case when `vw_register`.`status`= 'MENDESAK' then 1 else 0 end) AS `total_mendesak`,
            sum(case when `vw_register`.`status`= 'SELESAI' then 1 else 0 end) AS `total_selesai`
        from
            vw_register
        group by
            vw_register.jenis_register_nm,
            vw_register.tbl_company_id;
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared("drop VIEW IF EXISTS vw_notifikasi");

        DB::unprepared("
        create or replace VIEW vw_notifikasi as 
        select
            `vw_register`.`tbl_company_id` AS `tbl_company_id`,
            coalesce(`vw_register`.`jenis_register_nm`,
            'TIDAK DIKETAHUI') AS `jenis_register_nm`,
            count(0) AS `total`,
            sum(case when `vw_register`.`status`= 'BELUM' then 1 else 0 end) AS `total_belum_proses`,
            sum(case when `vw_register`.`status`= 'MENDESAK' then 1 else 0 end) AS `total_mendesak`,
            sum(case when `vw_register`.`status`= 'SELESAI' then 1 else 0 end) AS `total_selesai`
        from
            vw_register
        group by
            vw_register.jenis_register_nm,
            vw_register.tbl_company_id;
        ");
    }
}

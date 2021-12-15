<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateVwRegister20200909 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("drop VIEW IF EXISTS vw_register");
        DB::unprepared("
        create or replace VIEW vw_register as 
        select
            tr.tbl_register_id AS tbl_register_id,
            tr.tbl_company_id AS tbl_company_id,
            company.company_root,
            company.notif_url,
            company.notif_token_1,
            company.notif_token_2,
            company.notif_token_3,
            company.phone as company_phone,
            tr.jenis_register AS jenis_register,
            tr.wajib_pajak AS wajib_pajak,
            tr.no_surat AS no_surat,
            tr.info_02 AS info_02,
            tr.datetime_input AS datetime_input,
            date_format(tr.datetime_input,'%d/%m/%Y') as datetime_input_format,
            tr.proses_st AS proses_st,
            tr.notification_st,
            prosesst.code_nm AS proses_st_nm,
            tr.datetime_done AS datetime_done,
            date_format(tr.datetime_done,'%d/%m/%Y') as datetime_done_format,
            TO_DAYS(tr.datetime_done)-to_days(tr.datetime_input) + 1 as durasi_penyelesaian,
            tr.phone AS phone,
            tr.file_tp AS file_tp,
            tr.done_by AS done_by,
            coalesce(tjr.jenis_register_nm, 'TIDAK DIKETAHUI') AS jenis_register_nm,
            tjr.duration AS duration,
            tjr.warning AS warning,
            case 
				when (to_days(curdate()) - to_days(tr.datetime_input) < warning and proses_st = 'PROSES_ST_1') then 'BELUM'
				when (to_days(curdate()) - to_days(tr.datetime_input) >= warning and proses_st = 'PROSES_ST_1') then 'MENDESAK'
				when (proses_st in ('PROSES_ST_2','PROSES_ST_3')) then 'SELESAI'
				-- when (proses_st in ('PROSES_ST_2')) then 'SELESAI_DI_KPP'
				-- when (proses_st in ('PROSES_ST_3')) then 'DITERUSKAN_KE_KANWIL'
				else 'EMBUH' 
			end as status,
            to_days(curdate()) - to_days(tr.datetime_input) AS running,
            tjr.notification_tp AS notification_tp,
            tr.pemohon_note,
            tr.pemohon_note_st,
            tr.datetime_input + interval tjr.duration day AS datetime_deadline,
            to_days(curdate()) - to_days(tr.datetime_input + interval tjr.duration day) AS selisih,
            bpn_check_by,
            bpn_user_check.user_nm as bpn_check_by_nm,
            bpn_check_datetime,
            bpn_check_count,
            bpn_approve_by,
            bpn_user_approve.user_nm as bpn_approve_by_nm,
            bpn_approve_datetime,
            bpn_approve_st
        from
            tbl_register tr
        join tbl_company company on
            company.tbl_company_id = tr.tbl_company_id
        left join tbl_jenis_register tjr on
            tr.jenis_register = tjr.jenis_register_nm
        left join com_code prosesst on
            prosesst.com_cd = tr.proses_st
        left join users bpn_user_check on
            bpn_user_check.user_id = tr.bpn_check_by
        left join users bpn_user_approve on
            bpn_user_approve.user_id = tr.bpn_approve_by
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared("drop VIEW IF EXISTS vw_register");
        DB::unprepared("
        create or replace VIEW vw_register as 
        select
            tr.tbl_register_id AS tbl_register_id,
            tr.tbl_company_id AS tbl_company_id,
            company.company_root,
            company.notif_url,
            company.notif_token_1,
            company.notif_token_2,
            company.notif_token_3,
            company.phone as company_phone,
            tr.jenis_register AS jenis_register,
            tr.wajib_pajak AS wajib_pajak,
            tr.no_surat AS no_surat,
            tr.info_02 AS info_02,
            tr.datetime_input AS datetime_input,
            date_format(tr.datetime_input,'%d/%m/%Y') as datetime_input_format,
            tr.proses_st AS proses_st,
            tr.notification_st,
            prosesst.code_nm AS proses_st_nm,
            tr.datetime_done AS datetime_done,
            date_format(tr.datetime_done,'%d/%m/%Y') as datetime_done_format,
            TO_DAYS(tr.datetime_done)-to_days(tr.datetime_input) as durasi_penyelesaian,
            tr.phone AS phone,
            tr.file_tp AS file_tp,
            tr.done_by AS done_by,
            coalesce(tjr.jenis_register_nm, 'TIDAK DIKETAHUI') AS jenis_register_nm,
            tjr.duration AS duration,
            tjr.warning AS warning,
            case 
				when (to_days(curdate()) - to_days(tr.datetime_input) < warning and proses_st = 'PROSES_ST_1') then 'BELUM'
				when (to_days(curdate()) - to_days(tr.datetime_input) >= warning and proses_st = 'PROSES_ST_1') then 'MENDESAK'
				when (proses_st in ('PROSES_ST_2','PROSES_ST_3')) then 'SELESAI'
				-- when (proses_st in ('PROSES_ST_2')) then 'SELESAI_DI_KPP'
				-- when (proses_st in ('PROSES_ST_3')) then 'DITERUSKAN_KE_KANWIL'
				else 'EMBUH' 
			end as status,
            to_days(curdate()) - to_days(tr.datetime_input) AS running,
            tjr.notification_tp AS notification_tp,
            tr.pemohon_note,
            tr.pemohon_note_st,
            tr.datetime_input + interval tjr.duration day AS datetime_deadline,
            to_days(curdate()) - to_days(tr.datetime_input + interval tjr.duration day) AS selisih,
            bpn_check_by,
            bpn_user_check.user_nm as bpn_check_by_nm,
            bpn_check_datetime,
            bpn_check_count,
            bpn_approve_by,
            bpn_user_approve.user_nm as bpn_approve_by_nm,
            bpn_approve_datetime,
            bpn_approve_st
        from
            tbl_register tr
        join tbl_company company on
            company.tbl_company_id = tr.tbl_company_id
        left join tbl_jenis_register tjr on
            tr.jenis_register = tjr.jenis_register_nm
        left join com_code prosesst on
            prosesst.com_cd = tr.proses_st
        left join users bpn_user_check on
            bpn_user_check.user_id = tr.bpn_check_by
        left join users bpn_user_approve on
            bpn_user_approve.user_id = tr.bpn_approve_by
        ");
    }
}

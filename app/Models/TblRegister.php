<?php

namespace App\Models;

use DB;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;

class TblRegister extends Model
{
    use Uuid;

    protected $table       = 'tbl_register';
    protected $primaryKey  = 'tbl_register_id'; 
    public $incrementing   = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tbl_register_id',
        'file_tp',
        'no_surat',
        'jenis_register',
        'wajib_pajak',
        'note',
        'petugas_penerima',
        'info_02',
        'info_03',
        'datetime_input',
        'proses_st',
        'tbl_company_id',
        'datetime_deadline',
        'datetime_done',
        'done_by',
        'phone',
        'pemohon_note',
        'pemohon_note_st',
        'bpn_check_by',
        'bpn_check_datetime',
        'bpn_check_count',
        'bpn_approve_by',
        'bpn_approve_datetime',
        'bpn_approve_st',
        'notification_st',
        'tbl_company_id_from',
        'created_by',
        'updated_by',
    ];
}

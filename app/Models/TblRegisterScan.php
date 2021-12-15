<?php

namespace App\Models;

use DB;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;

class TblRegisterScan extends Model
{
    use Uuid;

    protected $table       = 'tbl_register_scan';
    protected $primaryKey  = 'tbl_register_scan_id'; 
    public $incrementing   = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tbl_register_scan_id',
        'tbl_register_id',
        'scan_by',
        'scan_attempt',
        'scan_datetime',
        'scan_tp',
        'created_by',
        'updated_by',
    ];
}

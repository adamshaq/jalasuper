<?php

namespace App\Models;

use DB;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;

class TblJenisRegister extends Model
{
    use Uuid;
    
    protected $table       = 'tbl_jenis_register';
    protected $primaryKey  = 'tbl_jenis_register_id'; 
    public $incrementing   = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tbl_jenis_register_id',
        'jenis_register_nm',
        'jenis_register_tp',
        'notification_tp',
        'duration',
        'warning',
        'created_by',
        'updated_by',
    ];
}

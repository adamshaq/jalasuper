<?php

namespace App\Models;

use DB;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;

class TblLogPencarian extends Model
{
    use Uuid;
    
    protected $table       = 'tbl_log_pencarian';
    protected $primaryKey  = 'tbl_log_pencarian_id'; 
    public $incrementing   = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tbl_log_pencarian_id',
        'search_param',
        'jenis_register',
        'tbl_company_id',
        'created_by',
        'updated_by',
    ];
}

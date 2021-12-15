<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Model;

class TblCompany extends Model
{
    protected $table       = 'tbl_company';
    protected $primaryKey  = 'tbl_company_id'; 
    public $incrementing   = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tbl_company_id',
        'company_nm',
        'company_tp',
        'company_address',
        'phone',
        'created_by',
        'updated_by',
    ];
}

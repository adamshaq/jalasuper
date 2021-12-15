<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VwRegister extends Model
{
    protected $table       = 'vw_register';
    protected $primaryKey  = 'tbl_register_id'; 
    public $incrementing   = false;
}

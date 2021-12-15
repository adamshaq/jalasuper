<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ComCode extends Model{
    protected $table        = 'com_code';
    protected $primaryKey   = 'com_cd'; 
    public $incrementing    = false;

    protected $fillable = [
        'com_cd', 'code_nm', 'code_group','code_value','created_by', 'update_by'
    ];

    public static function getComCd($codeGroup){
        $code = ComCode::where('code_group', $codeGroup)->count();

        return $codeGroup.'_'.str_pad($code + 1 , 2 , "0" ,STR_PAD_LEFT);
    }
}

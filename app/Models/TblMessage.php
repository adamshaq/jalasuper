<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;

class TblMessage extends Model
{
    use Uuid;

    protected $table       = 'tbl_messages';
    protected $primaryKey  = 'tbl_messages_id'; 
    public $incrementing   = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tbl_messages_id',
        'tbl_register_id',
        'sender',
        'sender_tp',
        'message',
        'created_by',
        'updated_by',
    ];
}

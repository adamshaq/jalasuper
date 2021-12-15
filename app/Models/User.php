<?php

namespace App\Models;

use DB;
// use App\Traits\Uuid;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\MailResetPasswordNotification;
use App\Notifications\MailVerificationNewUserNotification;
use Tymon\JWTAuth\Contracts\JWTSubject;

// class User extends Authenticatable implements MustVerifyEmail, 
class User extends Authenticatable implements JWTSubject
{
    use Notifiable;
    // use Uuid;

    protected $table            = 'users';
    private static $tableName   = 'users as user';
    protected $primaryKey       = 'user_id'; 
    public $incrementing    = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'user_nm',
        'user_tp',
        'email',
        'phone',
        'password',
        'image',
        'active',
        'tbl_company_id',
        'fcm_token',
        'created_by',
        'updated_by',
        'remember_token',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    /* public function sendPasswordResetNotification($token)
    {
        $this->notify(new MailResetPasswordNotification($token, $this->user_nm));
    } */

    /**
     * Send the email verification notification.
     *
     * @return void
     */
    /* public function sendEmailVerificationNotification()
    {
        $this->notify(new MailVerificationNewUserNotification);
    } */
}

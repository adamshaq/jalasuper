<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\LoginHistory;

class LogSuccessfulLogin
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Login  $event
     * @return void
     */
    public function handle(Login $event){
        $loginHistory=LoginHistory::create([
            'user_id'    => $event->user->user_id,
            'ip_address' => \Illuminate\Support\Facades\Request::ip()
        ]);
        
        \Illuminate\Support\Facades\Request::session()->put('logId',$loginHistory->login_history_id );
    }
}

<?php

namespace App\Listeners;

use Carbon\Carbon;
use Illuminate\Auth\Events\Logout;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\LoginHistory;

class LogSuccessfulLogout
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
     * @param  Logout  $event
     * @return void
     */
    public function handle(Logout $event){
        $loginHistory= LoginHistory::findOrFail(\Illuminate\Support\Facades\Request::session()->get('logId'));
        $loginHistory->datetime_logout = date('Y-m-d H:i:s');
        $loginHistory->save();
    }
}

<?php

namespace App\Http\Middleware;
use Auth;
use App\Models\AuthRoleMenu;
use Closure;

class CheckRoleMenu{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $menuCd = NULL){
        $userTp = Auth::user()->user_tp;

        $roles = array();
        $roles['USER_TP_1'] = ['USER','COMP','JREG'];
        $roles['USER_TP_2'] = ['USER'];
        $roles['USER_TP_3'] = [];
                
        if (!in_array($menuCd, $roles[$userTp])) {
            return abort(404);
        }

        return $next($request);
    }
}

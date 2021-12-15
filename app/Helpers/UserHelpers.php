<?php 
if (! function_exists('roleUser')) {
    function roleUser(){
        $userId = Auth::user()->user_id;

        $roleUser=App\Models\AuthRoleUser::where('user_id', $userId)->first();
        return $roleUser->role_cd;
    }
}

if (! function_exists('isRoleUser')) {
    function isRoleUser($roleParam){
        $userId = Auth::user()->user_id;

        $roleUser=App\Models\AuthRoleUser::where('user_id',$userId)
                ->where('role_cd',$roleParam)
                ->count();
                
        if ($roleUser == 1) {
            return TRUE;
        }else {
            return FALSE;
        }
    }
}

if (! function_exists('belumBaca')) {
    function belumBaca(){
        $tblCompanyId = Auth::user()->tbl_company_id;

        $belumDibaca  = App\Models\TblRegister::where('pemohon_note_st','0')
                        ->whereNotNull('pemohon_note')
                        ->whereRaw("coalesce(tbl_company_id, '') = '$tblCompanyId'")
                        ->count();
        
        return $belumDibaca;
    }
}


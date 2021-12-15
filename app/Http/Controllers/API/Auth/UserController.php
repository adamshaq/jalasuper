<?php

namespace App\Http\Controllers\API\Auth;

use Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\TblCompany;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public $successStatus = 200;

    public function show($id = NULL){
        if ($id) {
            $user = User::find($id);
        }else{
            $user = Auth::user();
        }

        $company = TblCompany::find($user->tbl_company_id);
        $user['company'] = $company->company_nm;

        return response()->json(['status' => 'ok','result' => $user], $this->successStatus);
    }

    function allUser()
    {
        $data = User::all();
        return response()->json(['status' => 'ok', 'result' => $data], $this->successStatus);
    }

    function destroy()
    {
        $id = request('user_id');
        User::destroy($id);
        return response()->json(['status' => 'ok', 'message' => 'User Deleted'], $this->successStatus);
    }
}

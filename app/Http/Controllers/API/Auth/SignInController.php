<?php

namespace App\Http\Controllers\API\Auth;

use Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\TblCompany;

use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;

use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class SignInController extends Controller
{
    public $successStatus = 200;

    function index(Request $request){
        $login = request()->input('email');

        $fieldType = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'user_id';
        request()->merge([$fieldType => $login]);
        
        $credentials = $request->only($fieldType, 'password');

        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 400);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        $user = Auth::user();

        $updateToken             = User::find($user->user_id);
        $updateToken->fcm_token  = $request->fcm_token;
        $updateToken->updated_by = $user->user_id;
        $updateToken->save();

        $company = TblCompany::find($user->tbl_company_id);

        $user['token'] = $token;
        $user['company'] = $company->company_nm;

        return response()->json(['status' => 'ok', 'result' => $user], 200);
    }
}

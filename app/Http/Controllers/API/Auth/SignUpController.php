<?php

namespace App\Http\Controllers\API\Auth;

use Auth;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Validator;

use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class SignUpController extends Controller
{
    public $successStatus = 200;

    public function index(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $user             = new User;
        $user->name       = $request->get('name');
        $user->email      = $request->get('email');
        $user->password   = Hash::make($request->get('password'));
        $user->fcm_token  = $request->get('fcm_token');
        $user->created_by = $request->get('name');
        $user->save();

        $token = JWTAuth::fromUser($user);

        $user = Auth::user();
        $user['token'] = $token;

        return response()->json(['status' => 'ok', 'result' => $user], 200);
    }

    public function getAuthenticatedUser()
    {
        try {

            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }

        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

            return response()->json(['token_expired'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

            return response()->json(['token_invalid'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {

            return response()->json(['token_absent'], $e->getStatusCode());

        }

        return response()->json(compact('user'));
    }
}

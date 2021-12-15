<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use DataTables;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PasswordController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index($id = NULL){
        $title = 'Ubah Kata Sandi';
        return view('password', compact('title'));
    }

    function store(Request $request)
    {
        $this->validate($request,[
            'password'  => 'required',
            'repeat_password' => 'required',
        ]);

        if ($request->password == $request->repeat_password) {
            $user           = User::find(Auth::user()->user_id);
            $user->password = Hash::make($request->password);
            $user->save();

            return response()->json(['status' => 'ok'],200);
        }else {
            return response()->json(['status' => 'failed' , 'message' => 'Password Mismatch'],200);
        }
    }
}
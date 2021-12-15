<?php

namespace App\Http\Controllers\DataMaster;

use DB;
use Auth;
use DataTables;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\TblCompany;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;

class UserBpnController extends Controller
{
    private $folder_path = 'user-bpn';
    
    function __construct(){
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function index(){
        $pageName   = 'index';
        $title      = 'Kelola Data User BPN';
        $companies  = TblCompany::where('company_tp','COMPANY_TP_3')->get();

        return view('data-master.' . $this->folder_path . '.' . $pageName, compact('title','companies'));
    }

    function profil($id){
        $pageName   = 'profil';
        $title      = 'Profil User';
        $dataUser   = User::where('user_id',$id)
                    ->join('com_code as usertp','usertp.com_cd','users.user_tp')
                    ->join('tbl_company as company','company.tbl_company_id','users.tbl_company_id')
                    ->first();

        return view('data-master.' . $this->folder_path . '.' . $pageName, compact('title', 'dataUser'));
    }

    /**
     * Display a listing of the resource for datatables.
     *
     * @return \Illuminate\Http\Response
     */
    function getData(){
        $kppUser = Auth::user()->tbl_company_id; 
        $data = User::select(
                    'user_id',
                    'user_nm',
                    'user_tp',
                    'usertp.code_nm as user_tp_nm',
                    'users.tbl_company_id',
                    'company.company_nm as company_nm'
                )
                ->join('com_code as usertp','usertp.com_cd','users.user_tp')
                ->join('tbl_company as company','company.tbl_company_id','users.tbl_company_id')
                ->where('company.company_tp','COMPANY_TP_3')
                ;

        if(Auth::user()->user_tp != 'USER_TP_1'){
            $data->where('user_tp','<>','USER_TP_1');
            $data->where('users.tbl_company_id',"$kppUser");
        }

        return DataTables::of($data)
        ->addColumn('actions',function($data){
            $actions = '';
            
            $actions .= "<button type='button' id='profil' class='btn btn-info btn-sm legitRipple'><i class='fa fa-user'></i> </button>";
            
            return $actions;
        })
        ->rawColumns(['actions'])
        ->make(true);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    function store(Request $request){
        $this->validate($request,[
            'user_id' => 'required|unique:users',
            'user_nm' => 'required',
            'user_tp' => Auth::user()->user_tp == 'USER_TP_2' ? 'nullable' : 'required',
            'password'=> 'required',
        ]);


        $user                   = new User;
        $user->user_id          = $request->tbl_company_id ? $request->tbl_company_id.$request->user_id : env('DEFAULT_CABANG').$request->user_id;
        $user->user_nm          = $request->user_nm;
        $user->email            = $request->user_id;
        $user->password         = Hash::make($request->password);
        $user->user_tp          = Auth::user()->user_tp == 'USER_TP_2' ? 'USER_TP_3' : $request->user_tp;
        $user->tbl_company_id   = $request->tbl_company_id ? $request->tbl_company_id : Auth::user()->tbl_company_id;
        $user->created_by       = Auth::user()->user_id;
        $user->save();
            
        return response()->json(['status' => 'ok'],200); 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    function show($id){
        $user = User::find($id);

        if($user){
            return response()->json(['status' => 'ok', 'data' => $user],200);
        }else{
            return response()->json(['status' => 'failed', 'data' => 'not found'],200);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    function update(Request $request, $id){
        $this->validate($request,[
            'user_nm' => 'required',
            'user_tp' => Auth::user()->user_tp == 'USER_TP_2' ? 'nullable' : 'required',
        ]);

        $user                   = User::find($id);
        $user->user_nm          = $request->user_nm;
        $user->user_tp          = Auth::user()->user_tp == 'USER_TP_2' ? 'USER_TP_3' : $request->user_tp;
        $user->tbl_company_id   = $request->tbl_company_id ? $request->tbl_company_id : Auth::user()->tbl_company_id;
        $user->updated_by       = Auth::user()->user_id;
        $user->save();

        return response()->json(['status' => 'ok'],200); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    function destroy($id){
        $delete = DB::transaction(function () use($id) {
            $user = User::find($id);

            if (Auth::user()->user_id != $user->user_id) {
                User::destroy($id);

                return ['status' => 'ok'];
            }else{
                return ['status' => 'error', 'msg' => 'NGAPAIN LU HAPUS DIRI LU SENDIRI BAMBANG!!!'];
            }
        });

        return response()->json($delete,200);
    }

    function changeImage(Request $request, $id){
        DB::transaction(function () use($request, $id) {

            $user       = User::find($id);

            if ($request->image == NULL) {
                $user->image = NULL;
            } else {
                $image          = $request->image;  // your base64 encoded
                $image          = str_replace('data:image/png;base64,', '', $image);
                $image          = str_replace(' ', '+', $image);
                $imageName      = $user->user_id.'.'.'png';
    
                \File::put(storage_path('app/public/user-picture/'.$imageName), base64_decode($image));
    
                $user->image = $imageName;
            }
            

            $user->save();

        });

        return response()->json(['status' => 'ok'],200);
    }

    function changePassword(Request $request){
        $this->validate($request,[
            'password'  => 'required',
            'repeat_password' => 'required',
        ]);

        if ($request->password == $request->repeat_password) {
            $user           = User::find($request->user_id_password);
            $user->password = Hash::make($request->password);
            $user->save();

            return response()->json(['status' => 'ok'],200);
        }else {
            return response()->json(['status' => 'failed' , 'message' => 'Password Mismatch'],200);
        }
    }
}

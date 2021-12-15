<?php

namespace App\Http\Controllers\DataMaster;

use Auth;
use DataTables;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\TblJenisRegister;

class JenisRegisterController extends Controller{
    function __construct(){
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function index($id = NULL){
        $pageFileName = 'company';
        $title        = 'Jenis Register';
        return view('data-master.jenis-register', compact('title'));
    }

    /**
     * Display a listing of the resource for DataTables.
     *
     * @return \Illuminate\Http\Response
     */
    function getData(){
        $data = TblJenisRegister::select(
                    'tbl_jenis_register.tbl_jenis_register_id',
                    'tbl_jenis_register.jenis_register_nm',
                    'tbl_jenis_register.jenis_register_tp',
                    'registertp.code_nm as jenis_register_tp_nm',
                    'tbl_jenis_register.duration',
                    'tbl_jenis_register.warning',
                    'tbl_jenis_register.notification_tp',
                    'notificationtp.code_nm as notification_tp_nm'
                )
                ->leftJoin('com_code as registertp','registertp.com_cd','tbl_jenis_register.jenis_register_tp')
                ->leftJoin('com_code as notificationtp','notificationtp.com_cd','tbl_jenis_register.notification_tp');
        
        return DataTables::of($data)
                ->addColumn('actions', function($data){
                    $actions = '';
                    $actions .= "<button type='button' id='ubah'  class='btn btn-warning btn-flat btn-sm' data-toggle='tooltip' data-placement='top' title='Ubah Data'><i class='icon icon-pencil7'></i> </button> &nbsp";
                    $actions .= "<button type='button' id='hapus' class='btn btn-danger btn-flat btn-sm' data-toggle='tooltip' data-placement='top' title='Hapus Data'><i class='icon icon-trash'></i> </button>";
                    
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
            'jenis_register_nm' => 'required',
            'jenis_register_tp' => 'nullable',
            'notification_tp'   => 'required',
            'duration'          => 'required',
        ]);
            
        $jenisRegister                     = new TblJenisRegister;
        $jenisRegister->jenis_register_nm  = $request->jenis_register_nm;
        $jenisRegister->jenis_register_tp  = $request->jenis_register_tp;
        $jenisRegister->duration           = $request->duration;
        $jenisRegister->warning            = round(env('WARNING_COEFFITIENT') * $request->duration);
        $jenisRegister->notification_tp    = $request->notification_tp;
        $jenisRegister->created_by         = Auth::user()->user_id;
        $jenisRegister->save();

        return response()->json(['status' => 'ok'],200); 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    function show($id){
        $jenisRegister = TblJenisRegister::find($id);

        return response()->json(['status' => 'ok', 'data' => $jenisRegister],200); 
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
            'jenis_register_nm' => 'required',
            'jenis_register_tp' => 'nullable',
            'notification_tp'   => 'required',
            'duration'          => 'required',
        ]);
            
        $jenisRegister                      = TblJenisRegister::find($id);
        $jenisRegister->jenis_register_nm   = $request->jenis_register_nm;
        $jenisRegister->jenis_register_tp   = $request->jenis_register_tp;
        $jenisRegister->duration            = $request->duration;
        $jenisRegister->warning             = round(env('WARNING_COEFFITIENT') * $request->duration);
        $jenisRegister->notification_tp     = $request->notification_tp;
        $jenisRegister->updated_by          = Auth::user()->user_id;
        $jenisRegister->save();

        return response()->json(['status' => 'ok'],200); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    function destroy($id){
        TblJenisRegister::destroy($id);
        
        return response()->json(['status' => 'ok'],200); 
    }
}
